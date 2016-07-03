<?php
require_once('database.php');
require_once('message_box.php');
require_once('session_manager.php');


$db = db_connect();

$messagebox = new Messagebox($db);
$session_manager = new SessionManager($db);


#TODO: smarter login code
if($_GET["cmd"] == "login") {
  $id = $session_manager->login();
  echo(json_encode($id));

  if(!is_null($id)) {
    # Peer matching
    $peer_id = $session_manager->find_matching_peer($id);
    if(!is_null($peer_id)) {
      $messagebox->send_message($id, $peer_id, "JOIN_OFFER", "");
      $messagebox->send_message($peer_id, $id, "JOIN_OFFER", "");
    }
  } else {
    die("LOGOUT");
  }

  exit();
}

# Checking if logged in
$idle_time = $session_manager->calculate_idle_time($_GET["id"]);

if(is_null($idle_time) or $idle_time > 60*10) {
  if(!is_null($idle_time)) {
    $session_manager->close_session($_GET["id"]);
  }
  die("LOGOUT");
} 

$session_manager->update_activity($_GET["id"]);


switch ($_GET["cmd"]) {
  case "get_first_message":
    $res = $messagebox->get_first_message($_GET["id"], $_GET["type"]);
    echo(json_encode($res));
    break;

  case "delete_message":
    $msg = $messagebox->get_message($_GET["msg_id"]);
    if ($msg["receiver"] == $_GET["id"]) {
      $messagebox->delete_message($_GET["msg_id"]);
    }
    echo(json_encode($_GET["msg_id"]));
    break;

  case "send_message":
    $res = $messagebox->send_message($_GET["id"], $_GET["receiver"],
                                     $_GET["type"], $_GET["content"]);
    echo(json_encode($res));
    break;

  case "get_active_sessions":
    $res = $session_manager->get_active_sessions();
    echo(json_encode($res));
    break;

  case "get_activity":
    $res = $session_manager->get_activity($_GET["session_id"]);
    echo(json_encode($res));
    break;
}

?>
