<?php
session_start();
/**
 * File Name: Information update
 */

require_once "../ess/base.php";
require_once "../ess/internal.php";
require_once "../ess/check.php";
require_once "../ess/io.php";
Internal::authenticate();

class Information extends Check{
  public function __construct($array){
    parent::__construct();

    if(parent::success() == true){
      $link = parent::connect();
      $result = $link->query("SELECT user_id FROM user_info WHERE user_id='".$_SESSION["USERID"]."'");
      $result = $result->fetch_assoc();
      if($result == NULL){
        $result = $link->query("INSERT INTO user_info(user_id, firstname, lastname, middlename, birthdate)
                                VALUES('".$_SESSION["USERID"]."','".$array["firstname"]."','".$array["lastname"]."','".$array["middlename"]."','".$array["dob"]."')");
      }else{
        $result = $link->query("UPDATE user_info
                                SET firstname = '".$array["firstname"]."',
                                    lastname = '".$array["lastname"]."',
                                    middlename = '".$array["middlename"]."',
                                    birthdate = '".$array["dob"]."'
                                WHERE user_id='".$_SESSION["USERID"]."'");
      }

      $link = parent::close($link);
      $this->report["successMessage"] = "Information updated!";
      //$this->report["redirect"] = Ess::get_host();
    }else{
      $this->report["information"]["message"] = "Something went wrong!";
      $this->report["success"] = false;
    }

  }

}

if($_POST){
  $information = new Information(IO::serializeInput($_POST));
  echo json_encode($information->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
