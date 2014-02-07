# URL Wallboard

## Introduction

This project was built behind the idea of creating a generic wallboard that end users could use in order to create a simple wallboard for queue monitoring while connected to services at http://url.net.au/

## Installation

Change to your working web directory. (Example based on Debian/Ubuntu + Apache2)

```
cd /var/www
```

Install composer

```
curl -sS https://getcomposer.org/installer | php
```

Create your composer configuration (composer.json)

```
{
    "require": {
        "hrabbit/url-wallboard": "*"
    }
}
```