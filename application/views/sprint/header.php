<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Sprint/get_insert' title='Add New Sprint'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Sprint/get_search' title='Search Sprint'>Search</a>
&nbsp;
<?php if(!empty($Sprint_ID)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Sprint/get_edit/<?php echo $Sprint_ID; ?>'  title='Edit Current Sprint'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Sprint/get_upload' title='Import from a CSV File'>Upload</a>

