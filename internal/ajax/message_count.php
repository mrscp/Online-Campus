<?php
session_start();
/**
 * File Name: NewsFeed for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/io.php";


class NewsFeed extends Internal{
  public function __construct($array){
    parent::authenticate();
    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);
    $user_id = $_SESSION['USERID'];
    $seen = $link->query("
                          SELECT count(Distinct user_id) as cid
                          FROM message
                          WHERE receiver_id='".$user_id."' AND flag != 1
                        ");
    $seen = $seen->fetch_assoc();

    if($seen["cid"] > 0){
      if($seen["cid"] > 9){
        $seen["cid"] = "9+";
      }
      ?>
      <a title="Notification" href="<?php echo parent::get_host() ?>internal/message.php">
        <span class="glyphicon glyphicon-envelope text-danger" aria-hidden="true"></span>
        <span class="badge"><?php echo $seen['cid'] ?></span>
      </a>
      <?php
    }else{
      ?>
      <a title="Notification" href="<?php echo parent::get_host() ?>internal/message.php">
        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
      </a>
      <?php
    }
  }
}

if($_POST){
  $news_feed = new NewsFeed(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
