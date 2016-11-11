<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/CPCR/get_insert' title='Add New CPCR'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/CPCR/get_search' title='Search CPCR'>Search</a>
&nbsp;
<?php if(!empty($cpcr_id)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/CPCR/get_edit/<?php echo $cpcr_id; ?>'  title='Edit Current CPCR'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/CPCR/get_upload' title='Import from a CSV File'>Upload</a>

