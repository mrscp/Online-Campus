<?php
session_start();
/**
 * Filename: Signout
 */
require_once "../ess/base.php";
require_once "../ess/internal.php";

class Signout extends Internal
{
  function __construct()
  {
    parent::authenticate();
    unset($_SESSION["USERID"]);
    unset($_SESSION["EMAIL"]);
    unset($_SESSION["FIRSTNAME"]);
    header("location: " . urldecode($_GET["redirect"]));
  }
}
new Signout();
?>
