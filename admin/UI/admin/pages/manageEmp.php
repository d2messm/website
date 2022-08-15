<section class="content-header">
    <h1>
        Employee Management  
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Employee | Update Employee Details</li>
    </ol>
</section>
<section class="content">
<div class="row">
        <div class="col-md-12">
            <div class="box">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Employee</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                <form method="post" action="">

                    
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Employee Name</label>
                                <input type="text" name="emp_name" id="emp_name" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Mobile</label>
                                <input type="number"  name="emp_mobile" id="emp_mobile" value="" class="form-control">
                            </div>
                        </div>

                   

                    <div class="row">
                        <div class="col-md-6">

                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" name="emp_email" id="emp_email" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">UserName</label>
                                    <input type="text" name="emp_username" id="emp_username" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Password</label>
                                    <input type="password" name="emp_password" id="emp_password" value="" class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6" id="view_right">
                            <!--this colum used to display rigths checkbox-->

                        </div>

                    </div>
                    <div class="col-md-6" style="margin-bottom: 40px;">
                    <button type="button" class="btn btn-primary btn-sm" id="add_emp_btn">Add Employee</button>
                    <button type="button" class="btn btn-primary btn-sm" id="update_emp_btn">update Employee</button>
                    <button type="button" class="btn btn-danger btn-sm" id="remove_emp_btn">Remove</button>
                    <div class="clearfix"></div>
                    </div><br>

                    <!--  add Additional info model from  below     -->

                </form>
            </div>
        </div>

                

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Employee Detail</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-hover" id="emp_list_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody id="emp_list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
        </div>
    </section>
    <script src="./dist/js/pages/manageemp.js" type="text/javascript"></script>
