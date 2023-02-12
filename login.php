
<?php 

  include('admin/db_connection.php');

  if(isset($_SESSION['username'])){
      echo '<script> 
          window.location = "index.php";
      </script> '; 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIN YANG</title>
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/700816c2b5.js" crossorigin="anonymous"></script>
</head>
<style> 
.container {
  background-image: url("kape.jpg");
}
.card-body {
  background-image: url("kape2.jpg");
}

.container {
  margin-top: 100px;
  margin-bottom: 100px;
}

.j-orange-login{
  background: rgb(209,180,140);
  color:white;
}

</style>

<body>
<!-- <div class="px-3 ms-xl-4">
          <span class="h1 fw-bold mb-0"><a href="/"><img src="img/logo.png" alt=""></a></span>
</div> -->
<!-- HEADER -->
<nav class="navbar fixed-top navbar-expand-sm navbar-light bg-light ">
            <a href="/"><img src="img/logo.png" class="logo px-5" alt="" id="logobinyang"></a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse  justify-content-end" id="navbarMenu" >
            <ul class="navbar-nav " style="margin-left:50px;margin-right:50px;">
                <li class="nav-item">
                    <a href="/" id="Home" class="nav-link rounded" >Home</a>
                </li>
                <li class="nav-item">
                    <a href="menuV2.php" id="Menu" class="nav-link rounded">Menu</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" id="Contact" class="nav-link rounded">Contact</a>
                </li>
                
                <li id="lg-bag" class="nav-item" >
                    <a  href="cart.php" id="Cart" class="nav-link position-relative rounded">
                        <i class="fa-solid fa-bag-shopping"></i>
                            <span id="availed_count" ><?= $availed_count ?></span>
                            <!-- <span class="visually-hidden">unread messages</span> -->
                        </span>

                    </a>
                </li>
                <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
                <div id="mobile">
                    <a href="cart.php" class="position-relative">
                        <i class="fa-solid fa-bag-shopping"></i> 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <span id="availed_count" ><?= $availed_count ?></span>
                            <!-- <span class="visually-hidden">unread messages</span> -->
                        </span>
                    </a>
                    <i id="bar" class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </ul>
        </div>
        
    </nav>

    
<div class="container" style="width:100%;">
	
	<div class="row text-center">
	    <div class="col-md-6 offset-md-3">
	        <div class="card">
	            <div class="card-body">
	                <div class="login-title">
	                    <h4>Log In</h4>
	                </div>
	                <div class="login-form mt-4">
                      <form action="process.php" method="POST" id="loginform">
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-4">
                              <input type="email" id="form2Example18" class="form-control form-control-lg" name="email" placeholder="Email" required/>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                              <input type="password" id="form2Example28" class="form-control form-control-lg" name="password" placeholder="Password" required />
                            </div>
                          </div>
                        
                        <div class="form-row">
                            <button type="submit" name="submit_login" class="btn btn-success btn-block">Login</button>
                        </div>
                    </form>
	                </div>
	                <div class="logi-forgot text-right mt-2">
                    <p>Don't have an account? <a href="register.php" class="">Sign up here</a></p>
                    <p><a href="#forgot_password" class="" data-bs-toggle="modal" data-bs-target='#forgot-password-modal'>Forgot Password</a></p>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
<!-- <section class="vh-100" id="hero">
  <div class="container-fluid" id="login">
    <div class="row">
      <div class="col-sm-6 text-black" id="register_form">

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-1 pt-xl-0 mt-xl-n5" >

          <form style="width: 23rem;" action="process.php" method="POST" id="loginform">

            <h3 class="fw-normal mb-3" style="letter-spacing: 1px;">Log in</h3>

            <div class="form-outline mb-2">
              <input type="email" id="form2Example18" class="form-control form-control-lg" name="email" required/>
              <label class="form-label" for="form2Example18">Email address</label>
            </div>

            <div class="form-outline mb-2">
              <input type="password" id="form2Example28" class="form-control form-control-lg" name="password" required />
              <label class="form-label" for="form2Example28">Password</label>
            </div>

            <div class="pt-1 mb-2">
              <button class="btn btn-info btn-lg btn-block" type="submit" name="submit_login">Login</button>
            </div>

            <p>Don't have an account? <a href="register.php" class="link-info">Register here</a></p>

          </form>

        </div>

      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        
      </div>
    </div>
  </div>
</section> -->



<div class="modal fade" id="forgot-password-modal"   data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header j-orange-login">
                <h4 class="modal-title text-white">Reset Password</h4>
            <!-- <button type="button" >
                <span aria-hidden="true">&times;</span>
            </button> -->
            <a href="#" class=" btn btn-close close-size" style='text-decoration:none;' data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <div class="modal-body " style="margin:0;padding:0;">
              <section id="product1" class="section-p1  " style="margin:0;padding:0;">
                <div class="pro-container d-flex justify-content-center"  id="sizes-body" style="margin:0;padding:0;">
                  <form action="send.php" method="POST">
                      <input type="email" name="email"  class="form-control mt-3" value="" placeholder="Email" required>
                      <!-- <span id="system_message" class="mt-3"> Reset password link has been sent to your email.</span><br> -->
                      <?php 
                        // echo substr(sha1(mt_rand()),17,6)
                      ?>
                      <button type="submit" name="send" class=" btn btn-success btn-block mb-3 mt-3">Send</button>
                  </form>
                </div>
              </section>
            </div>

            <div class="modal-footer " hidden >
                <!-- justify-content-between -->
                <div class="j-orange pro" style="border:0;">
                    <div id="subtotal" class="d-flex justify-content-start" style="border:0;margin:0;padding:0;">
                        <div id="sizes-footer">


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="new-password-modal"  style="z-index:99999;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog " >
        <div class="modal-content ">
            <div class="modal-header j-orange-login">
                <h4 class="modal-title text-white">Reset Password</h4>
            </div>

            <div class="modal-body m-5" style="margin:0;padding:0;">
              <section id="product1" class="section-p1  " style="margin:0;padding:0;">
                <div class="pro-container d-flex justify-content-center"  id="sizes-body" style="margin:0;padding:0;">
                  <form action="process.php" method="POST">
                      <?php 
                        $generated_request_id = $_GET['generated_request_id'];
                        $sql = "SELECT * FROM reset_request_tbl WHERE generated_request_id='$generated_request_id' LIMIT 1";
                        $query=mysqli_query($con,$sql);
                        $row=mysqli_fetch_assoc($query);
            
                        if($row){ //existing
                          $email = $row['email'];
                          $generated_request_id = $row['generated_request_id'];
                        }else{ //not existing
                          
                        }

                      ?>
                      <input type="hidden" name="generated_request_id"  class="form-control mt-3" value="<?=$generated_request_id?>" >
                      <input type="email" name="email"  class="form-control mt-3" value="<?=$email?>" placeholder="Email" disabled>
                      <!-- <input type="password" name="old_password"  class="form-control mt-3" value="" placeholder="Old Password"> -->
                      <input type="password" name="password"  id="new_password" class="form-control mt-3" value="" placeholder="New Password">
                      <span id="new_password_message" class="text-danger"></span>
                      <input type="password" name="password2"  id="new_password2" class="form-control mt-3" value="" placeholder="Confirm New Password">
                      <span id="new_password2_message" class="text-danger"></span><br>
                      <button type="submit" name="submit_new_password" id="submit_new_password" class=" btn btn-success btn-block mb-3 mt-3" disabled>Send</button>
                  </form>
                </div>
              </section>
            </div>

            <div class="modal-footer " hidden >
                <!-- justify-content-between -->
                <div class="j-orange pro" style="border:0;">
                    <div id="subtotal" class="d-flex justify-content-start" style="border:0;margin:0;padding:0;">
                        <div id="sizes-footer">


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
        
        
</body>
<?php include('footer.php');?>

<script>
  $(document).ready(function () {

    swal({
        title: "Notice.",
        text: "Bin Yang only takes orders within Biñan. Are you sure you want to log in?",
        icon: "info",
        buttons: "OK",
        dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $('#email').focus();
      } 
    });


    var generated_request_id =  "<?= $_GET['generated_request_id'];?>";
    
    if(generated_request_id!=""){
      console.log(generated_request_id);

      //open reset modal
      $('#new-password-modal').modal('show');
    }

    $(document).on('keyup','#new_password, #new_password2', function(){
      var new_password = $('#new_password').val();
      var new_password2 = $('#new_password2').val();

      if(new_password.length>0 && new_password2.length>0){
       
        if(new_password.length>=8 && new_password2.length>=8 ){
          if( new_password.length<20 && new_password2.length<20){
            if(new_password==new_password2){
              $('#new_password').addClass('border border-3 border-success ');
              $('#new_password2').addClass('border border-3 border-success ');
              $('#new_password_message').html("");
              $('#new_password2_message').html("");
              $('#submit_new_password').attr('disabled',false);

            }else{
              $('#new_password_message').html("Password did not match.");
              $('#new_password2_message').html("Password did not match.");
              $('#new_password').removeClass('border border-5 border-success');
              $('#new_password2').removeClass('border border-5 border-success');
              $('#submit_new_password').attr('disabled',true);

            }
          }else{
            $('#new_password_message').html("Your password should be less than 20 characters.");
            $('#new_password2_message').html("Your password should be less than 20 characters.");
            $('#new_password').removeClass('border border-3 border-success');
            $('#new_password2').removeClass('border border-3 border-success');
            $('#submit_new_password').attr('disabled',true);

          }
        }else{
          if(new_password.length<8){
            $('#new_password_message').html("Your password should be more than 8 characters.");
            $('#new_password').removeClass('border border-3 border-success');
          }
          
          if(new_password2.length<8){
            $('#new_password2_message').html("Your password should be more than 8 characters.");
            $('#new_password2').removeClass('border border-3 border-success');
          }
         
          
          $('#submit_new_password').attr('disabled',true);
        }
      }
    });



  });
</script>