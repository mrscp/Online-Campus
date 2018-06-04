<?php
session_start();
/**
 * Filename: Section
 * Description: User Section
 */
 require_once "ess/base.php";
 require_once "ess/internal.php";
 require_once "ess/theme.php";
 require_once "internal/main.php";

class Section extends Main
{

  function __construct()
  {
    $section_ext_id = $_GET["id"];
    $section_id = parent::int_id($section_ext_id);

    $link = parent::connect();
    $result = $link->query("SELECT * FROM section NATURAL JOIN course NATURAL JOIN department WHERE section_id='".$section_id."'");
    $section_info = $result->fetch_assoc();

    $fullname = $section_info["course_name"] . " - " . $section_info["course_code"] . " - " . $section_info["section_name"] . " - " . parent::get_trimester(true) . " " . date("Y");
    parent::head($fullname);


    if(!is_array($section_info)){
      require_once "internal/profile/noprofile.php";
      new NoProfile();
    }else{
      $faculty_result = $link->query("SELECT uiu_id, section_id, user_id, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
                                      FROM fa_assign JOIN user_info NATURAL JOIN member
                                      ON fa_assign.faculty_id = user_info.user_id
                                      WHERE section_id='".$section_id."'");
      $faculty_info = $faculty_result->fetch_assoc();
      $sectionlink = "section.php?id=" . $section_ext_id;
      $facultylink = parent::profile_link($faculty_info["uiu_id"], parent::user_ext_id($faculty_info["user_id"]));
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
          <div class="col-md-8">
            <div class="page-header">
              <h3><a href="<?php echo $sectionlink ?>"><?php echo $fullname ?></a></h3>
            </div>
          </div>
          <div class="col-md-4 pull-right">
            <a href="<?php echo $facultylink ?>" class="thumbnail">
              <?php
                echo parent::display_picture($faculty_info["dp"], $faculty_info["name"]);
                echo "<h4 class='text-center'>". $faculty_info["name"] ."</h4>";
              ?>
            </a>
            <div class="panel">
              <?php
              $pull = "";
              if(parent::post_permission($link, $section_id) > 0 && $faculty_info["user_id"] != $_SESSION['USERID']){
                $pull = "pull-right";
                echo '<a href="'.parent::get_host(). "internal/message.php?id=" . parent::user_ext_id($faculty_info["user_id"]) .'" class="btn btn-info profile-btn">Message</a>';
              }
              if(parent::follow_permission($link, $faculty_info["user_id"]) == 0){
                ?>
                <form id="follow-form" class="<?php echo $pull; ?>" role="form" action="actions/profile/follow.php" method="post">
                      <input type="hidden" name="user_id" value="<?php echo parent::user_ext_id($faculty_info["user_id"]) ?>">
                      <button type="submit" class="btn btn-success profile-btn">Follow</button>
                </form>
                <?php
              }
              ?>
            </div>
            <div class="panel panel-warning" >
                <div class="panel-heading">
                  <div class="panel-title">Basic Information</div>
                </div>
                <div class="panel-body">
              <ul>
                <li>Faculty:
                  <a href="<?php echo $facultylink ?>">
                    <?php echo $faculty_info["name"] ?>
                  </a>
                </li>
                <li>Building: <?php echo $section_info["building"] ?>, Room No: <?php echo $section_info["room_number"] ?></li>
                <li>Time: <?php echo $section_info["timeslot"] ?></li>
                <li>Department: <?php echo $section_info["name"] ?></li>
                <div id="section-info" linkAjax="internal/section/info.php" data="<?php echo $section_ext_id ?>">
                  <?php echo parent::loading("small"); ?>
                </div>
              </ul>
            </div>
          </div>
          </div>
          <div class="col-md-8">
            <?php if(parent::post_permission($link, $section_id) > 0){ ?>
            <form id="post-form" targetAjax="#post-block-ajax" class="form-horizontal" role="form" action="actions/section/post.php" method="post">
              <div class="form-group">
                <div class="panel panel-warning" >
                    <div class="panel-heading">
                      <textarea id="post-input" name="post" class="form-control" rows="2" cols="70" placeholder="Say something.."></textarea>
                    </div>
                    <div class="panel-footer">
                      <input type="hidden" name="section_id" value="<?php echo $section_ext_id ?>">
                      <!--<input type="file" name="img" multiple>-->
                      <button type="submit" class="btn btn-default pull-right">Post</button>
                      <p class="help-block">Ask/post anything about the section of the course!</p>
                    </div>
                  </div>
                </div>
            </form>
            <?php
            }
            $data['page'] = !isset($_GET["page"]) || trim($_GET["page"]) == ""?0:$_GET["page"];
            $data['section_id'] = $section_ext_id;
            ?>
            <div id="post-block-ajax" linkAjax="internal/section/post.php" data='<?php echo parent::jsonencode($data) ?>'><?php echo parent::loading(); ?></div>
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
new Section();
?>
