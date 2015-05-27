#!/bin/bash

composer install --prefer-dist

vendor/bin/doctrine orm:schema-tool:update --force
