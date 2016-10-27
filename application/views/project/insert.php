


<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="project_insert-title"> Add New Project</h4>
        </div>
        <div class="modal-body" id="project_insert-body">
            <?php echo form_open('Project/insert',array('id'=>'project_insert_form')); ?>
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
                        <input type="text" class="form-control" name="Build_Date" value="<?php echo $Build_Date;?>" id="Build_Date" placeholder="yyyy-mm-dd" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="End_Date">End Date</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" name="End_Date" value="<?php echo $End_Date;?>" id="End_Date" placeholder="yyyy-mm-dd" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask="">
                    </div>
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="project_insert-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="project_insert_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="project_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' record='Project-{$Project_ID}' target ='content'> $result</button>";
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
<script>
    $('#End_Date').datepicker({format: 'yyyy-mm-dd',});
    $('#Build_Date').datepicker({format: 'yyyy-mm-dd',});
    
</script>
