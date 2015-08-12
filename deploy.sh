#!/bin/bash

cd /vagrangt;

composer install --prefer-dist;

./vendor/bin/doctrine-module orm:schema-tool:drop --force;
./vendor/bin/doctrine-module orm:schema-tool:update --force;
#./bin/cli schema:data-generate ;