<?php
session_start();
/**
 * File Name: Passowrd update
 */

 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/check.php";
 require_once "../../ess/io.php";

Internal::authenticate();

class Message extends Check{
  public function __construct($array){
    parent::__construct();
    $link = parent::connect();
    $receiver_ext_id = $array['receiver_id'];
    $receiver_id = parent::user_int_id($receiver_ext_id);

    parent::str_len($array["message"]);
    if(parent::success() == true){
      $result = $link->query("INSERT INTO message(user_id, receiver_id, message, time_stamp)
                              VALUES('".$_SESSION['USERID']."','".$receiver_id."','".$array["message"]."','".time()."')");
      $this->report["successMessage"] = "Messaged!";
    }else{
      $this->report["message"]["message"] = "Something went wrong!";
    }
    $link = parent::close($link);
  }
}

if($_POST){
  $message = new Message(IO::serializeInput($_POST));
  echo json_encode($message->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
