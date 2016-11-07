<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/WBS/get_insert' title='Add New Project'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/WBS/get_search' title='Search Project'>Search</a>
&nbsp;
<?php if(!empty($Project_ID)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/WBS/get_edit/<?php echo $Project_ID; ?>'  title='Edit Current Project'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/WBS/get_upload' title='Import from a CSV File'>Upload</a>

