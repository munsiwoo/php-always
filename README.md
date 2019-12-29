# Simple MVC in PHP

This is a simple PHP framework.
Implemented in an MVC pattern and includes a simple router and a [MunTemplate](https://github.com/munsiwoo/mun-template).

| Dev env         | Name          |
| ----------- | ------------- |
| OS          | Ubuntu 16.04  |
| Server | Apache2       |
| language | PHP 7, SQLite3 |

### Installation for linux

```bash
git clone https://github.com/munsiwoo/simple-mvc-in-php
cd simple-mvc-in-php

docker build -t phpmvc:v1 .
docker run -it -d -p 3000:80 --name mvc phpmvc:v1
docker exec -it mvc service apache2 start
```

##### Check server status

```bash
curl -I 0.0.0.0:3000

HTTP/1.1 200 OK
Date: Sat, 12 Oct 2019 15:48:04 GMT
Server: Apache/2.4.18 (Ubuntu)
Set-Cookie: session_id=foo; path=/
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate
Pragma: no-cache
Content-Type: text/html; charset=UTF-8
```





