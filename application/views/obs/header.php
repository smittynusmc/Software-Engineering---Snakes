<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/OBS/get_insert' title='Add New Project'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/OBS/get_search' title='Search Project'>Search</a>
&nbsp;
<?php if(!empty($obs_id)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/OBS/get_edit/<?php echo $obs_id; ?>'  title='Edit Current Project'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/OBS/get_upload' title='Import from a CSV File'>Upload</a>

