<?php
/**
 * File Name: Change password for password recovery
 */
require_once "../ess/base.php";
require_once "../ess/internal.php";
require_once "../ess/check.php";
require_once "../ess/io.php";

class Change extends Check{
  public function __construct($array){
    parent::__construct();

    $link = parent::connect();
    $sql = "SELECT * FROM forgot_token WHERE token='".$array["token"]."'";
    $result = mysqli_query($link,$sql);
    $token = mysqli_fetch_assoc($result);
    parent::password($array["password"], $array["cpassword"]);
    if(strcmp($token["token"], $array["token"]) == 0 && parent::success() == true){
      $result = $link->query("UPDATE member SET password='".IO::hash_password($array["password"])."' WHERE email='".$token["email"]."'");
      $result = $link->query("DELETE FROM forgot_token WHERE email = '".$token["email"]."'");
      //$this->sendmail();
      $this->report["successMessage"] = "Password updated!";
      $this->report["redirect"] = parent::get_host();
    }else{
      $this->report["message"]["change"] = "Something went wrong!";
      $this->report["success"] = false;
    }
    $link = parent::close($link);
  }

}

if($_POST){
  $change = new Change(IO::serializeInput($_POST));
  echo json_encode($change->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
