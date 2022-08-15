
<section class="content-header">
    <h1>
        Add Associate 
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Associate</li>
    </ol>
</section>
<br>
<form action="" method="POST" enctype="multipart/form-data">
    <!-- Main content put content inside it-->
    <section class="content" id="sectiondiv">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Associate Partner</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Name</label>
                                        <input type="text" name="name"title="" id="name" value="" class="form-control" required="true" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Mobile</label>
                                        <input type="text"i oninput="this.value=this.value.replace(/[^0-9.]/g,'')" name="name"title="" id="mobile" value="" class="form-control" required="true" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Email</label>
                                        <input type="text"  name="name"title="" id="email" value="" class="form-control" required="true" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Gender</label>
                                        <div class="radio">
                                            <label> <input type = "radio" id ="" value ="Male" name="gender">Male</label> 
                                        </div>
                                        <div class="radio">
                                            <label> <input type = "radio" id ="" value ="Female" name="gender">Female</label> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Date of Birth</label>
                                        <input type="date"  name="name"title="" id="dob" value="" class="form-control" required="true" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Address</label>
                                        <input type="text"  name="name"title="" id="address" value="" class="form-control" required="true" >
                                    </div>
                                </div>
                                <style>
                                    #document_div input{
                                        margin-right:20px;
                                        margin-bottom: 15px;
                                        height:34px;
                                    }
                                </style>
                                <div class="col-md-12">
                                    <div class="form-group label-floating" id="document_div">
                                        <label class="control-label">Documents</label>
                                         <span class="help-block"><a href="javascript:void(0);" id="add_document" style="cursor: pointer;margin-top: 20px;margin-left:0px;margin-bottom: 20px;" class="">Add new Document</a></span>
                                        <div class="form" >
                                            <input type="text" placeholder="Document Number" id="doc_no_1" name="doc_no_1" class="col-md-3">
                                            <input id="doc_name_1" type="text" placeholder="Document Name"  name="doc_name_1"  class="col-md-3">
                                            <input id="doc_url_1" name="doc_url_1" type="file" class=" col-md-3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">UserName</label>
                                        <input type="text"  name="name"title="" id="user_name" value="" class="form-control" required="true" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Password</label>
                                        <input type="text"  name="name"title="" id="password" value="" class="form-control" required="true" >
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Rights</label>
                                    <div class="checkbox" style="width:300px;" id="userRightsDiv">
                                        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">Additional Detail</label>
                                    <button type="button" id="" class="btn btn-success" data-toggle="modal" data-target="#companyModal" >Is Company</button>
                                    <button type="submit"  class="btn btn-primary" id="save_associate_btn">Save</button>
                                    <button type="button"  class="btn btn-warning" id="update_associate_btn">Update</button>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- /.box -->
                </div>

                <div class="box">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Associate Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <table id="associateDataTable" class="table table-bordered data-table" >
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>DOB</th>
                                            <th>Is Company</th>
                                            <th>Company Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="associateTableBody">


                                    </tbody> 

                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- /.box -->
                </div>



            </div>
        </div>

        <div class="modal fade" id="companyModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Company Description</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Company Name</label>
                                    <input type="text" name="company_name"  id="company_name" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Company GSTIN</label>
                                    <input type="text" name=""  id="gstin" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Company TIN NO.</label>
                                    <input type="text" name=""  id="tin_no" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">PAN NO.</label>
                                    <input type="text" name=""  id="pan_no" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Contact No</label>
                                    <input type="text" name=""  id="company_phone" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Company State</label>
                                    <input type="text" name=""  id="company_state" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Company Country</label>
                                    <input type="text" name=""  id="company_country" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Company Address</label>
                                    <input type="text" name=""  id="company_address" value="" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="" class="btn btn-default" data-dismiss="modal">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<script src="./dist/js/pages/addAssociatePartner.js" type="text/javascript"></script>
