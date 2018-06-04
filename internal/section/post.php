<?php
session_start();
/**
 * File Name: Post for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/post.php";
 require_once "../../ess/io.php";

class Post extends Internal_Post{
  public function __construct($array){

    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);

    parent::get_post($link, $data);

    $link = parent::close($link);

  }
}
if($_POST){
  $post = new Post(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
