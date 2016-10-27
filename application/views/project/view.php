<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"> Project Detail</h3>
        <div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table">
            
            <tbody>
              <tr>
                <td class="detail-title">Project ID:</td>
                <td class="detail-info"><?php echo $Project_ID;?></td>
                <td class="detail-title">Project Name:</td>
                <td class="detail-info"><?php echo $Project_Name;?></td>
              </tr>
              <tr>
                <td class="detail-title">Build Date:</td>
                <td class="detail-info"><?php echo $Build_Date;?></td>
                <td class="detail-title">End Date:</td>
                <td class="detail-info"><?php echo $End_Date;?></td>
              </tr>
              
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
    </div>
</div>
    
    