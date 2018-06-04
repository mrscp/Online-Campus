<?php
session_start();
/**
 * File Name: Add Phone
 */

 require_once "../ess/base.php";
 require_once "../ess/internal.php";
 require_once "../ess/check.php";
 require_once "../ess/io.php";

Internal::authenticate();

class AddPhone extends Check{
  public function __construct($array){
    parent::__construct();

    $link = parent::connect();
    $user_id = parent::user_int_id($array['user_id']);
    parent::str_len($array['phone']);
    //var_dump($array);
    if(parent::success() == true){
      $sql = "INSERT INTO phone(user_id, phone) VALUES('".$user_id."','".$array['phone']."')";
      $link->query($sql);
      $this->report["successMessage"] = "Added!";
    }else{
      $this->report["addphone"]["message"] = "Something went wrong!";
      $this->report["success"] = false;
    }
    $link = parent::close($link);
  }

}

if($_POST){
  $addphone = new AddPhone(IO::serializeInput($_POST));
  echo json_encode($addphone->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
