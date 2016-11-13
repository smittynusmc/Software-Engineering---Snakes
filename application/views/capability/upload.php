


<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="capability_insert-title"> Add New Capability</h4>
        </div>
        <div class="modal-body" id="capability_insert-body">
            <?php echo form_open('Capability/upload',array('id'=>'capability_upload_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="checkbox">
                  <label>
                      <input type="checkbox" id="has_header" name ="has_header" value="1" checked> CSV File included header
                  </label>
                    <p class="help-block">Check this box if the csv file to be uploaded contains column headings.</p>
                </div>
                
                <div class="form-group">
                    <label for="csv">File input</label>
                    <input type="file" id="csv" name ="csv">
                    <p class="help-block">Only csv files are allowed.</p>
                </div>
            </div> 
        </div>
        <div class="modal-footer" id="capability_insert-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="capability_upload_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="capability_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    echo "<button class='btn btn-default btn-block' type='button' target ='content'> $result</button>";
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