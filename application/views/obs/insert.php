


<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="obs_insert-title"> Add New OBS</h4>
        </div>
        <div class="modal-body" id="obs_insert-body">
            <?php echo form_open('OBS/insert',array('id'=>'obs_insert_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
					<label>Program</label>
					<select class="form-control select2" style="width: 100%;"name="program_id" id="program_id">
						<option value="">Select Program </option>
						<?php
							foreach($program as $row){
								if(isset($program_id) && $program_id == $row->program_id){
									echo " <option value='{$row->program_id}' selected>{$row->program_code}-{$row->program_name}</option>";
								}
								else{
									echo " <option value='{$row->program_id}'>{$row->program_code}-{$row->program_name}</option>";
								}
							}
						?>
					  
					</select>
				</div>
				<div class="form-group">
					<label>Product</label>
					<select class="form-control select2" style="width: 100%;" name="product_id" id="product_id">
						<option value="">Select Product</option>
						<?php
							foreach($product as $row){
								if(isset($product_id) && $product_id == $row->product_id){
									echo " <option value='{$row->product_id}' selected>{$row->product_code}-{$row->product_name}</option>";
								}
								else{
									echo " <option value='{$row->product_id}'>{$row->product_code}-{$row->product_name}</option>";
								}
							}
						?>
					  
					</select>
				</div>
				<div class="form-group">
					<label>WBS</label>
					<select class="form-control select2"name="wbs_id" id="wbs_id">
						<option value="">Select WBS</option>
						<?php
							foreach($wbs as $row){
								if(isset($wbs_id) && $product_id == $row->wbs_id){
									echo " <option value='{$row->wbs_id}}' selected>{$row->wbs_code}-{$row->wbs_name}</option>";
								}
								else{
									echo " <option value='{$row->wbs_id}}'>{$row->wbs_code}-{$row->wbs_name}</option>";
								}
							}
						?>
					  
					</select>
				</div>
                
            </div> 
        </div>
        <div class="modal-footer" id="product_insert-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="obs_insert_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="product_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/OBS/index/{$obs_id}' target ='content'> $result</button>";
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
