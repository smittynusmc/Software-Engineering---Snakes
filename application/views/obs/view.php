
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"> Organizational Breakdown Structure Detail</h3>
        <div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table">
             
            <tbody>
              <tr>
                <td class="detail-title">OBS ID:</td>
                <td class="detail-info"><?php echo $obs_id;?></td>
			  <tr>
			  </tr>
                <td class="detail-title">Program:</td>
                <td class="detail-info"><?php echo $program_code."-".$program_name;?></td>
              </tr>
              <tr>
                <td class="detail-title">Product:</td>
                <td class="detail-info"><?php echo $product_name;?></td>
			  <tr>
			  </tr>
                <td class="detail-title">WBS:</td>
                <td class="detail-info"><?php echo $wbs_code."-".$wbs_name;?></td>
              </tr>
              
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
    </div>
</div>
    
    