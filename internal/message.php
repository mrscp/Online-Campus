<?php
session_start();
/**
 * Filename: Message
 * Description: User Message
 */
 require_once "../ess/base.php";
 require_once "../ess/internal.php";
 require_once "../ess/theme.php";
 require_once "main.php";
 Internal::authenticate();

class Message extends Main
{

  function __construct()
  {
    if(isset($_GET["id"]) && trim($_GET["id"]) !== ""){
      $m_user_ext_id = $_GET["id"];
    }else{
      $m_user_ext_id = 0;
    }
    $m_user_id = parent::user_int_id($m_user_ext_id);
    $user_id = $_SESSION['USERID'];
    $user_ext_id = parent::user_ext_id($user_id);

    $link = parent::connect();
    $result = $link->query("SELECT * FROM user_info NATURAL JOIN member WHERE user_id='".$m_user_id."'");
    $user_info = $result->fetch_assoc();
    $link = parent::close($link);

    $fullname = $user_info["firstname"] . " " . $user_info["middlename"] . " " . $user_info["lastname"];

    if(!isset($_GET["id"]) || trim($_GET["id"]) == ""){
      parent::head("Messages ");
    }else if(!is_array($user_info)){
      parent::head("Not Found - Messages ");
      $data["user_id"] = $m_user_ext_id;
    }else{
      parent::head($fullname . " - Messages ");
      $data["user_id"] = $m_user_ext_id;
    }

    $page = !isset($_GET["page"]) || trim($_GET["page"]) == ""?0:$_GET["page"];

    $data["page"] = $page;

    ?>
    <div class="container internal">
      <div class="row">
        <div class="col-md-8">
          <div class="page-header">
            <h3>
              <?php
              if(!isset($_GET["id"]) || trim($_GET["id"]) == "") echo "Messages ";
              else if(!is_array($user_info)) echo "Not Found - Messages ";
              else echo '<a href="' . parent::profile_link($user_info['uiu_id'], $m_user_ext_id) . '">' . $fullname . "</a> - Messages ";
              ?>
            </h3>
          </div>
          <div id="message-block-ajax" linkAjax="ajax/message.php" data='<?php echo parent::jsonencode($data) ?>'><?php echo parent::loading(); ?></div>
          <?php
          if(is_array($user_info)){
          ?>
          <form id="message-send-form" targetAjax="#message-block-ajax" class="form-horizontal" role="form" action="../actions/profile/message.php" method="post">
            <div class="form-group">
              <div class="panel panel-warning" >
                  <div class="panel-heading">
                    <textarea id="message-input" name="message" class="form-control" rows="1" cols="70" placeholder="Write something.."></textarea>
                  </div>
                  <div class="panel-footer">
                    <input type="hidden" name="receiver_id" value="<?php echo $data["user_id"] ?>">
                    <!--<input type="file" name="img" multiple>-->
                    <button type="submit" class="btn btn-default pull-right">Send</button>
                    <p class="help-block">Write a message!</p>
                  </div>
                </div>
              </div>
          </form>
          <?php
          }
          ?>
        </div>
        <div class="col-md-4">

        </div>
      </div>
    </div>
    <?php
    parent::tail();
  }
}
new Message();
?>
