# PPPwn-Luckfox

An alternative low-cost Linux board for exploits PS4 on V11.00 or below.<br>
Original work by theflow <a href=https://github.com/TheOfficialFloW/PPPwn>PPPwn</a> 
and thanks to xfangfang <a href=https://github.com/xfangfang/PPPwn_cpp>PPPwn-CPP</a> for an executable re-write of PPPwn in C++ and SiSTRo for his <a href=https://github.com/GoldHEN/GoldHEN>GoldHen</a>, and lastly <a href=https://github.com/stooged/PI-Pwn>Stooged</a> for his inspiration. <br>

## Note

- Currently support version: `9.00, 9.60, 10.00, 10.01, 10.50, 10.70, 10.71, 11.00`
- The average PPPwned time is around `1min - 2min` sometimes it loads under `1 minute`
- Using `pppwn` C++ nightly build from xfangfang PPPwn_cpp <be>
- The problem where the PS4 does not shutdown properly (white blinking light) and sometimes crashes when trying to shutdown are still present in the current version resulting in an HDD check, please use it at your own responsibility!

## Contributing
Feel free to submit pull requests for improvements and bug fixes.

## Web Server Features
Thanks to [@harsha-0110](https://github.com/harsha-0110) for the webserver base scripts and PHP.<br>
You can access it at `192.168.1.1` on your PS4 browser. It allows you to:

- Change your PPPwn settings
- Shutdown your Luckfox device
- Execute PPPwn
- Inject payloads for 9.00 & 11.00 (make sure to enable BinLoader in GoldHEN)
- Set on/off auto-run PPPwn on boot (ON by default)
- Disable Eth0 (to free LAN port)
  
You can manually edit the configuration file located at `/etc/pppwn/config.json`.

## Support Boards

- <b>Luckfox Pico Pro</b><br>
- <b>Luckfox Pico Max</b><br>
- <b>Luckfox Pico Plus</b><be>
- <b>Luckfox Pico Mini B</b><br>

## Requirements

- One of Luckfox Pico models above
- Ethernet Cable
- USB Type-C
- A USB drive with exFAT formatted (only use for the first time to load GoldHEN)
- PC/Laptop for config the Luckfox


## Installation

Download one of the pre-build image for your respective Luckfox models and your PS4 version below or from the [release](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases) pages.<br>


| **Luckfox Models**             | **PS4 FW** | **Pre-build Image** 
| ----------------------------- | ---------- | ------------------- | 
| **Luckfox Pico Pro/Max**      | 9.00       | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_9.00.7z)        | 
|                               | 9.60       | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_9.60.7z)        |
|                               | 10.00      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_10.00.7z)        |
|                               | 10.01      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_10.01.7z)        |
|                               | 10.50      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_10.50.7z)        |
|                               | 10.70      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_10.70.7z)        |
|                               | 10.71      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_10.71.7z)        |
|                               | 11.00      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_FW_11.00.7z)        |
|                               | 9.00-11.00 (web server) | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pro_max_image_web_FW_9.00-11.00.7z)        |
| **Luckfox Pico Plus/Mini B**  | 9.00       | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_9.00.7z)        |
|                               | 9.60       | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_9.60.7z)        |
|                               | 10.00      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_10.00.7z)        |
|                               | 10.01      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_10.01.7z)        |
|                               | 10.50      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_10.50.7z)        |
|                               | 10.70      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_10.70.7z)        |
|                               | 10.71      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_10.71.7z)        |
|                               | 11.00      | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_FW_11.00.7z)        |
|                               | 9.00-11.00 (web server) | [download](https://github.com/0x1iii1ii/PPPwn-Luckfox/releases/download/1.2.5/pppwn_luckfox_v1.2.5_pico_plus_image_web_FW_9.00-11.00.7z)        |

Use [SocToolKit](https://drive.google.com/file/d/1ALo4G7rEaF1GNhUHINoYHT_RGWGddzYw) to burn the pre-build image you downloaded above to your Luckfox. Proceed to burn by following the official tutorial <a href=https://wiki.luckfox.com/Luckfox-Pico/Luckfox-Pico-RV1103/Luckfox-Pico-Flash-burn-image>here</a>.<be>

Once you flashed the image, pppwn will run automatically.<be>

```
If you use the pre-build image with web server, you need to open the web config, select your PS4 
version and pppwn type then run the exploit manually from the web
The auto-run PPPwn on boot changed to OFF by default,so if you want your luckfox to auto jailbreak at 
boot go to the config page again and tick the auto-run PPPwn to ON
```

## Installation Hardware

You simply need to connect the LAN cable from Luckfox Pico to the PS4 and power the Luckfox from the PS4 via a USB Type-C cable or other sources.

## On PS4:<br>

- Go to `Settings` and then `Network`<br>
- Select `Set Up Internet connection` and choose `Use a LAN Cable`<br>
- Choose `Custom` setup and choose `PPPoE` for `IP Address Settings`<br>
- Enter `ppp` for both `PPPoE User ID` and `PPPoE Password`<br>
- Choose `Automatic` for `DNS Settings` and `MTU Settings`<br>
- Choose `Do Not Use` for `Proxy Server`<br>
  
## GoldHEN:<br>

- For GoldHEN you need to place the goldhen.bin file onto the root of a USB drive and plug it into the console.<br>
- Once GoldHEN has been loaded for the first time it will be copied to the console's internal HDD and the USB is no longer required.<br>
- To update GoldHEN just repeat the above process and the new version will be copied to the internal HDD. <be>
