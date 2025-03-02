#!/bin/sh

read_json() {
  local key=$1
  awk -F"[,:}]" '/"'$key'"/{gsub(/"/, "", $2); print $2}' $CONFIG_FILE | tr -d ' '
}

# Define the path to the configuration file
CONFIG_FILE="/etc/pppwn/config.json"

# Read configuration values from config.json
FW_VERSION=$(read_json 'FW_VERSION')
TIMEOUT=$(read_json 'TIMEOUT')
WAIT_AFTER_PIN=$(read_json 'WAIT_AFTER_PIN')
GROOM_DELAY=$(read_json 'GROOM_DELAY')
BUFFER_SIZE=$(read_json 'BUFFER_SIZE')
AUTO_RETRY=$(read_json 'AUTO_RETRY')
NO_WAIT_PADI=$(read_json 'NO_WAIT_PADI')
REAL_SLEEP=$(read_json 'REAL_SLEEP')
AUTO_START=$(read_json 'AUTO_START')
HALT_CHOICE=$(read_json 'HALT_CHOICE')
PPPWN_EXEC=$(read_json 'PPPWN_EXEC')
GOLD_CHECK=$(read_json 'GOLD_CHECK')
DIR=$(read_json 'install_dir')
LOG_FILE=$(read_json 'log_file')
EN_NET=$(read_json 'en_inet')

# Construct file paths and command
STAGE1_FILE="$DIR/stage1/${FW_VERSION}/stage1.bin"
STAGE2_FILE="$DIR/stage2/${FW_VERSION}/stage2.bin"
CMD="$DIR/$PPPWN_EXEC --interface eth0 --fw $FW_VERSION --stage1 $STAGE1_FILE --stage2 $STAGE2_FILE"

# Append optional parameters
[ "$TIMEOUT" != "null" ] && CMD="$CMD --timeout $TIMEOUT"
[ "$WAIT_AFTER_PIN" != "null" ] && CMD="$CMD --wait-after-pin $WAIT_AFTER_PIN"
[ "$GROOM_DELAY" != "null" ] && CMD="$CMD --groom-delay $GROOM_DELAY"
[ "$BUFFER_SIZE" != "null" ] && CMD="$CMD --buffer-size $BUFFER_SIZE"
[ "$AUTO_RETRY" = "true" ] && CMD="$CMD --auto-retry"
[ "$NO_WAIT_PADI" = "true" ] && CMD="$CMD --no-wait-padi"
[ "$REAL_SLEEP" = "true" ] && CMD="$CMD --real-sleep"

# Utility functions
reset_eth() { ifconfig eth0 down; sleep 1; ifconfig eth0 up; sleep 1; }
pppoe_up() { pppoe-server -I eth0 -T 60 -N 1 -C isp -S isp -L 10.1.1.1 -R 10.1.1.2 & }
web_up() { /etc/init.d/S50nginx start; /etc/init.d/S49php-fpm start; }

pppwn_exec(){
  /etc/init.d/S50nginx stop
  /etc/init.d/S49php-fpm stop
  killall pppoe-server
  >$LOG_FILE
  reseteth
  $CMD >>$LOG_FILE 2>&1
  if grep -q "\[+\] Done!" $LOG_FILE; then
    echo "PPPwned"
    [ "$HALT_CHOICE" = "true" ] && { ifconfig eth0 down; sleep 1; halt; } || { reset_eth; pppoe_up; web_up; }
  fi
}

# Goldhen check
check_goldhen() {
    [ "$GOLD_CHECK" != "true" ] && return 1
    echo "Checking Goldhen..."
    pppoe_up; sleep 2
    while ! ping -c 1 10.1.1.2 >/dev/null 2>&1; do sleep 2; done
    sleep 2
    nmap -n -p 3232 10.1.1.2 | grep -q '3232/tcp open' && { killall pppoe-server; return 0; } || { killall pppoe-server; return 1; }
}

# Main execution
if [ "$AUTO_START" = "true" ]; then
    if check_goldhen; then
        echo "Goldhen detected, skipping PPPwn..."
        pppoe_up
        web_up
    else
        pppwn_exec
    fi
else
    echo "Auto Start disabled, skipping PPPwn..."
    pppoe_up
    web_up
fi
