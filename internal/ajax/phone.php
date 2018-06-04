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
    ?>
    <table>
    <?php
    $link = parent::connect();
    $result = $link->query("SELECT * FROM phone WHERE user_id='".$_SESSION['USERID']."'");
    if($result->num_rows <= 0){
      echo "No Phone Numbers!";
    }
    while($phone = $result->fetch_assoc()){
      $data["user_id"] = parent::user_ext_id($phone['user_id']);
      $data["phone"] = $phone["phone"];
      ?>
      <tr>
        <td width="200"><?php echo $phone['phone'] ?></td>
        <td>
          <form id="delete" targetAjax="#default-block-ajax" class="form-horizontal" role="form" action="../actions/delete.php" method="post">
            <input type="hidden" name="data" value="<?php echo parent::jsonencode($data); ?>" />
            <button type="submit" class="btn btn-danger">X</button>
          </form>
        </td>
      </tr>
      <?php
    }
    ?>
    </table>
    <?php
    $link = parent::close($link);
  }
}

if($_POST){
  $search = new Search(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
