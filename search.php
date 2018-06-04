<?php
session_start();
/**
 * Filename: Profile
 * Description: User Profile
 */
 require_once "ess/base.php";
 require_once "ess/internal.php";
 require_once "ess/theme.php";
 require_once "internal/main.php";

class Profile extends Main
{

  function __construct()
  {
    $query = !isset($_GET["query"]) || trim($_GET["query"]) == ""?"":$_GET["query"];
    $page = !isset($_GET["page"]) || trim($_GET["page"]) == ""?0:$_GET["page"];
    parent::head($query . " - Search");
    $data["query"] = $query;
    $data["page"] = $page;
    ?>
    <div class="container internal">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header">
            <h3>Results for: <?php echo "\"" . $query . "\"" ?></h3>
          </div>
          <div id="default-block-ajax" linkAjax="internal/ajax/search.php" data='<?php echo parent::jsonencode($data) ?>'><?php echo parent::loading(); ?></div>
        </div>
      </div>
      <?php parent::footer(); ?>
    </div>

    <?php
    parent::tail();
  }
}
new Profile();
?>
