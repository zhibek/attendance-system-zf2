#!/bin/bash

composer install
php public/index.php migrations:run
