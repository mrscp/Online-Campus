<?php
session_start();
/**
 * File Name: Students for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/io.php";

class Students extends Internal{
  public function __construct($array){

    $section_ext_id = $array["data"];
    $section_id = parent::int_id($section_ext_id);

    $link = parent::connect();
    $result = $link->query("SELECT uiu_id, section_id, user_id, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
                                    FROM takes JOIN user_info NATURAL JOIN member
                                    ON takes.student_id = user_info.user_id
                                    WHERE section_id='".$section_id."'");

    if($result->num_rows<=0){
      echo "No Students";
    }
    echo '<div class="row">';
    while ($student = $result->fetch_assoc()) {
      $user_id = $student["user_id"];
      $user_ext_id = parent::user_ext_id($user_id);
      $profilelink = parent::profile_link($student['uiu_id'], $user_ext_id);
      ?>
      <div class="col-md-10 result-element">
        <div class="media">
          <div class="media-left media-middle">
            <a href="<?php echo $profilelink ?>">
              <?php echo parent::display_picture($student['dp'], $student["name"], "thumb") ?>
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><a href="<?php echo $profilelink ?>"><?php echo $student["name"] ?></a></h4>
            <?php
            $user_result = $link->query("SELECT * FROM student WHERE user_id='".$user_id."'");
            $info = $user_result->fetch_assoc();
            if(is_array($info)){
              echo "<li>Student, " . $info["dept_name"] . "</li>";
              echo "<li>Admission Date:" . date("Y-m-d", $info["addmission_date"]) . "</li>";
            }
            ?>
          </div>
        </div>
      </div>
      <?php
    }
    $link = parent::close($link);
    echo "</div>";
  }
}
if($_POST){
  $information = new Students(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
