#!/bin/bash

cd /vagrangt;

composer install --prefer-dist;

./bin/cli orm:schema-tool:update --force;

./bin/cli schema:data-generate ;
