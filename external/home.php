<?php
/**
 * Filename: External Home/Index
 * Description: Homepage for the people did not login
 */
 require_once "ess/base.php";
 require_once "ess/internal.php";
 require_once "ess/theme.php";
 require_once "internal/main.php";

class ExternalHome extends Main
{
  function __construct()
  {
    parent::head();
    $data["query"] = "";
    $data["page"] = 0;
    ?>
    <div class="container internal">
    <div id="default-block-ajax" linkAjax="internal/ajax/search.php" data='<?php echo parent::jsonencode($data) ?>'><?php echo parent::loading(); ?></div>
    <!--

            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
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
                                          <input type="hidden" name="redirect" value="<?php echo parent::get_host() ?>" />
                                          <button type="submit" id="btn-login" class="btn btn-success">Sign In</button>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-md-12 control">
                                            <div id="pnt_menu" style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                                Don't have an account!
                                            <a href="#signuplink" id="signuplink" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                                Sign Up Here
                                            </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
            </div>
            <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="panel-title">Sign Up</div>
                                <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#signinlink" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                            </div>
                            <div class="panel-body" >
                                <form id="signupform" class="form-horizontal" role="form" action="actions/signup.php" method="post">

                                    <div id="alert" class="alert hide"></div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-3 control-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="email" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" name="passwd" placeholder="Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-md-3 control-label">Confirm Password</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" name="cpasswd" placeholder="Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                        </div>
                                    </div>
                                </form>
                             </div>
                        </div>
             </div>
        </div>
        -->
      </div>

    <?php
    parent::footer();
    parent::tail();
  }
}

?>
