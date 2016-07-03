<?php

function db_connect() {
  $host = '127.0.0.1';
  $login = 'waiter';
  $password = 'qwerty';
  $db = 'waiting_room';

  $connection = new mysqli($host, $login, $password, $db);
  
  if ($connection->connect_errno) {
      echo("Failed to connect to MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error);
  }  

  return $connection;
}

?>
