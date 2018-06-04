<?php
session_start();
/**
 * Filename: Notification
 * Description: User Notification
 */
 require_once "../ess/base.php";
 require_once "../ess/internal.php";
 require_once "../ess/theme.php";
 require_once "main.php";
 Internal::authenticate();

class Notification extends Main
{

  function __construct()
  {
    $user_id = $_SESSION['USERID'];
    $user_ext_id = parent::user_ext_id($user_id);
    parent::head("Notifications ");
    $page = !isset($_GET["page"]) || trim($_GET["page"]) == ""?0:$_GET["page"];
    $data["page"] = $page;
    ?>
    <div class="container internal">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header">
            <h3>Notifications</h3>
          </div>
          <div id="default-block-ajax" linkAjax="ajax/notification.php" data='<?php echo parent::jsonencode($data) ?>'><?php echo parent::loading(); ?></div>
        </div>
      </div>
    </div>
    <?php
    parent::tail();
  }
}
new Notification();
?>
