

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html lang="en">
    <?php
    if (isset($this->session->userdata['logged_in'])) {

        header("location: ".base_url()."index.php/User_Authentication/user_login_process");
    }
    ?>
    <head>
        <meta charset="utf-8">
        <title>Login Form</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css">
    </head>
   
    <body>
        
        <div id="container" align="center" >
        
            <div class="box box-primary" style='width: 50%;'>
                <div class="box-header with-border">
                    <h3 class="box-title">Login</h3>
                </div>
                <div class="form-error">
                    <?php 
                    if (isset($error_message)) {
                        echo $error_message;
                    }
                    echo validation_errors(); 
                    ?>
                    <?php
                    if (isset($logout_message)) {
                        echo "<div class='message'>";
                        echo $logout_message;
                        echo "</div>";
                    }
                    ?>
                </div>
                <?php echo form_open('User_Authentication/user_login_process'); ?>
                    <div class="box-body" >
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" class="form-control" name="username" id="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <a href="<?php echo base_url() ?>index.php/User_Authentication/user_registration_show">To SignUp Click Here</a>
                
                    <?php echo form_close(); ?>
            </div>

        </div>
        
    </body>
</html>
