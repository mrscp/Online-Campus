<?php
session_start();
/**
 * File Name: Notification for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/post.php";
 require_once "../../ess/io.php";


class Notification extends Internal_Post{
  public function __construct($array){
    parent::authenticate();
    $user_id = $_SESSION['USERID'];
    $user_ext_id = parent::user_ext_id($user_id);
    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);
    $page = $data->page;
    $limit = 15;
    $start = $page * $limit;
    $end = $start + $limit;
    $next = $page + 1;
    $prev = $page != 0?$page - 1:$page;

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
    $seen = $link->query($student . " UNION " . $faculty . " UNION " . $ta);
    $seen_array = array();
    while($seen_row = $seen->fetch_assoc()){
      $seen_array[] = $seen_row;
    }


    $student = "(
                        SELECT post_id
                        FROM takes JOIN post ON takes.section_id = post.section_id and post.user_id != '".$user_id."'
                        WHERE student_id='".$user_id."'
                        ORDER BY time_stamp DESC
                        LIMIT ". $start .",". $end ."
                      )";
    $faculty = "(
                        SELECT post_id
                        FROM fa_assign JOIN post ON fa_assign.section_id = post.section_id and post.user_id != '".$user_id."'
                        WHERE faculty_id='".$user_id."'
                        ORDER BY time_stamp DESC
                        LIMIT ". $start .",". $end ."
                      )";
    $ta = "(
                        SELECT post_id
                        FROM ta_assign JOIN post ON ta_assign.section_id = post.section_id and post.user_id != '".$user_id."'
                        WHERE student_id='".$user_id."'
                        ORDER BY time_stamp DESC
                        LIMIT ". $start .",". $end ."
                      )";
    $result = $link->query($student . " UNION " . $faculty . " UNION " . $ta);

    if($result->num_rows<=0){
      echo "No notification!";
      $next = $page;
    }
    echo '<div class="row">';
    while($notification = $result->fetch_assoc()){
      $notification_data = "";
      $notification_data["post_id"] = parent::ext_id($notification["post_id"]);
      $notification_data["notification"] = true;
      $notification_data = parent::jsonencode($notification_data);
      $notification_data = parent::jsondecode($notification_data);
      $class = "";
      if(parent::in_array_m($notification["post_id"], $seen) === true){
        $link->query("INSERT INTO p_seen(post_id, user_id) VALUES('".$notification["post_id"]."','".$user_id."')");
        $class = "alert alert-warning";
      }
      echo "<div class='result-element ".$class."'>";
      parent::get_post($link, $notification_data);
      echo "</div>";
    }
    echo "</div>";
    $link = parent::close($link);
    ?>
    <nav>
      <ul class="pager">
        <li><a href="<?php echo parent::get_host() . "internal/notification.php?page=" . $prev ?>">Previous</a></li>
        <li><a href="<?php echo parent::get_host() . "internal/notification.php?page=" . $next ?>">Next</a></li>
      </ul>
    </nav>
    <?php
  }
}

if($_POST){
  $notification = new Notification(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
