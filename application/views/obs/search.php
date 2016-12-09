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
                    <label for="program_code">Program Code</label>
                    <input type="text" class="form-control" name="program_code" id="program_code" placeholder="Program Code" value="<?php echo $program_code;?>">
                </div>
				<div class="form-group">
                    <label for="program_name">Program Name</label>
                    <input type="text" class="form-control" name="program_name" id="program_name" placeholder="Program Name" value="<?php echo $program_name;?>">
                </div>
                <div class="form-group">
                    <label for="product_code">Product Code</label>
                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Product Code" value="<?php echo $product_code;?>">
                </div>
				<div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo $product_name;?>">
                </div>
                <div class="form-group">
                    <label for="wbs_code">WBS Code</label>
                    <input type="text" class="form-control" name="wbs_code" id="wbs_code" placeholder="WBS Name" value="<?php echo $wbs_code;?>">
                </div>
				<div class="form-group">
                    <label for="wbs_name">WBS Name</label>
                    <input type="text" class="form-control" name="wbs_name" id="wbs_name" placeholder="WBS Name" value="<?php echo $wbs_name;?>">
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
                        . "{$record->program_code} - {$record->program_name} "
                        . "<br>"
                        . "{$record->product_code} - {$record->product_name}"
                        . "<br>"
                        . "{$record->wbs_code}  - {$record->wbs_name}"        
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
