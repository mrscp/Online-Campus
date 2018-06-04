<?php
session_start();
/**
 * Filename: Profile
 * Description: User Profile
 */
 require_once "ess/base.php";
 require_once "ess/internal.php";
 require_once "ess/theme.php";
 require_once "internal/main.php";

class Profile extends Main
{
  function __construct($array = null)
  {
    $link = parent::connect();
    $id = parent::logged_in()?parent::user_ext_id($_SESSION["USERID"]):0;
    if($array[0] !== null){
      $id = $link->query("SELECT user_id FROM member WHERE uiu_id='".$array[0]."'");
      $id = $id->fetch_assoc();
      $id = parent::user_ext_id($id['user_id']);
    }
    $user_ext_id = (!isset($_GET["id"]) || trim($_GET["id"]) == "")?$id:$_GET["id"];
    $user_id = parent::user_int_id($user_ext_id);

    $result = $link->query("SELECT * FROM user_info WHERE user_id='".$user_id."'");
    $user_info = $result->fetch_assoc();

    $fullname = $user_info["firstname"] . " " . $user_info["middlename"] . " " . $user_info["lastname"];
    if(!is_array($user_info)) parent::head("Not Found");
    else parent::head($fullname);

    $result = $link->query("SELECT email, uiu_id FROM member WHERE user_id='".$user_id."'");
    $user = $result->fetch_assoc();

    $username = $user['uiu_id'];
    if(!is_array($user_info)){
      require_once "internal/profile/noprofile.php";
      new NoProfile();
    }else{
      $profilelink = parent::profile_link($username, $user_ext_id);
      ?>

      <div class="container internal">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Loading</h4>
              </div>
              <div class="modal-body">
                <?php echo parent::loading(); ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 pull-right">
            <div>
              <a href="<?php echo $profilelink ?>" class="thumbnail">
                <?php
                echo parent::display_picture($user_info["dp"], $fullname);
                echo "<h4 class='text-center'>". $fullname ."</h4>";
                ?>
              </a>
            </div>
            <div class="panel">
              <?php
              $pull = '';
              if(parent::follow_permission($link, $user_id) > 0){
                echo '<a href="'.parent::get_host(). "internal/message.php?id=" . $user_ext_id .'" class="btn btn-info">Message</a>';
                $pull = 'pull-right';
              }
              if(parent::follow_permission($link, $user_id) == 0){
                ?>
                <form id="follow-form" class="<?php echo $pull; ?>" role="form" action="actions/profile/follow.php" method="post">
                  <input type="hidden" name="user_id" value="<?php echo $user_ext_id ?>">
                  <button type="submit" class="btn btn-success profile-btn">Follow</button>
                </form>
                <?php
              }
              ?>
              <ul style="margin-top: 5px;" class="nav nav-pills nav-stacked">
                <li>
                  <a href="#follow" id="follow" class="ajaxModalView" titleAjax="Follow" linkAjax="<?php echo parent::get_host() ?>internal/profile/follow.php" data="<?php echo parent::jsonencode(array("user_id"=>$user_ext_id)) ?>">
                    Follow
                    <span id="follow-count-block-ajax" linkAjax="<?php echo parent::get_host() ?>internal/profile/follow_count.php" data='<?php echo parent::jsonencode(array("user_id"=>$user_ext_id)) ?>'>
                    </span>
                  </a>
                </li>
                <li>
                  <a href="#follower" id="follower" class="ajaxModalView" titleAjax="Follower" linkAjax="<?php echo parent::get_host() ?>internal/profile/follow.php" data="<?php echo parent::jsonencode(array("user_id"=>$user_ext_id, "follower"=>true)) ?>">
                    Follower
                    <span id="follower-count-block-ajax" linkAjax="<?php echo parent::get_host() ?>internal/profile/follow_count.php" data='<?php echo parent::jsonencode(array("user_id"=>$user_ext_id, "follower"=>true)) ?>'>
                    </span>
                  </a>
                </li>
              </ul>
            </div>

            <div id="default-block-ajax" linkAjax="internal/profile/info.php" data="<?php echo $user_ext_id ?>"><?php echo parent::loading(); ?></div>

          </div>
          <div class="col-md-8">
            <div class="page-header">
              <h3><a href="<?php echo $profilelink ?>"><?php echo $fullname ?></a></h3>
            </div>

            <div id="running-course" linkAjax="internal/profile/course.php" data="<?php echo $user_ext_id ?>"><?php echo parent::loading(); ?></div>
          </div>
          <div class="col-md-4">
            <?php
            parent::footer();
            ?>
          </div>
        </div>
      </div>
      <?php
    }
    $link = parent::close($link);
    parent::tail();
  }
}
$array = !isset($array)?null:$array;
new Profile($array);
?>
