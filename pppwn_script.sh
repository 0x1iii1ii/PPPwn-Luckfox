#!/bin/bash

# Disable eth0
ifconfig eth0 down

# Wait a seconds
sleep 1

# Enable eth0
ifconfig eth0 up

# Wait a seconds
sleep 1

# Change to the directory containing the pppwn executable
cd /home/pico/PPPwn-Luckfox/
# Execute the pppwn command with the desired options
./pppwn --interface eth0 --fw 1100 --stage1 "stage1.bin" --stage2 "stage2.bin" -a -t 5 -nw -wap 2

# Check if the pppwn command was successful
if [ $? -eq 0 ]; then
    echo "pppwn execution completed successfully."
    systemctl stop pppwn.service
	sleep 20
	ifconfig eth0 down
else
    echo "pppwn execution failed. Exiting script."
    exit 1
fi

