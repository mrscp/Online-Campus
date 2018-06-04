<?php
/**
 * Filename: Base
 * Description: Contains all atomics
 */

class Base
{
  private $host = "localhost";
  private $username = "1059165";
  private $password = "2016dbmsfall";
  private $database = "1059165";

  public function var_dump($array){
    echo "<pre>";
    var_dump($array);
    echo "</pre>";
  }

  public function in_array_m($needle, $haystack, $strict = false) {
      foreach ($haystack as $item) {
          if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_m($needle, $item, $strict))) {
              return true;
          }
      }
      return false;
  }

  public static function get_host(){
    if($_SERVER['HTTP_HOST'] === "localhost"){
      return "http://localhost/campus/";
    }else{
      return "http://" . $_SERVER['HTTP_HOST'] . "/";
    }
  }

  public static function current_url(){
    if($_SERVER['HTTP_HOST'] === "localhost"){
      return "http://localhost" . $_SERVER['REQUEST_URI'];
    }else{
      return "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
  }

  public function connect(){
    if($_SERVER['HTTP_HOST'] === "localhost"){
      $this->username = "root";
      $this->password = "";
    }
    return new mysqli($this->host, $this->username, $this->password, $this->database);
  }

  public function close($link){
    return $link = null;
  }

  public function jsonencode($array){
    $array = json_encode($array);
    return urlencode($array);
  }

  public function jsondecode($string){
    $string = urldecode($string);
    return json_decode($string);
  }
}
?>
