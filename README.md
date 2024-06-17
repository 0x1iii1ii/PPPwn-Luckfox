# PPPwn-Luckfox

An alternative low-cost Linux board for exploits PS4 on V11.00 or below.<br>
Original work by theflow <a href=https://github.com/TheOfficialFloW/PPPwn>PPPwn</a> 
and thanks to xfangfang <a href=https://github.com/xfangfang/PPPwn_cpp>PPPwn-CPP</a> for an executable re-write of PPPwn in C++ for Cortex-A7 which is compatible with RV1103/RV1106 rockchip
on the luckfox pico series and SiSTRo for his <a href=https://github.com/GoldHEN/GoldHEN>GoldHen</a>, and lastly <a href=https://github.com/stooged/PI-Pwn>Stooged</a> for his inspiration. <br>

## Note

- Currently support PS4 version: `9.00, 9.60, 10.00, 10.01, 11.00`
- The average PPPwned time is around `1min - 2min` sometimes it load under `1 minute`
- Using `pppwn` nightly build from xfangfang PPPwn_cpp <be>

## Tested Version

- [x] 9.00
- [x] 9.60
- [x] 10.00
- [x] 10.01
- [x] 11.00
      
## What it does

The goal here is to setup the Luckfox pico to automatically try and jailbreak the console, all you need to do is wait until the process completes. Once it PPPwned the process will stop. <br>

## Requirements

- An SD Card 8GB or above
- Luckfox Pico/Pro/Max/Plus/Mini
- Ethernet Cable
- USB Type-C for power to the board
- A USB drive with exFAT32 formatted (only use for the first time to load GoldHEN)

## Support Boards

- <b>Luckfox Pico Pro</b><br>
- <b>Luckfox Pico Max</b><br>
- <b>Luckfox Pico Plus</b><be>
- <b>Luckfox Pico Mini *</b><br>
- <b>Luckfox Pico *</b><br>

## Installation Software

1. Download <a href=https://drive.google.com/drive/folders/1sFUWjYpDDisf92q9EwP1Ia7lHgp9PaFS>Ubuntu OS </a> After you download, extract one of the zip files according to your Luckfox Pico models. <br>
2. Burn the image onto an SD Card. Download <a href=https://drive.google.com/file/d/1ALo4G7rEaF1GNhUHINoYHT_RGWGddzYw>SocToolKit</a> and unzip the burning tool.
3. Open the software and select your chip type

Luckfox Models  | Chip Type
------------- | -------------
Luckfox Pico Pro/Max  | RV1106
Luckfox Pico/Plus/Mini  | RV1103 

4. Steps to download firmware for Luckfox Pico on Windows: <br>
  a. Choose the SD card tool.<br>
  b. The SD card size will be displayed under USB Disk. If not displayed, reinsert the card reader.<br>
  c. Select SD card booting.<br>
  d. Import the boot file.（Note: The startup files do not include update.img）<br>
  e. Click "Create SD Card".<br>

5. After done, eject and place the SD card into the Luckfox, power it using USB Type-C, and wait about `5 to 10 min` for luckfox to config the network, then connect it to the internet by plugging the LAN cable into the router <br> 
6. Loggin to ubuntu:

      log in using SSH: connect Luckfox to the internet via LAN cable, find its IP on your router, and log in via SSH on <a href=https://putty.org>PuTTY</a>

```sh
Login: pico
Password: luckfox
```

7. After you log in, run the following commands and follow the setup instruction

```sh
git clone https://github.com/0x1iii1ii/PPPwn-Luckfox.git
cd PPPwn-Luckfox
chmod +x install.sh
sudo ./install.sh
```

Once the Luckfox reboots pppwn will run automatically.<be>

## * Special Note for Luckfox Pico/Mini
Ignore this if you use Pro/Max/Plus version. For these 2 boards, there's no Ethernet port, to make it work you need to solder the LAN Port (RJ45) cable to it, either female or male is fine, and burn the Ubuntu image with `pico plus image` and follow the same step as other boards. See the wiring in the `Issues` tab.

## Installation Hardware

1. You simply need to connect the LAN cable from Luckfox Pico to the PS4 and power the Luckfox from the PS4 via a USB Type-C cable or other sources.

## On your PS4:<br>

- Go to `Settings` and then `Network`<br>
- Select `Set Up Internet connection` and choose `Use a LAN Cable`<br>
- Choose `Custom` setup and choose `PPPoE` for `IP Address Settings`<br>
- Enter `ppp` for `PPPoE User ID` and `PPPoE Password`<br>
- Choose `Automatic` for `DNS Settings` and `MTU Settings`<br>
- Choose `Do Not Use` for `Proxy Server`<br>

For GoldHen you need to place the goldhen.bin file onto the root of a usb drive and plug it into the console.<br>
Once goldhen has been loaded for the first time it will be copied to the consoles internal hdd and the usb is no longer required.<br>
To update goldhen just repeat the above process and the new version will be copied to the internal hdd<br>

## Upcoming alternative method using NAND flash

- no SD card
- boot faster
- execute pppwn faster
- higher success rate
