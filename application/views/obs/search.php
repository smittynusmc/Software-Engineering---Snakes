

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="project_search-title"> OBS Search</h4>
        </div>
        <div class="modal-body" id="project_search-body">
            <?php echo form_open('OBS/search/',array('id'=>'obs_search_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="obs_id">OBS ID</label>
                    <input type="text" class="form-control" name="obs_id" id="obs_id" placeholder="OBS ID" value="<?php echo $obs_id;?>">
                </div>
                <div class="form-group">
                    <label for="program_id">Program ID</label>
                    <input type="text" class="form-control" name="program_id" id="program_id" placeholder="Program ID" value="<?php echo $program_id;?>">
                </div>
                <div class="form-group">
                    <label for="product_id">Product ID</label>
                    <input type="text" class="form-control" name="product_id" id="Product_Code" placeholder="Product ID" value="<?php echo $product_id;?>">
                </div>
                <div class="form-group">
                    <label for="wbs_id">WBS ID</label>
                    <input type="text" class="form-control" name="wbs_id" id="product_id" placeholder="WBS ID" value="<?php echo $wbs_id;?>">
                </div>
                
                
            </div> 
        </div>
        <div class="modal-footer" id="project_search-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="obs_search_form">Search</button>
            </div>
        </div>
        <div class="modal-footer" id="project_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    foreach ($result as $record){
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/OBS/index/{$record->obs_id}'target ='content'>  "
                        . "{$record->program_id}"
                        . "<br>"
                        . "{$record->product_id}"
                        . "<br>"
                        . "{$record->wbs_id}"        
                        . "</button>";
                    }
                }
                else{
                    echo "<button class='btn btn-default btn-block error' >  $result</button>";
                }
            }
            ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
