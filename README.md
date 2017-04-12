Dominoes
========
A dominoes game (in progress) written in part to get more experience with the following
frameworks and technologies:

1. [Slim Framework](https://www.slimframework.com/)
1. [PHP DI](http://php-di.org/)
1. [MongoDB](https://www.mongodb.com/)
1. [Vue](http://vuejs.org/)
1. [Codeception](http://codeception.com/)
1. [Atom (text editor)](https://atom.io/)

The application consists of two parts:

1. Server side component (PHP, MongoDB)
1. Client side component that runs in the browser (HTML, Javascript)

Requirements
------------

Requirements for running the server side of this game are:

* PHP (version 7.1 or higher)
* MongoDB

Also the following PHP extensions must be installed:

* mbstring
* curl
* xml
* PECL Mongo DB extension (not the PHP mongo extension, see http://php.net/manual/en/mongodb.installation.pecl.php)


Installation
------------
Use [composer](https://getcomposer.org/) to install the PHP dependencies:

    composer install

To install the javascript dependencies, you will need npm and [webpack](https://webpack.js.org/).

    npm install vue

To install or update the javascript files, run webpack:

    webpack


Testing
-------
Tests are written using [codeception](http://codeception.com/) and can be found in the `tests` folder. So far only acceptance tests have been added.

Use the `./run-test.sh` script to run the automated tests. The script will clean up and initialize the test database and then run the tests.

The automated tests expect selenium and the web application to be running. To start selenium (you need java):

    vendor/bin/selenium-server-standalone

To run the web application using the PHP built-in web server:

    cd web
    APP_ENV=test php -S localhost:8000

Then run the tests:

    ./run-test.sh

License
-------

See [LICENSE.md](LICENSE.md)
