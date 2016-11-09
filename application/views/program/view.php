<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"> Program Detail</h3>
        <div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table">
            
            <tbody>
              <tr>
                <td class="detail-title">Program ID:</td>
                <td class="detail-info"><?php echo $program_id;?></td>
                <td class="detail-title"></td>
                <td class="detail-info"></td>
              </tr>
              <tr>
                <td class="detail-title">Program Code:</td>
                <td class="detail-info"><?php echo $program_code;?></td>
                <td class="detail-title">Program Name:</td>
                <td class="detail-info"><?php echo $program_name;?></td>
              </tr>
              <tr>
                <td class="detail-title">Build Date:</td>
                <td class="detail-info"><?php echo $build_date;?></td>
                <td class="detail-title">End Date:</td>
                <td class="detail-info"><?php echo $end_date;?></td>
              </tr>
              
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
    </div>
</div>
    
    