<?php
session_start();
/**
 * File Name: NewsFeed for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/post.php";
 require_once "../../ess/io.php";


class NewsFeed extends Internal_Post{
  public function __construct($array){
    parent::authenticate();
    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);
    $page = $data->page;
    $limit = 15;
    $start = $page * $limit;
    $end = $start + $limit;
    $next = $page + 1;
    $prev = $page != 0?$page - 1:$page;

    $student = "(
                        SELECT post_id
                        FROM takes JOIN post ON takes.section_id = post.section_id
                        WHERE student_id='".$_SESSION['USERID']."'
                        ORDER BY time_stamp DESC
                        LIMIT ". $start .",". $end ."
                      )";
    $faculty = "(
                        SELECT post_id
                        FROM fa_assign JOIN post ON fa_assign.section_id = post.section_id
                        WHERE faculty_id='".$_SESSION['USERID']."'
                        ORDER BY time_stamp DESC
                        LIMIT ". $start .",". $end ."
                      )";
    $ta = "(
                        SELECT post_id
                        FROM ta_assign JOIN post ON ta_assign.section_id = post.section_id
                        WHERE student_id='".$_SESSION['USERID']."'
                        ORDER BY time_stamp DESC
                        LIMIT ". $start .",". $end ."
                      )";
    $result = $link->query($student . " UNION " . $faculty . " UNION " . $ta);
    if($result->num_rows<=0){
      echo "No news!";
      $next = $page;
    }

    echo '<div class="row">';
    while($news = $result->fetch_assoc()){
      $news_data = "";
      $news_data["post_id"] = parent::ext_id($news["post_id"]);
      $news_data["news_feed"] = true;
      $news_data = parent::jsonencode($news_data);
      $news_data = parent::jsondecode($news_data);

      parent::get_post($link, $news_data);

      //echo $news['post_id'];
    }
    echo "</div>";
    $link = parent::close($link);
    ?>
    <nav>
      <ul class="pager">
        <li><a href="<?php echo parent::get_host() . "?page=" . $prev ?>">Previous</a></li>
        <li><a href="<?php echo parent::get_host() . "?page=" . $next ?>">Next</a></li>
      </ul>
    </nav>
    <?php
  }
}

if($_POST){
  $news_feed = new NewsFeed(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
