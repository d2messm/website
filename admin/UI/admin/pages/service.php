<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<!--<script src="../../assets/ckfinder/ckfinder.js"></script>-->
<section class="content-header">
    <h1>
        Services  
        <small>Control panel</small>

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Services </li>
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
                        <h3 class="box-title">Add Service</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <!--<form id='add_category_form'>-->

                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Service Name</label>
                                    <input type="text" name="service_name" id="service_name" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Service Punch Line/Tag Line</label>
                                    <input type="text" name="service_punchline" id="service_punchline" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Thumbnail Image</label>
                                    <input type="file" name="thumbnail_image_file" id="thumbnail_image_file" value="" class="">
                                </div>
                            </div>

                            <div class="col-lg-6" style="margin-top: 15px; margin-bottom: 30px;">
                                <button  id="addservice_btn" class="btn btn-primary pull-right">Add Service</button>
                                <div class="clearfix"></div>
                            </div>
                            <!--</form>-->
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!--  view category table below   -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Service Lists</h3>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="panel-group" id="accordion">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/View/Edit Service Description -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Service Description</h3>
                    </div>

                    <div class="row" style="margin: 20px;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <select id="service_list_select" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <textarea id="service_description" rows="10" style="resize: both; overflow: auto"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input id="update_description_btn" type="button" class="btn btn-primary col-md-4 pull-right" value="Update Description" style="margin-top: 10px; margin-bottom: 20px">

                </div>
            </div>
        </div>
    </div>
</section>    

<script src="./dist/js/constants.js" type="text/javascript"></script>
<script src="./dist/js/pages/addservice.js" type="text/javascript"></script>