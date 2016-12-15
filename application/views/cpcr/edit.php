<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="cpcr_edit-title"> Edit CPCR</h4>
        </div>
        <div class="modal-body" id="cpcr_edit-body">
            <?php echo form_open('CPCR/edit',array('id'=>'cpcr_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
				<div class="form-group">
					<label for="cpcr_id">CPCR ID</label>
					<input type="text" class="form-control" name="cpcr_id" id="get_cpcr_id" placeholder="CPCR ID" value="<?php echo $cpcr_id;?>" readonly>
				</div>
				<div class="form-group">
					<label>Program</label>
					<select class="form-control select2" style="width: 100%;" name="program_id" id="edit_cpcr_program_id">
						<option value="">Select Programs </option>
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
					<select class="form-control select2" style="width: 100%;" name="product_id" id="edit_cpcr_product_id">
						<option value="">Select Product</option>
						
					  
					</select>
				</div>
				<div class="form-group">
					<label>WBS</label>
					<select class="form-control select2" style="width: 100%;" name="wbs_id" id="edit_cpcr_wbs_id">
						<option value="">Select WBS</option>
						
					  
					</select>
				</div>
				
				<div class="form-group">
					<label>Status</label>
					<select class="form-control select2" style="width: 100%;" name="cpcr_status" id="edit_cpcr_status">
						<option value="">Select Status </option>
						<?php
							foreach($cpcr_status_codeset as $row){
								if(isset($cpcr_status) && $cpcr_status == $row->cpcr_status_code){
									echo " <option value='{$row->cpcr_status_code}' selected>{$row->cpcr_status_code}-{$row->cpcr_status_name}</option>";
								}
								else{
									echo " <option value='{$row->cpcr_status_code}'>{$row->cpcr_status_code}-{$row->cpcr_status_name}</option>";
								}
							}
						?>
					  
					</select>
                </div>
				<div class="form-group">
                    <input type="text" class="form-control" name="obs_id" id="edit_cpcr_obs_id" value="<?php echo $obs_id;?>" style="display:none;" >
                </div>
				
                
            </div> 
        </div>
        <div class="modal-footer" id="product_insert-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="cpcr_edit_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="product_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/CPCR/index/{$cpcr_id}' target ='content'> $result</button>";
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
		var product = JSON.parse('<?php echo json_encode($obs_data['product']);?>');		
		var wbs = JSON.parse('<?php echo json_encode($obs_data['wbs']);?>');
		var def_option_product = '<option>Select Product</option>';
		var def_option_wbs = '<option>Select WBS</option>';
		var seted_program_id = <?php if(empty($program_id)){echo 0;} else{echo $program_id;}?>;
		var seted_product_id = <?php if(empty($product_id)){echo 0;} else{echo $product_id;}?>;
		var seted_wbs_id = <?php if(empty($wbs_id)){echo 0;} else{echo $wbs_id;}?>;
		var seted_obs_id = <?php if(empty($obs_id)){echo 0;} else{echo $obs_id;}?>;
		$(document).on('change','#edit_cpcr_program_id',function(e){
			var option = '';
			var program_id = $('#edit_cpcr_program_id').val();
			$('#edit_cpcr_product_id').html(def_option_product);
			$('#edit_cpcr_wbs_id').html(def_option_wbs);
			$('#edit_cpcr_obs_id').val('');
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
				$('#edit_cpcr_product_id').html(option);
				$('#edit_cpcr_product_id').prop('disabled', false);
				$('#edit_cpcr_wbs_id').prop('disabled', true);
			}
			else{				
				$('#edit_cpcr_product_id').html(def_option_product);
				$('#edit_cpcr_product_id').prop('disabled', true);
				$('#edit_cpcr_wbs_id').html(def_option_wbs);
				$('#edit_cpcr_wbs_id').prop('disabled', true);
			}
			
		});
		$(document).on('change','#edit_cpcr_product_id',function(e){
			var option = '';
			var program_id = $('#edit_cpcr_program_id').val();
			var product_id = $('#edit_cpcr_product_id').val();
			$('#edit_cpcr_obs_id').val('');
			if(program_id > 0 && product_id >0){
				option += def_option_wbs;
				
				for (w in wbs[program_id][product_id]){
					if(seted_wbs_id > 0 && seted_wbs_id == wbs[program_id][product_id][w].wbs_id){
						option += '<option obs_id="'+wbs[program_id][product_id][w].obs_id+'"  value="'+wbs[program_id][product_id][w].wbs_id+'" selected> '+wbs[program_id][product_id][w].wbs_code+'-'+wbs[program_id][product_id][w].wbs_name+'</option>';
					}
					else{
						option += '<option obs_id="'+wbs[program_id][product_id][w].obs_id+'"  value="'+wbs[program_id][product_id][w].wbs_id+'"> '+wbs[program_id][product_id][w].wbs_code+'-'+wbs[program_id][product_id][w].wbs_name+'</option>';
					}
				};		
				$('#edit_cpcr_wbs_id').prop('disabled', false);
				$('#edit_cpcr_wbs_id').html(option);
			}
			else{
				$('#edit_cpcr_wbs_id').html(def_option_wbs);
				$('#edit_cpcr_wbs_id').prop('disabled', true);
			}
			
		});
		$(document).on('change','#edit_cpcr_wbs_id',function(e){
			if($('#edit_cpcr_wbs_id').val() > 0){
				$('#edit_cpcr_obs_id').val($('#edit_cpcr_wbs_id option:selected').attr('obs_id'));
			}
			else{
				$('#edit_cpcr_obs_id').val('');
			}
		});
		$('#edit_cpcr_program_id').trigger('change');
		if(seted_product_id > 0){
			$('#edit_cpcr_product_id').trigger('change');
		}
		if(seted_wbs_id > 0){
			$('#edit_cpcr_wbs_id').trigger('change');
		}
		
		if(seted_obs_id > 0){
			$('#edit_cpcr_obs_id').val(seted_obs_id);
		}
		$('#date').datepicker({format: 'yyyy-mm-dd',});
</script>