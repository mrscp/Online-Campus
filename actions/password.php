<?php
session_start();
/**
 * File Name: Passowrd update
 */

 require_once "../ess/base.php";
 require_once "../ess/internal.php";
 require_once "../ess/check.php";
 require_once "../ess/io.php";

Internal::authenticate();

class Password extends Check{
  public function __construct($array){
    parent::__construct();

    $link = parent::connect();

    parent::password($array["new"], $array["confirm"]);
    $result = $link->query("SELECT password FROM member WHERE user_id='".$_SESSION["USERID"]."'");
    $password_q = mysqli_fetch_assoc($result);
    if(strcmp($password_q["password"], IO::hash_password($array["current"])) != 0){
      $this->report["message"]["password"] = "Current password did not match!";
      $this->report["success"] = false;
    }
    if(parent::success() == true){
      $result = $link->query("UPDATE member SET password='".IO::hash_password($array["new"])."' WHERE user_id='".$_SESSION["USERID"]."'");
      $this->report["successMessage"] = "Password updated!";
      //$this->report["redirect"] = Ess::get_host();
    }else{
      $this->report["password"]["message"] = "Something went wrong!";
      $this->report["success"] = false;
    }
    $link = parent::close($link);
  }

}

if($_POST){
  $password = new Password(IO::serializeInput($_POST));
  echo json_encode($password->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
