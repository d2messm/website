<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Products 
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Products</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Products Detail</h3>
                </div>
                <div class="box-body">
                    <table id="product_table" class="table table-bordered table-hover">
                        <thead class="text-primary">
                        <th>S.NO.</th>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Unit</th>
                        <th>HSN</th>
                        <th>Discount</th>
                        <th>Images</th>
                        <th>action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Product details</h4>
            </div>

            <div  style="display: none; margin-left: 10px; margin-top: 10px; margin-right: 10px;" id="showModelErr" class="alert alert-danger" ></div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <!-- /.box-header -->
                                <!-- form start -->
                                <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <form method="post" action="" name="add_product_description" enctype="multipart/form-data">

                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Product Name</label>
                                                    <input type="text" name="product_name"title="Enter the Product Name" id="product_name" value="" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Product Brand Name(optional)</label>
                                                    <input type="text" name="product_make" id="product_make" value="" class="form-control" title="Enter the Brand Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Category Name</label>
                                                    <select class="form-control" id="category_id" title="Enter the Category Name belongs to product">
                                                        <option disabled >Select Category</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Product Unit(optional)</label>
                                                    <input type="text" name="unit_of_measurement" id="unit_of_measurement" value="" class="form-control" title="Enter Product Unit">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Product Description</label>
                                                        <textarea class="form-control" id="product_description" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4" id="product_image_0">
                                                    <div class="form-group">
                                                        <label class="btn btn-default" id="image_1">
                                                            Image 1 <input type="file"  id="product_image_0" name="photo[]" hidden>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="product_image_1">
                                                    <div class="form-group">
                                                        <label class="btn btn-default" id="image_1">
                                                            Image 2 <input type="file"  id="product_image_1" name="photo[]" hidden>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="product_image_2">
                                                    <div class="form-group">
                                                        <label class="btn btn-default" id="image_1">
                                                            Image 3 <input type="file"  id="product_image_2" name="photo[]" hidden>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="addNewFeature" class="btn btn-success">Add More Feature(optional)</button>
                                                </div>
                                            </div>
                                            <div class="row" id="featureBox">

                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Purchase Price(optional)</label>
                                                    <input type="number" name="purchase_price" id="purchase_price" value="" class="form-control" title="Enter Purchase Price">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Selling Price(optional)</label>
                                                    <input type="number" name="selling_price" id="selling_price" value="" class="form-control" title="Enter Selling Price">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-12 checkbox">
                                                <label for="">Display Price:</label>
                                                <input type="checkbox" id="display_price">
                                            </div>

                                            <div class="clearfix"><input type="hidden" id="pdtid"</div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <button type="button" class="btn btn-default btn-success" id="update_product_btn"  style="color: white;">Update</button>
            </div>
        </div>

    </div>
</div>
</div>
<script src="./dist/js/pages/view_products.js" type="text/javascript"></script>
<script src="./dist/js/pages/addcategory.js" type="text/javascript"></script>

