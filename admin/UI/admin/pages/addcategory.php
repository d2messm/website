<section class="content-header">
    <h1>
        Category  
        <small>Control panel</small>
        <button type="button" id="viewsubcategory" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Add Sub Category</button>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Category | Sub-Category</li>
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
                        <h3 class="box-title">Add Category</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div  style="display: none; margin-left: 10px;margin-right: 10px; margin-top: 10px;" id="showErr" class="alert alert-danger" ></div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <!--<form id='add_category_form'>-->

                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Category Name</label>
                                        <input type="text" name="category_name" id="category_name" value="" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6" style="margin-bottom: 30px;">
                                <button  id="addcategory_btn" class="btn btn-primary ">Add category</button>
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
                        <h3 class="box-title">Category Lists</h3>
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
    <section



    <!--  add sub category model from  below     -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Add Sub Category</h4>
                </div>
                <div  style="display: none; margin-left: 10px; margin-top: 10px; margin-right: 10px;" id="showModelErr" class="alert alert-danger" ></div>
                <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control" id="category_id">


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_name" class="control-label">Sub Category Name:</label>
                            <input type="text"  class="form-control" id="subcategory_name">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addsubcategory_btn">Add Sub Category</button>
                </div>
            </div>
        </div>
    </div><!--  add sub category model from  below     -->
    
    
    <script src="./dist/js/pages/addcategory.js" type="text/javascript"></script>
