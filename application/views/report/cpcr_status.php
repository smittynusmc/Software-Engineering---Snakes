<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title">CPCR Status Report</h3>
		<div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <div class="modal-body" id="cpcr_status-body">
            <?php echo form_open('report/cpcr_status_get_result', array('id' => 'cpcr_status_report_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <table class='postfilter'>
                    <tbody>
                        <tr>
                            <td class="detail-info">
                                <div class="form-group">
                                    <label>Program</label>
                                    <select class="form-control select2" style="width: 100%;" name="program_id" >
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
                                    <select class="form-control select2" style="width: 100%;" name="product_id" >
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
                                    <select class="form-control select2" name="wbs_id" >
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
								<div class="form-group">
									<label>Status</label>
									<select class="form-control select2" style="width: 100%;" name="cpcr_status" id="cpcr_status">
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
                <button type="submit" class="btn btn-primary report-submit-button" formid="cpcr_status_report_form" target="content">Submit</button>
            </div>
        </div>


		<?php echo form_close(); ?>
		<?php if(!empty($report_data)){?>
		<div class="box-body">
			<h3 class="box-title">
				Report Data
				<button type="button" class="btn btn-primary btn-success export-button" filename="cpcr_status_report.csv" data='<?php echo json_encode ($report_data); ?>'> 
					<span class="glyphicon glyphicon-download-alt">
					</span>
					CSV
				</button>
			</h3>
			<table id="cpcr_status_report_table" class="tablesorter">
				<thead>
					<tr>
						<th width="25%">Program Name</th>
						<th width="25%">Product Name</th>
						<th width="35%">WBS Name</th>
						<th width="15%">CPCR Status</th>
					</tr>
			    </thead>
				<tbody>
					
				<?php 

					foreach($report_data as $row){
						echo "<tr>";
						echo "<td>";
						echo $row->program_name;
						echo "</td>";
						echo "<td>";
						echo $row->product_name;
						echo "</td>";
						echo "<td>";
						echo $row->wbs_name;
						echo "</td>";
						echo "<td>";
						echo $row->cpcr_status;
						echo "</td>";
						echo "</tr>";
					}
				?>
				</tbody>
			</table>
			
		</div>
		<?php }?>
    </div>
</div>
<script>
	$(document).ready(function (){
		$('#cpcr_status_report_table').tablesorter({
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