#!/bin/sh

# load_config.sh
. /root/PPPwn-Luckfox/scripts/load_config.sh
# Utility functions
reset_eth() { ifconfig eth0 down; sleep 1; ifconfig eth0 up; sleep 1; }
pppoe_up() { pppoe-server -I eth0 -T 60 -N 1 -C isp -S isp -L 10.1.1.1 -R 10.1.1.2 & }
web_up() { /etc/init.d/S50nginx start; /etc/init.d/S49php-fpm start; }

pppwn_exec(){
  /etc/init.d/S50nginx stop
  /etc/init.d/S49php-fpm stop
  killall pppoe-server
  >$LOG_FILE
  reset_eth
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
