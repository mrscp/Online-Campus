<?php
$uri = substr($_SERVER['REQUEST_URI'], 1);
if($_SERVER['HTTP_HOST'] === "localhost"){
  $uri = substr($_SERVER['REQUEST_URI'], 8);
}

$uri = explode("?", $uri);
$array = explode("/", $uri[0]);
require_once "profile.php";
?>
