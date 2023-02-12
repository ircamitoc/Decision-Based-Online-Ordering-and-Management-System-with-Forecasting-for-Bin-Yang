<?php 

include('header.php'); 

if(!isset($_SESSION['username'])){
    echo '<script> 
        window.location = "login.php";
    </script> '; 
}

?>

<style>
 
</style>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Inventory</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Inventory</li>
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
                    <div class="card-header">
                        <!-- <h3 class="card-title">Inventory</h3> -->
                        <button type="button" class="btn  j-orange j-btn float-left mx-2" data-toggle="modal" data-target="#add-modal">
                            <i class="fa fa-solid fa-plus"></i> Add Product
                        </button>

                        <button type="button" class="btn  j-orange j-btn float-left mx-2" data-toggle="modal" data-target="#category-modal">
                            <i class="nav-icon fas fa-database"></i> Category List
                        </button>

                        <button type="button" class="btn  j-orange j-btn float-left mx-2" data-toggle="modal" data-target="#add-ons-modal">
                            <i class="nav-icon fas fa-database"></i> Add-ons List
                        </button>

                        <button type="button" class="btn  j-orange j-btn float-left mx-2" data-toggle="modal" data-target="#set-delivery-fee-modal">
                            <i class="nav-icon ion-android-bicycle"></i> Set Delivery Fee
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="inventory_table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="40px">Action</th>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Is Active</th>
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
    <div class="modal fade" id="add-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Add Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <form action="process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="card " >
                                <div class="card-body">
                                    <div class="form-group">
                                    <label for="product">Product Name</label>
                                        <!-- <input type="text" class="form-control" id="product"  name="product" oninput="this.value = this.value.replace(/[^0-9.a-zA-Z ]/g, '').replace(/(\..*)\./g, '$1');"> -->
                                        <select name="product" id="product" class="form-control" style="width:100%;">
                                            <option value=""></option>
                                            <?php 
                                                $query = "SELECT product FROM products_tbl ORDER BY product ";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['product']?>"><?=$row['product']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">Price</label>
                                        <input type="number" class="form-control" id="product_price"  name="price"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_quantity">Quantity</label>
                                        <input type="number" class="form-control" id="product_quantity"  name="quantity" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Category</label>
                                        <!-- <input type="number" class="form-control" id="product_category"  name="category" > -->
                                        <select name="category" id="product_category" class="form-control" style="width:100%;">
                                            <!-- <option value="">Select Category</option>
                                            <option value="coffee">Coffee</option>
                                            <option value="noncoffee">Non-Coffee</option>
                                            <option value="milktea">Milk Tea</option> -->
                                            <!-- <option value="creamcheese">Cream Cheese Series</option> -->
                                            <!-- <option value="cheesecake">Cheese Cake Series</option>
                                            <option value="fruittea">Fruit Tea</option> -->
                                            <option value=""></option>
                                            <?php 
                                                $query = "SELECT category FROM category_tbl WHERE is_active=1 ORDER BY category ASC";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['category']?>"><?=$row['category']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputFile">Image</label>
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
                        <button type="submit" class="btn j-green j-btn" name="add_product">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- update modal -->
    <div class="modal fade" id="update-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Update Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <form action="process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="card " >
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="update_product_id"  name="update_product_id" >

                                        <label for="product">Product Name</label>
                                        <!-- <input type="text" class="form-control" id="update_item" name="product"  oninput="this.value = this.value.replace(/[^0-9.a-zA-Z ]/g, '').replace(/(\..*)\./g, '$1');"> -->

                                        <select name="product" id="update_item" class="form-control" style="width:100%;">
                                            <option value=""></option>
                                            <?php 
                                                $query = "SELECT product FROM products_tbl ORDER BY product ";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['product']?>"><?=$row['product']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">Price</label>
                                        <input type="number" class="form-control" id="update_price"  name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_quantity">Quantity</label>
                                        <input type="number" class="form-control" id="update_quantity"  name="quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>

                                    <div class="form-group">
                                        <label for="product_category">Category</label>
                                        <!-- <input type="number" class="form-control" id=""  name="category" > -->
                                        <select name="category" id="update_category" class="form-control"  style="width:100%;">
                                            <!-- <option value="">Select Category</option>
                                            <option value="coffee">Coffee</option>
                                            <option value="noncoffee">Non-Coffee</option>
                                            <option value="milktea">Milk Tea</option> -->
                                            <!-- <option value="creamcheese">Cream Cheese Series</option> -->
                                            <!-- <option value="cheesecake">Cheese Cake Series</option>
                                            <option value="fruittea">Fruit Tea</option> -->
                                            <option value=""></option>
                                            <?php 
                                                $query = "SELECT category FROM category_tbl WHERE is_active=1 ORDER BY category ASC";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['category']?>"><?=$row['category']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="exampleInputFile">Image</label><br>
                                        <a href="" id="update_image_anchor" ><img id="update_image" alt="" style="max-width:200px;" class="card shadow-lg"></a>

                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"  id="image" accept="image/gif, image/jpeg, image/png" name="image" > 
                                                <input type="hidden" id="get_filename" name="get_filename" value="0">
                                                <p id="filename" hidden></p>
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
                        <button type="submit" class="btn j-green j-btn" name="update_product">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!--  category modal -->
    <div class="modal fade" id="category-modal">
        <div class="modal-dialog " >
            <div class="modal-content" >
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Category List</h4>

                    <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <button type="button" class="btn  j-orange j-btn float-left mb-2" data-toggle="modal" data-target="#add-category-modal">
                        <i class="fa fa-solid fa-plus"></i> Add
                    </button>
                    <table id="category_table" class="table table-bordered table-striped table-hover">
                        <thead >
                            <tr>
                                <th width="40px">Action</th>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Date&nbsp;added</th>
                                <th>Date&nbsp;updated</th>
                                <th>Added&nbsp;by</th>
                                <th>Is&nbsp;active</th>
                            </tr>
                        </thead>
                    </table>
                </div>
               
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- add category modal -->
    <div class="modal fade" id="add-category-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Add Category</h4>
                    <button type="button" class="close foat-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product">Category</label>
                        <select class="form-select " id="category_name"  style="width:100%;">
                            <option value=""></option>
                            <?php 
                                $query = "SELECT category FROM category_tbl WHERE is_active=1 ORDER BY category ASC";
                                $query_run = mysqli_query($con, $query);
                                
                                if(mysqli_num_rows($query_run)>0){
                                    foreach($query_run as $row){
                                    ?>
                                        <option value="<?=$row['category']?>"><?=$row['category']?></option>
                                    <?php
                                    }
                                }else{
                                    ?>
                                    <option value="" >No Record Found</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn j-green j-btn" id="submit_category">Submit</button>
                    </div>
                </div>
               
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- update category modal -->
    <div class="modal fade" id="update-category-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Update Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card " >
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="update_category_id">

                                <label for="product">Category</label>
                                <!-- <input type="text" class="form-control" id="update_category_name" > -->
                                <select name="category" id="update_category_name" class="form-control" style="width:100%;">
                                    <option value=""></option>
                                    <?php 
                                        $query = "SELECT category FROM category_tbl  ORDER BY category ASC";
                                        $query_run = mysqli_query($con, $query);
                                        
                                        if(mysqli_num_rows($query_run)>0){
                                            foreach($query_run as $row){
                                            ?>
                                                <option value="<?=$row['category']?>"><?=$row['category']?></option>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="" >No Record Found</option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn j-green j-btn" id="update_category_btn">Save</button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!--  add-ons modal -->
    <div class="modal fade" id="add-ons-modal">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Add-ons List</h4>

                    <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <button type="button" class="btn  j-orange j-btn float-left mb-2" data-toggle="modal" data-target="#add-add-ons-modal">
                        <i class="fa fa-solid fa-plus"></i> Add
                    </button>
                    <table id="add_ons_table" class="table table-bordered table-striped table-hover" >
                        <thead>
                            <tr>
                                <th width="40px">Action</th>
                                <th>ID</th>
                                <th>Add&nbsp;ons</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Date&nbsp;added</th>
                                <th>Date&nbsp;updated</th>
                                <th>Added&nbsp;by</th>
                                <th>Is&nbsp;active</th>
                            </tr>
                        </thead>
                    </table>
                </div>
               
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- add add-ons modal -->
    <div class="modal fade" id="add-add-ons-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Add List</h4>
                    <button type="button" class="close foat-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product">Add-ons</label>
                        <select class="form-select " id="add_ons_name"  style="width:100%;">
                            <option value=""></option>
                            <?php 
                                $query = "SELECT add_ons FROM add_ons_list_tbl WHERE is_active=1 ORDER BY add_ons ASC";
                                $query_run = mysqli_query($con, $query);
                                
                                if(mysqli_num_rows($query_run)>0){
                                    foreach($query_run as $row){
                                    ?>
                                        <option value="<?=$row['add_ons']?>"><?=$row['add_ons']?></option>
                                    <?php
                                    }
                                }else{
                                    ?>
                                    <option value="" >No Record Found</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="add_ons_price">Price</label>
                        <input type="number" class="form-control" id="add_ons_price"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>

                    <div class="form-group">
                        <label for="add_ons_quantity">Quantity</label>
                        <input type="number" class="form-control" id="add_ons_quantity"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>

                    <div class="form-group">
                        <label for="add_ons_quantity">Category</label>
                        <select name="category" id="add_ons_category" class="form-control" style="width:100%;">
                            <option value=""></option>
                            <?php 
                                $query = "SELECT category FROM category_tbl WHERE is_active=1 ORDER BY category ASC";
                                $query_run = mysqli_query($con, $query);
                                
                                if(mysqli_num_rows($query_run)>0){
                                    foreach($query_run as $row){
                                    ?>
                                        <option value="<?=$row['category']?>"><?=$row['category']?></option>
                                    <?php
                                    }
                                }else{
                                    ?>
                                    <option value="" >No Record Found</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn j-green j-btn" id="submit_add_ons">Submit</button>
                    </div>
                </div>
               
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- update add-ons modal -->
    <div class="modal fade" id="update-add-ons-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Update Add-ons</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card " >
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="update_add_ons_list_id">

                                <label for="product">Add-ons</label>

                                <select class="form-select " id="update_add_ons_name"  style="width:100%;">
                                    <?php 
                                        $query = "SELECT add_ons FROM add_ons_list_tbl  ORDER BY add_ons ASC";
                                        $query_run = mysqli_query($con, $query);
                                        
                                        if(mysqli_num_rows($query_run)>0){
                                            foreach($query_run as $row){
                                            ?>
                                                <option value="<?=$row['add_ons']?>"><?=$row['add_ons']?></option>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="" >No Record Found</option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="add_ons_price">Price</label>
                                <input type="number" class="form-control" id="update_add_ons_price"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                            <div class="form-group">
                                <label for="add_ons_quantity">Quantity</label>
                                <input type="number" class="form-control" id="update_add_ons_quantity"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                            <div class="form-group">
                                <label for="add_ons_quantity">Category</label>
                                <select name="category" id="update_add_ons_category" class="form-control" style="width:100%;">
                                    <option value=""></option>
                                    <?php 
                                        $query = "SELECT category FROM category_tbl WHERE is_active=1 ORDER BY category ASC";
                                        $query_run = mysqli_query($con, $query);
                                        
                                        if(mysqli_num_rows($query_run)>0){
                                            foreach($query_run as $row){
                                            ?>
                                                <option value="<?=$row['category']?>"><?=$row['category']?></option>
                                            <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="" >No Record Found</option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn j-green j-btn" id="update_add_ons_btn">Save</button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!--  category modal -->
    <div class="modal fade" id="set-delivery-fee-modal">
        <div class="modal-dialog " >
            <div class="modal-content" >
                <div class="modal-header j-orange">
                    <?php 
                        $delivery_fee_query = "SELECT delivery_fee FROM delivery_fee_tbl";
                        $delivery_fee_query_run = mysqli_query($con, $delivery_fee_query);
                        $delivery_fee_query_row=mysqli_fetch_array($delivery_fee_query_run);
                    ?>
                    <h4 class="modal-title " id="delivery_fee_title">Set Delivery Fee</h4>
                    <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="row ">
                        <label for="" class="col-12">Delivery Fee</label>
                        <input type="hidden" id="delivery_fee_input_hidden"  value="<?=$delivery_fee_query_row['delivery_fee']?>" >
                        <input type="text" 
                            class="form-control mb-3 mx-2 col-3" 
                            id="delivery_fee_input" 
                            value="<?=$delivery_fee_query_row['delivery_fee']?>" 
                            placeholder="Set Delivery Fee" 
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" 
                            disabled
                        >
                    </div>

                    <div id="edit_delivery_fee_content">
                        <button type="button" title="Click here to edit the delivery fee." class="btn  j-orange j-btn  mb-2 " id="edit_delivery_fee">
                            <i class="fa fa-pen"></i> Edit
                        </button>
                    </div>
                    

                    
                </div>
               
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

        

        console.log('test');
        $('#inventory_table').DataTable({
            "processing":true,
            "serverSide": true,
            // scrollX:true,
            scrollY:'50vh',
            // "ordering":false,
            "pageLength": 10,
            "pagingType": "numbers",
            lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
            order: [[ 4, "ASC" ]],//sorted for quantity
            "ajax":{
            url:"fetch_product_list.php",
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
                "className": "product_id",
            },
            {
                "targets": 6,
                "orderable": false,
            },
            {
                "targets": 7,
                // "orderable": false,
            },
            ],
        });//end of #inventory_table


        $(document).on('click','.update_product', function  (e) {
            e.preventDefault();
            var product_id = $(this).closest('tr').find('.product_id').text();
            console.log(product_id);
            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'product_id' : product_id
                },
                success: function (response) {
                    console.log(response); //for debug
                    var obj = JSON.parse(response);
                    $('#update_product_id').val(obj.product_id);
                    $('#update_item').val(obj.product);
                    $('#update_item').trigger('change');
                    $('#update_price').val(obj.product_price);
                    $('#update_quantity').val(obj.product_quantity);
                    $('#update_category').val(obj.category);
                    $('#update_category').trigger('change');

                    $('#update_image').attr("src", "assets/img/"+obj.product_image);
                    $('#update_image_anchor').attr("href", "assets/img/"+obj.product_image);
                    $('#update_image_anchor').attr("target", "newTab");
                }
            });
        });


        $(document).on('click','.remove_btn', function  (e) {
            e.preventDefault();
            var remove_product_id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this product!",
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
                            'remove_product_id' : remove_product_id
                        },
                        success: function (response) {
                            // console.log(response);
                            // swal({
                            //     icon: "success",
                            // });
                            // window.location='inventory.php';
                        }
                    });
                    
                    swal("Product has been removed", {
                        icon: "success",
                    });
                    $("#inventory_table").DataTable().ajax.reload();
                } 
                // else {
                //     swal("Your imaginary file is safe!");
                // }
            });
           
        });

        $('#product, #update_item').select2({
            theme: 'classic',
            // closeOnSelect:false,
            tags:true,
        });

        // ----------------------------------------
        // category table
        var category_table = $('#category_table').DataTable({
            "processing":true,
            "serverSide": true,
            scrollX:true,
            scrollY:'50vh',
            "sScrollXInner": "100%",
            // "bAutoWidth": false,
            // "ordering":false,
            "pageLength": 10,
            "pagingType": "numbers",
            lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
            order: [[ 1, "DESC" ]],
            "ajax":{
            url:"fetch_category_list.php",
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
                "className": "category_id",
            },
           
            ],
        });

        // category_table.columns.adjust().draw()


        $(document).on('click','#submit_category', function  (e) {
            console.log('submit_category');
            var category_name = $('#category_name').val();

            if(category_name.match(/^[0-9a-zA-Z- ]+$/)){ // if alphanumeric category, pasok
                console.log(1);
                $.ajax({
                    method: "POST",
                    url: "process.php",
                    data: {
                        'add_category' : 1,
                        'category_name' : category_name
                    },
                    success: function (response) {
                        console.log(response);
                        var obj = JSON.parse(response);

                        if(obj.system_message == "New category has been added."){
                            swal({
                                title: "New category",
                                text: "has been added",
                                icon: "success",
                                buttons: "OK",
                                dangerMode: true,
                            });
                            $("#category_table").DataTable().ajax.reload();

                        }

                        if(obj.system_message == "Category is already existing."){
                            swal({
                                title: "Category",
                                text: "is already existing",
                                icon: "error",
                                buttons: "OK",
                                dangerMode: true,
                            });
                        }

                        if(obj.error_message == "ERROR"){
                            swal({
                                title: "Category",
                                text: obj.system_message,
                                icon: "error",
                                buttons: "OK",
                                dangerMode: true,
                            });
                        }


                       
                    }
                });
            }else{
                console.log(2);

            }
            
        });

        $(document).on('click','.edit_category_btn', function  (e) {
            console.log('edit_category_btn');
            var category_id = $(this).closest('tr').find('.category_id').text();
            console.log(category_id);

            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'edit_category_btn' : 1,
                    'category_id' : category_id,
                },
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);
                    $('#update_category_id').val(obj.category_id);
                    $('#update_category_name').val(obj.category);
                    $('#update_category_name').trigger('change');
                }
            });
        });

        $(document).on('click','#update_category_btn', function  (e) {
            console.log('update_category_btn');
            var category_id = $('#update_category_id').val();
            var category_name = $('#update_category_name').val();

            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'update_category_btn' : 1,
                    'category_id' : category_id,
                    'category_name' : category_name,
                },
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);
                    if(obj.system_message=="Update Category Successful."){
                        swal({
                            title: "Update Category Successful.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "success",
                            buttons: "OK",
                            dangerMode: true,
                        });
                        $("#category_table").DataTable().ajax.reload();
                    }

                    if(obj.system_message=="Category is already existing."){
                        swal({
                            title: "Category is already existing.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        })
                    }

                    if(obj.error_message=="ERROR"){
                        swal({
                            title: "Category",
                            text: obj.error_message,
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        })
                    }




                }
            });

        });

        $(document).on('click','.remove_category_btn', function  (e) {
            console.log('remove_category_btn');
            var remove_category_id = $(this).data('id');

            swal({
                title: "Are you sure?",
                // text: "Once deleted, you will not be able to recover this category!",
                icon: "warning",
                buttons: ["CANCEL","YES"],
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: "POST",
                        url: "process.php",
                        data: {
                            'remove_category_id' : remove_category_id
                        },
                        success: function (response) {
                            console.log(response);
                            var obj = JSON.parse(response);

                            if(obj.system_message=="Remove Category Successful."){
                                swal({
                                    title: "Remove Category Successful.",
                                    // text: "Once deleted, you will not be able to recover this product!",
                                    icon: "success",
                                    buttons: "OK",
                                    dangerMode: true,
                                });
                                $("#category_table").DataTable().ajax.reload();
                            }

                            if(obj.error_message=="ERROR"){
                                swal({
                                    title: "Remove Category.",
                                    text: obj.system_message,
                                    icon: "error",
                                    buttons: "OK",
                                    dangerMode: true,
                                });
                            }

                        }
                    });
                    
                } 
              
            });
        });


        $(document).on('click','.activate_category_btn', function  (e) {
            console.log('activate_category_btn');
            var activate_category_id = $(this).data('id');

           
            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'activate_category_id' : activate_category_id
                },
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);

                    if(obj.system_message=="Activate Category Successful."){
                        swal({
                            title: "Activate Category Successful.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "success",
                            buttons: "OK",
                            dangerMode: true,
                        });
                        $("#category_table").DataTable().ajax.reload();
                    }

                    if(obj.error_message=="ERROR"){
                        swal({
                            title: "Activate Category.",
                            text: obj.system_message,
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        });
                    }

                }
            });
                    
                
        });

        $('#category_name').select2({
            theme: 'classic',
            // closeOnSelect:false,
            tags:true,
        });
        

        $('#product_category').select2({
            theme: 'classic',
            // closeOnSelect:false,
            // tags:true,
        });

        $('#update_category').select2({
            theme: 'classic',
            // closeOnSelect:false,
            // tags:true,
        });

        $('#update_category_name').select2({
            theme: 'classic',
            // closeOnSelect:false,
            tags:true,
        });

        
        // ----------------------------------------



        // ----------------------------------------
        // add-ons table
        $('#add_ons_table').DataTable({
            "processing":true,
            "serverSide": true,
            scrollX:true,
            scrollY:'50vh',
            "sScrollXInner": "100%",
            "fixedHeader":true,
            // "ordering":false,
            "pageLength": 10,
            "pagingType": "numbers",
            lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
            order: [[ 1, "DESC" ]],
            "ajax":{
            url:"fetch_add_ons_list.php",
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
                "className": "add_ons_list_id",
            },
           
            ],
        });



        $(document).on('click','#submit_add_ons', function  (e) {
            var add_ons_name = $('#add_ons_name').val();
            var add_ons_price = $('#add_ons_price').val();
            var add_ons_quantity = $('#add_ons_quantity').val();
            var add_ons_category = $('#add_ons_category').val();

            if(add_ons_name.match(/^[0-9a-zA-Z- ]+$/)){ // if alphanumeric category, pasok
                console.log(1);
                $.ajax({
                    method: "POST",
                    url: "process.php",
                    data: {
                        'add_add_ons' : 1,
                        'add_ons_name' : add_ons_name,
                        'add_ons_price' : add_ons_price,
                        'add_ons_quantity' : add_ons_quantity,
                        'add_ons_category' : add_ons_category,
                    },
                    success: function (response) {
                        console.log(response);
                        var obj = JSON.parse(response);

                        if(obj.system_message == "New Add-ons has been added."){
                            swal({
                                title: "New category",
                                text: "has been added",
                                icon: "success",
                                buttons: "OK",
                                dangerMode: true,
                            });
                            $("#add_ons_table").DataTable().ajax.reload();

                        }

                        if(obj.system_message == "Add-ons is already existing."){
                            swal({
                                title: "Add-ons",
                                text: "is already existing",
                                icon: "error",
                                buttons: "OK",
                                dangerMode: true,
                            });
                        }

                        if(obj.error_message == "ERROR"){
                            swal({
                                title: "Add-ons",
                                text: obj.system_message,
                                icon: "error",
                                buttons: "OK",
                                dangerMode: true,
                            });
                        }


                       
                    }
                });
            }else{
                console.log(2);

            }
            
        });

        $(document).on('click','.edit_add_ons_btn', function  (e) {
            // var add_ons_list_id = $(this).closest('tr').find('.add_ons_list_id').text();
            var add_ons_list_id = $(this).data('id');
            console.log(add_ons_list_id);

            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'edit_add_ons_btn' : 1,
                    'add_ons_list_id' : add_ons_list_id,
                },
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);
                    $('#update_add_ons_list_id').val(obj.add_ons_list_id);
                    $('#update_add_ons_name').val(obj.add_ons);
                    $('#update_add_ons_name').trigger('change');

                    $('#update_add_ons_price').val(obj.add_ons_price);
                    $('#update_add_ons_quantity').val(obj.add_ons_quantity);
                    $('#update_add_ons_category').val(obj.add_ons_category);

                    

                }
            });
        });

        $(document).on('click','#update_add_ons_btn', function  (e) {
            var add_ons_list_id = $('#update_add_ons_list_id').val();
            var add_ons_name = $('#update_add_ons_name').val();
            var add_ons_price = $('#update_add_ons_price').val();
            var add_ons_quantity = $('#update_add_ons_quantity').val();
            var add_ons_category = $('#update_add_ons_category').val();

            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'update_add_ons_btn' : 1,
                    'add_ons_list_id' : add_ons_list_id,
                    'add_ons_name' : add_ons_name,
                    'add_ons_price' : add_ons_price,
                    'add_ons_quantity' : add_ons_quantity,
                    'add_ons_category' : add_ons_category,
                },
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);
                    if(obj.system_message=="Update Add-ons Successful."){
                        swal({
                            title: "Update Add-ons Successful.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "success",
                            buttons: "OK",
                            dangerMode: true,
                        });
                        $("#add_ons_table").DataTable().ajax.reload();
                    }

                    if(obj.system_message=="Add-ons is already existing."){
                        swal({
                            title: "Add-ons is already existing.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        })
                    }

                    if(obj.error_message=="ERROR"){
                        swal({
                            title: "Add-ons",
                            text: obj.error_message,
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        })
                    }




                }
            });

        });

        $(document).on('click','.remove_add_ons_btn', function  (e) {
            var remove_add_ons_list_id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this add-ons!",
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
                            'remove_add_ons_list_id' : remove_add_ons_list_id
                        },
                        success: function (response) {
                            console.log(response);
                            var obj = JSON.parse(response);

                            if(obj.system_message=="Remove Add-ons Successful."){
                                swal({
                                    title: "Remove Add-ons Successful.",
                                    // text: "Once deleted, you will not be able to recover this product!",
                                    icon: "success",
                                    buttons: "OK",
                                    dangerMode: true,
                                });
                                $("#add_ons_table").DataTable().ajax.reload();
                            }

                            if(obj.error_message=="ERROR"){
                                swal({
                                    title: "Remove Add-ons.",
                                    text: obj.system_message,
                                    icon: "error",
                                    buttons: "OK",
                                    dangerMode: true,
                                });
                            }

                        }
                    });
                    
                } 
              
            });
        });


        $(document).on('click','.activate_add_ons_btn', function  (e) {
            var activate_add_ons_id = $(this).data('id');

            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'activate_add_ons_id' : activate_add_ons_id
                },
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);

                    if(obj.system_message=="Activate Add-ons Successful."){
                        swal({
                            title: "Activate Add-ons Successful.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "success",
                            buttons: "OK",
                            dangerMode: true,
                        });
                        $("#add_ons_table").DataTable().ajax.reload();
                    }

                    if(obj.error_message=="ERROR"){
                        swal({
                            title: "Activate Add-ons.",
                            text: obj.system_message,
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        });
                    }

                }
            });
                    
                
        });

        $('#add_ons_name').select2({
            theme: 'classic',
            // closeOnSelect:false,
            tags:true,
        });
        

        
        $('#update_add_ons_name').select2({
            theme: 'classic',
            // closeOnSelect:false,
            tags:true,
        });

        // $('#update_category').select2({
        //     theme: 'classic',
        //     // closeOnSelect:false,
        //     // tags:true,
        // });
        

        // ----------------------------------------

        // activate product
        

        $(document).on('click','.activate_product_btn', function  (e) {
            var activate_product_id = $(this).data('id');

            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'activate_product_id' : activate_product_id
                },
                success: function (response) {
                    console.log(response);
                    var obj = JSON.parse(response);

                    if(obj.system_message=="Activate Product Successful."){
                        swal({
                            title: "Activate Product Successful.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "success",
                            buttons: "OK",
                            dangerMode: true,
                        });
                        $("#inventory_table").DataTable().ajax.reload();
                    }

                    if(obj.error_message=="ERROR"){
                        swal({
                            title: "Activate Product.",
                            text: obj.system_message,
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        });
                    }

                }
            });

            
                
        });

        // ---------------------- end of active product




        // edit delivery fee
        $(document).on('click','#edit_delivery_fee', function  (e) {
            console.log("edit_delivery_fee");
            $('#delivery_fee_input').attr('disabled',false).focus().select();
            $('#edit_delivery_fee_content').html(`
                <button type="button" class="btn  j-orange j-btn  mb-2 " id="cancel_update_delivery_fee">
                    <i class="ion-android-close"></i> Cancel
                </button>
                <button type="button" title="Click here to edit the delivery fee." class="btn  j-orange j-btn  mb-2 " id="update_delivery_fee">
                    <i class="ion-android-send"></i> Save
                </button>
            `);
        });
        $(document).on('click','#cancel_update_delivery_fee', function  (e) {
            $('#delivery_fee_input').attr('disabled',true).val($('#delivery_fee_input_hidden').val());

            $('#edit_delivery_fee_content').html(`
                <button type="button" title="Click here to edit the delivery fee." class="btn  j-orange j-btn  mb-2 " id="edit_delivery_fee">
                    <i class="fa fa-pen"></i> Edit
                </button>
            `);
        });

        $(document).on('click','#update_delivery_fee', function  (e) {
            console.log("#update_delivery_fee");

            var delivery_fee_input = $('#delivery_fee_input').val();
            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'delivery_fee_input' : delivery_fee_input
                },
                success: function (response) {
                    console.log(response); //for debug
                    var obj = JSON.parse(response);

                    if(obj.system_message=="Update Delivery Fee Successful."){
                        swal({
                            title: "Update Delivery Fee Successful.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "success",
                            buttons: "OK",
                            dangerMode: true,
                        });

                        $('#delivery_fee_input').attr('disabled',true);

                        $('#edit_delivery_fee_content').html(`
                            <button type="button" title="Click here to edit the delivery fee." class="btn  j-orange j-btn  mb-2 " id="edit_delivery_fee">
                                <i class="fa fa-pen"></i> Edit
                            </button>
                        `);
                    }

                    if(obj.error_message=="ERROR"){
                        swal({
                            title: "Update Delivery Fee.",
                            text: obj.system_message,
                            icon: "error",
                            buttons: "OK",
                            dangerMode: true,
                        });
                    }
                   
                }
            });
        });
        
        
        
    });
</script>

<script>

    
</script>


