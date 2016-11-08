

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="wbs_search-title"> WBS Search</h4>
        </div>
        <div class="modal-body" id="wbs_search-body">
            <?php echo form_open('WBS/search/',array('id'=>'wbs_search_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="wbs_id">WBS ID</label>
                    <input type="text" class="form-control" name="wbs_id" id="wbs_id" placeholder="WBS ID" value="<?php echo $wbs_id;?>">
                </div>
				<div class="form-group">
                    <label for="wbs_code">WBS Code</label>
                    <input type="text" class="form-control" name="wbs_code" id="wbs_code" placeholder="WBS Code" value="<?php echo $wbs_code;?>">
                </div>
                <div class="form-group">
                    <label for="wbs_name">WBS Name</label>
                    <input type="text" class="form-control" name="wbs_name" id="wbs_name" placeholder="WBS Name" value="<?php echo $wbs_name;?>">
                </div>
                
                
            </div> 
        </div>
        <div class="modal-footer" id="project_search-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="wbs_search_form">Search</button>
            </div>
        </div>
        <div class="modal-footer" id="project_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    foreach ($result as $record){
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/WBS/index/{$record->wbs_id}'target ='content'>  {$record->wbs_name}</button>";
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
