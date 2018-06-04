<?php
session_start();
/**
 * File Name: Follow for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/io.php";


class Follow extends Internal{
  public function __construct($array){
    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);
    $user_ext_id = $data->user_id;
    $user_id = parent::user_int_id($user_ext_id);
    $seen = $link->query("
                          SELECT count(user_id) as cid
                          FROM follow
                          WHERE user_id='".$user_id."'
                        ");
    if(isset($data->follower)){
      $seen = $link->query("
                            SELECT count(user_id) as cid
                            FROM follow
                            WHERE followed_id='".$user_id."'
                          ");
    }
    $seen = $seen->fetch_assoc();

    if($seen["cid"] > 0){
      ?>
        <span class="badge"><?php echo $seen['cid'] ?></span>
      <?php
    }
  }
}

if($_POST){
  $follow = new Follow(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
