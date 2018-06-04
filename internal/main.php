<?php
/**
 * Filename: Internal
 * Description: Contains all the Internal Basics
 * Pre-Requisits: ess/base.php, ess/internal.php, theme.php
 */

class Main extends Theme
{
  function menu(){
    ?>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo parent::get_host() ?>">Campus</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <form class="navbar-form navbar-left" role="search" action="<?php echo parent::get_host() ?>search.php" method="get">
              <div class="form-group">
                <input type="text" class="form-control" name="query" value="<?php echo !isset($_GET["query"])?"":$_GET["query"] ?>" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Search</button>
            </form>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <?php
            if(parent::logged_in() === 1){
              ?>
              <li>
                <div class="notification" id="notification-count-block-ajax" linkAjax="<?php echo parent::get_host() ?>internal/ajax/notification_count.php" data='<?php echo parent::jsonencode(array()) ?>'>
                  <a title="Notification" href="<?php echo parent::get_host() ?>internal/notification.php">
                    <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
                  </a>
                </div>
              </li>
              <li>
                <div class="notification" id="message-count-block-ajax" linkAjax="<?php echo parent::get_host() ?>internal/ajax/message_count.php" data='<?php echo parent::jsonencode(array()) ?>'>
                  <a title="Message" href="<?php echo parent::get_host() ?>internal/message.php">
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                  </a>
                </div>
              </li>
              <li><a title="Home" href="<?php echo parent::get_host() ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trim($_SESSION["FIRSTNAME"])!=""?$_SESSION["FIRSTNAME"]:$_SESSION["EMAIL"] ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo parent::get_host() ?>profile.php">Profile</a></li>
                  <li><a href="<?php echo parent::get_host() ?>internal/account.php">Account Settings</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?php echo parent::get_host() ?>actions/signout.php?redirect=<?php echo urlencode(parent::current_url()) ?>">Signout</a></li>
                </ul>
              </li>
              <?php
            }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <?php
    if(parent::logged_in() === 0){
      ?>
      <div class="container internal">
        <div class="jumbotron">
          <div class="row">
            <div class="col-md-6">
              <h2 class="text-warning">Welcome to the Campus!</h2>
              <p class="text-success">Complete Educational Network for United International University!</p>
              <p class="text-info text-right"><small>Please sign in to get maximum access to the network!</small></p>
            </div>
            <div class="col-md-6">
              <div class="panel panel-warning" >
                <div class="panel-heading">
                    <div class="panel-title">Sign In</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="<?php parent::get_host() ?>external/forgot.php">Forgot password?</a></div>
                </div>

                <div style="padding-top:30px" class="panel-body" >
                <form id="default-form" class="form-horizontal" role="form" action="actions/signin.php" method="post">
                  <div id="alert" class="alert hide"></div>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="username" value="<?php echo !isset($_COOKIE["username"])?"": $_COOKIE["username"] ?>" placeholder="Email">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password" value="<?php echo !isset($_COOKIE["password"])?"": $_COOKIE["password"] ?>" placeholder="password">
                    </div>


                    <div class="input-group">
                      <div class="checkbox">
                        <label>
                          <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                        </label>
                      </div>
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                          <input type="hidden" name="redirect" value="<?php echo parent::current_url() ?>" />
                          <button type="submit" id="btn-login" class="btn btn-success">Sign In</button>
                        </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php
    }
  }
  function head($title = ""){
    parent::head($title);
    $this->menu();
  }
}
?>
