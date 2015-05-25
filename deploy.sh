#!/bin/bash

chmod 0777 -R application/cache
chmod 0777 -R application/logs

composer install
php public/index.php migrations:run
