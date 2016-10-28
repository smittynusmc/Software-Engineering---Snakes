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
                <td class="detail-title">Project ID:</td>
                <td class="detail-info"><?php echo $Project_ID;?></td>
                <td class="detail-title">Project Name:</td>
                <td class="detail-info"><?php echo $Project_Name;?></td>
              </tr>
              <tr>
                <td class="detail-title">Product Code:</td>
                <td class="detail-info"><?php echo $Product_Code;?></td>
                <td class="detail-title">Product Name:</td>
                <td class="detail-info"><?php echo $Product_Name;?></td>
              </tr>
              <tr>
                <td class="detail-title">WBS ID:</td>
                <td class="detail-info"><?php echo $WBS_ID;?></td>
                <td class="detail-title">WBS Name:</td>
                <td class="detail-info"><?php echo $WBS_Name;?></td>
              </tr>
              <tr>
                <td class="detail-title">SLOC:</td>
                <td class="detail-info"><?php echo $SLOC;?></td>
                <td class="detail-title">Hours:</td>
                <td class="detail-info"><?php echo $Hours;?></td>
              </tr>
              <tr>
                <td class="detail-title">Date:</td>
                <td class="detail-info"><?php echo $Date;?></td>
                <td class="detail-title">&nbsp;</td>
                <td class="detail-info">&nbsp;</td>
              </tr>
              
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" tabindex="-1" role="dialog" aria-labelledby="my_dialog_title" aria-hidden="true">

        </div>
    </div>
</div>
    
    