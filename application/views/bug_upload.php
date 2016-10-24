<html>
    <?php
    if (isset($this->session->userdata['logged_in'])) {
        $username = $this->session->userdata['logged_in']['username'];
        $email = $this->session->userdata['logged_in']['email'];
        $firstname = $this->session->userdata['logged_in']['firstname'];
        $lastname = $this->session->userdata['logged_in']['lastname'];
    } else {
//          header("location: User_Authentication/login");
        $lastname = $this->session->userdata['logged_in']['lastname'];
        echo 'test';
    }
    ?>

    <head>
        <meta charset="utf-8">
        <title>Bug Upload Form</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
    </head>
    <body>
        <div id="container" >
            <?php echo $error; ?>

            <?php echo form_open_multipart('BugUpload/do_upload'); ?>

                <div class="box-body">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bug Upload</h3>
                    </div>
                    <div class="form-group">
                        <label for="bugcsv">File input</label>
                        <input type="file" id="bugcsv" name ="bugcsv">

                        <p class="help-block">Only csv files are allowed.</p>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

</body> 
</html>