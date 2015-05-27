#!/bin/bash

cd /vagrant
composer install

vendor/bin/doctrine orm:schema-tool:update --force