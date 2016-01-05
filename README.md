To run the application you must:

1) Clone the repo: git@github.com:GatuZa/test-app.git test-app.com && cd test-app.com

2) Install composer: curl -sS https://getcomposer.org/installer | php OR php -r "readfile('https://getcomposer.org/installer');" | php

3) php composer.phar install

4) Prepare databases:
- create database "app" and run "php protected/yiic migrate"
- create database "test_app" for tests and run "php protected/yiic migrate --connectionID=test_db"

5) You can run tests:
- run Selenium server: cd protected/vendor/netwing/selenium-server-standalone && java -jar -debug selenium-server-standalone-2.46.0.jar
- run the tests: go to protected/tests and run ../../bin/phpunit --verbose functional
