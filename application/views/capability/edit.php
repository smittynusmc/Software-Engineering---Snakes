

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="capability_edit-title"> Edit capability</h4>
        </div>
        <div class="modal-body" id="capability_edit-body">
            <?php echo form_open('Capability/edit',Array('id'=>'capability_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="capability_id">Capability ID</label>
                    <input type="text" class="form-control" name="capability_id" id="capability_id" placeholder="Capability ID" value="<?php echo $capability_id;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="capability_name">Capability Name</label>
                    <input type="text" class="form-control" name="capability_name" id="capability_name" placeholder="Capability Name" value="<?php echo $capability_name;?>">
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="capability_edit-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="capability_edit_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="capability_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Capability/index/{$capability_id}' target ='content'> $result</button>";
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