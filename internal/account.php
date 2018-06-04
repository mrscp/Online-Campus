<?php
session_start();
/**
 * Filename: Account Settings
 * Description: Account Settings for the current user
 */
 require_once "../ess/base.php";
 require_once "../ess/internal.php";
 require_once "../ess/theme.php";
 require_once "main.php";

class Account extends Main
{

  function __construct()
  {
    parent::authenticate();
    parent::head("Account Settings");
    $link = parent::connect();
    $user_ext_id = parent::user_ext_id($_SESSION['USERID']);
    $result = $link->query("SELECT *
                            FROM user_info
                            WHERE user_id='".$_SESSION["USERID"]."'");

    $user_info = $result->fetch_assoc();
    $link = parent::close($link);
    ?>
    <div class="container internal">
      <div class="page-header">
        <h3>Account Settings</h3>
      </div>
      <div class="row">
        <div class="col-md-4">
          <ul class="nav nav-pills nav-stacked" id="pnt_menu">
            <li role="presentation" class="active"><a id="email" href="#email">Email</a></li>
            <li role="presentation"><a id="pass" href="#pass">Password</a></li>
            <li role="presentation"><a id="info" href="#info">Basic Information</a></li>
            <li role="presentation"><a id="phone" href="#phone">Phone</a></li>
          </ul>
        </div>
        <div class="col-md-6" id="pnt_container">
          <!--Email-->
          <div id="email" class="pnt_div show">
            <form id="default-form" class="form-horizontal" role="form" action="actions/email.php" method="post">
              <div id="alert" class="alert hide"></div>
              <div class="form-group">
                  <label for="email" class="col-md-3 control-label">Email</label>
                  <div class="col-md-9">
                      <input type="text" class="form-control" disabled="disabled" name="email" value="<?php echo $_SESSION["EMAIL"] ?>" placeholder="Email Address">
                  </div>
              </div>
              <div class="form-group">
                    <label for="password" class="col-md-3 control-label">Password</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                </div>
              <div class="form-group">
                  <!-- Button -->
                  <div class="col-md-offset-3 col-md-9">
                      <button id="btn-signup" type="submit" disabled="disabled" class="btn btn-info">Update</button>
                  </div>
              </div>
            </form>
          </div>
          <!--Password-->
          <div id="pass" class="pnt_div">
            <form id="pass_update" class="form-horizontal" role="form" action="../actions/password.php" method="post">
                <div id="alert" class="alert hide"></div>
                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Current Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="current" placeholder="Current Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">New Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="new" placeholder="New Password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="confirm" placeholder="Confirm Password">
                    </div>
                </div>

                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-offset-4 col-md-8">
                        <button id="btn-signup" type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </form>
          </div>
          <!--Basic Information-->
          <div id="info" class="pnt_div">
            <form id="info_update" class="form-horizontal" role="form" action="../actions/info.php" method="post">
                <div id="alert" class="alert hide"></div>

                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">First Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="firstname" value="<?php echo $user_info["firstname"] ?>" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Middle Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="middlename" value="<?php echo $user_info["middlename"] ?>" placeholder="Middle Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Last Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="lastname" value="<?php echo $user_info["lastname"] ?>" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-3 control-label">Date of Birth</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="dob" value="<?php echo $user_info["birthdate"] ?>" placeholder="Date of Birth">
                    </div>
                </div>

                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-offset-3 col-md-9">
                        <button id="btn-signup" type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
            </form>
          </div>
          <!--Phone-->
          <div id="phone" class="pnt_div">
            <div class="page-header">
              <h4>Phone Numbers</h4>
            </div>
            <div id="default-block-ajax" linkAjax="ajax/phone.php" data='<?php echo parent::jsonencode(array()) ?>'><?php echo parent::loading("small"); ?></div>
            <form id="add_phone" targetAjax="#default-block-ajax" class="form-horizontal" role="form" action="../actions/addphone.php" method="post">
            <div class="page-header">
              <h4>Add Phone Number</h4>
            </div>
            <div class="form-group">
                <div class="col-md-9">
                    <input type="text" class="form-control" name="phone" placeholder="Phone Number">
                </div>
            </div>

            <div class="form-group">
                <!-- Button -->
                <div class=" col-md-9">
                  <input type="hidden" name="user_id" value="<?php echo $user_ext_id ?>" />
                    <button id="btn-signup" type="submit" class="btn btn-info">Add</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
    <?php
    parent::tail();
  }
}
new Account();
?>
