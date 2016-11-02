

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
                    <label for="Product_Code">Product Code</label>
                    <input type="text" class="form-control" name="Product_Code" id="Product_Code" placeholder="Product Code" value="<?php echo $Product_Code;?>">
                </div>
                <div class="form-group">
                    <label for="Product_Name">Product Name</label>
                    <input type="text" class="form-control" name="Product_Name" id="Product_Name" placeholder="Product Name" value="<?php echo $Product_Name;?>">
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
                        echo "<button class='btn btn-default btn-block btn-loadrecord' type='button' archo='".base_url()."index.php/Product/index/{$record->Product_Code}'target ='content'>  {$record->Product_Name}</button>";
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
