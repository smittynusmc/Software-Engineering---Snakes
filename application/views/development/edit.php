<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="development_edit-title"> Edit Development</h4>
        </div>
        <div class="modal-body" id="development_edit-body">
            <?php echo form_open('Development/edit',array('id'=>'development_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
				<div class="form-group">
                    <label for="development_id">Development ID</label>
                    <input type="text" class="form-control" name="development_id" id="development_id" placeholder="Development ID" value="<?php echo $development_id;?>" readonly>
                </div>
                <div class="form-group">
					<label>Program</label>
					<select class="form-control select2" style="width: 100%;" name="program_id" id="edit_program_id">
						<option value="">Select Program </option>
						<?php
							foreach($obs_data['program'] as $row){
								if(isset($program_id) && $program_id == $row['program_id']){
									echo " <option value='{$row['program_id']}' selected>{$row['program_code']}-{$row['program_name']}</option>";
								}
								else{
									echo " <option value='{$row['program_id']}'>{$row['program_code']}-{$row['program_name']}</option>";
								}
							}
						?>
					  
					</select>
				</div>
				<div class="form-group">
					<label>Product</label>
					<select class="form-control select2" style="width: 100%;" name="product_id" id="edit_product_id">
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
					<select class="form-control select2" style="width: 100%;" name="wbs_id" id="edit_wbs_id">
						<option value="">Select WBS</option>
						<?php
							foreach($wbs as $row){
								if(isset($wbs_id) && $wbs_id == $row->wbs_id){
									echo " <option value='{$row->wbs_id}' selected>{$row->wbs_code}-{$row->wbs_name}</option>";
								}
								else{
									echo " <option value='{$row->wbs_id}'>{$row->wbs_code}-{$row->wbs_name}</option>";
								}
							}
						?>
					  
					</select>
				</div>
				<div class="form-group">
                    <label for="build_date">Date</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" name="date" value="<?php echo $date;?>" id="date" placeholder="yyyy-mm-dd" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask="">
                    </div>
                </div>
				<div class="form-group">
                    <label for="development_id">SLOC</label>
                    <input type="text" class="form-control" name="sloc" id="edit_sloc" placeholder="SLOC" value="<?php echo $sloc;?>">
                </div>
				<div class="form-group">
                    <label for="development_id">Hours</label>
                    <input type="text" class="form-control" name="hours" id="edit_hours" placeholder="Hours" value="<?php echo $hours;?>">
                </div>	
				<div class="form-group">
                    <input type="text" class="form-control" name="obs_id" id="edit_obs_id" value="<?php echo $obs_id;?>" style="display:none;" >
                </div>	
                
            </div> 
        </div>
        <div class="modal-footer" id="development_edit-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="development_edit_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="obs-edit-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Development/index/{$development_id}' target ='content'> $result</button>";
                }
                else{
                    echo $result;
                }
            }
            ?>
        </div>
        <?php echo form_close(); ?>
    </div>

<script>
	var product = JSON.parse('<?php echo json_encode($obs_data['product']);?>');		
	var wbs = JSON.parse('<?php echo json_encode($obs_data['wbs']);?>');
	var def_option_product = '<option>Select Product</option>';
	var def_option_wbs = '<option>Select WBS</option>';
	var seted_program_id = <?php if(empty($program_id)){echo 0;} else{echo $program_id;}?>;
	var seted_product_id = <?php if(empty($product_id)){echo 0;} else{echo $product_id;}?>;
	var seted_wbs_id = <?php if(empty($wbs_id)){echo 0;} else{echo $wbs_id;}?>;
	var seted_obs_id = <?php if(empty($obs_id)){echo 0;} else{echo $obs_id;}?>;
	$(document).on('change','#edit_program_id',function(e){
		var option = '';
		var program_id = $('#edit_program_id').val();
		$('#edit_obs_id').val('');
		if(program_id > 0){
			option += '<option>Select Product</option>';
			for (pro in product[program_id]){	
				if(seted_product_id > 0 && seted_product_id == product[program_id][pro].product_id){
					option += '<option value="'+product[program_id][pro].product_id+'" selected> '+product[program_id][pro].product_name+'</option>';
				}
				else{
					option += '<option value="'+product[program_id][pro].product_id+'"> '+product[program_id][pro].product_name+'</option>';
				}
			};
			$('#edit_product_id').html(option);
			$('#edit_product_id').prop('disabled', false);
			$('#edit_wbs_id').prop('disabled', true);
		}
		else{
			$('#edit_product_id').html(def_option_product);
			$('#edit_product_id').prop('disabled', true);
			$('#edit_wbs_id').html(def_option_wbs);
			$('#edit_wbs_id').prop('disabled', true);
		}
		
	});
	$(document).on('change','#edit_product_id',function(e){
		var option = '';
		var program_id = $('#edit_program_id').val();
		var product_id = $('#edit_product_id').val();
		$('#edit_obs_id').val('');
		if(program_id > 0 && product_id >0){
			option += def_option_wbs;
			for (w in wbs[program_id][product_id]){
				if(seted_wbs_id > 0 && seted_wbs_id == wbs[program_id][product_id][w].wbs_id){
					option += '<option value="'+wbs[program_id][product_id][w].obs_id+'" selected> '+wbs[program_id][product_id][w].wbs_code+'-'+wbs[program_id][product_id][w].wbs_name+'</option>';
				}
				else{
					option += '<option value="'+wbs[program_id][product_id][w].obs_id+'"> '+wbs[program_id][product_id][w].wbs_code+'-'+wbs[program_id][product_id][w].wbs_name+'</option>';
				}
			}		
			$('#edit_wbs_id').prop('disabled', false);
			$('#edit_wbs_id').html(option);
		}
		else{
			$('#edit_wbs_id').html(def_option_wbs);
			$('#edit_wbs_id').prop('disabled', true);
		}
		
	});
	$(document).on('change','#edit_wbs_id',function(e){
		if($('#edit_wbs_id').val() > 0){
			$('#edit_obs_id').val($('#edit_wbs_id').val());
		}
		else{
			$('#edit_obs_id').val('');
		}
	});
	if(seted_program_id > 0){
		$('#edit_program_id').trigger('change');
	}
	if(seted_product_id > 0){
		$('#edit_product_id').trigger('change');
	}
	if(seted_wbs_id > 0){
		$('#edit_wbs_id').trigger('change');
	}
	$('#date').datepicker({format: 'yyyy-mm-dd',});
</script>