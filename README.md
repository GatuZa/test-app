To run the application you must:
1) git@github.com:GatuZa/test-app.git test-app.com
2) cd test-app.com
3) curl -sS https://getcomposer.org/installer | php OR php -r "readfile('https://getcomposer.org/installer');" | php
4) php composer.phar install
5) php protected/yiic migrate -> press "yes"