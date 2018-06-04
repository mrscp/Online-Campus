
<?php
/**
 * Filename: External Home/Index
 * Description: Homepage for the people did not login
 */

require_once "ess/base.php";
require_once "ess/internal.php";
require_once "ess/theme.php";
require_once "internal/main.php";

class InternalHome extends Main
{

  function __construct()
  {
    parent::authenticate();
    parent::head();
    $page = !isset($_GET["page"]) || trim($_GET["page"]) == ""?0:$_GET["page"];
    $data["page"] = $page;

    $user_ext_id = parent::user_ext_id($_SESSION["USERID"]);
    $profile = parent::get_host() . "profile.php?id=" . $user_ext_id;

    $fullname = $_SESSION["FIRSTNAME"];
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
      
      <div class="col-md-8">
        <div class="page-header hidden-md-down">
          <h3>Welcome, <a href="<?php echo $profile ?>"><?php echo $fullname ?></a></h3>
        </div>
        <div id="news-feed-ajax" linkAjax="internal/ajax/newsfeed.php" data="<?php echo parent::jsonencode($data); ?>"><?php echo parent::loading(); ?></div>
      </div>
      <div class="col-md-4">
        <div id="running-course" linkAjax="internal/profile/course.php" data="<?php echo $user_ext_id ?>"><?php echo parent::loading(); ?></div>
      </div>
    </div>
    <?php
    parent::tail();
  }
}
?>
