<?php
session_start();
/**
 * File Name: Search for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/io.php";

class Search extends Internal{
  public function __construct($array){

    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);
    $query = $data->query;
    $page = $data->page;
    $limit = 15;
    $start = $page * $limit;
    $end = $start + $limit;
    $next = $page + 1;
    $prev = $page != 0?$page - 1:$page;

    $user_info_sql = "(
                        SELECT user_id, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name, 'user' as name1
                        FROM user_info
                        HAVING
                          name LIKE '%".$query."%'
                        LIMIT ". $start .",". $end ."
                      )";

    $section_info_sql = "(
                        SELECT section_id as user_id, dp, CONCAT_WS(' - ', course_name, course_code, section_name) AS name, CONCAT_WS(' ', firstname, middlename, lastname) AS name1
                        FROM section NATURAL JOIN course NATURAL JOIN fa_assign JOIN user_info
                        ON fa_assign.faculty_id = user_info.user_id
                        HAVING
                          name LIKE '%".$query."%'
                        LIMIT ". $start .",". $end ."
                      )";

    $result = $link->query($user_info_sql . " UNION " . $section_info_sql);
    if($result->num_rows<=0){
      echo "No Results!";
      $next = $page;
    }
    echo '<div class="row">';
    while($search_result = $result->fetch_assoc()){
      $dp = parent::display_picture($search_result["dp"], $search_result["name"], "thumb");
      $user_id = $search_result["user_id"];
      $user_ext_id = parent::user_ext_id($user_id);
      $profilelink = "profile.php?id=" . $user_ext_id;
      if($search_result["name1"] !== "user"){
        $user_ext_id = parent::ext_id($user_id);
        $profilelink = "section.php?id=" . $user_ext_id;
      }
      ?>
        <div class="col-md-4 result-element">
          <div class="media">
            <div class="media-left media-middle">
              <a href="<?php echo $profilelink ?>">
                <?php echo $dp ?>
              </a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $profilelink ?>"><?php echo $search_result["name"] ?></a></h4>
              <?php
              if($search_result["name1"] === "user"){
                $user_result = $link->query("SELECT * FROM faculty WHERE user_id='".$user_id."'");
                $info = $user_result->fetch_assoc();
                if(is_array($info)){
                  echo "<li>" . $info["designation"] . ", " . $info["dept_name"] . "</li>";
                  echo "<li>Joining Date: " . date("Y-m-d", $info["joining_date"]) . "</li>";
                }

                $user_result = $link->query("SELECT * FROM staff WHERE user_id='".$user_id."'");
                $info = $user_result->fetch_assoc();
                if(is_array($info)){
                  echo "<li>" . $info["designation"] . ", " . $info["dept_name"] . "</li>";
                  echo "<li>Joining Date: " . date("Y-m-d", $info["joining_date"]) . "</li>";
                }

                $user_result = $link->query("SELECT * FROM student WHERE user_id='".$user_id."'");
                $info = $user_result->fetch_assoc();
                if(is_array($info)){
                  echo "<li>Student, " . $info["dept_name"] . "</li>";
                  echo "<li>Admission Date:" . date("Y-m-d", $info["addmission_date"]) . "</li>";
                }
              }else {
                echo "<li>Faculty: " . $search_result["name1"] . "</li>";
              }
              ?>
            </div>
          </div>
        </div>
      <?php
    }
    echo "</div>";
    $link = parent::close($link);
    ?>
    <nav>
      <ul class="pager">
        <li><a href="<?php echo parent::get_host() . "search.php?query=" . $query . "&page=" . $prev ?>">Previous</a></li>
        <li><a href="<?php echo parent::get_host() . "search.php?query=" . $query . "&page=" . $next ?>">Next</a></li>
      </ul>
    </nav>
    <?php
  }
}

if($_POST){
  $search = new Search(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
