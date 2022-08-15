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
        margin-left:2px;
    }
</style>

<section class="content-header">
    <h1>
        Import Excel  
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Import Data From Excel</li>
    </ol>
</section>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row"  id="preform">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Upload Excel files</strong> <small> </small></div>
                <div class="panel-body">
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Click on browse and select your file. After selecting Click on upload</strong>
                    </div>
                    <div  style="display: none;  margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                    <div class="input-group image-preview">
                        <input placeholder="" type="text" id="filename" class="form-control image-preview-filename" disabled="disabled">
                        <!-- don't give a name === doesn't send on POST/GET --> 
                        <span class="input-group-btn"> 
                            <!-- image-preview-clear button -->
                            <button type="button" class="btn btn-default image-preview-clear" style="display:none;"> <span class="glyphicon glyphicon-remove"></span> Clear </button>
                            <!-- image-preview-input -->
                            <div class="btn btn-default image-preview-input"> <span class="glyphicon glyphicon-folder-open"></span> <span class="image-preview-input-title">Browse</span>
                                <input type="file" name="file" id="file" change="setFileName()"/>
                                <!-- rename it --> 
                            </div>
                            <button type="button" class="btn btn-labeled btn-primary" onclick="submitExcelSheet()"> <span class="btn-label"><i class="glyphicon glyphicon-upload"></i> </span>Upload</button>
                        </span> </div>
                    <!-- /input-group image-preview [TO HERE]--> 
                    <br />
                    <!-- Drop Zone -->
                    <!--<div class="upload-drop-zone" id="drop-zone"> Or drag and drop files here </div>-->
                    <br />
                    <!-- Progress Bar -->
                    <div class="progress">
                        <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"> <span class="sr-only">60% Complete</span> </div>
                    </div>
                    <br />
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
                        </div><br><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Category Name</label>
                            <select class="form-control" id="category_name" name="category_name">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Product Name</label>
                            <select class="form-control" id="product_name" name="product_name">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Brand Name</label>
                            <select class="form-control" id="product_make" name="product_make">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Unit of Measurement</label>
                            <select class="form-control" id="unit_of_measurement" name="unit_of_measurement">...</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Supplier Name</label>
                            <select class="form-control" id="supplier_name" name="supplier_name">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Purchase Date</label>
                            <select class="form-control" id="date_of_purchase" name="date_of_purchase">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Invoice Number</label>
                            <select class="form-control" id="invoice_no" name="invoice_no">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Other charges</label>
                            <select class="form-control" id="other_charges" name="other_charges">...</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>HSN Code</label>
                            <select class="form-control" id="hsn" name="hsn">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Barcode</label>
                            <select class="form-control" id="barcode" name="barcode">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>CESS</label>
                            <select class="form-control" id="cess" name="cess">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Cost Price</label>
                            <select class="form-control" id="purchase_price" name="purchase_price">...</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Selling Price</label>
                            <select class="form-control" id="selling_price" name="selling_price">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Discount</label>
                            <select class="form-control" id="discount" name="discount">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Product Description</label>
                            <select class="form-control" id="product_description" name="product_description">...</select>
                        </div>
                        <div class="col-md-3">
                            <label>Stock quantity</label>
                            <select class="form-control" id="quantity" name="quantity">...</select>
                        </div>
                    </div>
                        <br><br><br><br>
                        <div class="col-lg-6" style="margin-bottom: 50px;">
                            <input  id="importExcel" class="btn btn-primary " type="submit" value="Import">
                            <div class="clearfix"></div>
                        </div>
                        <br><br><br><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="./dist/js/pages/importexcel.js" type="text/javascript"></script>
