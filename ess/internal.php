<?php
/**
 * Filename: Base
 * Description: Contains all atomics
 * Pre-Requisits: ess/base.php
 */
class Internal extends Base
{
  public static function authenticate(){
    if(!isset($_SESSION["USERID"]) || trim($_SESSION["USERID"]) == ""){
      header("location: " . parent::get_host());
    }
  }
  public static function logged_in(){
    if(!isset($_SESSION["USERID"]) || trim($_SESSION["USERID"]) == ""){
      return 0;
    }
    return 1;
  }

  public function get_trimester($text = false){
    $trimester = ceil(date('n')/4);
    if($text === true){
      $trimester = $trimester==3?"Fall":($trimester == 2?"Spring":"Summer");
    }
    return $trimester;
  }

  public function profile_link($username, $user_id){
    if($_SERVER['HTTP_HOST'] === "localhost"){
      return "http://localhost/campus/profile.php?id=" . $user_id;
    }else{
      return parent::get_host() . $username;
    }
  }

  public function post_permission($link, $section_id){
    if(self::logged_in() === 1){
      $user_id = $_SESSION['USERID'];

      $faculty = $link->query("SELECT count(faculty_id) AS cid FROM fa_assign WHERE section_id='".$section_id."' AND faculty_id='".$user_id."'");
      $faculty = $faculty->fetch_assoc();
      $faculty = $faculty['cid'];

      $student = $link->query("SELECT count(student_id) as cid FROM takes WHERE section_id='".$section_id."' AND student_id='".$user_id."'");
      $student = $student->fetch_assoc();
      $student = $student['cid'];

      $ta = $link->query("SELECT count(student_id) as cid FROM ta_assign WHERE section_id='".$section_id."' AND student_id='".$user_id."'");
      $ta = $ta->fetch_assoc();
      $ta = $ta['cid'];

      return $faculty + $student + $ta;
    }else return 0;
  }

  public function follow_permission($link, $profile_id){
    if(self::logged_in() === 1){
      $user_id = $_SESSION['USERID'];
      if($user_id == $profile_id){
        return -1;
      }
      $follow = $link->query("SELECT count(followed_id) as cid FROM follow WHERE followed_id='".$profile_id."' AND user_id='".$user_id."'");
      $follow = $follow->fetch_assoc();
      $follow = $follow['cid'];

      return $follow;
    }else return -1;
  }

  public function user_ext_id($user_id = null){
    $user_id = 10000000 + $user_id;
    return dechex($user_id);
  }
  public function user_int_id($user_ext_id){
    $user_ext_id = hexdec($user_ext_id);
    return $user_ext_id - 10000000;
  }
  public function ext_id($user_id = null){
    $user_id = 1000 + $user_id;
    return dechex($user_id);
  }
  public function int_id($user_ext_id){
    $user_ext_id = hexdec($user_ext_id);
    return $user_ext_id - 1000;
  }
  public function view_time($time_stamp){
    $time = time();
    $time = $time - $time_stamp;
    if($time < 60)
      return round($time) . " seconds ago";
    $time = $time/60;
    if($time < 60)
      return round($time) . " minutes ago";
    $time = $time/60;
    if($time < 24)
      return round($time) . " hours ago";
    $time = $time/24;
    if($time < 7)
      return round($time) . " days ago";

    return date("d-M-Y, D, h:i:s", $time_stamp);

  }
  public function display_picture($dp, $alt, $type = null){
    $width = "";
    if($type == "thumb"){
      $width = "width='100'";
    }else if($type == "thumb-small"){
      $width = "width='64'";
    }else if($type == "thumb-extra-small"){
      $width = "width='32'";
    }else{}

    $dplink = trim($dp)!=""?"files/dp/".$dp:"files/dp/default.jpg";
    $dplink = parent::get_host() . $dplink;
    return '<img class="media-object" src="'.$dplink.'" '. $width .' alt="'.$alt.'">';
  }
  public function loading($type = null){
    $width = "width='100'";
    if($type == "small"){
      $width = "width='32'";
    }
    return '<p class="text-center"><img src="'.parent::get_host().'files/loading.gif" ' . $width . ' alt="Loading"></p>';
  }
}
?>
