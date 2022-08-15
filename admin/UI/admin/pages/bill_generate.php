<style>
    input,textarea{width:100%; font-family:inherit;font-size:inherit;line-height:inherit;}
    select{width:100%; font-family:inherit;font-size:inherit;line-height:inherit}
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    
   
</style>
<link href="./dist/css/bootstrap-toggle.min.css" rel="stylesheet">

<section class="content-header">
    <h1>
        Billing  
        <small>Control panel</small>
        <a class="btn btn-primary btn-sm " href="index.php?page_name=viewbill&lid=9" >View Bill</a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Generate Bill</li>

    </ol>
</section>

<section class="content">
    <!-- Small boxes (Stat box) -->
    
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Generate Bill </h3>
                    </div>
                    <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="card-content">

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="control-label" id="companyName"> Company Details</label>
                                <textarea disabled class="form-control" rows="4"  id="companyDetails">Bulwark Software and reserch Private Limited</textarea>
                            </div>
                        </div>

                        <div class=" col-md-6">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label-control">Invoice Date</label>
                                        <input type="date" class="form-control "id="myTime" value="<?php echo date("Y-m-d"); ?>"/>
                                    </div>
                                </div>    
                            </div>
                        </div>

                        <div class="col-md-12" style="box-shadow:0px 1px grey;margin-bottom:30px;">
                            <h5 style="text-align:center;">Tax Invoice </h5>
                        </div>
                        
                        


                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Customer Name</label>
                                <input type="text" name="barcode" id="customer_name" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Customer Phone No</label>
                                <input type="number" maxlength="15" name="customer_phone" id="customer_phone" value="" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group label-floating col-md-6">
                                    <label class="control-label">Customer Email</label>
                                    <input type="text" name="customer_email" style='text-transform:lowercase' id="customer_email" value="" class="form-control">
                                </div>
                                <div class="form-group label-floating col-md-6">
                                    <label class="control-label">Customer GST No(Optional)</label>
                                    <input type="text" name="customer_gstin" style='text-transform:uppercase' id="customer_gstin" value="" class="form-control">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="control-label"> Customer Address/Billing Address</label>
                                <textarea class="form-control" rows="4" id="customer_Add"></textarea>
                            </div>
                        </div>
                       
                        <div class=" col-md-12" style="box-shadow: 0px 1px grey; position: relative;margin-bottom:30px;">
                            <h5 style="text-align:center;">Items Details </h5>
                        </div>
                        <div class="col-md-6"   >
                            <a onclick="insertNewItemRow()" style="cursor: pointer;" class="btn btn-sm btn-primary">Add new Item</a>
                            <button onclick="" class="btn btn-sm btn-success" style="margin-left:50px;"data-toggle="modal" data-target="#productModal">New Product</button>

                        </div>
                    </div>
                    
                    <div class="" id="divrefresh">
                        <div class="col-md-12  table-responsive " style="overflow-x: scroll">
                            <table class="table ">
                                <thead class="text-primary">
                                <th>SNo.</th>
                                <th>HSN</th>
                                <th >Items</th>
                                <th>Qty</th>
                                <th>Price(per Unit)</th>
                                <th>Unit</th>
                                <th>Discount</th>
                                <th >%(discount)</th>
                                <th>Cost(ex. Tax)</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>CESS</th>
                                <th>Total</th>
                                <th></th>
                                </thead>
                                <tbody id="items">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <style> 
                        #overlaycard { visibility: hidden;}
                    </style>
                    <div class="clearfix"></div>
                    <div class="row" style="margin: 20px;">
                        <div class="col-md-5">
                            <p>Mode of Payment:-&nbsp;&nbsp;&nbsp;<input type="checkbox" checked data-toggle="toggle" data-on="Cash" data-off="Card/Cheque" data-onstyle="success" data-offstyle="danger" id="mode_of_payment" onchange='toggleModeOfPayment()'></p>
                        </div>
                        <div class="col-md-offset-4 col-md-3">
                            <div class="checkbox inline">
                                <label for=""> Round Off:</label>
                                <input type="checkbox" checked data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger" name="roundoff" id="roundoff" onchange="setGrandTotal()">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 10px;margin-right: 10px;">
                        <div class=" col-md-4">
                            <div class="form-group">
                                <label for=""> Customer Note:</label>
                                <textarea class="form-control" rows="3" id="comment">******* Thank You for Shopping with Us *******</textarea>
                            </div>
                        </div>
                        
                        <div class=" col-md-4 ">
                            <span id="overlaycard" style="">
                                <label for=""> Transaction Ref NO :</label>
                                <input type="text" id="transaction_no" placeholder="Transaction Ref. NO./ Cheque Number" />
                            </span>
                            <span id="overlaycash">
                                <label for=""> Transaction Detail:</label>
                                <!--<input type="number" placeholder="Amount Paid" id="paid_amount" min="0" oninput='this.value=this.value.replace(/[^0-9]/g)' onkeyup='setRefundAmount(this)'/>-->
                                <!-- If they don't want to round off let them input the number in decimal-->
                                <input type="number" placeholder="Amount Paid" id="paid_amount" min="0" onkeyup='setRefundAmount(this)'/>
                                <input type="number" placeholder="Refund Amount" min="0" step=".01" disabled id="refund_amount" style="margin-top:10px;"/>
                            </span>
                        </div>
                        <div class=" col-md-4">
                            <label for="">Discount (%)</label><input type="number" id="totaldiscount" value="0" onkeyup="setGrandTotal()" disabled min="0"/>
                            <label for="">Other Charges</label><input type="number" id="other_charges" value="0" oninput='this.value=this.value.replace(/[^0-9]/g)' onkeyup="setGrandTotal()" min="0"/>
                            <label>Grand Total. </label><input type="number" readonly id="grandTotal" value="0" min="0" disabled/>
                            <label>Other Charges Description</label><textarea  id="other_charges_desc">*It may include shipping and other charges.</textarea>
                            <!--<input type="checkbox" checked data-toggle="toggle">-->
                        </div>
                    </div>
                    <div class="row">
                        <button id="genrateInvoice" class="btn btn-primary pull-right" style="margin: 20px;">Save & Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Print Invoice Modal -->
<div id="invoice_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bill Generated Successfully</h4>

            </div>
            <div class="modal-body">
                <h5 style="text-align:center;">Customize the fields to Print  </h5>
                <div class="row" style="margin-left: 10%;">
                    
                    <div class=" col-md-2">
                        <label><input type="checkbox" name=" " id="is_gst" class="pull-right" checked>GST:</label>
                    </div>
                    <div class=" col-md-2">
                        <label><input type="checkbox" name=" " id="is_cess" class="pull-right" checked>CESS</label>
                    </div>
                <!--</div>-->
                    <div class=" col-md-2 ">
                        <label><input type="checkbox" name=" " id="is_discount" class="pull-right" checked>Discount</label>
                    </div>
                
                    <div class=" col-md-2 ">
                        <label><input type="checkbox" name=" " id="is_tax_value" class="pull-right" checked>Tax</label>
                    </div>
                    <div class=" col-md-2 ">
                        <label><input type="checkbox" name=" " id="is_rate" class="pull-right" checked>Rate</label>
                    </div>
                
                
                    
                   
                </div>
                
                <div class="col-md-12" style="box-shadow:0px 1px grey;margin-bottom:20px;">
                            
                        </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <a href="#"><img id="logn_bill_img" src="./dist/img/bill_long_format.png" style=" height:350px;width: 100%;"></a>

                        <input id="long_bill_btn" class="btn btn-primary" type="button" value="Print Bill (Long Formt)">
                    </div>
                    <div class="col-md-6">
                        <a href="#"><img src="./dist/img/bill_short_format.png" style=" height:350px;width: 82%;"></a>
                        <input id="short_bill_btn" class="btn btn-primary" type="button" value="Print Bill (Short Formt)">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
            </div>
        </div>
    </div>
</div>
</div>
<!--  add Additional info model from  below     -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Add Product & Stock</h4>
            </div>
            <div  style="display: none; margin-left: 10px; margin-top: 10px; margin-right: 10px;" id="showModelErr" class="alert alert-danger" ></div>
            <div class="modal-body">
                <!-- <form > -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Product Make (Brand)</label>
                            <input type="text" name="product_make" id="product_make" value="" class="form-control" title="Enter the Brand Name">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" id="category_id" title="Enter the Category Name ">
                                <option disabled>Category Name</option>

                            </select>
                        </div>

                    </div>
                    <!--<div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Unit (Eg: kg / box / ....</label>
                            <input type="text"title="Enter the unite of maesurement" name="unit_of_measurement" id="unit_of_measurement" value="" class="form-control">
                        </div>
                    </div>-->
                </div>
                <div class="row" hidden="true">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Barcode (optional)</label>
                            <input type="text" name="barcode" id="barcode" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">cess (optional)</label>
                            <input type="text" name="cess" id="cess" value="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row" hidden="true">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Inclusive Tax(optional)</label>
                            <input type="text" name="inclusive_tax" id="inclusive_tax" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Purchase Price (optional)</label>
                            <input type="text" name="purchase_price" id="purchase_price" value="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row" hidden="true">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Selling Price (optional)</label>
                            <input type="text" name="selling_price" id="selling_price" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Discounts (optional)</label>
                            <input type="text" name="discount" id="discount" value="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row" hidden="true">
                    <div class="col-md-12">
                        <div class="form-group">

                            <div class="form-group label-floating">
                                <label class="control-label"> Product Description (optional)</label>
                                <textarea class="form-control" id="product_description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group label-floating">
                                <label class="control-label">Available stock</label>
                                <input type="number" class="form-control" id="product_stock" min="0 "></input>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group label-floating">
                                <label class="control-label">Unit of measurement</label>
                                <input type="text" class="form-control" id="unit_of_measurement" ></input>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- </form>-->
            </div>
            <div class="modal-footer">
                <button type="button" id="add_product_btn_modal" class="btn btn-primary pull-right" data-dismiss="modal">Add Product</button>
                <!--<button type="button" id="" class="btn btn-default" data-dismiss="modal">Done</button>-->
                <!-- <button type="button" class="btn btn-primary" id="">Done</button>-->
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="./dist/css/jquery-ui.css">
<script src="./dist/js/pages/bill_generate.js" type="text/javascript"></script>
<script src="./dist/js/jquery-1.12.4.js"></script>
<script src="./dist/js/jquery-ui.js"></script>
<script src="./dist/js/pages/addcategory.js" type="text/javascript"></script>
<script src="./dist/js/bootstrap-toggle.min.js"></script>