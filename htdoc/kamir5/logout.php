<?php
// session start
$HOSTNAME = explode(".", $_SERVER['HTTP_HOST']);
if(count($HOSTNAME) == 3)
	unset($HOSTNAME[0]);

$HOSTNAME = implode("_", $HOSTNAME);

session_name("$HOSTNAME");
session_set_cookie_params(0, "/", ".kormi.org");
session_start();
session_unset();
session_destroy();
header('Location:index.php');
?>