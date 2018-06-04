<?php
session_start();
/**
 * File Name: Delete
 */

 require_once "../ess/base.php";
 require_once "../ess/internal.php";
 require_once "../ess/check.php";
 require_once "../ess/io.php";

Internal::authenticate();

class Delete extends Check{
  public function __construct($array){
    parent::__construct();

    $link = parent::connect();
    $data = parent::jsondecode($array['data']);
    $user_id = parent::user_int_id($data->user_id);
    $sql = "DELETE FROM phone WHERE user_id = '".$user_id."' AND phone='".$data->phone."'";
    if($link->query($sql)) $this->report["success"] = false;
    if(parent::success() == true){
      $this->report["successMessage"] = "Deleted!";
    }else{
      $this->report["delete"]["message"] = "Something went wrong!";
      $this->report["success"] = false;
    }
    $link = parent::close($link);
  }

}

if($_POST){
  $delete = new Delete(IO::serializeInput($_POST));
  echo json_encode($delete->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
