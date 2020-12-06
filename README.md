AUGS
================

This application is the Api Ubitransport Student Grading.

Installation
------------

### Clone repository into your server

```bash
$ git clone git@github.com:i-unlu/ubitransport-project.git .
```

### Install vendors

```bash
$ composer install
```

### API definition


#### Generate swagger definition

```bash
$ vendor/bin/openapi --format json --output ./public/swagger/swagger.json ./swagger/swagger.php src
```
