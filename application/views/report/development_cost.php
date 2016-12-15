<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title">Development Report</h3>
		<?php include 'header.php'; ?>
    </div>
    <div class="box-body">
        <div class="modal-body" id="cpcr_insert-body">
            <?php echo form_open('report/development_cost_get_result', array('id' => 'development_report_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <table>
                    <tbody>
                        <tr>
                            <td class="detail-info">
                                <div class="form-group">
                                    <label>Program</label>
                                    <select class="form-control select2" style="width: 100%;"name="program_id" id="obs_program_id">
                                        <option value="">Select Program </option>
                                        <?php
                                        foreach ($program as $row) {
                                            if (isset($program_id) && $program_id == $row->program_id) {
                                                echo " <option value='{$row->program_id}' selected>{$row->program_code}-{$row->program_name}</option>";
                                            } else {
                                                echo " <option value='{$row->program_id}'>{$row->program_code}-{$row->program_name}</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </td>
                            <td class="detail-info">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select class="form-control select2" style="width: 100%;" name="product_id" id="obs_product_id">
                                        <option value="">Select Product</option>
											<?php
											foreach ($product as $row) {
												if (isset($product_id) && $product_id == $row->product_id) {
													echo " <option value='{$row->product_id}' selected>{$row->product_code}-{$row->product_name}</option>";
												} else {
													echo " <option value='{$row->product_id}'>{$row->product_code}-{$row->product_name}</option>";
												}
											}
											?>
                                    </select>
                                </div>
                            </td>
                            <td class="detail-info">
                                <div class="form-group">
                                    <label>WBS</label>
                                    <select class="form-control select2"name="wbs_id" id="obs_wbs_id">
                                        <option value="">Select WBS</option>
											<?php
											foreach ($wbs as $row) {
												if (isset($wbs_id) && $wbs_id == $row->wbs_id) {
													echo " <option value='{$row->wbs_id}' selected>{$row->wbs_code}-{$row->wbs_name}</option>";
												} else {
													echo " <option value='{$row->wbs_id}'>{$row->wbs_code}-{$row->wbs_name}</option>";
												}
											}
											?>

                                    </select>
                                </div>
                            </td>
                        </tr>
						<tr>
							<td>
								<label>Details Level</label>
								<div class="form-group" style="float:right;">
								  <div class="checkbox">
									<label>
									  <input id="program_detail_level_show" value="1" name= "program_detail_leval_show" type="checkbox" disabled checked>
									  <input id="program_detail_level" name="program_detail_level" type="checkbox" value="1" style="display:none;" checked/>
									  Program
									</label>
								  </div>

								  <div class="checkbox">
									<label>
										<?php if(!empty($product_detail_level) && $product_detail_level ==1){ ?>
										<input id="product_detail_level" value="1" name="product_detail_level" type="checkbox" checked>
										<?php }else{ ?>
									   <input id="product_detail_level" value="1" name="product_detail_level" type="checkbox">
										<?php }?>
									  Product
									</label>
								  </div>

								  <div class="checkbox">
									<label>
									  <?php if(!empty($wbs_detail_level) && $wbs_detail_level ==1) { ?>
									  <input id="wbs_detail_level" value="1" name="wbs_detail_level" type="checkbox" checked >
									  <?php } else { ?>
									  <input id="wbs_detail_level" value="1" name="wbs_detail_level" type="checkbox" >
									  <?php } ?>
									  WBS
									</label>
								  </div>
								</div>
							</td>
							<td>
								
							</td>
							<td>
							</td>
						</tr>
                    </tbody>
                </table>	

            </div> 
            <div class="box-footer">
                <button type="submit" class="btn btn-primary report-submit-button" formid="development_report_form" target="content">Submit</button>
            </div>
			<?php echo form_close(); ?>
			<?php if(!empty($report_data)){?>
			<div class="box-body">
				<h3 class="box-title">
					Report Data 
					<button type="button" class="btn btn-primary btn-success export-button" filename="development_cost_report.csv" data='<?php echo json_encode ($report_data); ?>'> 
						<span class="glyphicon glyphicon-download-alt">
						</span>
						CSV
					</button>
				</h3> 
				<table id="development_cost_report_table" class="tablesorter">
					<thead>	
						<tr>
							<th width="15%">Program Name</th>
							<th width="15%">Product Name</th>
							<th width="20%">WBS Name</th>
							<th width="15%">AVG SLOC</th>
							<th width="15%">AVG HOURS</th>
							<th width="10%">SUM SLOC</th>
							<th width="10%">SUM HOURS</th>
						</tr>
					</thead>
					<tbody>
						
				<?php 

					foreach($report_data as $row){
						echo "<tr>";
						echo "<td>";
						if(isset($row['program_name'])){
							echo $row['program_name'];
						}
						echo "</td>";
						echo "<td>";
						if(isset($row['product_name'])){
							echo $row['product_name'];
						}
						echo "</td>";
						echo "<td>";
						if(isset($row['wbs_name'])){
							echo $row['wbs_name'];
						}
						echo "</td>";
						echo "<td>";
						if(isset($row['avg_sloc'])){
							echo $row['avg_sloc'];
						}
						echo "</td>";
						echo "<td>";
						if(isset($row['avg_hours'])){
							echo $row['avg_hours'];
						}
						echo "</td>";
						echo "<td>";
						if(isset($row['sum_sloc'])){
							echo $row['sum_sloc'];
						}
						echo "</td>";
						echo "<td>";
						if(isset($row['sum_hours'])){
							echo $row['sum_hours'];
						}
						echo "</td>";
						echo "</tr>";
					}
				?>
					</tbody>
				</table>
				
			</div>
			<?php }?>
        </div>


<?php echo form_close(); ?>

    </div>
</div>
<script>
	$(document).ready(function(){
		$('#program_detail_level_show').change(function(){
			if($(this).is(':checked')){
				$('#program_detail_level').prop('checked', true);
			}
			else{
				$('#program_detail_level').prop('checked', false);
			}
		});
		$('#product_detail_level').change(function(){
			if($(this).is(':checked')){
				$('#program_detail_leval').prop('checked', true);
			}
		});
		$('#wbs_detail_level').change(function(){
			if($(this).is(':checked')){
				$('#product_detail_level').prop('checked', true);
			}
		});
		$('#development_cost_report_table').tablesorter({
			// *** Appearance ***
			// fix the column widths
			widthFixed : true,
			// include zebra and any other widgets, options:
			// 'uitheme', 'filter', 'stickyHeaders' & 'resizable'
			// the 'columns' widget will require custom css for the
			// primary, secondary and tertiary columns
			widgets    : [ 'uitheme', 'zebra' ],
			// other options: "ddmmyyyy" & "yyyymmdd"
			dateFormat : "mmddyyyy",

			// *** Functionality ***
			// starting sort direction "asc" or "desc"
			sortInitialOrder : "asc",
			// These are detected by default,
			// but you can change or disable them
			headers : {
				// set "sorter : false" (no quotes) to disable the column
				0: { sorter: "text" },
				1: { sorter: "digit" },
				2: { sorter: "text" },
				3: { sorter: "url" }
			},
			// extract text from the table - this is how is
			// it done by default
			textExtraction : {
				0: function(node) { return $(node).text(); },
				1: function(node) { return $(node).text(); }
			},
			// forces the user to have this/these column(s) sorted first
			sortForce : null,
			// initial sort order of the columns
			// [[columnIndex, sortDirection], ... ]
			sortList : [],
			// default sort that is added to the end of the users sort
			// selection.
			sortAppend : null,
			// Use built-in javascript sort - may be faster, but does not
			// sort alphanumerically
			sortLocaleCompare : false,
			// Setting this option to true will allow you to click on the
			// table header a third time to reset the sort direction.
			sortReset: false,
			// Setting this option to true will start the sort with the
			// sortInitialOrder when clicking on a previously unsorted column.
			sortRestart: false,
			// The key used to select more than one column for multi-column
			// sorting.
			sortMultiSortKey : "shiftKey",

			// *** Customize header ***
			onRenderHeader  : function() {
				// the span wrapper is added by default
				$(this).find('span').addClass('headerSpan');
			},
			// jQuery selectors used to find the header cells.
			selectorHeaders : 'thead th',

			// *** css classes to use ***
			cssAsc        : "headerSortUp",
			cssChildRow   : "expand-child",
			cssDesc       : "headerSortDown",
			cssHeader     : "header",
			tableClass    : 'tablesorter',

			// *** widget css class settings ***
			// column classes applied, and defined in the skin
			widgetColumns : { css: ["primary", "secondary", "tertiary"] },
			// find these jQuery UI class names by hovering over the
			// Framework icons on this page:
			// http://jqueryui.com/themeroller/
			widgetUitheme : { css: [
				"ui-icon-arrowthick-2-n-s", // Unsorted icon
				"ui-icon-arrowthick-1-s",   // Sort up (down arrow)
				"ui-icon-arrowthick-1-n"    // Sort down (up arrow)
				]
			},
			// pick rows colors to match ui theme
			widgetZebra: { css: ["ui-widget-content", "ui-state-default"] },

			// *** prevent text selection in header ***
			cancelSelection : true,

			// *** send messages to console ***
			debug : false
		});
	});
</script>