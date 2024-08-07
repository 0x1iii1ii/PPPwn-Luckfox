#!/bin/sh
CONFIG_FILE="/etc/pppwn/config.json"

read_json() {
    local key=$1
    awk -F"[,:}]" '/"'$key'"/{gsub(/"/, "", $2); gsub(/[ \t]/, "", $2); print $2}' "$CONFIG_FILE"
}

while true; do
    if [ -f "$CONFIG_FILE" ]; then
        EXECUTE_FLAG=$(read_json 'execute_flag')
        SHUTDOWN_FLAG=$(read_json 'shutdown_flag')
        PPPWNDIR=$(read_json 'install_dir')
        if [ "$SHUTDOWN_FLAG" = "true" ]; then
            killall nginx
            killall php-fpm
            killall pppoe-server
            sleep 5
            awk -v OFS=: '{gsub("\"shutdown_flag\": true", "\"shutdown_flag\": false")}1' "$CONFIG_FILE" > /tmp/tmp.$$.json && mv /tmp/tmp.$$.json "$CONFIG_FILE"
            chmod 777 "$CONFIG_FILE"
            ifconfig ppp0 down
            sleep 1
            ifconfig eth0 down
            sleep 5
            halt -f
        fi

        if [ "$EXECUTE_FLAG" = "true" ]; then
            sh "$PPPWNDIR/web-run.sh"
            awk -v OFS=: '{gsub("\"execute_flag\": true", "\"execute_flag\": false")}1' "$CONFIG_FILE" > /tmp/tmp.$$.json && mv /tmp/tmp.$$.json "$CONFIG_FILE"
            chmod 777 "$CONFIG_FILE"
        fi
    fi
    sleep 5
done
