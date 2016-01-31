Purpose: create simple interface for tables. Implement simple functionality (create, edit, delete). Create simple unit tests.

To run the application you must:

1) Clone the repo: git clone git@github.com:GatuZa/test-app.git local2maker.com && cd local2maker.com

2) Install composer (one of two):
curl -sS https://getcomposer.org/installer | php
php -r "readfile('https://getcomposer.org/installer');" | php

3) php composer.phar install

4) Prepare databases:
- create database "local2maker" and run "php protected/yiic migrate"
- create database "local2maker_tests" for tests and run "php protected/yiic migrate --connectionID=unit_tests"
- edit database configuration files in protected/config folder: database.php, database-tests.php. 

5) You can run tests:
- run Selenium server: cd protected/vendor/netwing/selenium-server-standalone && java -jar -debug selenium-server-standalone-2.46.0.jar
- run the tests: cd  protected/tests && ../../bin/phpunit --debug --verbose functional

Test tested with:
- Firefox 26.0b3
- Selenium server standalone 2.46

Sometimes when used unix OS the migrations not inserted data to unit test DB (user table). In this case you must insert the data manually.