# php-always

This is an ultra-simple skeleton php application for pure PHP users.  
The currently implemented classes are sample codes that implement basic login and signup feature. If you need a new feature, implement a new class and add it to `classes/Controller.class.php` to easily implement and manage your web application with MVC patterns. I've deployed many projects based on code from this repository. I'll be implementing some pretty good router class soon. Long live pure PHP.  
  
Classics never die.

## Spec
\- [debian:11-slim](https://hub.docker.com/layers/library/debian/11-slim/images/sha256-139a42fa3bde3e5bad6ae912aaaf2103565558a7a73afe6ce6ceed6e46a6e519)  
\- [php8.1-apache](https://hub.docker.com/layers/library/php/8.1-apache/images/sha256-faf54b7511e54097fb5395aa8d03d50dae3f0010a21a5655030ff6c2a13dab17?context=explore)   
\- mariadb-server (latest, as of your build time)

## Usage
```
apt install docker docker-compose

git clone https://github.com/munsiwoo/php-always
cd ./php-always

docker-compose up -d --build

curl http://localhost:8080/
(default port is 8080)
```

## History
\- Sep 11, 2018: The `simple-mvc-php` repository has been made public.  
\- Mar 14, 2023: The project has been restructured.  
(The repository name has been changed from `simple-mvc-php` to `php-always`)
