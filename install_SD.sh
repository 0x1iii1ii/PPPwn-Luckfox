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
echo "★ SD ★ v1.1.0"
echo ""
echo "by: https://github.com/0x1iii1ii/PPPwn-Luckfox"
echo "credit to:"
echo "https://github.com/TheOfficialFloW/PPPwn"
echo "https://github.com/xfangfang/PPPwn_cpp"
echo ""

# Colors
Green='\033[0;32m'        # Green
Yellow='\033[0;33m'       # Yellow
BGreen='\033[1;32m'       # Bold Green
BYellow='\033[1;33m'      # Bold Yellow
BCyan='\033[1;36m'        # Cyan
NC='\033[0m'              # No Color

# Display the list of firmware versions
echo "Please select your PS4 firmware version:"
echo "a) 9.00"
echo "b) 9.60"
echo "c) 10.00"
echo "d) 10.01"
echo "e) 11.00"
echo ""
# Prompt the user for the selection
read -p "Enter your choice (a/b/c/d/e): " FW_CHOICE

# Set the firmware version based on the user's choice
declare -A fw_versions=(
    [a]="900"
	[b]="960"
    [c]="1000"
    [d]="1001"
    [e]="1100"
)

FW_VERSION=${fw_versions[$FW_CHOICE]}

if [ -z "$FW_VERSION" ]; then
    echo "Invalid choice. Exiting."
    exit 1
fi

echo "You have selected firmware version $FW_VERSION. Is this correct? (y/n)"
read -p "Enter your choice: " CONFIRMATION

if [[ $CONFIRMATION != "y" ]]; then
    echo "Firmware selection not confirmed. Exiting."
    exit 1
fi

echo ""
while true; do
    echo "Do you want your luckfox to shutdown after successfully jailbreak? (y/n)"
    read -p "Enter your choice: " HALT_CHOICE
    if [[ "$HALT_CHOICE" == "y" || "$HALT_CHOICE" == "n" ]]; then
        break
    else
        echo "Invalid choice. Please enter 'y' or 'n'."
    fi
done

echo ""
echo "Please select the pppwn executable you want to use:"
echo -e "a) ${BGreen}pppwn${NC} - a normal stable release for some PS4 models"
echo -e "b) ${BGreen}pppwn_ipv6${NC} - an update IPV6 which compatible for all PS4 models"
echo ""
echo -e "${BYellow}Note:${NC} if your PS4 won't success with \"pppwn\", Please use \"pppwn_ipv6\" by redo installation again using cmd \"sudo ./install.sh\""
echo ""
read -p "Enter your choice (a/b): " PPPWN_CHOICE

# Set the executable based on the user's choice
case $PPPWN_CHOICE in
    a) PPPWN_EXEC="./pppwn" ;;
    b) PPPWN_EXEC="./pppwn_ipv6" ;;
    *) echo "Invalid choice. Exiting."; exit 1 ;;
esac

case $PPPWN_CHOICE in
    a) READABLE_PPPWN_EXEC="pppwn" ;;
    b) READABLE_PPPWN_EXEC="pppwn_ipv6" ;;
esac

declare -A fw_readable=(
    [a]="9.00"
    [b]="9.60"
    [c]="10.00"
    [d]="10.01"
    [e]="11.00"
)
READABLE_FW_VERSION=${fw_readable[$FW_CHOICE]}
READABLE_HALT_CHOICE=$( [[ "$HALT_CHOICE" == "y" ]] && echo "yes" || echo "no" )

confirm_settings() {
    echo ""
    echo -e "${BCyan}You have selected the following settings:${NC}"
    echo -e "PS4 Firmware: ${BGreen}$1${NC}"
    echo -e "PPPwn executable: ${BGreen}$2${NC}"
    echo -e "Shutdown after successful jailbreak: ${BGreen}$3${NC}"
    echo ""
    read -p "Are these settings correct? (y/n): " SETTINGS_CONFIRMATION
    if [[ $SETTINGS_CONFIRMATION != "y" ]]; then
        echo -e "${Red}Settings not confirmed. Exiting.${NC}"
        exit 1
    fi
}

confirm_settings "$READABLE_FW_VERSION" "$READABLE_PPPWN_EXEC" "$READABLE_HALT_CHOICE"

STAGE1_FILE="stage1/$FW_VERSION/stage1.bin"
STAGE2_FILE="stage2/$FW_VERSION/stage2.bin"

cat <<EOL > pppwn_script.sh
#!/bin/bash

# Define variables
INSTALL_DIR="/home/pico/PPPwn-Luckfox/"
FW_VERSION=$FW_VERSION
STAGE1_FILE="$STAGE1_FILE"
STAGE2_FILE="$STAGE2_FILE"
HALT_CHOICE=$HALT_CHOICE
PPPWN_EXEC=$PPPWN_EXEC

# Disable eth0
ifconfig eth0 down
# Wait a second
sleep 1
# Enable eth0
ifconfig eth0 up
# Wait a second
sleep 1
# Change to pppwn directory
cd \$INSTALL_DIR
# Execute the pppwn command with the desired options
\$PPPWN_EXEC --interface eth0 --fw \$FW_VERSION --stage1 "\$STAGE1_FILE" --stage2 "\$STAGE2_FILE" -a -t 5 -nw -wap 2
# Check if the pppwn command was successful
if [ \$? -eq 0 ]; then
    echo "pppwn execution completed successfully."
    sleep 10
    ifconfig eth0 down
    if [[ "\$HALT_CHOICE" == "y" ]]; then
        sleep 5
        systemctl halt
    else
        echo "System halt skipped."
    fi
else
    echo "pppwn execution failed. Exiting script."
    exit 1
fi
EOL

chmod +x pppwn_script.sh
chmod +x pppwn
chmod +x pppwn_ipv6

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

sudo mv pppwn.service /etc/systemd/system/
sudo chmod +x /etc/systemd/system/pppwn.service
sudo systemctl enable pppwn.service

echo "install to SD completed! rebooting..."

sudo reboot
