<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="project_search-title"> CPCR Search</h4>
        </div>
        <div class="modal-body" id="project_search-body">
            <?php echo form_open('CPCR/search/',array('id'=>'cpcr_search_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="cpcr_id">CPCR ID</label>
                    <input type="text" class="form-control" name="cpcr_id" id="cpcr_id" placeholder="CPCR ID" value="<?php echo $cpcr_id;?>">
                </div>
				<div class="form-group">
                    <label for="program_name">Program Name</label>
                    <input type="text" class="form-control" name="program_name" id="program_name" placeholder="Program Name" value="<?php echo $program_name;?>">
                </div>
				<div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo $product_name;?>">
                </div>
				<div class="form-group">
                    <label for="wbs_name">WBS Name</label>
                    <input type="text" class="form-control" name="wbs_name" id="wbs_name" placeholder="WBS Name" value="<?php echo $wbs_name;?>">
                </div>
				<div class="form-group">
                    <label for="wbs_name">CPCR Status</label>
                    <input type="text" class="form-control" name="cpcr_status" id="cpcr_status" placeholder="CPCR Status" value="<?php echo $cpcr_status;?>">
                </div>
				<div class="form-group">
                    <label for="wbs_name">Updated</label>
                    <input type="text" class="form-control" name="updated" id="updated" placeholder="Updated" value="<?php echo $updated;?>">
                </div>
				<div class="form-group">
                    <label for="wbs_name">Created</label>
                    <input type="text" class="form-control" name="created" id="created" placeholder="Created" value="<?php echo $created;?>">
                </div>
                
                
            </div> 
        </div>
        <div class="modal-footer" id="project_search-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="cpcr_search_form">Search</button>
            </div>
        </div>
        <div class="modal-footer" id="project_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    foreach ($result as $record){
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/CPCR/index/{$record->cpcr_id}'target ='content'>  "
                        . "{$record->program_name} "
                        . "<br>"
                        . "{$record->product_name}"
                        . "<br>"
                        . "{$record->wbs_name}"
						. "<br>"
                        . "{$record->cpcr_status}" 
						. "<br>"
                        . "{$record->updated}"  
						. "<br>"
                        . "{$record->created}"  
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
