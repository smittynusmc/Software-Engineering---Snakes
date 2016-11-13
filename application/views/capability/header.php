<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Capability/get_insert' title='Add New Capability'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Capability/get_search' title='Search Capability'>Search</a>
&nbsp;
<?php if(!empty($capability_id)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Capability/get_edit/<?php echo $capability_id; ?>'  title='Edit Current Capability'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Capability/get_upload' title='Import from a CSV File'>Upload</a>


