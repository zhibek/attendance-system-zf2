Attendance System
=================

Installation
------------

### Clone repo and provision with vagrant:

    git clone git@github.com:camelcasetechsd/attendance-system.git
    cd attendance-system
    vagrant up
    vagrant provision ## run this if the initial "vagrant up" had any fatal error preventing it completing


### Add the IP to your hosts file:

    10.1.1.33     attendance.localhost


### Access the box:

To access the vagrant environment from the terminal, change to the vagrant directory and type 

    vagrant ssh


### Use composer to install PHP dependencies:

    cd /vagrant
    composer install --prefer-dist

### Use bower to install css/js dependencies:
    cd /vagrant/public
    bower install 

### Install latest database schema
    cd /vagrant
    ./bin/cli orm:schema-tool:update --force

### Install acceptance data
    cd /vagrant
    ./bin/cli schema:data-generate 

### View the site:

Visit [http://attendance.local/](http://attendance.local/) to view the site.
