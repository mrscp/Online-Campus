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

    $section_ext_id = $array["data"];
    $section_id = parent::int_id($section_ext_id);

    $link = parent::connect();
    $result = $link->query("SELECT uiu_id, section_id, user_id, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
                                    FROM ta_assign JOIN user_info NATURAL JOIN member
                                    ON ta_assign.student_id = user_info.user_id
                                    WHERE section_id='".$section_id."'");
    $ta = $result->fetch_assoc();
    echo "<li>Teacher's Assistant: ";
    if(trim($ta["name"])!==""){
      echo '<a href="'.parent::profile_link($ta['uiu_id'],parent::user_ext_id($ta['user_id'])) . '">' . $ta["name"] . '</a>';
    }else{
      echo "None";
    }
    echo "</li>";
    $result = $link->query("SELECT count(student_id) as c_student
                            FROM takes
                            WHERE section_id='".$section_id."'");
    $student = $result->fetch_assoc();
    echo '<li>Total Students : <a href="#students" titleAjax="Students" linkAjax="internal/section/students.php" data="'.$section_ext_id.'" id="ajaxModalView">'. $student["c_student"] ."</a></li>";
    $link = parent::close($link);
  }
}
if($_POST){
  $information = new Information(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
