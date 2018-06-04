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
    $student = "SELECT post_id
                            FROM takes JOIN post ON takes.section_id = post.section_id and post.user_id != '".$user_id."'
                            WHERE student_id='".$user_id."' AND post_id NOT IN (
                              SELECT post_id
                              FROM p_seen
                              WHERE user_id = '".$user_id."'
                            )";
    $faculty = "SELECT post_id
                            FROM fa_assign JOIN post ON fa_assign.section_id = post.section_id and post.user_id != '".$user_id."'
                            WHERE faculty_id='".$user_id."' AND post_id NOT IN (
                              SELECT post_id
                              FROM p_seen
                              WHERE user_id = '".$user_id."'
                            )";
    $ta = "SELECT post_id
                            FROM ta_assign JOIN post ON ta_assign.section_id = post.section_id and post.user_id != '".$user_id."'
                            WHERE student_id='".$user_id."' AND post_id NOT IN (
                              SELECT post_id
                              FROM p_seen
                              WHERE user_id = '".$user_id."'
                            )";
    $seen = $link->query("SELECT count(post_id) as cid FROM (" . $student . " UNION " . $faculty . " UNION " . $ta . ") as notification");
    $seen = $seen->fetch_assoc();
    if($seen["cid"] > 0){
      if($seen["cid"] > 9){
        $seen["cid"] = "9+";
      }
      ?>
      <a title="Notification" href="<?php echo parent::get_host() ?>internal/notification.php">
        <span class="glyphicon glyphicon-bell text-danger" aria-hidden="true"></span>
        <span class="badge"><?php echo $seen['cid'] ?></span>
      </a>
      <?php
    }else{
      ?>
      <a title="Notification" href="<?php echo parent::get_host() ?>internal/notification.php">
        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
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
