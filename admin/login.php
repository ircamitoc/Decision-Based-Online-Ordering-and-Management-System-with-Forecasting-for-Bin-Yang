<?php 

include('header.php'); 

if(isset($_SESSION['username'])){
    echo '<script> 
        window.location = "index.php";
    </script> '; 
}

?>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0">BIN-YANG Coffee & Tea</h1> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="#" class="j-active-link">Login</a></li>
              <li class="breadcrumb-item "><a href="#" class="j-link">Dashboard</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content d-flex justify-content-center" >
        <div class="card " style="width:500px;" >
            <div class="card-header j-orange ">
                <h3 class="card-title ">Admin Login</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="process.php" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="">Access Level</label>
                        <select name="access_level" class="form-control col-3" required>
                            <option value=""></option>
                            <option value="admin">ADMIN</option>
                            <option value="staff">STAFF</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn  j-orange j-btn" name="login">Login</button>
                    <!-- <button type="button" class="btn  j-green j-btn" data-toggle="modal" data-target="#register-modal">
                        Create New Account
                    </button> -->
                </div>
            </form>

            <!-- registration modal -->
            <div class="modal fade" id="register-modal">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header j-orange">
                    <h4 class="modal-title ">Account Registration</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    <form action="process.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="card " >
                                    <div class="card-body">
                                        <div class="form-group">
                                        <!-- <label for="exampleInputEmail1">Username</label> -->
                                            <input type="text" class="form-control" id="Username" placeholder="Enter Username" name="username" >
                                        </div>
                                        <div class="form-group">
                                            <!-- <label for="exampleInputPassword1">Password</label> -->
                                            <input type="password" class="form-control" id="Password" placeholder="Password" name="password" >
                                        </div>
                                        <div class="form-group">
                                            <!-- <label for="exampleInputPassword1">Confirm Password</label> -->
                                            <input type="password" class="form-control" id="Password2" placeholder="Confirm Password" name="password2" >
                                        </div>
                                        <div class="form-group">
                                            <!-- <label for="exampleInputPassword1">Confirm Password</label> -->
                                            <select name="access_level" id="" class="form-control">
                                                <option value="">Select Access Level</option>
                                                <option value="admin">admin</option>
                                                <option value="staff">staff</option>
                                                <option value="owner">owner</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Profile Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"  id="profile_photo" accept="image/gif, image/jpeg, image/png" name="image"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="modal-footer ">
                            <!-- justify-content-between -->
                            <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn j-green j-btn" name="register">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  

</body>

<?php include('footer.php'); ?>


