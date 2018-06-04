<?php
session_start();

if(!isset($_SESSION["USERID"]) || trim($_SESSION["USERID"]) === null){
  require_once "external/home.php";
  new ExternalHome();
}else{
  require_once "internal/home.php";
  new InternalHome();
}
?>
