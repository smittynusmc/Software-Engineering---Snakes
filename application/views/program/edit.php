

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="program_edit-title"> Edit Program</h4>
        </div>
        <div class="modal-body" id="program_edit-body">
            <?php echo form_open('Program/edit',Array('id'=>'program_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="program_id">Program ID</label>
                    <input type="text" class="form-control" name="program_id" id="program_id" placeholder="Program ID" value="<?php echo $program_id;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="program_id">Program Code</label>
                    <input type="text" class="form-control" name="program_code" id="program_code" placeholder="Program Code" value="<?php echo $program_code;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="program_name">Program Name</label>
                    <input type="text" class="form-control" name="program_name" id="program_name" placeholder="Program Name" value="<?php echo $program_name;?>">
                </div>
                <div class="form-group">
                    <label for="build_date">Build Date</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" name="build_date" value="<?php echo $build_date;?>" id="build_date" placeholder="yyyy-mm-dd" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="End_Date">End Date</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" name="end_date" value="<?php echo $end_date;?>" id="end_date" placeholder="yyyy-mm-dd" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask="">
                    </div>
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="program_edit-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="program_edit_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="program_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Program/index/{$program_id}' target ='content'> $result</button>";
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
    $('#end_date').datepicker({format: 'yyyy-mm-dd',});
    $('#build_date').datepicker({format: 'yyyy-mm-dd',});
</script>