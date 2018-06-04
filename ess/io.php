<?php
/**
 * File Name: Input Output
 */

class IO{
  public static function serializeInput($array = array()){
    $output = array();
    foreach($array as $key=>$value){
      $output[$key] = $value;
    }
    return $output;
  }

  public static function hash_password($string){
    return hash("sha384", $string, false);
  }

  public static function hash_token($string){
    return hash("sha384", $string, false);
  }

  public static function send_mail($to, $subject, $body){
    $to = "elyfes.com@gmail.com";

    $message = "<html>
                <head>
                  <title>".$subject."</title>
                </head>
                <body>
                  ". $body ."
                </body>
                </html>";

    $header = "From: Campus UIU <noreply@gmail.com> \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $mail = mail ($to,$subject,$message,$header);
    if($mail == true){
      return true;
    }else{
      return false;
    }
  }
}
?>
