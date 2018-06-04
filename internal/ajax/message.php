<?php
session_start();
/**
 * File Name: Message for block ajax
 */
 require_once "../../ess/base.php";
 require_once "../../ess/internal.php";
 require_once "../../ess/post.php";
 require_once "../../ess/io.php";


class Message extends Internal_Post{
  public function __construct($array){
    parent::authenticate();
    $user_id = $_SESSION['USERID'];
    $user_ext_id = parent::user_ext_id($user_id);
    $link = parent::connect();
    $data = parent::jsondecode($array["data"]);
    $page = $data->page;
    $limit = 5;
    $start = $page * $limit;
    $end = $start + $limit;
    $next = $page + 1;
    $prev = $page != 0?$page - 1:$page;

    $message_sql= "(
                        SELECT m_id, uiu_id, user_id, flag, message, time_stamp, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
                        FROM message NATURAL JOIN user_info NATURAL JOIN member
                        WHERE receiver_id='".$user_id."' AND m_id IN (
                                                                          SELECT MAX(m_id) as mm_id
                                                                          FROM message
                                                                          WHERE receiver_id='".$user_id."'
                                                                          GROUP BY user_id
                                                                        )
                        ORDER BY time_stamp DESC
                        LIMIT ". $start .",". $end ."
                      )";
    if(isset($data->user_id)){
      $m_user_id = parent::user_int_id($data->user_id);
      $message_sql= "SELECT *
                      FROM (
                            SELECT m_id, uiu_id, user_id, flag, message, time_stamp, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
                            FROM message NATURAL JOIN user_info NATURAL JOIN member
                            WHERE (receiver_id='".$user_id."' AND user_id = '".$m_user_id."') OR (receiver_id='".$m_user_id."' AND user_id = '".$user_id."')
                            ORDER BY m_id DESC
                            LIMIT ". $start .",". $end ."
                          ) AS sub
                      ORDER BY m_id ASC";
    }
    $result = $link->query($message_sql);

    if($result->num_rows<=0){
      echo "No message!";
      $next = $page;
    }
    ?>
    <div class="conversation">
      <?php
      if(isset($data->user_id)){
      ?>
        <nav>
          <ul class="pager">
            <li><a href="<?php echo parent::get_host() . "internal/message.php?id=".$data->user_id."&page=" . $prev ?>">Newer</a></li>
            <li><a href="<?php echo parent::get_host() . "internal/message.php?id=".$data->user_id."&page=" . $next ?>">Older</a></li>
          </ul>
        </nav>
        <?php
      }
      ?>
      <ul class="nav nav-pills nav-stacked">
        <?php
          while($message = $result->fetch_assoc()){
            $profile_link = parent::profile_link($message["uiu_id"], parent::user_ext_id($message["user_id"]));
            $flag = "";
            if($message["flag"] === "0" && !isset($data->user_id)){
              $flag = "active";
            }else if($message["flag"] === "0" && isset($data->user_id)){
              $link->query("UPDATE message SET flag = '1' WHERE m_id='".$message['m_id']."' AND user_id != '".$user_id."'");
              $flag = "alert alert-info";
            }else{}
            ?>
            <li class="<?php echo $flag ?>">
            <?php
            if(!isset($data->user_id)){
              echo '<a href="'.parent::get_host() . "internal/message.php?id=" . parent::user_ext_id($message["user_id"]) .'">';
            }
            ?>
                <div class="media-left">
                  <?php
                  if(isset($data->user_id)){
                    echo '<a href="'.$profile_link.'">' . parent::display_picture($message["dp"], $message["name"], "thumb-small") . '</a>';
                  }else echo parent::display_picture($message["dp"], $message["name"], "thumb-small");
                  ?>
                </div>

                <div class="media-body">
                  <h4 class="media-heading">
                    <?php
                    if(isset($data->user_id)){
                      echo '<a href="'.$profile_link.'">' . $message["name"] . '</a>';
                    }else echo $message["name"];
                    ?>
                  </h4>
                  <p><small><?php echo nl2br($message["message"]) ?></small></p>
                  <p><small><?php echo parent::view_time($message["time_stamp"]) ?></small></p>
                </div>
              <?php
              if(!isset($data->user_id)){
                echo '</a>';
              }
              ?>
            </li>
            <?php
          }
          $link = parent::close($link);
        ?>
      </ul>
    </div>
    <?php
    if(!isset($data->user_id)){
    ?>
      <nav>
        <ul class="pager">
          <li><a href="<?php echo parent::get_host() . "internal/message.php?page=" . $prev ?>">Previous</a></li>
          <li><a href="<?php echo parent::get_host() . "internal/message.php?page=" . $next ?>">Next</a></li>
        </ul>
      </nav>
      <?php
    }
  }
}

if($_POST){
  $message = new Message(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
