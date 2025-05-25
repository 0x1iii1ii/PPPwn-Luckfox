#!/bin/sh

# load_config.sh
. /root/PPPwn-Luckfox/scripts/load_config.sh
# Utility functions
reset_eth() { ifconfig eth0 down; sleep 1; ifconfig eth0 up; sleep 1; }
pppoe_up() { pppoe-server -I eth0 -T 60 -N 1 -C isp -S isp -L 10.1.1.1 -R 10.1.1.2 & }

killall nginx
killall php-fpm
killall pppoe-server
>$LOG_FILE
reset_eth
$CMD >>$LOG_FILE 2>&1
if grep -q "\[+\] Done!" $LOG_FILE; then
    echo "PPPwned"
    [ "$HALT_CHOICE" = "true" ] && { ifconfig eth0 down; sleep 1; halt; } || {
            reset_eth; pppoe_up
            /etc/init.d/S50nginx start
            /etc/init.d/S49php-fpm start
    }
fi
