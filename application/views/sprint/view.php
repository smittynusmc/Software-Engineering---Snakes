
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"> Sprint Detail</h3>
        <div>
            <?php include 'header.php'; ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table">
             
            <tbody>
              <tr>
                <td class="detail-title">Sprint ID:</td>
                <td class="detail-info"><?php echo $sprint_id;?></td>
              </tr>
			  <tr>
                <td class="detail-title">Sprint Name:</td>
                <td class="detail-info"><?php echo $sprint_name;?></td>
              </tr>
              
            </tbody>
          </table>
        
        <div class="modal fade" id="my_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
    </div>
</div>
    
    