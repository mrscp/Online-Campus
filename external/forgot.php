<?php
/**
 * Filename: Forgot Password
 * Description: Password recovery
 */
 require_once "../ess/base.php";
 require_once "../ess/internal.php";
 require_once "../ess/theme.php";

class Forgot extends Theme
{
  function __construct()
  {
    parent::head("Forgot Passowrd");
    ?>
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-warning" >
                    <div class="panel-heading">
                        <div class="panel-title">Forgot Password</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="<?php echo parent::get_host() ?>index.php">Home</a></div>
                    </div>

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                        <?php
                        if(!isset($_GET["token"]) || trim($_GET["token"]) == null){
                          ?>
                          <form id="default-form" class="form-horizontal" role="form" action="../actions/forgot.php" method="post">
                            <div id="alert" class="alert hide"></div>
                              <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="login-username" type="text" class="form-control" name="email" value="" placeholder="Email">
                              </div>
                              <div style="margin-top:10px" class="form-group">
                                  <div class="col-sm-12 controls">
                                    <button type="submit" id="btn-login" class="btn btn-success">Request for Change</button>
                                  </div>
                              </div>
                          </form>
                          <?php
                        }else{
                          ?>
                          <form id="default-form" class="form-horizontal" role="form" action="../actions/change.php" method="post">
                            <div id="alert" class="alert hide"></div>
                              <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="login-username" type="password" class="form-control" name="password" value="" placeholder="New Password">
                              </div>
                              <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="login-username" type="password" class="form-control" name="cpassword" value="" placeholder="Confirm Password">
                              </div>
                              <div style="margin-top:10px" class="form-group">
                                  <div class="col-sm-12 controls">
                                    <input type="hidden" name="token" value="<?php echo $_GET["token"] ?>" />
                                    <button type="submit" id="btn-login" class="btn btn-success">Change</button>
                                  </div>
                              </div>
                          </form>
                          <?php
                        }
                        ?>

                        </div>
                    </div>
        </div>
    </div>
    <?php
    parent::tail();
  }
}
new Forgot();
?>
