#!/bin/sh

read_json() {
    local key=$1
    awk -F"[,:}]" '/"'$key'"/{gsub(/"/, "", $2); print $2}' $CONFIG_FILE | tr -d ' '
}

set -a
# Define the path to the configuration file
CONFIG_FILE="/etc/pppwn/config.json"

# Check if the configuration file exists
if [ ! -f "$CONFIG_FILE" ]; then
    echo "Error: Config file $CONFIG_FILE not found" >&2
    exit 1
fi

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
PPPWN_IPV6=$(read_json 'PPPWN_IPV6')
PPPWN_EXEC=$(read_json 'PPPWN_EXEC')
GOLD_CHECK=$(read_json 'GOLD_CHECK')
DIR=$(read_json 'install_dir')
LOG_FILE=$(read_json 'log_file')
SCRIPT_DIR="$DIR/scripts"
PPPWN_DIR="$DIR/pppwn"

# Construct file paths and command
STAGE1_FILE="$DIR/stage1/${FW_VERSION}/stage1.bin"
STAGE2_FILE="$DIR/stage2/${FW_VERSION}/stage2.bin"
CMD="$PPPWN_DIR/$PPPWN_EXEC --interface eth0 --fw $FW_VERSION --stage1 $STAGE1_FILE --stage2 $STAGE2_FILE"

# Append optional parameters
[ "$TIMEOUT" != "null" ] && CMD="$CMD --timeout $TIMEOUT"
[ "$WAIT_AFTER_PIN" != "null" ] && CMD="$CMD --wait-after-pin $WAIT_AFTER_PIN"
[ "$GROOM_DELAY" != "null" ] && CMD="$CMD --groom-delay $GROOM_DELAY"
[ "$BUFFER_SIZE" != "null" ] && CMD="$CMD --buffer-size $BUFFER_SIZE"
[ "$AUTO_RETRY" == "true" ] && CMD="$CMD --auto-retry"
[ "$NO_WAIT_PADI" == "true" ] && CMD="$CMD --no-wait-padi"
[ "$REAL_SLEEP" == "true" ] && CMD="$CMD --real-sleep"
[ "$PPPWN_IPV6" != "true" ] && CMD="$CMD --old-ipv6"
set +a