Provisioning a remote server
============================

Setup a private key on the box to be provisioned, matching a public key to you available locally (use ~/.ssh/id_rsa and you won't need to add the key explitly to knife solo commands).
We'll use the <user> you created the private key with in the steps below. Please note, this user should have sudo rights without requiring a password.


Install knife solo:

    sudo apt-get install ruby-dev
    sudo gem install knife-solo


Run knife solo bootstrap, following by knife solo cook (use --verbose if you want to observe what's happening on the server):

    knife solo bootstrap <user>@<hostname>
    knife solo cook <user>@<hostname> nodes/dev.json


Known issue: An error relating to "procps" will be shown when knife solo cook is first run. This error is triggered from cookbook "sysctl" which shouldn't be modified.
Until we have a fix, the work around is to run knfe solo cook a second time (which avoids the error):

    knife solo cook <user>@<hostname> nodes/dev.json


The server is now provisioned, but (unless you already put it there) no application code exists yet. Our deployment process should handle this, but for now we need to ssh into the server and clone the github repo:

    ssh <user>@<hostname>
    sudo rm -fr /var/www/logs
    sudo git clone https://github.com/camelcasetechsd/attendance-system.git /var/www
    sudo mkdir /var/www/logs
    sudo /var/www/deploy.sh


Now, you should be able access the web site on the host address, i.e. http://<host>.
