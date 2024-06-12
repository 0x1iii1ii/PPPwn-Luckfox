#!/bin/bash

echo "______________________________                       "
echo "\\______   \\______   \\______   \\__  _  ______  "
echo " |     ___/|     ___/|     ___/\\ \\/ \\/ /    \\ "
echo " |    |    |    |    |    |     \\     /   |  \\     "
echo " |____|    |____|    |____|      \\/\\_/|___|  /    "
echo "                                           \\/       "
echo " __                 __      _____                    " 
echo "|  |  __ __   ____ |  | ___/ ____\\_______  ___      "
echo "|  | |  |  \\_/ ___\\|  |/ /\\   __\\/  _ \\  \\/  / "
echo "|  |_|  |  /\\  \\___|    <  |  | (  <_> >    <      "
echo "|____/____/  \\_____>__|_ \\ |__|  \\____/__/\\_ \\  "
echo ""

echo "by: https://github.com/0x1iii1ii/PPPwn-Luckfox"
echo ""
echo "credit to:"
echo "https://github.com/TheOfficialFloW/PPPwn"
echo "https://github.com/xfangfang/PPPwn_cpp"
echo ""

# Display the list of firmware versions
echo "Please select your PS4 firmware version:"
echo "a) 9.00"
echo "b) 9.03"
echo "c) 9.60"
echo "d) 10.00"
echo "e) 10.01"
echo "f) 10.50"
echo "g) 10.70"
echo "h) 11.00"
echo ""
# Prompt the user for the selection
read -p "Enter your choice (a/b/c/d/e/f/g/h): " FW_CHOICE

# Set the firmware version based on the user's choice
declare -A fw_versions=(
    [a]="900"
    [b]="903"
	[c]="960"
    [d]="1000"
    [e]="1001"
    [f]="1050"
    [g]="1070"
    [h]="1100"
)

FW_VERSION=${fw_versions[$FW_CHOICE]}

if [ -z "$FW_VERSION" ]; then
    echo "Invalid choice. Exiting."
    exit 1
fi

# Confirm the firmware version selection
echo "You have selected firmware version $FW_VERSION. Is this correct? (y/n)"
read -p "Enter your choice: " CONFIRMATION

if [[ $CONFIRMATION != "y" ]]; then
    echo "Firmware selection not confirmed. Exiting."
    exit 1
fi

# Define the paths for the stage1 and stage2 files based on the firmware version
STAGE1_FILE="stage1/$FW_VERSION/stage1.bin"
STAGE2_FILE="stage2/$FW_VERSION/stage2.bin"

# Create the execution script with the user inputs
cat <<EOL > pppwn_script.sh
#!/bin/bash

# Define variables
FW_VERSION=$FW_VERSION
STAGE1_FILE="$STAGE1_FILE"
STAGE2_FILE="$STAGE2_FILE"

# Disable eth0
ifconfig eth0 down

# Wait a second
sleep 1

# Enable eth0
ifconfig eth0 up

# Wait a second
sleep 1

# Change to the directory containing the pppwn executable
cd /home/pico/PPPwn-Luckfox/

# Execute the pppwn command with the desired options
./pppwn --interface eth0 --fw \$FW_VERSION --stage1 "\$STAGE1_FILE" --stage2 "\$STAGE2_FILE" -a -t 5 -nw -wap 2

# Check if the pppwn command was successful
if [ \$? -eq 0 ]; then
    echo "pppwn execution completed successfully."
    sleep 10
    ifconfig eth0 down
	sleep 5
	systemctl halt
else
    echo "pppwn execution failed. Exiting script."
    exit 1
fi
EOL

# Make the pppwn and script executable
chmod +x pppwn_script.sh
chmod +x pppwn

# Create the pppwn.service file
cat <<EOL > pppwn.service
[Unit]
Description=PPPwn Script Service
After=network.target

[Service]
Type=simple
ExecStart=/home/pico/PPPwn-Luckfox/pppwn_script.sh

[Install]
WantedBy=multi-user.target
EOL

# Move and enable the service file
sudo mv pppwn.service /etc/systemd/system/
sudo chmod +x /etc/systemd/system/pppwn.service
sudo systemctl enable pppwn.service

echo "install completed! rebooting..."

sudo reboot
