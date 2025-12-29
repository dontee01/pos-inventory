<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content bbn-modal">
    <form method="post" id="compose-modal">
        <div class="modal-header text-left">
            <div class="text-right">
                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
            </div>
            <div class="text-left">
                <h4 class="modal-title">Edit Product</h4>
            </div>
        </div>
    <div class="modal-body">

        <div class="row modal-row">

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="category" id="edit-product-category" placeholder="Category" disabled="disabled" />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="category" id="edit-product-item" placeholder="Item"  />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty_content" id="edit-product-content" placeholder="Content" />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty_bottle" id="edit-product-bottle" placeholder="Empty bottles" />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty" id="edit-product-qty" placeholder="Quantity" />
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="price" id="edit-product-price" placeholder="Price" />
                </div>
            </div>
        </div>

        </div>

    </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-danger btn-recharge" id="edit-product-confirm"
                    data-dismiss="modal" >Save</button>
            <button type="button" class="btn btn-modal-save pull-left"
                    data-dismiss="modal" >Cancel</button>
        </div>
    </form>
    </div>
</div>
            </div>