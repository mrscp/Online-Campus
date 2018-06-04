<?php
/**
 * File Name: Theme
 * Description : Contains All Basics
 * Pre-Requisits: ess/base.php, ess/internal.php
 */

class Theme extends Internal
{
  function html_begin(){
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo parent::get_host() ?>logo.ico" type="image/x-icon">.
    <?php
  }
  function html_middle(){
    ?>
  </head>
  <body>
    <?php
  }
  function html_end(){
    ?>
</body>
</html>
    <?php
  }

  function title($title){
    ?>
    <title><?php echo $title . " - Campus UIU" ?></title>
    <?php
  }

  function css(){
    ?>
    <link href="<?php echo parent::get_host() ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo parent::get_host() ?>css/main.css" rel="stylesheet">
    <?php
  }
  function js_ie(){
    ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php
  }

  function js(){
    ?>
    <script src="<?php echo parent::get_host() ?>bootstrap/js/jquery-1.12.4.js"></script>
    <script src="<?php echo parent::get_host() ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo parent::get_host() ?>js/main.js"></script>
    <?php
  }
  function footer(){
    ?>
    <div>
      <ul class="nav nav-pills">
        <li><a href="#">Home</a></li>
        <li><a href="#">Privacy</a></li>
        <li><a href="#">Terms of Service</a></li>
      </ul>
    </div>
    <?php
  }
  function head($title  = "Welcome to Campus - United International University"){
    $title = $title==""?"Welcome to Campus - United International University":$title;
    $this->html_begin();
    $this->title($title);
    $this->css();
    $this->js_ie();
    $this->html_middle();
  }
  function tail(){
    $this->js();
    $this->html_end();
  }
}
?>
