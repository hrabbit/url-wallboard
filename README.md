# URL Wallboard

## Introduction

This project was built behind the idea of creating a generic wallboard that end users could use in order to create a simple wallboard for queue monitoring while connected to services at http://url.net.au/

## Installation

Change to your working web directory. (Example based on Debian/Ubuntu + Apache2)

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