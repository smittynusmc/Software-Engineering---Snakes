

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="project_search-title"> Development Search</h4>
        </div>
        <div class="modal-body" id="project_search-body">
            <?php echo form_open('Development/search/',array('id'=>'development_search_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="Project_ID">Project ID</label>
                    <input type="text" class="form-control" name="Project_ID" id="Project_ID" placeholder="Project ID" value="<?php echo $Project_ID;?>">
                </div>
                <div class="form-group">
                    <label for="Project_Name">Project Name</label>
                    <input type="text" class="form-control" name="Project_Name" id="Project_Name" placeholder="Project Name" value="<?php echo $Project_Name;?>">
                </div>
                <div class="form-group">
                    <label for="Product_Code">Product Code</label>
                    <input type="text" class="form-control" name="Product_Code" id="Product_Code" placeholder="Product Code" value="<?php echo $Product_Code;?>">
                </div>
                <div class="form-group">
                    <label for="Product_Name">Product Name</label>
                    <input type="text" class="form-control" name="Product_Name" id="Product_Name" placeholder="Product Name" value="<?php echo $Product_Name;?>">
                </div>
                <div class="form-group">
                    <label for="WBS_ID">WBS ID</label>
                    <input type="text" class="form-control" name="WBS_ID" id="WBS_ID" placeholder="Project ID" value="<?php echo $WBS_ID;?>">
                </div>
                <div class="form-group">
                    <label for="WBS_Name">WBS Name</label>
                    <input type="text" class="form-control" name="WBS_Name" id="WBS_Name" placeholder="WBS Name" value="<?php echo $WBS_Name;?>">
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
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Development/index/{$record->Development_ID}'target ='content'>  "
                        . "{$record->Project_Name}"
                        . "<br>"
                        . "{$record->Product_Name}"
                        . "<br>"
                        . "{$record->WBS_Name}"        
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
