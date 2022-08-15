<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Customers
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Customer</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Customer List</h3>
                </div>
                <div class="box-body">
                    <table class="display responsive nowrap" id="customer_table" width="100%">
                        <thead class="text-primary">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                        </thead>
                        <tbody >


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
                <h4 class="modal-title">Update Customer details</h4>
            </div>
            <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showModelErr" class="alert alert-danger" ></div>
            <div class="modal-body">

                <form method="post" action="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="">Customer Name</label>
                                <input type="text" name="" id="u_customer_name" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="">Customer Email</label>
                                <input type="text" name="" id="u_customer_email" value="" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="">Customer Phone</label>
                                <input type="number" name="" id="u_customer_phone" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="">Address</label>
                                <input type="text" name="u_customer_address" id="u_customer_address" value="" class="form-control">
                            </div>
                        </div>

                    </div>





                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default btn-success" id="update_customer" style="color: white;">Update</button>
            </div>
        </div>

    </div>
</div>
<script src="./dist/js/pages/customer.js" type="text/javascript"></script>