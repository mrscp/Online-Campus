<?php
session_start();
/**
 * File Name: Information for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/io.php";

class Information extends Internal{
  public function __construct($array){

    $user_ext_id = $array["data"];
    $user_id = parent::user_int_id($user_ext_id);

    $link = parent::connect();
    $result = $link->query("SELECT course_code, section_id, section_name, building, room_number, timeslot, course_name
                            FROM takes NATURAL JOIN section NATURAL JOIN course
                            WHERE student_id='".$user_id."' AND yr='".date("Y")."' AND trimester='".parent::get_trimester()."'");
    if($result->num_rows <= 0){
      $result = $link->query("SELECT course_code, section_id, section_name, building, room_number, timeslot, course_name
                              FROM fa_assign NATURAL JOIN section NATURAL JOIN course
                              WHERE faculty_id='".$user_id."' AND yr='".date("Y")."' AND trimester='".parent::get_trimester()."'");
    }
    if($result->num_rows <= 0){
      die;
    }
    ?>
    <div class="panel panel-warning" >
        <div class="panel-heading">
          <div class="panel-title">Running Courses <?php echo " - " . parent::get_trimester(true) . " " . date('Y') ?></div>
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <?php
              while($course = $result->fetch_assoc()){
                ?>
                <li class="list-group-item">
                  <h4>
                    <a href="<?php echo parent::get_host() . "section.php?id=" . parent::ext_id($course["section_id"]); ?>">
                      <?php echo $course["course_name"] . " - " . $course["course_code"] ?>
                    </a>
                  </h4>
                  <p>Section: <?php echo $course["section_name"] ?>, Time: <?php echo $course["timeslot"] ?></p>
                  <p>Building: <?php echo $course["building"] ?>, Room No: <?php echo $course["room_number"] ?></p>
                </li>
                <?php
              }
            ?>
          </ul>

        </div>
    </div>
    <?php
  }
}
if($_POST){
  $information = new Information(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
