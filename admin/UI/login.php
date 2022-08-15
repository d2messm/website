<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/" />
        <link rel="icon" type="image/png" href="assets/img/" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Login</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/login.css" rel="stylesheet" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
        
        <style>
.load {
  border: 10px solid #f3f3f3;
  border-radius: 50%;
  border-top: 10px solid #3498db;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
    </head>
    <body>
        
        <div class="container">
            <div class="middlePage">
                <div class="page-header">
                    <h1 class="logo">CNK4Pets <small>Welcome to Dog Kennel!</small></h1>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body" style="padding:35px;margin-top: 30px;margin-bottom: 30px;">
                        <div class="row">
                            <div class="col-md-5" >
                             <!--   <a href="#"><img src="assets/img/bills3.gif" style="width: 100%;"/></a><br/>-->
                           
                            </div>
                            <div id="progressive" style="display: none;">
                                <div>
                                    <h1 class="loadFont text-center">Please Wait...</h1>
                                </div>
                                <div class="progress" id="shadow" >
                                    <div class="progress-bar progress-bar-danger six-sec-ease-in-out" role="progressbar" data-transitiongoal="100"></div>
                                </div>
                            </div>
                            <div class="col-md-7" style="border-left:1px solid #ccc;height:160px">
                                <form class="form-horizontal">
                                    <fieldset>

                                        <input name="username" id="username" type="text" placeholder="Enter User Name" class="form-control input-md">
                                        <div class="spacing"></div>
                                        <input name="password" id="password" type="password" placeholder="Enter Password" class="form-control input-md">
                                        <div class="spacing" style="cursor:pointer;"><a data-toggle="modal" data-target="#myModal"><small> Forgot Password?</small></a><br/></div>
                                        <button  id="login_btn" class="btn btn-info btn-sm pull-right">Sign In</button>
                                        <div class="load" id="loader" style="display: none;"></div>
                                    </fieldset>
                                    <div  style="display: none; margin-left: 5px; margin-top: 5px;" id="showErr" class="alert alert-danger" ></div>
                                    <input type="reset" id="reset_forget_pass" hidden="hidden">
                                </form>



                            </div>

                        </div>
                    </div>
                </div>
                <p><a href="https://bsrnetwork.in">About</a> · BSR</p>
            </div>
        </div>

        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content" style="margin-top: 230px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reset Password</h4>
                    </div>
                    <div class="modal-body">
                        <!--<form class="form-horizontal">-->
                            <fieldset>
                                <label>Enter username or email</label>
                                <input name="username_reset" id="username_reset" type="text" placeholder="" class="form-control input-md">
                                <div class="spacing" ></div>

                            </fieldset>
                            <div  style="display: none; margin-left: 5px; margin-top: 5px;" id="showmodelErr" class="alert alert-danger" ></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="reset" class="btn btn-info" >Reset</button>
                        <button type="button" id="" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    <!--</form>--> 
                </div>

            </div>
        </div>
    </body>
    <!--   Core JS Files   -->
    <?php
    include"assets/js/common_basic_js.php";
    ?>
    <script src="assets/js/login.js" type="text/javascript"></script>
    <script src="assets/js/resetpassword.js" type="text/javascript"></script>
</html>