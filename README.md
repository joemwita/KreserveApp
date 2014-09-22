KreserveApp
===========

A Hybrid Mobile Application for Restaurant Reservation

This application includes 2 sections. One section is in client side (Will be compiled as a Mobile App by Intel XDK or Phone Gap) and another section is in the server-side.
The client side is written by HTML5, CSS and jQuery Mobile. The Server-side is written in PHP and working with a MySql database. Server and client are connected by Ajax. Ajax is sending and receiving all data as JSON objects.

The server-side scripts is in appserver/indexserver.php

The client-side codes has 3 main parts as below:

1- CSS codes: AppClient/css/homepage.css
2- Html and UI codes: AppClient/index.html
3- front end scripts like jquery scripts, DOM manipulations and Ajax calls: AppClient/ajaxhandler.js
