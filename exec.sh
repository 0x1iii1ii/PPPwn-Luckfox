#!/bin/sh
CONFIG_FILE="/etc/pppwn/config.json"

read_json() {
    local key=$1
    jq -r ".$key" "$CONFIG_FILE"
}

update_flag() {
    local flag_name=$1
    jq ".$flag_name = false" "$CONFIG_FILE" > /tmp/tmp.$$.json && mv /tmp/tmp.$$.json "$CONFIG_FILE"
    chmod 777 "$CONFIG_FILE"
}

killweb() {
    killall nginx
    killall php-fpm
    sleep 1
    killall pppoe-server
}

perform_action() {
    case $1 in
    shutdown)
        killweb
        update_flag "shutdown_flag"
        sleep 1
        halt
        ;;
    eth0_down)
        killweb
        update_flag "eth0_flag"
        sleep 1
        ifconfig eth0 down
        ;;
    execute)
        sh "$PPPWNDIR/web-run.sh"
        update_flag "execute_flag"
        ;;
    esac
}

check_input() {
    while [ -f "$CONFIG_FILE" ]; do
        SHUTDOWN_FLAG=$(read_json 'shutdown_flag')
        ETH0_FLAG=$(read_json 'eth0_flag')
        EXECUTE_FLAG=$(read_json 'execute_flag')
        PPPWNDIR=$(read_json 'install_dir')

        [ "$SHUTDOWN_FLAG" = "true" ] && perform_action shutdown
        [ "$ETH0_FLAG" = "true" ] && perform_action eth0_down
        [ "$EXECUTE_FLAG" = "true" ] && perform_action execute

        sleep 5
    done
}

check_input &
