

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="project_search-title"> Project Search</h4>
        </div>
        <div class="modal-body" id="project_search-body">
            <?php echo form_open('Project/search/',array('id'=>'project_search_form')); ?>
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
                    <label for="Build_Date">Build Date</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" name="Build_Date" id="Build_Date" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" value="<?php echo $Build_Date;?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="End_Date">End Date</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" name="End_Date" id="End_Date" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" value="<?php echo $End_Date;?>">
                    </div>
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="project_search-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="project_search_form">Search</button>
            </div>
        </div>
        <div class="modal-footer" id="project_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    foreach ($result as $record){
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Project/index/{$record->Project_ID}'target ='content'>  {$record->Project_Name}</button>";
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
<script>
    $('#End_Date').datepicker({format: 'yyyy-mm-dd',});
    $('#Build_Date').datepicker({format: 'yyyy-mm-dd',});
    
</script>