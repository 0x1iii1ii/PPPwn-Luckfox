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
DIR=$(read_json 'install_dir')
LOG_FILE=$(read_json 'log_file')

STAGE1_FILE="$DIR/stage1/${FW_VERSION}/stage1.bin"
STAGE2_FILE="$DIR/stage2/${FW_VERSION}/stage2.bin"

CMD="$DIR/$PPPWN_EXEC --interface eth0 --fw $FW_VERSION --stage1 $STAGE1_FILE --stage2 $STAGE2_FILE"

# Append optional parameters
[ "$TIMEOUT" != "null" ] && CMD="$CMD --timeout $TIMEOUT"
[ "$WAIT_AFTER_PIN" != "null" ] && CMD="$CMD --wait-after-pin $WAIT_AFTER_PIN"
[ "$GROOM_DELAY" != "null" ] && CMD="$CMD --groom-delay $GROOM_DELAY"
[ "$BUFFER_SIZE" != "null" ] && CMD="$CMD --buffer-size $BUFFER_SIZE"
[ "$AUTO_RETRY" == "true" ] && CMD="$CMD --auto-retry"
[ "$NO_WAIT_PADI" == "true" ] && CMD="$CMD --no-wait-padi"
[ "$REAL_SLEEP" == "true" ] && CMD="$CMD --real-sleep"

reseteth() {
  ifconfig eth0 down
  sleep 1
  ifconfig eth0 up
  sleep 3
}

if [ "$AUTO_START" = "true" ]; then
  /etc/init.d/S50nginx stop
  /etc/init.d/S49php-fpm stop
  > $LOG_FILE
  sleep 1
  reseteth
  $CMD
  echo "PPPwned"
    if [ "$HALT_CHOICE" = "true" ]; then
      sleep 1
      halt
    else
      reseteth
      pppoe-server -I eth0 -T 60 -N 1 -C isp -S isp -L 192.168.1.1 -R 192.168.1.2 &
      sleep 5
      /etc/init.d/S50nginx start
      /etc/init.d/S49php-fpm start
  fi
else
  echo "Auto Start is disabled, skipping PPPwn..."
  pppoe-server -I eth0 -T 60 -N 1 -C isp -S isp -L 192.168.1.1 -R 192.168.1.2 &
fi
