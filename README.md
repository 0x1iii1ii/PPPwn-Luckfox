# PPPwn-Luckfox

An alternative low-cost Linux board for exploits PS4 on V11.00 or below.<br>
Original work by theflow <a href=https://github.com/TheOfficialFloW/PPPwn>PPPwn</a> 
and thanks to xfangfang <a href=https://github.com/xfangfang/PPPwn_cpp>PPPwn-CPP</a> for an executable re-write of PPPwn in C++ for Cotext-A7 which is compatible with RV1103/RV1106 chip
on the Luckfox Pico series and SiSTRo for his <a href=https://github.com/GoldHEN/GoldHEN>GoldHen</a>, and lastly <a href=https://github.com/stooged/PI-Pwn>Stooged</a> for his inspiration. <br>

![](https://github.com/0x1iii1ii/PPPwn-Luckfox/blob/main/images/image1.jpg)

## Note

- This is a very early <b> Work-In-Progress </b> it is still not stable sometimes the console crashes and freezes, so if you are a developer and want to improve this script, Please do so.
I'm looking for your contribution!
- Currently only support PS4 `V11.00`
  
## Requirements

- An SD Card 8GB or above
- Luckfox Pico Pro/Max/Plus
- Ethernet Cable
- USB Type-C for power to the board
- A USB drive with exFAT32 formatted (only use for the first time to load GoldHEN)

## Support Boards

- <b>Luckfox Pico Pro</b><br>
- <b>Luckfox Pico Max</b><br>
- <b>Luckfox Pico Plus</b><br>
- <b>Luckfox Pico Mini</b><br>
- <b>Luckfox Pico </b><br>

You can get one from the official site <a href=https://www.luckfox.com>Luckfox</a>  or from <a href=https://www.aliexpress.com/item/1005006083739388.html>Aliexpress</a> at around 15$.

# Special Note for Luckfox Pico/Mini
For this 2 boards, there's no Ethernet port, to make it work you need to solder the LAN Port (RJ45) cable to it, either Female or male is fine, and burn the Ubuntu image with pico plus image and follow the same step as other boards type.

<br>

<img src="https://github.com/0x1iii1ii/PPPwn-Luckfox/blob/main/images/image.jpg" alt="Luckfox Pico Mini" width="300">
<br>
## Installation Software

1. Download <a href=https://drive.google.com/drive/folders/1sFUWjYpDDisf92q9EwP1Ia7lHgp9PaFS>Ubuntu OS </a> After you download, extract one of the zip files according to your Luckfox Pico models. <br>
2. Burn the image onto an SD Card by following an official tutorial from Luckfox <a href=https://wiki.luckfox.com/Luckfox-Pico/Luckfox-Pico-SD-Card-burn-image>Here</a>.<br>
3. Place the SD card into the Luckfox, power it using USB Type-C, boot it, and connect it to the internet by plugging the LAN cable into the router<br>
4. Loggin to ubuntu:

`Login: pico` <br>
`Password: luckfox` <be>

You have `2 options` to log in:

- Using SSH: connect Luckfox to the internet via LAN cable, find its IP on your router and log in via SSH on PuTTY

- Using Serial: you need to have a serial-usb-converter module and connect it to Luckfox like this
                                   
serial-usb-converter  | Luckfox
------------- | -------------
RX ->  | TX
TX ->  | RX 

Open PuTTY click on serial, set `COM7` base on your serial-usb-converter and set baudrate to `115200`, then click open.

5. After you log in, run the following commands

<br>

```sh
sudo apt update
sudo apt install git -y
git clone https://github.com/0x1iii1ii/PPPwn-Luckfox.git
cd PPPwn-Luckfox
chmod +x pppwn
chmod +x pppwn_script.sh
sudo mv pppwn.service /etc/systemd/system/
sudo chmod +x /etc/systemd/system/pppwn.service
sudo systemctl enable pppwn.service
sudo reboot
```

<br>

Once the Luckfox reboots pppwn will run automatically.<br>

## Installation Hardware

1. You simply need to connect the LAN cable from Luckfox Pico to the PS4 and power the Luckfox from the PS4 via a USB Type-C cable or other sources.

## On your PS4:<br>

- Go to `Settings` and then `Network`<br>
- Select `Set Up Internet connection` and choose `Use a LAN Cable`<br>
- Choose `Custom` setup and choose `PPPoE` for `IP Address Settings`<br>
- Enter `ppp` for `PPPoE User ID` and `PPPoE Password`<br>
- NOTE if you enable internet access you must match the username and password entered during the install or use the default `ppp`
- Choose `Automatic` for `DNS Settings` and `MTU Settings`<br>
- Choose `Do Not Use` for `Proxy Server`<br>

For GoldHen you need to place the goldhen.bin file onto the root of a usb drive and plug it into the console.<br>
Once goldhen has been loaded for the first time it will be copied to the consoles internal hdd and the usb is no longer required.<br>
To update goldhen just repeat the above process and the new version will be copied to the internal hdd<br>

## What it does

Once everything is set up, the Luckfox should automatically try and PPPwn the console.<br>
The exploit may fail many times but the luckfox will continue to purge the console to keep trying to PPPwn itself.<br>
Once it PPPwned the process will stop. <br>

You will need to restart the Luckfox if you wish to PPPwn the console again.<br>

The idea is you boot the console and the Luckfox together and the Luckfox will keep trying to PPPwn the console without any input from you, just wait on the home screen until the process completes.<br>
