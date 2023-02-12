<?php include('header.php');?>

    <!-- page HEADER -->
    <section id="page-header" class="contact-header" hidden>
        <h2>Contact Us</h2>
        
    </section>

    <div style='margin-top:100px;'></div>
    <div class="container-fluid bg-trasparent my-4 p-4" style="position: relative;"> 
        <div class="row row-cols-1 row-cols-xs-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-2 g-3"> 
            
            <div class="col">
                <div class="details">
                    <span>GET IN TOUCH</span>
                    <h2>Visit one of our restaurant or contact us today</h2>
                    <h3>Main Branch</h3>
                        <div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fa-regular fa-map"></i>
                                <p>92 Mercado, Platero, Biñan, Philippiness</p>
                            </li>

                            <li class="list-group-item">
                                <i class="fa-regular fa-at"></i>
                                <p>binyangxitea@gmail.com</p>
                            </li>

                            <li class="list-group-item">
                                <i class="fa-solid fa-phone"></i>
                                <p>(+63) 995 423 1223 / (043) 01 1234 1251</p>
                            </li>

                            <li class="list-group-item">
                                <i class="fa-regular fa-clock"></i>
                                <p>2:00 PM - 10:00 PM, Mon - Sun</p>
                            </li>
                        </ul>
                        </div>
                </div> 
            </div>

            <div class="col-md">
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1932.9150551486287!2d121.09475480598321!3d14.321298997624211!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d999c12848e1%3A0x280a5797a6db1477!2sBin%20Yang%20Coffee%20%26%20Tea!5e0!3m2!1sen!2sph!4v1664030074709!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                
                </div>
            </div>

        </div>
    </div>
    <!-- CONTACT DETAILS -->
    <!-- <section id="contact-details" class="section-p1 m-5">
        <div class="details">
        <span>GET IN TOUCH</span>
        <h2>Visit one of our restaurant or contact us today</h2>
        <h3>Main Branch</h3>
            <div>
                <li>
                    <i class="fa-regular fa-map"></i>
                    <p>92 Mercado, Platero, Biñan, Philippiness</p>
                </li>

                <li>
                    <i class="fa-regular fa-at"></i>
                    <p>binyangxitea@gmail.com</p>
                </li>

                <li>
                    <i class="fa-solid fa-phone"></i>
                    <p>(+63) 995 423 1223 / (043) 01 1234 1251</p>
                </li>

                <li>
                    <i class="fa-regular fa-clock"></i>
                    <p>2:00 PM - 10:00 PM, Mon - Sun</p>
                </li>
            </div>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1932.9150551486287!2d121.09475480598321!3d14.321298997624211!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d999c12848e1%3A0x280a5797a6db1477!2sBin%20Yang%20Coffee%20%26%20Tea!5e0!3m2!1sen!2sph!4v1664030074709!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          
        </div>
    </section> -->
    
    <!-- CONTACT FORMS -->

    
        
     <!-- PEOPLE -->
    <!--<div class="people">-->
    <!--    <div>-->
            <!--<img src="img/people/1.png" alt="">-->
            <!--<p><span>Eleven</span> Senior Marketing Manager <br> Phone: +63 916 115 1231-->
            <!--<br>Email: contact@example.com-->
            <!--</p>-->
    <!--    </div>-->
    <!--    <div>-->
            <!--<img src="img/people/2.png" alt="">-->
            <!--<p><span>Max Mayfield</span> Senior Marketing Manager <br> Phone: +63 916 115 1231-->
            <!--<br>Email: contact@example.com-->
            <!--</p>-->
    <!--    </div>-->
    <!--    <div>-->
            <!--<img src="img/people/3.png" alt="">-->
            <!--<p><span>Lucas Sinclair</span> Senior Marketing Manager <br> Phone: +63 916 115 1231-->
            <!--<br>Email: contact@example.com-->
            <!--</p>-->
    <!--    </div>-->
    <!--</div>-->
<div></div>
    </section>
    </body>
<?php include('footer.php');?>


<script>

    $(document).ready(function () {
        $(document).on('click','#submit_message', function  (e) {
            e.preventDefault();
            console.log('submit_message');
            var name = $('#name').val();
            var email = $('#email').val();
            var subject = $('#subject').val();
            var message_txt = $('#message').val();

            if(email.indexOf('@')){
                $.ajax({
                    method: "POST",
                    url: "process.php",
                    data: {
                        'submit_message' : 1,
                        'name' : name,
                        'email' : email,
                        'subject' : subject,
                        'message_txt' : message_txt
                    },
                    success: function (response) {
                            var obj = JSON.parse(response);

                            $('#system_message').text(obj.system_msg);

                            var system_msg = obj.system_msg;
                            console.log(system_msg);
                            if(system_msg=='Message has been sent.'){
                                swal("Message has been sent.", {
                                    icon: "success",
                                });

                                $('#name').val('');
                                $('#email').val('');
                                $('#subject').val('');
                                $('#message').val('');
                            }else{
                                swal("Error.", {
                                    icon: "error",
                                });
                            }
                        
                            // let popup = document.getElementById("popup");
                            // popup.classList.add("open-popup");
                            // $(document).on('click','#ok_message', function  (e) {
                            //     popup.classList.remove("open-popup");
                            // });

                            // console.log(response);
                    }
                });
            }else{
                swal("Email is invalid."+email.indexOf('@'), {
                    icon: "error",
                });
            }

            

        });
    });
</script>
