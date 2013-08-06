metrodigiexercise
=================

## Setup

You'll need the following:

**mysql create table:**

```mysql
CREATE TABLE `sfo_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `temp_min` decimal(5,2) DEFAULT NULL,
  `temp_max` decimal(5,2) DEFAULT NULL,
  `temp_avg` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`timestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
```

**Apache vhosts for www.metrodigiweather.com and api.metrodigiweather.com**
```
<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	ServerName www.metrodigiweather.com
	ServerAlias api.metrodigiweather.com

	Header set Access-Control-Allow-Origin "*"
	Header set Access-Control-Allow-Headers "X-Requested-With"

	DocumentRoot /home/mmarcus/PhpstormProjects/metro_digi_test/weather
	#<Directory />
	#	Options FollowSymLinks
	#	AllowOverride None
	#</Directory>
	<Directory /home/mmarcus/PhpstormProjects/metro_digi_test/weather>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride all
        	Order allow,deny
        	allow from all
	</Directory>

	ScriptAlias /cgi-bin/ /usr/lib/cgi-bin/
	<Directory "/usr/lib/cgi-bin">
		AllowOverride None
		Options +ExecCGI -MultiViews +SymLinksIfOwnerMatch
		Order allow,deny
		Allow from all
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/error.log

	# Possible values include: debug, info, notice, warn, error, crit,
	# alert, emerg.
	LogLevel warn

	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
**hosts file entries**

127.0.0.1   localhost www.metrodigiweather.com api.metrodigiweather.com


## Requirements and comments

Warm Up:
1. Given a directory, retrieve a list of all files within directory and subdirectory (iterative or recursive).
**--Done. just run get_dir_list.php from the CLI**
2. Given an XML document with the following schema, please produce an order list of the steps as a string:
```xml
<root>
<instructions>
<step order="1">Cook spaghetti</step>
<step order="3">Add Sauce</step>
<step order="2">Drain from pot</step>
</instructions>
<dish>Pasta</dish>
</root>
```
**--Done. Just run order_list.php from the CLI**

Task 1
Create a web application in PHP that displays the maximum, minimum, and average temperature for San Francisco airport for a particular day. The data can be retrieved from the National Climate Date Center website (http://www.ncdc.noaa.gov/most-popular-data#lcdus > Quality Controlled Local Climatological Data > California > SFO).  The application should provide the following functionality:

1. Data should be downloaded from the climate date center and imported into a MySQL database **-- Climate center site didn't have any API that I could find so I opted for weathersource.com's API and PHP SDK.  Gives climatological data based on postal code w/ free account and can do longitude and latitude with a paid account.  Works for a POC.**
2. Create a view that displays the temperature results in a table **--Done, could use better error handling in the client (see TODO comments in client-side code)**
3. Users should also be able to click a refresh button on the page that will refresh the temperature data via an AJAX call. **--Wasn't quiet clear on how this should operate so I opted for an onChange ECMA event to just fire off multiple requests to the server**

Bonus Points: Provide a simple API to manage the data you have ingested in accordance with a REST/resource oriented architecture.**--Somewhat completed.  GET works, could use some polishing. Other HTTP methods are structured out in weatherapi.class.php, just not implemented.**

Task 2 **--couldn't get to this in time**
Create an application (either web-based or CLI) that accepts two arguments for input. The system should output the sum of the two numbers but without using the native addition or subtraction operator within PHP.

Task 3 **--couldn't get to this in time**
For the following function please provide both a recursive and iterative solution for any given input:

f(x) = f(x-1)^3 + f(x-2)^2 + f(x-3)

where

f(3) = 3
f(2) = 2
f(1) = 1

Essentially translate the mathematical notation into PHP code.
