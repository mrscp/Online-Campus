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

class Post extends Check{
  public function __construct($array){
    parent::__construct();

    $link = parent::connect();
    $section_ext_id = $array['section_id'];
    $section_id = parent::int_id($section_ext_id);
    $result = $link->query("SELECT count(section_id) as cid FROM section WHERE section_id='".$section_id."'");
    $result = $result->fetch_assoc();
    if($result["cid"] <= 0){
      $this->report["post"]["message"] = "Something went wrong!";
      $this->report["success"] = false;
    }
    parent::str_len($array["post"]);
    if(parent::success() == true){
      $result = $link->query("INSERT INTO post(user_id, section_id, post, time_stamp)
                              VALUES('".$_SESSION['USERID']."','".$section_id."','".$array["post"]."','".time()."')");
      $this->report["successMessage"] = "Posted!";
    }else{
      $this->report["post"]["message"] = "Something went wrong!";
    }
    $link = parent::close($link);
  }
}

if($_POST){
  $post = new Post(IO::serializeInput($_POST));
  echo json_encode($post->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
