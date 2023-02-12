<?php 

    include('header.php');

    //get visit
    $user_ip= $_SERVER['REMOTE_ADDR'];
    $query = "INSERT INTO activity_logs (action,created_at,description) VALUES('visit','$date', '$user_ip')";
                if(!mysqli_query($db, $query)){
                    echo("Error description: " . mysqli_error($db));
                }
?>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-aos="fade-down" data-aos-duration="1000">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="img/pic1.png" alt="First slide"  style="height: 70vh;">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img/pic3.png" alt="Second slide" style="height: 70vh;">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="img/pic5.png" alt="Third slide" style="height: 70vh;">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<!--<body>-->
<!--<div class="landingPage">-->
<!-- <img class="d-block w-100" src="img/carousel6.png" alt="Third slide" style="width:700px;height:450px;" >-->
<!--<button class="btnMenu" position:"absolute"><a href="menuV3.php">Learn More</a></button>-->
<!--</div>-->

    <!-- Carousel tinanggal ko muan yung carousel -chua-->
    <!--<div id="homeCarousel" class="carousel slide" data-ride="carousel"">-->
    <!--<section>-->
    <!--    <div class="carousel-inner" style="height:20%;">-->
    <!--    <button class="white"><a href="/menuV3.php" style="color:red; text-decoration: none;">Learn More</a></button>-->
    <!--        <div class="carousel-item active">-->
    <!--        <img class="d-block w-100" src="img/carousel3.jpg" alt="First slide" style="width:640px;height:600px;" >-->
    <!--        </div>-->
    <!--        <div class="carousel-item">-->
    <!--        <img class="d-block w-100" src="img/carousel5.jpg" alt="Second slide" style="width:640px;height:600px;" >-->
    <!--        </div>-->
    <!--        <div class="carousel-item">-->
    <!--        <img class="d-block w-100" src="img/carousel2.jpg" alt="Third slide" style="width:640px;height:600px;" >-->
    <!--        </div>-->
    <!--        <div class="carousel-item">-->
    <!--        <img class="d-block w-100" src="img/carousel1.jpg" alt="Third slide" style="width:640px;height:600px;" >-->
    <!--        </div>-->
    <!--        <div class="carousel-item">-->
    <!--        <img class="d-block w-100" src="img/carousel6.png" alt="Third slide" style="width:640px;height:600px;" >-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <a class="carousel-control-prev" href="#homeCarousel" role="button" data-slide="prev">-->
    <!--        <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
    <!--        <span class="sr-only">Previous</span>-->
    <!--    </a>-->
    <!--    <a class="carousel-control-next" href="#homeCarousel" role="button" data-slide="next">-->
    <!--        <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
    <!--        <span class="sr-only">Next</span>-->
    <!--    </a>-->
         
    <!--<section>-->
    <!--</div>-->
    
    <main>
    <p class="text-center mt-5" style="font-size: 40px; font-style: bold;" data-aos="fade-up" data-aos-duration="500">Products</p> 
      <div class="container-fluid bg-trasparent my-4 p-4" style="position: relative;"> 
        <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-5 g-3"> 
          <div class="col"> 
            <div class="card h-60 shadow-sm" data-aos="fade-left" data-aos-duration="500">
                <a href="menuV3.php#coffee_section"><img src="img/1917-Coffee1.png" class="card-img-top" alt="..."></a>  
                <div class="card-body"> 
                  <div class="clearfix mb-3"> 
                  <span class="float-start badge rounded-pill bg-success p-2">Coffee</span> 
                  <!-- <span class="float-end price-hp">12354.00&euro;</span>  -->
                  </div> 
                  <!-- <h5 class="card-title">What is coffee? Coffee is a beverage brewed from the roasted and ground seeds of the tropical evergreen coffee plant. Coffee is one of the three most popular beverages in the world (alongside water and tea), and it is one of the most profitable international commodities.</h5>  -->
                  <div class="text-center my-4"> 
                  </div> 
                </div> 
            </div> 
          </div>

          <div class="col"> 
            <div class="card h-60 shadow-sm" data-aos="fade-left" data-aos-duration="1000">
                <a href="menuV3.php#noncoffee_section"><img src="img/1917-Coffee1.png" class="card-img-top" alt="..."></a>  
                  <div class="card-body"> 
                    <div class="clearfix mb-3"> 
                    <span class="float-start badge rounded-pill bg-primary p-2">Non Coffee</span> 
                    <!-- <span class="float-end price-hp">12354.00&euro;</span>  -->
                    </div> 
                    <!-- <h5 class="card-title">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam quidem eaque ut eveniet aut quis rerum. Asperiores accusamus harum ducimus velit odit ut. Saepe, iste optio laudantium sed aliquam sequi.</h5>  -->
                    <div class="text-center my-4"> 
                    </div> 
                  </div> 
            </div> 
          </div>

          <div class="col"> 
            <div class="card h-60 shadow-sm" data-aos="fade-left" data-aos-duration="1500">
                <a href="menuV3.php#milktea_section"><img src="img/1917-Coffee1.png" class="card-img-top" alt="..."></a>  
                  <div class="card-body"> 
                    <div class="clearfix mb-3"> 
                    <span class="float-start badge rounded-pill bg-info p-2">Milk Tea</span> 
                    <!-- <span class="float-end price-hp">12354.00&euro;</span>  -->
                    </div> 
                    <!-- <h5 class="card-title">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam quidem eaque ut eveniet aut quis rerum. Asperiores accusamus harum ducimus velit odit ut. Saepe, iste optio laudantium sed aliquam sequi.</h5>  -->
                    <div class="text-center my-4"> 
                    </div> 
                  </div> 
            </div> 
          </div>

          

          <div class="col"> 
            <div class="card h-60 shadow-sm" data-aos="fade-left" data-aos-duration="2000">
                <a href="menuV3.php#cheesecake_section"><img src="img/1917-Coffee1.png" class="card-img-top" alt="..."></a>  
                  <div class="card-body"> 
                    <div class="clearfix mb-3"> 
                    <span class="float-start badge rounded-pill bg-danger p-2">Cheese Cake</span> 
                    <!-- <span class="float-end price-hp">12354.00&euro;</span>  -->
                    </div> 
                    <!-- <h5 class="card-title">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam quidem eaque ut eveniet aut quis rerum. Asperiores accusamus harum ducimus velit odit ut. Saepe, iste optio laudantium sed aliquam sequi.</h5>  -->
                    <div class="text-center my-4"> 
                    </div> 
                  </div> 
            </div> 
          </div>

          <div class="col"> 
            <div class="card h-60 shadow-sm" data-aos="fade-left" data-aos-duration="2500">
                <a href="menuV3.php#fruittea_section"><img src="img/1917-Coffee1.png" class="card-img-top" alt="..."></a> 
                  <div class="card-body"> 
                    <div class="clearfix mb-3"> 
                    <span class="float-start badge rounded-pill bg-warning p-2">Fruit Tea</span> 
                    <!-- <span class="float-end price-hp">12354.00&euro;</span>  -->
                    </div> 
                    <!-- <h5 class="card-title">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam quidem eaque ut eveniet aut quis rerum. Asperiores accusamus harum ducimus velit odit ut. Saepe, iste optio laudantium sed aliquam sequi.</h5>  -->
                    <div class="text-center my-4"> 
                    </div> 
                  </div> 
            </div> 
          </div>

          

        </div>
      </div>
    </main>

     <!--BOTTOM BANNERS -->
    <section id="sm-banner" class="section-p1 d-flex justify-content-center" data-aos="fade-up" data-aos-duration="1500">
        <div class="banner-box">
            <!-- <h2>buy 1 get 1 free</h2> -->
            <span style="margin-top: 500px; font-size: 20px;">Enjoy every sip with our best selling beverages. Coffee starts at ₱79!.</span>
            <button class="white"><a href="menuV3.php" style="color:white; text-decoration: none;">Learn More</a></button>
        </div>
        
    </section>

    <!-- <section id="sm-banner" class="section-p1 d-flex justify-content-center">
    <div class="banner-box2" style="width: 790px;margin-bottom: 160px;"  >
            <span style="font-size: 20px; "> Sip & Refresh</span>
            <button class="white"><a href="menuV3.php" style="color:white; text-decoration: none;">Learn More</a></button>
    </div>
    </section> -->

    
          
          

</body>
<?php include('footer.php');?>
