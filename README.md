This is one portion of a larger project of mine, RetorRubmble which is a clone I am making of the party game QuipLash. 

The main potion of this project I want to draw your attention too is the following:

* .files
  * .site
    * src
      * WebSockets
        * AbstractSocketHandler.php
        * CountdownHandler.php
    * composer.json
    * index.html
    * WSserver.php
  * .provision
    * Bootstrap.sh

The src directory contains a subdirectory for the relevant WebSockets, I have included the abstract Socket class I am using, and one of the several Websocket Handlers, in this case it handles performing a synchronized countdown over multiple websocket connections. 

**composer.json**, includes the three main dependencies ratchet, react/event-loop and phpdotenv the rest of the entries are dependencies of react/event-loop

**index.html** is a very simple page, that will just show the countdown (it currently has a hardcoded IP address, that is set in the vagrant config)

**WSserver.php** is a script that is run as a daemon, it creates the reactPHP event loop and adds a recurring timer event to it for the countdown, sets up the Web Socket server and listens to and parses incoming requests / messages over websockets.

This should be manually started from the command line via: php WSserver.php

Once that is done visiting the index.html page will show the countdown, additional debug info is displayed in the command line, while WSserver.php is running.

**bootstrap.sh** is the provisioning script for vagrant, that sets up the virtual machine, and configures everything the way i want it / sets the IP address to a known value so we can use that as a hardcoded value elsewhere. Eventually this will live on a server in the cloud somewhere and at such time we can switch the IP address to a domain name and everything will work the same (better in the case of the Content-Security-Policy)
