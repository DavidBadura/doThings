doThings!
=========

**with the power of taskwarrior!**

## Demo

|Key|Value|
|---|-----|
|Url|http://demo-dothings.david-badura.de/|
|Username|dothings|
|Password|dothings|

List:
![list](docs/list.png)

Info:
![info](docs/info.png)

Mobile:
![mobil](docs/mobile.png)

Installation
------------

```
composer install
npm install
```

Running in docker
-----------------

To run:
```
docker-compose up
```

To stop and clean:
```
docker-compose down
```

Docker-compose 1.7+ is required (and docker-engine 1.11+) because of v2 configuration file.

**NOTE:** Entire environment is wired for development (app_dev.php Symfony front controller), host mounted volumes with sources, gulp builder watching.

### Running tests

```
$ docker-compose exec php php bin/phpunit -c app/
PHPUnit 4.8.26 by Sebastian Bergmann and contributors.

...

Time: 48 ms, Memory: 6.00MB

OK (3 tests, 6 assertions)
```
