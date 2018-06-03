# chicken-coop-controller
This contains PHP and mysql code to control a Chicken coop door and other components. 
The door will open and close with the use of a car antenna attached to a 
Raspberry PI Zero W. 

The controller is hosted on the Pi via an Apache web server and various scripts written in PHP such that the user can schedule to time that the coop will open or close. In addition to schedulling the door open and close times, the webpage will also stream video and the current temperature.

It is intented the that PI will have a real time clock added to it such that if there is an internet failure as long as the controller is running or is rebooted the time will remain current and the door wil open and close as needed.

The pi controller is contained within a 3d printed enclosure which also contains a relay and and some circuitary to split off 5v from a 12v power supply.

In order to attach the antenna end to the door a 3d printed universal joint is used to allow for flex. It should possible to use this for both regular hinged doors as well as doors that slide.

# Installation
1 - Set up appache webserver and copy scripts to /var/www/html/

2 - setup job scheduller
  nano Crontab -e
  paste in two lines below at bottom  
  * * * * * /usr/bin/php "/var/www/html/door_schedule.php" >/dev/null 2>&1
 @reboot sh /home/pi/launcher.sh >/dev/null 2>&1

chmod 777 /var/www/html/door_schedule.php
copy launcher.sh to /home/pi
chmod 777 /home/pi/launcher.sh

sudo raspi-config -> Interfacing options -> enable camera.

Install Dave Jones Pistreaming check readme-> https://github.com/waveform80/pistreaming/blob/master/README.md
sudo apt-get install libav-tools git python3-picamera python3-ws4py
git clone https://github.com/waveform80/pistreaming.git


      
