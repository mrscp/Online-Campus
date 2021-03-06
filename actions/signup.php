                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
/**
 * File Name: Sign Up
 */

require_once "../ess/base.php";
require_once "../ess/internal.php";
require_once "../ess/check.php";
require_once "../ess/io.php";

class Signup extends Check{
  public function __construct($array){
    parent::__construct();

    parent::email($array["email"]);
    parent::password($array["passwd"], $array["cpasswd"]);
    if(parent::success() == true){
      $link = parent::connect();
      $result = $link->query("INSERT INTO member(email, password) VALUES('".$array["email"]."','".IO::hash_password($array["passwd"])."')");
      $link = parent::close($link);
      $this->report["successMessage"] = "Signup successfull!";
      $this->report["redirect"] = parent::get_host();
    }else{
      $this->report["successMessage"] = "Signup is not successfull!";
    }
  }
}

if($_POST){
  $signup = new Signup(IO::serializeInput($_POST));
  $json = json_encode($signup->get_report());
  echo $json;
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
