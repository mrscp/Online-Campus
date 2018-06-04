<?php
/**
 * File Name: Theme
 * Description : Contains All Basics
 * Pre-Requisits: ess/base.php, ess/internal.php
 */

class Check extends Internal {
  protected $report = array();
  public function __construct(){
    $this->report["success"] = true;
  }
  public function email_exists($email){
    $link = parent::connect();
    $sql = "SELECT email, password FROM member WHERE email='".$email."'";
    $result = mysqli_query($link,$sql);
    $link = parent::close($link);
    return mysqli_num_rows($result);
  }
  public function str_len($string){
    if(strlen(trim($string)) <= 2){
      $this->report["message"]["string"] = "You have to write atleast 3 characters!";
      $this->report["success"] = false;
    }
  }

  public function email($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->report["message"]["email"] = "Email is invalid!";
      $this->report["success"] = false;
    }else if($this->email_exists($email) > 0){
      $this->report["message"]["email"] = "Email is already associated with a account!";
      $this->report["success"] = false;
    }else{
      $this->report["message"]["email"] = "Email is OK!";
    }
  }

  public function password($password, $cpassword){
    if(strlen($password) < 8 || strlen($password) > 32){
      $this->report["message"]["password"] = "Password must be between 8 and 32 characters!";
      $this->report["success"] = false;
    }else if(strcmp($password, $cpassword) !== 0){
      $this->report["message"]["password"] = "Passwords did not match!";
      $this->report["success"] = false;
    }else{
      $this->report["message"]["password"] = "Password is OK!";
    }
  }
  public function success(){
    return $this->report["success"];
  }
  public function get_report(){
    return $this->report;
  }
}
?>
