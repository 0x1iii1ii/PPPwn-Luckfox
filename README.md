# PPPwn-Luckfox

An alternative low-cost Linux board for exploits PS4 on V11.00 or below.<br>
Original work by theflow <a href=https://github.com/TheOfficialFloW/PPPwn>PPPwn</a> 
and thanks to xfangfang <a href=https://github.com/xfangfang/PPPwn_cpp>PPPwn-CPP</a> for an executable re-write of PPPwn in C++ and SiSTRo for his <a href=https://github.com/GoldHEN/GoldHEN>GoldHen</a>, and lastly <a href=https://github.com/stooged/PI-Pwn>Stooged</a> for his inspiration. <br>

## Note

- Currently support PS4 version: `9.00, 9.60, 10.00, 10.01, 11.00`
- The average PPPwned time is around `1min - 2min` sometimes it loads under `1 minute`
- Using `pppwn` nightly build from xfangfang PPPwn_cpp <be>
  
## What it does

Automatically try and jailbreak the console itself, all you need to do is wait until the process completes. Once it's done the process will stop. <br>

## Support Boards

- <b>Luckfox Pico Pro</b><br>
- <b>Luckfox Pico Max</b><br>
- <b>Luckfox Pico Plus</b><be>
- <b>Luckfox Pico Mini A/B * </b>(Mini A No NAND flash, not support NAND method)<br>
- <b>Luckfox Pico *</b> (No NAND flash, not support NAND method) <br> 

## Requirements

- An SD Card 8GB or above with good R/W speed (only required if you use the SD Card method)
- Luckfox Pico/Pro/Max/Plus/Mini
- Ethernet Cable
- USB Type-C
- A USB drive with exFAT32 formatted (only use for the first time to load GoldHEN)

## Installation in NAND Flash <a name="nandinstallation"></a>

1. If you have a brand new Luckfox Pico Plus/Pro/Max skip to step 4.
2. If your Luckfox Pico Plus/Pro/Max has been used with SD Card before, you need to use <a href=https://drive.google.com/file/d/1ALo4G7rEaF1GNhUHINoYHT_RGWGddzYw>SocToolKit</a> to re-burn the buildroot image files again which can be found in <a href=https://drive.google.com/drive/folders/1sFUWjYpDDisf92q9EwP1Ia7lHgp9PaFS>Firmware</a> and select buildroot image according to your Luckfox models and proceed to burn it by following the official Luckfox tutorial on how to <a href=https://wiki.luckfox.com/Luckfox-Pico/Luckfox-Pico-RV1103/Luckfox-Pico-Flash-burn-image>Burning SPI NAND Flash Images</a>.
3. For Luckfox Pico Mini B you need to re-burn the buildroot image `Luckfox_Pico_Plus_Flash`.
4. Plug your luckfox to your PC via USB type-c port and wait a few minutes until you hear the device connect sound.
5. On your PC open `Control Panel -> Network and Internet -> Network and Sharing Center -> Change Adapter Options`. You will find `Remote NDIS based Internet Sharing Device`. Right-click and choose Properties.<be>

      ![](images/0.jpg)

6. Double-click on `Internet Protocol Version 4 (TCP/IPv4)`. Set the IPv4 address to `172.32.0.100` and subnet mask to `255.255.0.0` and click OK.<be>

      <p float="left">
        <img src="images/1.jpg" width="300" />
        <img src="images/2.jpg" width="336" /> 
      </p>

7. MobaXterm Login
   - Download <a href=https://drive.google.com/file/d/1pLikKXgdJNWqmylq8UYwXPDGaEDfxjNG>MobaXterm</a> and unzip to use.
   - Open the MobaXterm remote login software, choose Session->SSH, and enter the static IP address of Luckfox pico as `172.32.0.93`.<br>
   
        <img src="images/3.png" alt="Image 3" style="width: 600px;">
  
   - After filling it out, click OK, enter the login name, and login `root` password `luckfox`.
8. At this point, you have successfully logged in to Luckfox pico. Download <a href= https://github.com/0x1iii1ii/PPPwn-Luckfox/archive/refs/heads/main.zip>PPPwn-Luckfox</a> from release pages or from GitHub repo, unzip and rename folder to `PPPwn-Luckfox` drag and drop the files in the highlight red rectangle there, it will copy the files to the luckfox. <be>
   
   <img src="images/4.png" alt="Image 4" style="width: 700px;">
   
9.  After finish copy, paste this cmd, and follow instructions.

```sh
cd PPPwn-Luckfox
chmod +x install_NAND.sh
./install_NAND.sh
```
Once the Luckfox reboots pppwn will run automatically.<be>

## Installation in SD Card

1. Download <a href=https://drive.google.com/drive/folders/1sFUWjYpDDisf92q9EwP1Ia7lHgp9PaFS>Ubuntu</a>. After you download, extract one of the zip files according to your Luckfox pico models. <br>
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

5. After done, follow instructions from steps 4, 5, and 6 in [Installation in NAND Flash](#nandinstallation), for step 7 log in using static IP `172.32.0.70` login name `pico` and password `luckfox`.

6. After you logged in, follow step 8 in [Installation in NAND Flash](#nandinstallation), then run the following commands, and follow the setup instruction

```sh
cd PPPwn-Luckfox
chmod +x install_SD.sh
sudo ./install_SD.sh
```

Once the Luckfox reboots pppwn will run automatically.<be>

## Update PPPwn-Luckfox
For SD card with Ubuntu.
log in to your luckfox, connect it to the internet, then run this cmd:
```sh
cd PPPwn-Luckfox
sudo ./update.sh
```
For NAND, you need to manually copy the update files to luckfox using MobaXterm, then run this cmd.
```sh
cd PPPwn-Luckfox
./install_NAND.sh
```
## * Special Note for Luckfox Pico/Mini
Ignore this if you use Plus/Pro/Max version. For these 2 boards, there's no Ethernet port, to make it work you need to solder the LAN Port (RJ45) cable to it, either female or male is fine, and burn the Ubuntu image with `pico plus image` and follow the same step as other boards. Same with the NAND method by burning the buildroot image `Luckfox_Pico_Plus_Flash`. See the wiring in the `Issues` tab.

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
To update goldhen just repeat the above process and the new version will be copied to the internal HDD. <br>

