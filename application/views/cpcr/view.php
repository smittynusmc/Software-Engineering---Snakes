
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title">Computer Program Change Request Detail</h3>
        <div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table">
             
            <tbody>
              <tr>
                <td class="detail-title">CPCR ID:</td>
                <td class="detail-info"><?php echo $cpcr_id;?></td>
			  <tr>
			  </tr>
                <td class="detail-title">Program Name:</td>
                <td class="detail-info"><?php echo $program_name;?></td>
              </tr>
			  </tr>
                <td class="detail-title">Product Name:</td>
                <td class="detail-info"><?php echo $product_name;?></td>
              </tr>
			  </tr>
                <td class="detail-title">WBS Name:</td>
                <td class="detail-info"><?php echo $wbs_name;?></td>
              </tr>
              <tr>
                <td class="detail-title">CPCR Status:</td>
                <td class="detail-info"><?php echo $cpcr_status;?></td>
			  <tr>
			  </tr>
                <td class="detail-title">Updated:</td>
                <td class="detail-info"><?php echo $updated;?></td>
              </tr>
			  </tr>
                <td class="detail-title">Created:</td>
                <td class="detail-info"><?php echo $created;?></td>
              </tr>
              
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
    </div>
</div>
    
    