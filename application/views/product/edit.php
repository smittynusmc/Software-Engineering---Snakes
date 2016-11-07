

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="product_edit-title"> Edit Product</h4>
        </div>
        <div class="modal-body" id="product_edit-body">
            <?php echo form_open('Product/edit',Array('id'=>'product_edit_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="product_id">Product ID</label>
                    <input type="text" class="form-control" name="product_id" id="product_id" placeholder="Product ID" value="<?php echo $product_id;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="product_code">Product Code</label>
                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Product Code" value="<?php echo $product_code;?>" readonly >
                </div>
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo $product_name;?>">
                </div>
                
            </div> 
        </div>
        <div class="modal-footer" id="product_edit-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="product_edit_form">Submit</button>
            </div>
        </div>
        <div class="modal-footer" id="product_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status='success'){
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