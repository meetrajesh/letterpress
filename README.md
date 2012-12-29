Letterpress
===========

This is a web-based clone of the popular iOS word-game Letterpress using
purely PHP and Javascript.


Dev Setup Instructions
----------------------

### Minimum requirements:

* Running Apache Server
* PHP 5.3.6+. May work on PHP 5.2.x for now, but no guarantees it will continue to work going forward
* MySQL Server + Client
* git client

### Setup instructions:

1. Git clone this repo: <code>git clone https://github.com/meetrajesh/letterpress.git</code>. Remember where you put this repo. You will need it later.
1. Setup a vhost in your apache config file. On Mac, the config file lives at /etc/apache2/httpd.conf

<code>
### for letterpress ###
<VirtualHost *:80>
  ServerName localhost
  DocumentRoot "<letterpress_dir>"
  <Directory "<letterpress_dir>">
    Options +FollowSymlinks
    Order allow,deny
    Allow from all
    AllowOverride All
  </Directory>
</VirtualHost>
</code>

Replace <code><letter_press_dir></code> with the full path of your letterpress git repo that you checked out in the previous step.

The <code>AllowOverride All</code> line is important. Don't forget it. It allows you to setup URL rewriting rules via .htaccess config files.

1. Import the MySQL database locally

<code>
$ mysqladmin create letterpress
$ mysql letterpress < schema.sql
</code>

1. Create a file called <code>init.local.php</code> in your letterpress git repo and put this in there:

<code>
<?php

define('BASE_URL', 'http://localhost');
define('IS_DEV', true);
define('CSRF_SECRET', '<put some random string here thats about 40 chars long>');

// database credentials
define('DBHOST', 'localhost');
define('DBUSER', '');
define('DBPASS', '');
define('DBNAME', 'letterpress');
</code>

1. Replace your database credentials above if different from above.

1. Navigate to http://localhost/ on your browser. The game should load successfully. If not, ping me at rajesh@meetrajesh.com and I'll walk you through.



