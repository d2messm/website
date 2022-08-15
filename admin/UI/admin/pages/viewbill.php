<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Invoice Preview
        <small>Control panel</small>
        <a class="btn btn-primary btn-sm " href="index.php?page_name=bill_generate&lid=3" >Create Bill</a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Bill</li>
    </ol>
</section>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Invoice Detail</h3>
                </div>
                <div class="box-body">
                    <table class="table table-hover" id="invoice_table">
                        <thead class="text-primary">
                        <th>S NO</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Invoice NO</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Action</th>
                        </thead>
                        <tbody id='view_bill_tbody'>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="printBillModal" role="dialog">
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
                
                <div class="col-md-12" style="box-shadow:0px 1px grey;margin-bottom:20px;"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#"><img id="logn_bill_img" src="./dist/img/bill_long_format.png" style=" height:350px;width: 100%;"></a>

                            <input id="view_bill_long_bill_btn" class="btn btn-primary" type="button" value="Print Bill (Long Formt)">
                        </div>
                        <div class="col-md-6">
                            <a href="#"><img src="./dist/img/bill_short_format.png" style=" height:350px;width: 82%;"></a>
                            <input id="view_bill_short_bill_btn" class="btn btn-primary" type="button" value="Print Bill (Short Formt)">
                        </div>
                       
                    </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./dist/js/pages/viewbill.js" type="text/javascript"></script>

