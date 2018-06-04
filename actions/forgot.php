<?php
/**
 * File Name: Password Recovery
 */
require_once "../ess/base.php";
require_once "../ess/internal.php";
require_once "../ess/check.php";
require_once "../ess/io.php";

class Forgot extends Check{
  public function __construct($array){
    parent::__construct();

    if(parent::email_exists($array["email"]) > 0){
      $token = IO::hash_token($array["email"] . time());
      $link = parent::connect();
      $result = $link->query("INSERT INTO forgot_token(email, token) VALUES('".$array["email"]."','".$token."')");
      $link = parent::close($link);
      $url = parent::get_host() . "external/forgot.php?token=" . $token;

      $mail = "<p>Please Follow the link to reset password</p><p>
      <a href='".$url."'>Click Here</a>
      </p><p>
      or use this link: <a href='".$url."'>$url</a>
      </p>";
      IO::send_mail($array["email"], "Password Recovery", $mail);
      $this->report["successMessage"] = "A mail has been sent to your email!";
    }else{
      $this->report["message"]["forgot"] = "Something went wrong!";
      $this->report["success"] = false;
    }
  }
}

if($_POST){
  $forgot = new Forgot(IO::serializeInput($_POST));
  echo json_encode($forgot->get_report());
}else{
  header("location: " . Base::get_host());
  exit();
}
?>
