


<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="sprint_insert-title"> Add New Sprint</h4>
        </div>
        <div class="modal-body" id="sprint_insert-body">
            <?php echo form_open('Sprint/insert',array('id'=>'sprint_insert_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="sprint_name">Sprint Name</label>
                    <input type="text" class="form-control" name="sprint_name" id="sprint_name" placeholder="Sprint Name" value="<?php echo $sprint_name;?>">
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="sprint_insert-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="sprint_insert_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="sprint_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Sprint/index/{$sprint_id}' target ='content'> $result</button>";
                }
                else{
                    echo $result;
                }
            }
            ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
