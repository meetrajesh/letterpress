Letterpress
===========

This is a web-based clone of the popular iOS word-game Letterpress using
purely PHP and Javascript.


Dev Setup Instructions
----------------------

### Minimum Requirements

* Running Apache Server
* PHP 5.3.6+. May work on PHP 5.2.x for now, but no guarantees it will continue to work going forward
* MySQL Server + Client
* git client

### Setup instructions:

1. Fork the repo on github by going to https://github.com/meetrajesh/letterpress and clicking 'Fork' on the top-right-hand corner
1. Git clone your fork: <code>git clone https://github.com/&lt;username>/letterpress.git</code>. Remember where you do this checkout. You will need it later.
1. Setup a vhost in your apache config file. On Mac, the config file lives at /etc/apache2/httpd.conf. On Linux, it's typically at /etc/httpd/conf/httpd.conf. Depends on your distro

<pre>
### for letterpress ###
&lt;VirtualHost *:80>
  ServerName localhost
  DocumentRoot "[webroot]>"
  &lt;Directory "[webroot]">
    Options +FollowSymlinks
    Order allow,deny
    Allow from all
    AllowOverride All
  &lt;/Directory>
&lt;/VirtualHost>
</pre>

Replace <code>[webroot]</code> with the full path of your letterpress git repo that you checked out in the previous step.

The <code>AllowOverride All</code> line is important. Don't forget it. It allows you to setup URL rewriting rules via a Apache-specific .htaccess config file which you can view here: https://github.com/meetrajesh/letterpress/blob/master/.htaccess

1. Import the MySQL database locally

<pre>
$ mysqladmin create letterpress
$ mysql letterpress &lt; schema.sql
</pre>

1. Create a file called <code>init.local.php</code> in your letterpress git repo and put this in there:

<code>
&lt;?php

define('BASE_URL', 'http://localhost');
define('IS_DEV', true);
define('CSRF_SECRET', '&lt;put some random string here thats about 40 chars long>');

// database credentials
define('DBHOST', 'localhost');
define('DBUSER', '');
define('DBPASS', '');
define('DBNAME', 'letterpress');
</code>

1. Replace your database credentials above if different from above.

1. Navigate to http://localhost/ on your browser. The game should load successfully. If not, ping me at rajesh@meetrajesh.com and I'll walk you through.



