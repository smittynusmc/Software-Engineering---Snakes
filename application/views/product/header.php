<i class='glyphicon glyphicon-plus'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Product/get_insert' title='Add New Product'>Insert</a>
&nbsp;
<i class='glyphicon glyphicon-search'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Product/get_search' title='Search Product'>Search</a>
&nbsp;
<?php if(!empty($product_id)){ ?>
<i class='glyphicon glyphicon-pencil'></i> <a class='function-button' archo='<?php echo base_url(); ?>index.php/Product/get_edit/<?php echo $product_id; ?>'  title='Edit Current Product'>Edit</a>
<?php }?>  
&nbsp;
<i class='glyphicon glyphicon-upload'></i> <a class='function-button'  archo='<?php echo base_url(); ?>index.php/Product/get_upload' title='Import from a CSV File'>Upload</a>


