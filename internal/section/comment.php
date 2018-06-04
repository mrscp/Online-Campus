<?php
session_start();
/**
 * File Name: Post for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/io.php";

class Post extends Internal{
  public function __construct($array){

    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);
    $post_ext_id = $data->post_id;
    $post_id = parent::int_id($post_ext_id);

    $sql = "SELECT uiu_id, user_id, comment_id, comment, time_stamp, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
            FROM comment NATURAL JOIN user_info  NATURAL JOIN member
            WHERE post_id='".$post_id."' ORDER BY time_stamp DESC";
    $comment_result = $link->query($sql);
    while($comment = $comment_result->fetch_assoc()){
      $profile_link_comment = parent::profile_link($comment["uiu_id"], parent::user_ext_id($comment["user_id"]));
      ?>
      <div class="media">
        <div class="media-left">
          <a href="<?php echo $profile_link_comment ?>">
            <?php echo parent::display_picture($comment["dp"], $comment["name"], "thumb-extra-small"); ?>
          </a>
        </div>
        <div class="media-body">
          <h5 class="media-heading"><a href="<?php echo $profile_link_comment ?>"><?php echo $comment['name'] ?></a></h5>
          <p><?php echo nl2br($comment['comment']) ?></p>
          <small class="text-muted"><?php echo parent::view_time($comment['time_stamp']) ?></small>
        </div>
      </div>
      <?php
    }
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
