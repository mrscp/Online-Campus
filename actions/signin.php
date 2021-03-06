                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
session_start();
/**
 * File Name: Sign IN
 */

require_once "../ess/base.php";
require_once "../ess/internal.php";
require_once "../ess/check.php";
require_once "../ess/io.php";

class Signin extends Check{
  public function __construct($array){
    parent::__construct();
    if($array["remember"] == "1"){
      setcookie("username", $array["username"], time() + (86400 * 30), "../");
      setcookie("password", $array["password"], time() + (86400 * 30), "../");
    }
    $link = parent::connect();
    $sql = "SELECT member.user_id, member.email, member.password, user_info.firstname
            FROM member left outer join user_info
            on member.user_id = user_info.user_id
            WHERE member.email='".$array["username"]."'";
    $result = mysqli_query($link,$sql);
    $user = mysqli_fetch_assoc($result);
    $link = parent::close($link);

    if(strcmp($user["password"], IO::hash_password($array["password"])) === 0){
      $_SESSION["USERID"] = $user["user_id"];
      $_SESSION["EMAIL"] = $user["email"];
      $_SESSION["FIRSTNAME"] = $user["firstname"];
      $this->report["successMessage"] = "Signin successfull!";
      $this->report["redirect"] = $array["redirect"];
    }else{
      $this->report["message"]["signin"] = "Email or Password did not match!";
      $this->report["success"] = false;
    }
  }
}

if($_POST){
  $signin = new Signin(IO::serializeInput($_POST));
  echo json_encode($signin->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
