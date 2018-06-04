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

class Follow extends Check{
  public function __construct($array){
    parent::__construct();
    $link = parent::connect();
    $profile_ext_id = $array['user_id'];
    $profile_id = parent::user_int_id($profile_ext_id);

    if(parent::success() == true && $link->query("INSERT INTO follow(user_id, followed_id, time_stamp)
                            VALUES('".$_SESSION['USERID']."','".$profile_id."','".time()."')")){
      $this->report["successMessage"] = "Followed!";
    }else{
      $this->report["follow"]["message"] = "Something went wrong!";
    }
    $link = parent::close($link);
  }
}

if($_POST){
  $follow = new Follow(IO::serializeInput($_POST));
  echo json_encode($follow->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
