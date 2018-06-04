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

class Comment extends Check{
  public function __construct($array){
    parent::__construct();

    $link = parent::connect();
    $post_ext_id = $array['post_id'];
    $post_id = parent::int_id($post_ext_id);
    $result = $link->query("SELECT count(post_id) as cid FROM post WHERE post_id='".$post_id."'");
    $result = $result->fetch_assoc();
    if($result["cid"] <= 0){
      $this->report["comment"]["message"] = "Something went wrong!";
      $this->report["success"] = false;
    }
    parent::str_len($array["comment"]);
    if(parent::success() == true){
      $result = $link->query("INSERT INTO comment(user_id, post_id, comment, time_stamp)
                              VALUES('".$_SESSION['USERID']."','".$post_id."','".$array["comment"]."','".time()."')");
      $this->report["successMessage"] = "Commented!";
    }else{
      $this->report["comment"]["message"] = "Something went wrong!";
    }
    $link = parent::close($link);
  }
}

if($_POST){
  $comment = new Comment(IO::serializeInput($_POST));
  echo json_encode($comment->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
