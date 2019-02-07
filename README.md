# php_messages
Simple real-time message passing server in PHP with JavaScript client.

The typical use case is a simple web application in which users visiting a web page communicate with each other.

## Configuration

You need to copy all files to the server and configure MySQL database. Edit `database.php` to set database login and password. Then create tables using the code from `create_tables.php` (the file may be then deleted from the server since running it repeatedly will delete all data).

User logins and groups should be also created manually.

## Message API

You can send and receive messages through JavaScript API implemented in `php_messages.js`. It is an asynchronous non-blocking interface implemented through function callbacks. This means that each time you send a request to the server you specify function which will be called when the response is ready.

First you have to create `MessageClient` object:

    client = new MessageClient(logout_callback);
  
where `logout_callback` is a function that should be executed when the client logouts.

Then, you have to login to the server specifying username and providing function called after successful login:

    client.login(USERNAME, init_callback);

Afterwards, you may read messages:

    client.read_message(MSG_TYPE, msg_received_callback, msg_timeout_callback, timeout);
    client.send_message(PEER_ID, MSG_TYPE, MSG_CONTENT);
  
Example callback function:
  
    msg_received_callback = function(msg) {
      alert(msg['sender']);
      alert(msg['content']);
    };
    
Messages can be filtered according to MSG_TYPE (arbitrary string) and read independently. Messages of the same type are read in FIFO (first in, first out) manner.
