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
                <h1 class="m-0">Activity Logs</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Activity Logs</li>
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
                    <div class="card-body">
                    <table id="activity_table" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>USERNAME</th>
                            <th>ACTION</th>
                            <th>DATE</th>
                            <th>DESCRIPTION</th>
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

    
    

  

</body>

<?php include('footer.php'); ?>

<script>
    
    $(function () {

        $('#activity_table').DataTable({
            "processing":true,
            "serverSide": true,
            scrollX:true,
            scrollY:'50vh',
            // "ordering":false,
            "pageLength": 10,
            "pagingType": "numbers",
            lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
            order: [[ 0, "DESC" ]],
            "ajax":{
            url:"fetch_activity_list.php",
            type:"post",
            },  
            "columnDefs": [ 
            {
                "targets": 0,
                // "orderable": false,
                // "width": "25%", 
            },
            {
                "targets": 1,
                // "className": "activity_id",
            },
           
            ]
           

            
        });//end of #table


    });
</script>


