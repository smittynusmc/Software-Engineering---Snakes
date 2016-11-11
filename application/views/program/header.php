<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Program/get_insert' title='Add New Program'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Program/get_search' title='Search Program'>Search</a>
&nbsp;
<?php if(!empty($program_id)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Program/get_edit/<?php echo $program_id; ?>'  title='Edit Current Program'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Program/get_upload' title='Import from a CSV File'>Upload</a>

