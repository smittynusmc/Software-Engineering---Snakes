

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="WBS_edit-title"> Edit WBS</h4>
        </div>
        <div class="modal-body" id="WBS_edit-body">
            <?php echo form_open('WBS/edit',Array('id'=>'WBS_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="WBS_ID">WBS ID</label>
                    <input type="text" class="form-control" name="WBS_ID" id="WBS_ID" placeholder="WBS ID" value="<?php echo $WBS_ID;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="WBS_Name">WBS Name</label>
                    <input type="text" class="form-control" name="WBS_Name" id="WBS_Name" placeholder="WBS Name" value="<?php echo $WBS_Name;?>">
                </div>
             
            </div> 
        </div>
        <div class="modal-footer" id="WBS_edit-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="WBS_edit_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="WBS_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/WBS/index/{$WBS_ID}' target ='content'> $result</button>";
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

