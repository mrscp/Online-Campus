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
    $follow = $link->query("
                          SELECT uiu_id, followed_id, time_stamp, dp, time_stamp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
                          FROM follow JOIN user_info NATURAL JOIN member
                          ON follow.followed_id = user_info.user_id
                          WHERE follow.user_id='".$user_id."'
                        ");
    if(isset($data->follower)){
      $follow = $link->query("
                            SELECT uiu_id, user_id, time_stamp, dp, time_stamp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
                            FROM follow NATURAL JOIN user_info NATURAL JOIN member
                            WHERE followed_id='".$user_id."'
                          ");
    }
    $link = parent::close($link);
    if($follow->num_rows <= 0){
      echo "Nothing to show!";
    }
    echo "<div class='row'>";
    while($people = $follow->fetch_assoc()){
      if(isset($data->follower)){
        $user_id = $people["user_id"];
      }else{
        $user_id = $people["followed_id"];
      }
      $user_ext_id = parent::user_ext_id($user_id);
      $profilelink = parent::profile_link($people['uiu_id'], $user_ext_id);
      ?>
      <div class="col-md-6 result-element">
        <div class="media">
          <div class="media-left media-middle">
            <a href="<?php echo $profilelink ?>">
              <?php echo parent::display_picture($people['dp'], $people["name"], "thumb-small") ?>
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><a href="<?php echo $profilelink ?>"><?php echo $people["name"] ?></a></h4>
            <p class="text-muted"><?php echo parent::view_time($people["time_stamp"]) ?></p>
          </div>
        </div>
      </div>
      <?php
    }
    echo "</div>";
  }
}

if($_POST){
  $follow = new Follow(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
