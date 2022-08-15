<style>
    /* layout.css Style */
    .upload-drop-zone {
        height: 200px;
        border-width: 2px;
        margin-bottom: 20px;
    }

    /* skin.css Style*/
    .upload-drop-zone {
        color: black;
        border-style: dashed;
        border-color: black;
        line-height: 200px;
        text-align: center;
        background: #aaafa517;
    }

    .upload-drop-zone.drop {
        color: #222;
        border-color: #222;
    }

    .image-preview-input {
        position: relative;
        overflow: hidden;
        margin: 0px;
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }

    .image-preview-input input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .image-preview-input-title {
        margin-left: 2px;
    }
</style>

<section class="content-header">
    <h1>
        Import Product Excel
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Import Product From Excel</li>
    </ol>
</section>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row" id="preform">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Upload Product Excel files</strong>
                    <small></small>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Click on browse and select your file. After selecting Click on upload</strong>
                    </div>
                    <div style="display: none;  margin-top: 10px;" id="showErr" class="alert alert-danger"></div>
                    <div class="input-group image-preview">
                        <input placeholder="" type="text" id="product_filename"
                               class="form-control image-preview-filename" disabled="disabled">
                        <!-- don't give a name === doesn't send on POST/GET -->
                        <span class="input-group-btn">
                            <!-- image-preview-clear button -->
                            <button type="button" class="btn btn-default image-preview-clear"
                                    style="display:none;"> <span
                                        class="glyphicon glyphicon-remove"></span> Clear </button>
                            <!-- image-preview-input -->
                            <div class="btn btn-default image-preview-input"> <span
                                        class="glyphicon glyphicon-folder-open"></span> <span
                                        class="image-preview-input-title">Browse</span>
                                <input type="file" name="product_file" id="product_file" onchange="setFileName()"/>
                                <!-- rename it -->
                            </div>
                            <button type="button" class="btn btn-labeled btn-primary"
                                    onclick="submitExcelSheet()"> <span class="btn-label"><i
                                            class="glyphicon glyphicon-upload"></i> </span>Upload</button>
                        </span></div>
                    <!-- /input-group image-preview [TO HERE]-->
                    <br/>
                    <!-- Drop Zone -->
                    <!--<div class="upload-drop-zone" id="drop-zone"> Or drag and drop files here </div>-->
                    <br/>
                    <!-- Progress Bar -->
                    <div class="progress">
                        <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                             aria-valuemax="100" style="width: 0%;"><span class="sr-only">60% Complete</span></div>
                    </div>
                    <div>
                        <strong>File Should Contain: </strong>
                        <span class="badge">Product Name</span>
                        <span class="badge">Product Brand</span>
                        <span class="badge">Product Category</span>
                        <span class="badge">Product Unit(Kg/Litre/Packet)</span>
                        <span class="badge">Barcode</span>
                        <span class="badge">Purchase Price</span>
                        <span class="badge">Selling Price</span>
                        <span class="badge">Discount</span>
                        <span class="badge">Product Description</span>
                        <span class="badge">HSN</span>
                    </div>
                    <div style="margin-top: 10px">
                        <a href="./pages/sample_product_import.php" target="_blank">Download Sample Product Import File</a>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    <!--  view category table below   -->
    <div class="row" id="postform" style="display:none;">
        <div class="col-md-12">
            <div class="box">
                <form name="productsform" id="productsform">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Import Excel Data</h3>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Product Name*</label>
                                <select class="form-control" id="product_name" name="product_name">...</select>
                            </div>
                            <div class="col-md-3">
                                <label>Product Brand</label>
                                <select class="form-control" id="product_make" name="product_make">...</select>
                            </div>
                            <div class="col-md-3">
                                <label>Category*</label>
                                <select class="form-control" id="product_category" name="product_category">...</select>
                            </div>
                            <div class="col-md-3">
                                <label>Product Unit</label>
                                <select class="form-control" id="unit_of_measurement"
                                        name="unit_of_measurement">...</select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Barcode</label>
                                <select class="form-control" id="barcode" name="barcode">...</select>
                            </div>
                            <div class="col-md-3">
                                <label>Purchase Price</label>
                                <select class="form-control" id="purchase_price" name="purchase_price">...</select>
                            </div>
                            <div class="col-md-3">
                                <label>Selling Price</label>
                                <select class="form-control" id="selling_price" name="selling_price">...</select>
                            </div>
                            <div class="col-md-3">
                                <label>Discount</label>
                                <select class="form-control" id="discount" name="discount">...</select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Product Description*</label>
                                <select class="form-control" id="description" name="description">...</select>
                            </div>
                            <div class="col-md-3">
                                <label>HSN Code</label>
                                <select class="form-control" id="hsn" name="hsn">...</select>
                            </div>
                        </div>

                        <br><br><br><br>
                        <div class="col-lg-6" style="margin-bottom: 50px;">
                            <input id="importProductExcel" class="btn btn-primary " type="submit" value="Import">
                            <div class="clearfix"></div>
                        </div>
                        <br><br><br><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="./dist/js/pages/importproduct.js" type="text/javascript"/>