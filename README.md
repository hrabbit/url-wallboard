# URL Wallboard

## Introduction

This project was built behind the idea of creating a generic wallboard that end users could use in order to create a simple wallboard for queue monitoring while connected to services at http://url.net.au/

## Installation

* Use a directory that is just below the documentroot on your webserver.
* Change to your working web directory. eg. cd /var/www (Debian/Ubuntu + Apache2)
* Install composer
** ```
curl -sS https://getcomposer.org/installer | php
```
* Create your composer configuration (composer.json)
** ```
{
    "require": {
        "monolog/monolog": "1.2.*"
    }
}
```