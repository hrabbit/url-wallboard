# URL Wallboard

## Introduction

This project was built behind the idea of creating a generic wallboard that end users could use in order to create a simple wallboard for queue monitoring while connected to services at http://url.net.au/

## Requirements

* Apache or Nginx or "Other"
* PHP
* PHP Sqlite3
* PHP Curl

## Installation

Clone this repository to your web directory. (Parent of your web generally, not tested in a sub directory).

```
git clone git@github.com:hrabbit/url-wallboard.git
```

Install composer

```
curl -sS https://getcomposer.org/installer | php
```

Install requirements

```
php composer.phar update
```

You should be ready to roll. The 'web' directory is your DocumentRoot and therefore should be named to suite.

## Configuration

### Apache2

There is a .htaccess included in this repository ready to work. If required, tweak the RewriteBase directive to suite.

### Nginx

Below are the requirements for your service configuration. Nginx is not my strongest area so any more info here will be taken appreciatively.

```
server {
    #site root is redirected to the app boot script
    location = / {
        try_files @site @site;
    }

    #all other locations try other files first and go to our front controller if none of them exists
    location / {
        try_files $uri $uri/ @site;
    }

    #return 404 for all php files as we do have a front controller
    location ~ \.php$ {
        return 404;
    }

    location @site {
        fastcgi_pass   unix:/var/run/php-fpm/www.sock;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME $document_root/index.php;
        #uncomment when running via https
        #fastcgi_param HTTPS on;
    }
}
```
