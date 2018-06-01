# chicken-coop-controller
This contains PHP and mysql code to control a Chicken coop door and other components. 
The door will open and close with the use of a car antenna attached to a 
Raspberry PI Zero W. 

The controller is hosted on the Pi via an Apache web server and various scripts written in PHP such that the user can schedule to time that the coop will open or close. In addition to schedulling the door open and close times, the webpage will also stream video and the current temperature.

It is intented the that PI will have a real time clock added to it such that if there is an internet failure as long as the controller is running or is rebooted the time will remain current and the door wil open and close as needed.

The pi controller is contained within a 3d printed enclosure which also contains a relay and and some circuitary to split off 5v from a 12v power supply.

In order to attach the antenna end to the door a 3d printed universal joint is used to allow for flex. It should possible to use this for both regular hinged doors as well as doors that slide.

#Installation
I barely know how to get the data into github at the moment but hopefully this thing will be packagized soon.
