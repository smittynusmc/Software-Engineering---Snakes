


<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="development_search-title"> Development Search</h4>
        </div>
        <div class="modal-body" id="development_search-body">
            <?php echo form_open('Development/search/',array('id'=>'development_search_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="development_id">Development ID</label>
                    <input type="text" class="form-control" name="development_id" id="development_id" placeholder="Development ID" value="<?php echo $development_id;?>">
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
                    <label for="development_id">SLOC</label>
                    <input type="text" class="form-control" name="sloc" id="sloc" placeholder="SLOC" value="<?php echo $development_id;?>">
                </div>
				<div class="form-group">
                    <label for="development_id">Hours</label>
                    <input type="text" class="form-control" name="hours" id="hours" placeholder="Hours" value="<?php echo $development_id;?>">
                </div>	
                
            </div> 
        </div>
        <div class="modal-footer" id="project_search-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="development_search_form">Search</button>
            </div>
        </div>
        <div class="modal-footer" id="project_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    foreach ($result as $record){
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Development/index/{$record->development_id}'target ='content'>  "
                        . "{$record->program_name}"
                        . "<br>"
                        . "{$record->product_name}"
                        . "<br>"
                        . "{$record->wbs_name}"        
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
