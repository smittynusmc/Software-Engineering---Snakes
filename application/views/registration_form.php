<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
    <?php
    if (isset($this->session->userdata['logged_in'])) {
        header("location: http://localhost/login/index.php/user_authentication/user_login_process");
    }
    ?>
    <head>
        <title>Registration Form</title>
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
    </head>
    <body>
        <div id="container" align="center" >

            <div class="box box-primary" style='width: 50%;'>
                <div class="box-header with-border">
                    <h3 class="box-title">Registration Form</h3>
                </div>
                 <?php
                echo "<div class='error_msg'>";
                if (isset($error_message)) {
                    echo $error_message;
                }
                echo validation_errors();
                echo "</div>";
                echo form_open('user_authentication/new_user_registration');?>
                    <div class="box-body" >
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" class="form-control" name="username" id="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                    </div>   
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>

                    
                <?php echo form_close(); ?>
            </div>
            <a href="<?php echo base_url() ?> ">For Login Click Here</a>
        </div>
    </body>
</html>