

<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="product_search-title"> Product Search</h4>
        </div>
        <div class="modal-body" id="product_search-body">
            <?php echo form_open('Product/search/',array('id'=>'product_search_form')); ?>
            <div class="box-body" >
                <div class="form-error">
                    <?php echo validation_errors(); ?>
                </div>
                <div class="form-group">
                    <label for="Product_Code">Product ID</label>
                    <input type="text" class="form-control" name="product_id" id="product_id" placeholder="Product ID" value="<?php echo $product_id;?>">
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
        <div class="modal-footer" id="product_search-footer">
            <div class="box-footer">
                <button type="submit" class="btn btn-primary submit-button" formid="product_search_form">Search</button>
            </div>
        </div>
        <div class="modal-footer" id="product_search-result">
            <?php
            if(isset($result)){
                if(isset($status) && $status=='success'){
                    foreach ($result as $record){
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Product/index/{$record->product_id}'target ='content'>  {$record->product_name}</button>";
                    }
                }
                else{
                    echo "<button class='btn btn-default btn-block error' >  $result</button>";
                }
            }
            ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
