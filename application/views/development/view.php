<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"> Development Detail</h3>
        <div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table">
             <tbody>
              <tr>
                <td class="detail-title">Development ID:</td>
                <td class="detail-info"><?php echo $development_id;?></td>
			  </tr>
			  <tr>
                <td class="detail-title">Program Name:</td>
                <td class="detail-info"><?php echo $program_name;?></td>
              </tr>
			  <tr>
                <td class="detail-title">Product Name:</td>
                <td class="detail-info"><?php echo $product_name;?></td>
              </tr>
			  <tr>
                <td class="detail-title">WBS Name:</td>
                <td class="detail-info"><?php echo $wbs_name;?></td>
              </tr>
              <tr>
                <td class="detail-title">Date:</td>
                <td class="detail-info"><?php echo $date;?></td>
			  </tr>
			  <tr>
                <td class="detail-title">SLOC:</td>
                <td class="detail-info"><?php echo $sloc;?></td>
			  </tr>
			  <tr>
                <td class="detail-title">Hours:</td>
                <td class="detail-info"><?php echo $hours;?></td>
              </tr>
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" role="dialog" aria-labelledby="my_dialog_title" aria-hidden="true">
	
        </div>
    </div>
</div>
    
    