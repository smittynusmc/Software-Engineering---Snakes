

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="wbs_edit-title"> Edit WBS</h4>
        </div>
        <div class="modal-body" id="wbs_edit-body">
            <?php echo form_open('WBS/edit',Array('id'=>'wbs_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="WBS_ID">WBS ID</label>
                    <input type="text" class="form-control" name="wbs_id" id="wbs_id" placeholder="WBS ID" value="<?php echo $wbs_id;?>" readonly >
                </div>
				<div class="form-group">
                    <label for="WBS_ID">WBS Code</label>
                    <input type="text" class="form-control" name="wbs_code" id="wbs_code" placeholder="WBS ID" value="<?php echo $wbs_code;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="wbs_name">WBS Name</label>
                    <input type="text" class="form-control" name="wbs_name" id="wbs_name" placeholder="WBS Name" value="<?php echo $wbs_name;?>">
                </div>
            </div> 
        </div>
        <div class="modal-footer" id="wbs_edit-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="wbs_edit_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="wbs_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/WBS/index/{$wbs_id}' target ='content'> $result</button>";
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
