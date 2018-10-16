# micro
Micro APP (clean) Docker(Iside: Symphony+PHP 7.1 + Apache + Nginx + Mysql 5.7 CS )

1. Clone or download this archive ./into-local-dir -> cd /into-local-dir
2. From insde project dir install dependencies for Symphony v4.0 via composer
   $ composer install
3. Run Docker compose it will download images and run project
   $ docker-compose up
4. After this manipulations project should be available via adress
   http://localhost:8080 - Application
   http://localhost:8085 - PHPMyAdmin UI
5. RabbitMQ management console and packages to use with complaing AMQP-Lib PHP
   
NOTE: This is template not a real-app, from this you can startup your microservice
      skeleton.
      
Also, you should understand, that is't bladed for Docker for Windows, I don't know
how it would work under Linux/UNIX :)     
   
Base app to grow some FUBAR software. 
Enjoy!

Sincereley yours, Michael S. Merzlyakov AKA predator_pc 2018 