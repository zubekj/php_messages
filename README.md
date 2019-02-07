# php_messages
Simple real-time message passing server in PHP with JavaScript client.

The typical use case is a simple web application in which users visiting a web page communicate with each other.

## Configuration

You need to copy all files to the server and configure MySQL database. Edit `database.php` to set database login and password. Then create tables using the code from `create_tables.php` (the file may be then deleted from the server since running it repeatedly will delete all data).

User logins and groups should be also created manually.

## Message API
