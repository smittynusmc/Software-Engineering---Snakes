

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="sprint_edit-title"> Edit Sprint</h4>
        </div>
        <div class="modal-body" id="sprint_edit-body">
            <?php echo form_open('Sprint/edit',Array('id'=>'sprint_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="sprint_id">Sprint ID</label>
                    <input type="text" class="form-control" name="sprint_id" id="sprint_id" placeholder="Sprint ID" value="<?php echo $sprint_id;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="sprint_name">Sprint Name</label>
                    <input type="text" class="form-control" name="sprint_name" id="sprint_name" placeholder="Sprint Name" value="<?php echo $sprint_name;?>">
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="sprint_edit-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="sprint_edit_form">Submit</button>
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