#!/bin/bash

# Check internet connectivity
echo "Checking internet connection..."
ping -c 1 google.com > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "Error: No internet connection detected."
    echo "Please connect your Luckfox to the internet using LAN cable and try again."
    exit 1
fi

# Proceed with git pull and install.sh
echo "Internet connection detected. Proceeding with update..."
git pull
sudo ./install.sh
