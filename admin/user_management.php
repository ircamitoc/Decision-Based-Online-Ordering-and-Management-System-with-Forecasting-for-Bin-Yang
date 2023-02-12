<?php 

include('header.php'); 

if(!isset($_SESSION['username'])){
    echo '<script> 
        window.location = "login.php";
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
                <h1 class="m-0">User Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">User Management</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <?php if($session_access=="owner" || $session_access=="admin"):?>
                        <div class="card-header">
                            <!-- <h3 class="card-title">Inventory</h3> -->
                            <button type="button" class="btn  j-orange j-btn float-left" data-toggle="modal" data-target="#create-user-modal">
                                <i class="fa fa-solid fa-plus"></i> Create User
                            </button>
                        </div>
                        <!-- /.card-header -->
                    <?php endif;?>

                    <div class="card-body">
                    <table id="users_table" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <?php if($session_access=="owner" || $session_access=="admin"):?>
                                <th width="40px">Action</th>
                            <?php endif;?>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Access&nbsp;level</th>
                            <th>Date&nbsp;Created</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    
    </div>
    <!-- /.content-wrapper -->

    <!-- add modal -->
    <div class="modal fade" id="create-user-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Create User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
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
                                            <!-- <option value="owner">owner</option> -->
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
                        <button type="submit" class="btn j-green j-btn" name="create_user">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- update modal -->
    <div class="modal fade" id="update-modal" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Update User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_update">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <form action="process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="card " >
                            <div class="card-body" id="update_body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="hidden" class="form-control" id="Update_User_id"  name="update_user_id" >
                                    <input type="text" class="form-control" id="Update_Username" placeholder="Enter Username" name="username" >
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Access Level</label>
                                    <select name="access_level" id="Update_access_level" class="form-control">
                                        <option value="">Select Access Level</option>
                                        <option value="admin">admin</option>
                                        <option value="staff">staff</option>
                                        <option value="owner">owner</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Profile Photo</label><br>
                                    <a href="" id="update_image_anchor"><img id="update_image" alt="" style="max-width:200px;"></a>

                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"  id="image" accept="image/gif, image/jpeg, image/png" name="image"> 
                                            <input type="hidden" id="get_filename" name="get_filename" value="0">
                                            <p id="filename" hidden></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <a href="#Change_Password" id="Change_Password">Change Password</a>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <!-- justify-content-between -->
                        <button type="button" class="btn j-orange j-btn " id="cancel_update" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn j-green j-btn" id="update_user" name="update_user">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    

  

</body>

<?php include('footer.php'); ?>

<script>
    
    $(function () {

        $('#image').on('change',function(){
            // output raw value of file input
            $('#filename').html($(this).val().replace(/.*(\/|\\)/, '')); 

            // or, manipulate it further with regex etc.
            var filename = $(this).val().replace(/.*(\/|\\)/, '');
            // .. do your magic
            console.log(filename);
            $('#filename').html(filename);
            $('#get_filename').val(filename);
        });

        

        console.log('user management');
        $('#users_table').DataTable({
            "processing":true,
            "serverSide": true,
            // scrollX:true,
            scrollY:'50vh',
            // "ordering":false,
            "pageLength": 10,
            "pagingType": "numbers",
            lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
            order: [[ 0, "DESC" ]],
            "ajax":{
            url:"fetch_user_list.php",
            type:"post",
            },  
            "columnDefs": [ 
            {
                "targets": 0,
                "orderable": false,
                // "width": "25%", 
            },
            {
                "targets": 1,
                "className": "user_id",
            },
            {
                "targets": 5,
                "orderable": false,
            },
           
            ]
           

            
        });//end of #inventory_table


        $(document).on('click','.update_user', function  (e) {
            e.preventDefault();
            var user_id = $(this).closest('tr').find('.user_id').text();
            console.log(user_id);
            $.ajax({
            method: "POST",
            url: "process.php",
            data: {
                'user_id' : user_id
            },
            success: function (response) {
                console.log(response); //for debug
                var obj = JSON.parse(response);
                $('#Update_User_id').val(obj.user_id);
                $('#Update_Username').val(obj.username);
                $('#Update_access_level').val(obj.access_level);
                $('#update_image').attr("src", "assets/img/"+obj.user_image);
                $('#update_image_anchor').attr("href", "assets/img/"+obj.user_image);
                $('#update_image_anchor').attr("target", "newTab");
            }
            });
        });


        $(document).on('click','.remove_btn', function  (e) {
            e.preventDefault();
            var remove_user_id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this user!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: "POST",
                        url: "process.php",
                        data: {
                            'remove_user_id' : remove_user_id
                        },
                        success: function (response) {
                            // console.log(response);
                            // swal({
                            //     icon: "success",
                            // });
                            // window.location='inventory.php';
                        }
                    });
                    
                    swal("User has been removed", {
                        icon: "success",
                    });
                    $("#users_table").DataTable().ajax.reload();
                } 
                // else {
                //     swal("Your imaginary file is safe!");
                // }
            });
           
        });

        $(document).on('click','#Change_Password', function  (e) {
            var username = $('#Update_Username').val();

            $('#update_user').attr('name','update_password');
            $('#cancel_update').attr('id','cancel_update_password');
            $('#close_update').attr('id','close_update_password');

            $('#update_body').html(`
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="Update_Username" value="`+username+`"  name="username" style="pointer-events:none;">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" class="form-control" id="Update_Password" placeholder="Enter Password" name="change_password" >
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" class="form-control" id="Update_Password2" placeholder="Confirm Password" name="change_password2" >
                </div>


            `).fadeOut(200).fadeIn(200);
        
        });
        $(document).on('click','#cancel_update_password, #close_update_password', function  (e) {
            window.location='';
        });

        


    });
</script>


