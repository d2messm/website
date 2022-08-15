<section class="content-header">
    <h1>Admin Profile<small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Profile</li>
    </ol>
    <button  id="profile_btn" class="btn btn-primary btn-sm " style="margin-top: 10px;">Profile</button>
    <button  id="company_btn" class="btn btn-primary btn-sm " style="margin-top: 10px;">Company Info</button>

</section>

<section class="content" style="margin-top: -10px;" id="profile_div">
        <!-- Small boxes (State box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Profile</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">Name</label>
                                        <input type="text" name="admin_name" id="admin_name" value="" class="   form-control">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">Phone</label>
                                        <input type="text" name="admin_phone" id="admin_phone" value="" class="   form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">Email</label>
                                        <input type="text" name="admin_email" id="admin_email" value="" class="   form-control">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Username</label>
                                        <input type="text" name="username" id="admin_username" value="" class="   form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="admin_password" id="admin_password" value="" class="   form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 " style="margin-bottom: 30px; text-align: right;">

                                    <button  id="update_profile_btn" margin-right: 10px;"  class="btn btn-primary ">Update</button>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#myPasswordModal" >Change Password</button>

                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</section>


<!--Model for updation of Password-->
<div class="modal fade" id="myPasswordModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Password</h4>
            </div>
            <div  style="display: none; margin-left: 10px; margin-top: 10px; margin-right: 10px;" id="showModelErr" class="alert alert-danger" ></div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group label-floating">
                            <label class="">Current Password:</label>
                            <input type="password" name="" id="curr_pass" value="" class="form-control">
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group label-floating">
                            <label class="">New Password:</label>
                            <input type="password" name="" id="new_pass" value="" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group label-floating">
                            <label class="">Confirm New Password:</label>
                            <input type="password" name="" id="confirm_new_pass" value="" class="form-control">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default btn-success" id="update_admin_password" >Change Password</button>
            </div>
        </div>

    </div>
</div>

<!--section for company updation-->
<section class="content" style="margin-top: -10px;" id="company_div">

    <form method="post" enctype="multipart/form-data">

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Company Info</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">Company Name</label>
                                        <input type="text" name="company_name" id="company_name" value="" class="   form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">Company_logo</label>
                                        <input type="file" name="company_logo" id="company_logo" value="" class="   form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">GSTN</label>
                                        <input type="text" name="company_gstn" id="company_gstn" value="" class="   form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">Tin No.</label>
                                        <input type="text" name="company_tin" id="company_tin" value="" class="   form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="">Pan No.</label>
                                        <input type="text" name="company_pan" id="company_pan" value="" class="   form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="">State</label>
                                            <input type="text" name="company_state" id="company_state" value="" class="   form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="">Country</label>
                                            <input type="text" name="company_country" id="company_country" value="" class="   form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label for="comment">Address:</label>
                                        <textarea class="" rows="5" id="company_address"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: 80px;">
                                    <button   style="float:right" id="company_update_btn" class="btn btn-primary">Save/Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</section>
<script src="./dist/js/pages/editprofile.js" type="text/javascript"></script>