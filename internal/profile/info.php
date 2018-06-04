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

    $user_ext_id = $array["data"];
    $user_id = parent::user_int_id($user_ext_id);

    $link = parent::connect();
    $result = $link->query("SELECT email FROM member WHERE user_id='".$user_id."'");
    $user = $result->fetch_assoc();
    ?>
    <div class="panel panel-warning" >
        <div class="panel-heading">
          <div class="panel-title">Basic Information</div>
        </div>
        <div class="panel-body">
<ul>
  <li>Email : <?php echo $user["email"] ?></li>
  <li>
    <table><tr><td>Phone:</td>
    <?php

    $result = $link->query("SELECT phone FROM phone WHERE user_id='".$user_id."'");
    $phone = $result->fetch_assoc();
    echo "<td> ".$phone['phone']."</td></tr>";
    $phone = $result->fetch_assoc();
    echo "<tr><td></td><td> ".$phone['phone']."</td></tr>";

    ?>
    </table>
  </li>

  <?php

    $result = $link->query("SELECT * FROM faculty WHERE user_id='".$user_id."'");
    $info = $result->fetch_assoc();
    if(is_array($info))
      echo "<li>Faculty: " . $info["dept_name"] . ", " . $info["designation"] . ", Joining Date: " . date("Y-m-d", $info["joining_date"]) . "</li>";

    $result = $link->query("SELECT * FROM staff WHERE user_id='".$user_id."'");
    $info = $result->fetch_assoc();
    if(is_array($info))
      echo "<li>Stuff: " . $info["dept_name"] . ", " . $info["designation"] . ", Joining Date: " . date("Y-m-d", $info["joining_date"]) . "</li>";

    $result = $link->query("SELECT * FROM student WHERE user_id='".$user_id."'");
    $info = $result->fetch_assoc();
    if(is_array($info))
      echo "<li>Student: " . $info["dept_name"] . ", Admission Date:" . date("Y-m-d", $info["addmission_date"]) . "</li>";

    $link = parent::close($link);
  ?>
</ul>
</div>
</div>
    <?php
  }
}
if($_POST){
  $information = new Information(IO::serializeInput($_POST));
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
