# appVertical-lite-client
This is a web lite client for the french application "**Vertical**". It's a service which provide application exclusive videos. I sniffed packets coming in and out of the application to understand how the API works and how to replicate the application requests.
This means that you don't need to download the application and you can watch their videos on your computer or mobile phone. It's responsive.
Nothing is hosted on your web server, you just retrieve data remotely from Vertical servers.

I will probably add the homepage cache soon (Save links to not reload everytime).

## Configuration : Javascript (v.2)
Mody these lines in script.js with your account details. A test account is already there, please don't change its password.
```
/*Login details to change*/
const user = "testazerty"
const pass = "testazerty"
```
You are good to go. In this new Javascript version, the access token and the home page videos are stored in cache (Session Storage) so it can be very quick to load.
Keep in mind that Cross Origin Policy prevents Javascript to load external content. That's why i'm using CORS Anywhere, a NodeJS proxy, so you don't have anything to install. If you want to run your own instance of CORS Anywhere, alter this line with your server's details.
```
//Bypass Cross Origin Policy
const corsProxy = "https://cors-anywhere.herokuapp.com/"
```
You can find CORS Anywhere Github repository here : [https://github.com/Rob--W/cors-anywhere](https://github.com/Rob--W/cors-anywhere)

## Configuration : PHP (v.1)
Upload all files on a webserver with **PHP** and **php-curl** installed. *I only tested it on PHP 7.2 though.*
Just run these commands to install everything you need :

	sudo add-apt-repository ppa:ondrej/php-7.0
	sudo apt-get update && apt-get upgrade
	sudo apt-get install php7.0-cli php7.0-common libapache2-mod-php7.0 php7.0 php7.0-mysql php7.0-fpm php7.0-curl php7.0-gd php7.0-bz2
    	sudo apt-get install php7.0-curl

Change login details in **functions.php** (A test account is already there, don't change it's password please !).

    /*Login details to change.*/
    $username = "testazerty";
    $password = "testazerty";

## Demo
You can test it live here (The new JS version !) : [https://github.asauvage.fr/vertical/](https://github.asauvage.fr/vertical/)

## Screenshots
Mobile view :

![Homepage and video viewer](https://github.asauvage.fr/img/vertical/1.jpg)

Computer view :

![Homepage](https://github.asauvage.fr/img/vertical/2.jpg)
![Video viewer](https://github.asauvage.fr/img/vertical/3.jpg)
