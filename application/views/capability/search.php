

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="capability_search-title"> Capability Search</h4>
        </div>
        <div class="modal-body" id="capability_search-body">
            <?php echo form_open('Capability/search/',array('id'=>'capability_search_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="Capability_Code">Capability ID</label>
                    <input type="text" class="form-control" name="capability_id" id="capability_id" placeholder="Capability ID" value="<?php echo $capability_id;?>">
                </div>
                <div class="form-group">
                    <label for="capability_name">Capability Name</label>
                    <input type="text" class="form-control" name="capability_name" id="capability_name" placeholder="Capability Name" value="<?php echo $capability_name;?>">
                </div>

                
            </div> 
        </div>
        <div class="modal-footer" id="capability_search-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="capability_search_form">Search</button>
            </div>
        </div>
        <div class="modal-footer" id="capability_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    foreach ($result as $record){
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Capability/index/{$record->capability_id}'target ='content'>  {$record->capability_name}</button>";
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
