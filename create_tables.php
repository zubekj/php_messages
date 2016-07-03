<?php
require_once('database.php');

$db = db_connect();

$db->query("DROP TABLE users;");
$db->query("CREATE TABLE users (
id INT(6) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(30),
group_id INT(6) UNSIGNED);");
$db->query("INSERT INTO users ('agent1', 1);");
$db->query("INSERT INTO users ('agent2', 2);");

$db->query("DROP TABLE sessions;");
$db->query("CREATE TABLE sessions (
id INT(6) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
last_active TIMESTAMP DEFAULT NOW(),
peer_id INT(6) UNSIGNED,
user_id INT(6) UNSIGNED);");

$db->query("DROP TABLE messages;");
$db->query("CREATE TABLE messages (
  id INT(6) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  sender INT(6) UNSIGNED NOT NULL,
  receiver INT(6) UNSIGNED NOT NULL,
  time TIMESTAMP DEFAULT NOW(),
  type VARCHAR(30) DEFAULT '',
  content BLOB);");

?>
