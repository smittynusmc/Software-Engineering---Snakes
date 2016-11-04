
<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/WBS/get_insert' title='Add New WBS'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/WBS/get_search' title='Search WBS'>Search</a>
&nbsp;
<?php if(!empty($WBS_ID)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/WBS/get_edit/<?php echo $WBS_ID; ?>'  title='Edit Current WBS'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/WBS/get_upload' title='Import from a CSV File'>Upload</a>
