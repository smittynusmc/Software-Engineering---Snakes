
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"> WBS Detail</h3>
        <div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table">
             
            <tbody>
              <tr>
                <td class="detail-title">WBS ID:</td>
                <td class="detail-info"><?php echo $wbs_id;?></td>
                <td class="detail-title"></td>
                <td class="detail-info"></td>
              </tr>
			  <tr>
                <td class="detail-title">WBS Code:</td>
                <td class="detail-info"><?php echo $wbs_code;?></td>
                <td class="detail-title">WBS Name:</td>
                <td class="detail-info"><?php echo $wbs_name;?></td>
              </tr>
              
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
    </div>
</div>
    
    