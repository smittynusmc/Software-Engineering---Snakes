<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
    <?php
    if (isset($this->session->userdata['logged_in'])) {
        header("location: ".base_url()."/login/index.php/User_Authentication/user_login_process");
    }
    ?>
    <head>
        <title>Registration Form</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
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
                echo form_open('User_Authentication/new_user_registration');?>
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
                            <label for="firstname">First Name</label>
                            <input type="firstname" class="form-control" name="firstname" id="email" placeholder="First Name">
                        </div>
                        
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="lastname" class="form-control" name="lastname" id="email" placeholder="Last Name">
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