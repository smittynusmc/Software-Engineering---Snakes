


<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="product_insert-title"> Add New Product</h4>
        </div>
        <div class="modal-body" id="product_insert-body">
            <?php echo form_open('Product/insert',array('id'=>'product_insert_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="Product_Code">Product Code</label>
                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Product Code" value="<?php echo $product_code;?>">
                </div>
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo $product_name;?>">
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="product_insert-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="product_insert_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="product_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Product/index/{$product_id}' target ='content'> $result</button>";
                }
                else{
                    echo $result;
                }
            }
            ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
