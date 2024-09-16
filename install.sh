#!/bin/sh

cat <<"EOF"
______________________________                       
\______   \______   \______   \__  _  ______  
 |     ___/|     ___/|     ___/\ \/ \/ /    \ 
 |    |    |    |    |    |     \     /   |  \     
 |____|    |____|    |____|      \/\_/|___|  /    
                                           \/       
 __                 __      _____                    
|  |  __ __   ____ |  | ___/ ____\_______  ___      
|  | |  |  \_/ ___\|  |/ /\   __\/  _ \  \/  / 
|  |_|  |  /\  \___|    <  |  | (  <_> >    <      
|____/____/  \____>__|___\ |__|  \____/__/\__\  
EOF

echo ""
echo "★ v1.2.3 ★"
echo ""
echo "by: https://github.com/0x1iii1ii/PPPwn-Luckfox"
echo "credit to:"
echo "https://github.com/TheOfficialFloW/PPPwn for pppwn"
echo "https://github.com/xfangfang/PPPwn_cpp for pppwn cpp"
echo "https://github.com/harsha-0110/PPPwn-Luckfox for webserver"
echo ""

# Constants
Green='\033[0;32m'   # Green
Yellow='\033[0;33m'  # Yellow
BGreen='\033[1;32m'  # Bold Green
BYellow='\033[1;33m' # Bold Yellow
BCyan='\033[1;36m'   # Cyan
NC='\033[0m'         # No Color

CURRENT_DIR=$(pwd)
LOG_DIR="/var/log/pppwn.log"
WEB_DIR="/var/www/data"
WEB_CONF="/etc/nginx"
CONFIG_DIR="/etc/pppwn"
CONFIG_FILE="$CONFIG_DIR/config.json"
LOG_DIR="/var/log/pppwn.log"

# Display the list of firmware versions
echo "Please select your PS4 firmware version:"
echo "a) 9.00"
echo "b) 9.03"
echo "c) 9.60"
echo "d) 10.00"
echo "e) 10.01"
echo "f) 10.50"
echo "g) 10.70"
echo "h) 10.71"
echo "i) 11.00"

# Prompt the user for the selection
while true; do
    # Firmware selection
    echo ""
    read -p "Enter your choice (a/b/c/d/e): " FW_CHOICE
    case $FW_CHOICE in
    a)
        FW_VERSION="900"
        READABLE_FW_VERSION="9.00"
        ;;
    b)
        FW_VERSION="903"
        READABLE_FW_VERSION="9.03"
        ;;        
    c)
        FW_VERSION="960"
        READABLE_FW_VERSION="9.60"
        ;;
    d)
        FW_VERSION="1000"
        READABLE_FW_VERSION="10.00"
        ;;
    e)
        FW_VERSION="1001"
        READABLE_FW_VERSION="10.01"
        ;;
    f)
        FW_VERSION="1050"
        READABLE_FW_VERSION="10.50"
        ;;
    g)
        FW_VERSION="1051"
        READABLE_FW_VERSION="10.70"
        ;;
    h)
        FW_VERSION="1070"
        READABLE_FW_VERSION="10.71"
        ;;                    
    i)
        FW_VERSION="1100"
        READABLE_FW_VERSION="11.00"
        ;;
    *) echo "Invalid choice. Please select a valid option." ;;
    esac

    # Confirmation of firmware version
    if [ -n "$READABLE_FW_VERSION" ]; then
        echo -e "You have selected firmware version ${BGreen}$READABLE_FW_VERSION${NC}. Is this correct? (y/n)"
        read -p "Enter your choice: " CONFIRMATION
        if [ "$CONFIRMATION" = "y" ]; then
            break
        else
            echo "Firmware selection not confirmed. Please select again."
            FW_CHOICE=""
            CONFIRMATION=""
        fi
    fi
done

# Ask if the user wants to use the web server
while true; do
    echo ""
    echo -e "Do you want to use the ${BGreen}Web Server${NC} features? (y/n)"
    read -p "Enter your choice: " USE_WEBSERVER
    if [[ "$USE_WEBSERVER" == "y" || "$USE_WEBSERVER" == "n" ]]; then
        READABLE_WEBSERVER=$([ "$USE_WEBSERVER" = "y" ] && echo "yes" || echo "no")
        if [[ "$USE_WEBSERVER" == "y" ]]; then
            HALT_CHOICE="false"
            READABLE_HALT_CHOICE="no"
            break
        else
            # If they don't want to use the web server, ask if they want to shut down the device
            while true; do
                echo ""
                echo "Do you want your luckfox to shutdown after successfully jailbreak? (y/n)"
                read -p "Enter your choice: " HALT
                if [[ "$HALT" == "y" || "$HALT" == "n" ]]; then
                    READABLE_HALT_CHOICE=$([ "$HALT" = "y" ] && echo "yes" || echo "no")
                    HALT_CHOICE=$([ "$HALT" = "y" ] && echo "true" || echo "false")
                    break
                else
                    echo "Invalid choice. Please enter 'y' or 'n'."
                fi
            done
            break
        fi
    else
        echo "Invalid choice. Please enter 'y' or 'n'."
    fi
done

echo ""
echo "Please select the pppwn executable you want to use:"
echo -e "a) ${BGreen}pppwn${NC} - a normal stable release for some PS4 models"
echo -e "b) ${BGreen}pppwn_ipv6${NC} - an update IPV6 which compatible for all PS4 models"
echo ""
echo -e "${BYellow}Note:${NC} if your PS4 doesn't work with \"pppwn\", try \"pppwn_ipv6\" by redo installation again or config from webserver"

while true; do
    read -p "Enter your choice (a/b): " PPPWN_CHOICE
    case $PPPWN_CHOICE in
    a)
        PPPWN_EXEC="pppwn"
        READABLE_PPPWN_EXEC="PPPwn"
        break
        ;;
    b)
        PPPWN_EXEC="pppwn_ipv6"
        READABLE_PPPWN_EXEC="PPPwn IPV6"
        break
        ;;
    *) echo "Invalid choice. Please select a valid option." ;;
    esac
done

confirm_settings() {
    echo ""
    echo -e "${BCyan}You have selected the following settings:${NC}"
    echo -e "PS4 Firmware: ${BGreen}$1${NC}"
    echo -e "PPPwn executable: ${BGreen}$2${NC}"
    echo -e "Web Server: ${BGreen}$4${NC}"
    echo -e "Shutdown after jailbreak: ${BGreen}$3${NC}"
    echo ""
    read -p "Are these settings correct? (y/n): " SETTINGS_CONFIRMATION
    if [[ $SETTINGS_CONFIRMATION != "y" ]]; then
        echo -e "${Red}Settings not confirmed. Exiting.${NC}"
        exit 1
    fi
}

confirm_settings "$READABLE_FW_VERSION" "$READABLE_PPPWN_EXEC" "$READABLE_HALT_CHOICE" "$READABLE_WEBSERVER"

# Create configuration directory if it doesn't exist
if [ ! -d "$CONFIG_DIR" ]; then
    mkdir -p $CONFIG_DIR
fi

# Create the config.json file with the install directory if it doesn't exist
if [ ! -f "$CONFIG_FILE" ]; then
    cat >$CONFIG_FILE <<EOL
{
    "FW_VERSION": "$FW_VERSION",
    "TIMEOUT": "5",
    "WAIT_AFTER_PIN": "5",
    "GROOM_DELAY": "4",
    "BUFFER_SIZE": "0",
    "AUTO_RETRY": true,
    "NO_WAIT_PADI": false,
    "REAL_SLEEP": false,
    "AUTO_START": true,
	"HALT_CHOICE": $HALT_CHOICE,
	"PPPWN_EXEC": "$PPPWN_EXEC",
    "install_dir": "$CURRENT_DIR",
    "log_file": "$LOG_DIR",    
    "shutdown_flag": false,
    "execute_flag": false,
    "eth0_flag": false
}
EOL
    chmod 777 $CONFIG_FILE
fi

# Remove the web directory if it already exists
if [ -d "$WEB_DIR" ]; then
    rm -rf $WEB_DIR
fi

if [ "$HALT_CHOICE" != "true" ]; then

    # Set up the web directory
    mkdir -p $WEB_DIR
    cp -r $CURRENT_DIR/web/data/* $WEB_DIR/
    cp -r $CURRENT_DIR/web/config/* $WEB_CONF/
    chown -R www-data:www-data $WEB_DIR
    chmod -R 755 $WEB_DIR
    # Set up pppoe configuration
    cp $CURRENT_DIR/web/pppoe/pppoe-server-options /etc/ppp/
    cp $CURRENT_DIR/web/pppoe/pap-secrets /etc/ppp/

fi

cat <<EOL >/etc/init.d/S99pppwn
#!/bin/sh

PPPWNDIR=$CURRENT_DIR

case \$1 in
    start)
        echo "Starting pppwn"
        # Execution run.sh
	    \$PPPWNDIR/run.sh
        \$PPPWNDIR/exec.sh
        ;;
    stop)
        echo "Stopping pppwn"
        ;;
    *)
        echo "Usage: \$0 {start|stop}"
        exit 1
        ;;
esac

exit 0
EOL

chmod +x pppwn pppwn_ipv6 run.sh exec.sh web-run.sh
chmod +x /etc/init.d/S99pppwn
echo -e "${BGreen}install completed!${NC}"
reboot
