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
@media (min-width: 1025px) {
.h-custom {
height: 160vh !important;
}
}
.card-registration .select-input.form-control[readonly]:not([disabled]) {
font-size: 1rem;
line-height: 2.15;
padding-left: .75em;
padding-right: .75em;
}
.card-registration .select-arrow {
top: 13px;
}

/* .gradient-custom-2 {
/* fallback for old browsers */
background: #a1c4fd;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
} */

.bg-indigo {
background-color: #4835d4;
}
@media (min-width: 992px) {
.card-registration-2 .bg-indigo {
border-top-right-radius: 15px;
border-bottom-right-radius: 15px;
}
}
@media (max-width: 991px) {
.card-registration-2 .bg-indigo {
border-bottom-left-radius: 15px;
border-bottom-right-radius: 15px;
}
}

section {
  background-image: url("kape.jpg");
}

.p-5, .col-lg-6 {
  background-image: url("kape2.jpg");
}


</style>
<body>

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
                <?php if(isset($_SESSION['username'])):?>
                    <!-- <li><a href="profile.php" id="Profile">Profile: </a></li> -->
                    <li><a href="?logout=1" id="Logout" class="nav-link rounded">Logout</a></li>
                    <li><a href="profile.php" id="Profile" class="nav-link rounded"><img src="admin/assets/img/<?=$client_side_user_image?>" width="30px" height="30px" style="border-radius:50%;"></a></li>
                <?php else:?>
                    <li><a href="login.php" id="Login" class="nav-link rounded">Login</a></li>
                <?php endif;?>
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
<!--REGISTER FORM 11/02/2011 -->

<section class="h-100 h-custom gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
    <form id="reg_form" action="process.php" method="post" enctype="multipart/form-data">
      <div class="col-12">
        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
          <div class="card-body p-0">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="p-5">
                  <h3 class="fw-normal mb-5" style="color: #fff;">General Infomation</h3>

                  <div class="mb-4 pb-2">
                    <div class="form-outline">
                      <input type="email" id="email" class="form-control form-control-md" name="email" placeholder="" required/>
                      <label style="color: #fff" class="form-label" for="form3Examplev4">Email <span id="email_validation"></span></label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 ">
                      <div class="form-outline">
                        <input type="password"  class="form-control form-control-md password" name="password"  required/>
                        <label style="color: #fff" class="form-label" for="form3Examplev2">Password <span id="password_validation"></span></label>
                      </div>
                    </div>
                    <div class="col-md-6 ">
                      <div class="form-outline">
                        <input type="password" class="form-control form-control-md password2" name="password2"  required/>
                        <label style="color: #fff" class="form-label" for="form3Examplev3">Confirm Password <span id="password2_validation"></span></label>
                      </div>
                    </div>

                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <span id="passwords_validation"></span>
                      </div>
                    </div>


                  </div>

                    
                  <div class="mb-4 pb-2">
                    <div class="form-outline">
                      <input type="text"  class="form-control form-control-md" name="name" required/>
                      <label style="color: #fff" class="form-label" for="form3Examplev4">Full Name</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-4 pb-2 mb-md-0 pb-md-0">

                      <div class="form-outline">
                        <input type="file"  id="profile_photo" accept="image/gif, image/jpeg, image/png" name="image" class="form-control" > 
                        <label style="color: #fff" class="form-label" for="form3Examplev5">Profile Photo</label>
                      </div>

                    </div>
                  </div>

                </div>
              </div>
              <div class="col-lg-6 bg-indigo text-white">
                <div class="p-5">
                  <h3 class="fw-normal mb-5">Contact Details</h3>

                  <div class="mb-4 pb-2">
                    <div class="form-outline form-white">
                      <input type="text"  class="form-control form-control-md Street"  style="margin:0;" required/>
                      <label class="form-label" for="form3Examplea2">Street Address (Street, Floor/Unit/Room #)</label>
                    </div>
                  </div>

                  <div class="mb-4 pb-2">
                    <div class="form-outline form-white">
                    <input type="text"  class="form-control form-control-md Landmark"  style="margin:0;"/>
                      <label class="form-label" for="form3Examplea3">Landmark (Optional)</label>
                    </div>
                  </div>

                  <div class="mb-4 pb-2">
                    <div class="form-outline form-white">
                      <input type="text"  class="form-control form-control-md Town"   required style="margin:0;" value ='Biñan City, Laguna' disabled/>
                      <label class="form-label" for="form3Examplea6">Town / City</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 mb-4 pb-2">

                      <div class="form-outline form-white">
                        <input type="text"  class="form-control form-control-md Country"  required style="margin:0;" value ='Philippines' disabled/>
                        <label class="form-label" for="form3Examplea7">Country</label>
                      </div>

                    </div>
                    <div class="col-md-7 mb-4 pb-2">

                      <div class="form-outline form-white">
                        <input type="number" class="form-control form-control-md" name="mobile"  required  maxlength = "11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
                        <label class="form-label" for="form3Examplea8">Mobile Number</label>
                      </div>

                    </div>
                  </div>

                  <div class="mb-4">
                    <div class="form-outline form-white">
                      <input type="text"  class="form-control form-control-md Postcode"  required style="margin:0;" value ='4024' disabled/>
                      <label class="form-label" for="form3Examplea9">Postal</label>
                    </div>
                  </div>

                  <div class="form-outline mb-1"  style='pointer-events:none;'>
                      
                      <textarea name="address" id="delivery_address" cols="30" rows="3" class="form-control form-control-sm" placeholder="Address" required ></textarea>
                    </div>

                  <div class="form-check d-flex justify-content-start mb-4 pb-3">

                    <input class="form-check-input me-3" type="checkbox" value="" id="terms" />
                    <label class="form-check-label text-white" for="form2Example3">
                      I do accept the <a data-target="#terms_conditions" data-toggle="modal" class="MainNavText" id="MainNavHelp" 
                        href="" style="text-decoration: none;">Terms & Conditions</a> of your site.
                    </label>
                  </div>

                  <div id="terms_conditions" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-scrollable">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" >Terms & Conditions</h6>
                                    </div>
                                    <div class="modal-body" style="height: 400px;">
                                    <h2 style="text-align: center;"><b>TERMS AND CONDITIONS</b></h2>
                    <p>Last updated: 2022-11-04</p>
                    <p>1. <b>Introduction</b></p>
                    <p>Welcome to <b>Bin Yang</b> (“Company”, “we”, “our”, “us”)!</p>
                    <p>These Terms of Service (“Terms”, “Terms of Service”) govern your use of our website located at <b>https://binyang.online/</b> (together or individually “Service”) operated by <b>Bin Yang</b>.</p>
                    <p>Our Privacy Policy also governs your use of our Service and explains how we collect, safeguard and disclose information that results from your use of our web pages.</p>
                    <p>Your agreement with us includes these Terms and our Privacy Policy (“Agreements”). You acknowledge that you have read and understood Agreements, and agree to be bound of them.</p>
                    <p>If you do not agree with (or cannot comply with) Agreements, then you may not use the Service, but please let us know by emailing at <b>binyangxitea@gmail.com</b> so we can try to find a solution. These Terms apply to all visitors, users and others who wish to access or use Service.</p>
                    <p>2. <b>Communications</b></p>
                    <p>By using our Service, you agree to subscribe to newsletters, marketing or promotional materials and other information we may send. However, you may opt out of receiving any, or all, of these communications from us by following the unsubscribe link or by emailing at binyangxitea@gmail.com.</p>
                    <p>3. <b>Purchases</b></p><p>If you wish to purchase any product or service made available through Service (“Purchase”), you may be asked to supply certain information relevant to your Purchase including but not limited to, your credit or debit card number, the expiration date of your card, your billing address, and your shipping information.</p><p>You represent and warrant that: (i) you have the legal right to use any card(s) or other payment method(s) in connection with any Purchase; and that (ii) the information you supply to us is true, correct and complete.</p><p>We may employ the use of third party services for the purpose of facilitating payment and the completion of Purchases. By submitting your information, you grant us the right to provide the information to these third parties subject to our Privacy Policy.</p><p>We reserve the right to refuse or cancel your order at any time for reasons including but not limited to: product or service availability, errors in the description or price of the product or service, error in your order or other reasons.</p><p>We reserve the right to refuse or cancel your order if fraud or an unauthorized or illegal transaction is suspected.</p>
                    <p>4. <b>Contests, Sweepstakes and Promotions</b></p>
                    <p>Any contests, sweepstakes or other promotions (collectively, “Promotions”) made available through Service may be governed by rules that are separate from these Terms of Service. If you participate in any Promotions, please review the applicable rules as well as our Privacy Policy. If the rules for a Promotion conflict with these Terms of Service, Promotion rules will apply.</p>

                    <p>5. <b>Refunds</b></p><p>We issue refunds for Contracts within <b>1 days</b> of the original purchase of the Contract.</p>
                    <p>6. <b>Content</b></p><p>Content found on or through this Service are the property of Bin Yang or used with permission. You may not distribute, modify, transmit, reuse, download, repost, copy, or use said Content, whether in whole or in part, for commercial purposes or for personal gain, without express advance written permission from us.</p>
                    <p>7. <b>Prohibited Uses</b></p>
                    <p>You may use Service only for lawful purposes and in accordance with Terms. You agree not to use Service:</p>
                    <p>0.1. In any way that violates any applicable national or international law or regulation.</p>
                    <p>0.2. For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way by exposing them to inappropriate content or otherwise.</p>
                    <p>0.3. To transmit, or procure the sending of, any advertising or promotional material, including any “junk mail”, “chain letter,” “spam,” or any other similar solicitation.</p>
                    <p>0.4. To impersonate or attempt to impersonate Company, a Company employee, another user, or any other person or entity.</p>
                    <p>0.5. In any way that infringes upon the rights of others, or in any way is illegal, threatening, fraudulent, or harmful, or in connection with any unlawful, illegal, fraudulent, or harmful purpose or activity.</p>
                    <p>0.6. To engage in any other conduct that restricts or inhibits anyone’s use or enjoyment of Service, or which, as determined by us, may harm or offend Company or users of Service or expose them to liability.</p>
                    <p>Additionally, you agree not to:</p>
                    <p>0.1. Use Service in any manner that could disable, overburden, damage, or impair Service or interfere with any other party’s use of Service, including their ability to engage in real time activities through Service.</p>
                    <p>0.2. Use any robot, spider, or other automatic device, process, or means to access Service for any purpose, including monitoring or copying any of the material on Service.</p>
                    <p>0.3. Use any manual process to monitor or copy any of the material on Service or for any other unauthorized purpose without our prior written consent.</p>
                    <p>0.4. Use any device, software, or routine that interferes with the proper working of Service.</p>
                    <p>0.5. Introduce any viruses, trojan horses, worms, logic bombs, or other material which is malicious or technologically harmful.</p>
                    <p>0.6. Attempt to gain unauthorized access to, interfere with, damage, or disrupt any parts of Service, the server on which Service is stored, or any server, computer, or database connected to Service.</p>
                    <p>0.7. Attack Service via a denial-of-service attack or a distributed denial-of-service attack.</p>
                    <p>0.8. Take any action that may damage or falsify Company rating.</p>
                    <p>0.9. Otherwise attempt to interfere with the proper working of Service.</p>
                    <p>8. <b>Analytics</b></p>
                    <p>We may use third-party Service Providers to monitor and analyze the use of our Service.</p>
                    <p>9. <b>No Use By Minors</b></p>
                    <p>Service is intended only for access and use by individuals at least eighteen (18) years old. By accessing or using Service, you warrant and represent that you are at least eighteen (18) years of age and with the full authority, right, and capacity to enter into this agreement and abide by all of the terms and conditions of Terms. If you are not at least eighteen (18) years old, you are prohibited from both the access and usage of Service.</p>
                    <p>10. <b>Accounts</b></p><p>When you create an account with us, you guarantee that you are above the age of 18, and that the information you provide us is accurate, complete, and current at all times. Inaccurate, incomplete, or obsolete information may result in the immediate termination of your account on Service.</p><p>You are responsible for maintaining the confidentiality of your account and password, including but not limited to the restriction of access to your computer and/or account. You agree to accept responsibility for any and all activities or actions that occur under your account and/or password, whether your password is with our Service or a third-party service. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p><p>You may not use as a username the name of another person or entity or that is not lawfully available for use, a name or trademark that is subject to any rights of another person or entity other than you, without appropriate authorization. You may not use as a username any name that is offensive, vulgar or obscene.</p><p>We reserve the right to refuse service, terminate accounts, remove or edit content, or cancel orders in our sole discretion.</p>
                    <p>11. <b>Intellectual Property</b></p>
                    <p>Service and its original content (excluding Content provided by users), features and functionality are and will remain the exclusive property of Bin Yang and its licensors. Service is protected by copyright, trademark, and other laws of  and foreign countries. Our trademarks may not be used in connection with any product or service without the prior written consent of Bin Yang.</p>
                    <p>12. <b>Copyright Policy</b></p>
                    <p>We respect the intellectual property rights of others. It is our policy to respond to any claim that Content posted on Service infringes on the copyright or other intellectual property rights (“Infringement”) of any person or entity.</p>
                    <p>If you are a copyright owner, or authorized on behalf of one, and you believe that the copyrighted work has been copied in a way that constitutes copyright infringement, please submit your claim via email to binyangxitea@gmail.com, with the subject line: “Copyright Infringement” and include in your claim a detailed description of the alleged Infringement as detailed below, under “DMCA Notice and Procedure for Copyright Infringement Claims”</p>
                    <p>You may be held accountable for damages (including costs and attorneys’ fees) for misrepresentation or bad-faith claims on the infringement of any Content found on and/or through Service on your copyright.</p>
                    <p>13. <b>DMCA Notice and Procedure for Copyright Infringement Claims</b></p>
                    <p>You may submit a notification pursuant to the Digital Millennium Copyright Act (DMCA) by providing our Copyright Agent with the following information in writing (see 17 U.S.C 512(c)(3) for further detail):</p>
                    <p>0.1. an electronic or physical signature of the person authorized to act on behalf of the owner of the copyright’s interest;</p>
                    <p>0.2. a description of the copyrighted work that you claim has been infringed, including the URL (i.e., web page address) of the location where the copyrighted work exists or a copy of the copyrighted work;</p>
                    <p>0.3. identification of the URL or other specific location on Service where the material that you claim is infringing is located;</p>
                    <p>0.4. your address, telephone number, and email address;</p>
                    <p>0.5. a statement by you that you have a good faith belief that the disputed use is not authorized by the copyright owner, its agent, or the law;</p>
                    <p>0.6. a statement by you, made under penalty of perjury, that the above information in your notice is accurate and that you are the copyright owner or authorized to act on the copyright owner’s behalf.</p>
                    <p>You can contact our Copyright Agent via email at binyangxitea@gmail.com.</p>
                    <p>14. <b>Error Reporting and Feedback</b></p>
                    <p>You may provide us either directly at binyangxitea@gmail.com or via third party sites and tools with information and feedback concerning errors, suggestions for improvements, ideas, problems, complaints, and other matters related to our Service (“Feedback”). You acknowledge and agree that: (i) you shall not retain, acquire or assert any intellectual property right or other right, title or interest in or to the Feedback; (ii) Company may have development ideas similar to the Feedback; (iii) Feedback does not contain confidential information or proprietary information from you or any third party; and (iv) Company is not under any obligation of confidentiality with respect to the Feedback. In the event the transfer of the ownership to the Feedback is not possible due to applicable mandatory laws, you grant Company and its affiliates an exclusive, transferable, irrevocable, free-of-charge, sub-licensable, unlimited and perpetual right to use (including copy, modify, create derivative works, publish, distribute and commercialize) Feedback in any manner and for any purpose.</p>
                    <p>15. <b>Links To Other Web Sites</b></p>
                    <p>Our Service may contain links to third party web sites or services that are not owned or controlled by Bin Yang.</p>
                    <p>Bin Yang has no control over, and assumes no responsibility for the content, privacy policies, or practices of any third party web sites or services. We do not warrant the offerings of any of these entities/individuals or their websites.</p>
                    <p>YOU ACKNOWLEDGE AND AGREE THAT COMPANY SHALL NOT BE RESPONSIBLE OR LIABLE, DIRECTLY OR INDIRECTLY, FOR ANY DAMAGE OR LOSS CAUSED OR ALLEGED TO BE CAUSED BY OR IN CONNECTION WITH USE OF OR RELIANCE ON ANY SUCH CONTENT, GOODS OR SERVICES AVAILABLE ON OR THROUGH ANY SUCH THIRD PARTY WEB SITES OR SERVICES.</p>
                    <p>WE STRONGLY ADVISE YOU TO READ THE TERMS OF SERVICE AND PRIVACY POLICIES OF ANY THIRD PARTY WEB SITES OR SERVICES THAT YOU VISIT.</p>
                    <p>16. <b>Disclaimer Of Warranty</b></p>
                    <p>THESE SERVICES ARE PROVIDED BY COMPANY ON AN “AS IS” AND “AS AVAILABLE” BASIS. COMPANY MAKES NO REPRESENTATIONS OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, AS TO THE OPERATION OF THEIR SERVICES, OR THE INFORMATION, CONTENT OR MATERIALS INCLUDED THEREIN. YOU EXPRESSLY AGREE THAT YOUR USE OF THESE SERVICES, THEIR CONTENT, AND ANY SERVICES OR ITEMS OBTAINED FROM US IS AT YOUR SOLE RISK.</p>
                    <p>NEITHER COMPANY NOR ANY PERSON ASSOCIATED WITH COMPANY MAKES ANY WARRANTY OR REPRESENTATION WITH RESPECT TO THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY, OR AVAILABILITY OF THE SERVICES. WITHOUT LIMITING THE FOREGOING, NEITHER COMPANY NOR ANYONE ASSOCIATED WITH COMPANY REPRESENTS OR WARRANTS THAT THE SERVICES, THEIR CONTENT, OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE SERVICES WILL BE ACCURATE, RELIABLE, ERROR-FREE, OR UNINTERRUPTED, THAT DEFECTS WILL BE CORRECTED, THAT THE SERVICES OR THE SERVER THAT MAKES IT AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS OR THAT THE SERVICES OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE SERVICES WILL OTHERWISE MEET YOUR NEEDS OR EXPECTATIONS.</p>
                    <p>COMPANY HEREBY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, STATUTORY, OR OTHERWISE, INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT, AND FITNESS FOR PARTICULAR PURPOSE.</p>
                    <p>THE FOREGOING DOES NOT AFFECT ANY WARRANTIES WHICH CANNOT BE EXCLUDED OR LIMITED UNDER APPLICABLE LAW.</p>
                    <p>17. <b>Limitation Of Liability</b></p>
                    <p>EXCEPT AS PROHIBITED BY LAW, YOU WILL HOLD US AND OUR OFFICERS, DIRECTORS, EMPLOYEES, AND AGENTS HARMLESS FOR ANY INDIRECT, PUNITIVE, SPECIAL, INCIDENTAL, OR CONSEQUENTIAL DAMAGE, HOWEVER IT ARISES (INCLUDING ATTORNEYS’ FEES AND ALL RELATED COSTS AND EXPENSES OF LITIGATION AND ARBITRATION, OR AT TRIAL OR ON APPEAL, IF ANY, WHETHER OR NOT LITIGATION OR ARBITRATION IS INSTITUTED), WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE, OR OTHER TORTIOUS ACTION, OR ARISING OUT OF OR IN CONNECTION WITH THIS AGREEMENT, INCLUDING WITHOUT LIMITATION ANY CLAIM FOR PERSONAL INJURY OR PROPERTY DAMAGE, ARISING FROM THIS AGREEMENT AND ANY VIOLATION BY YOU OF ANY FEDERAL, STATE, OR LOCAL LAWS, STATUTES, RULES, OR REGULATIONS, EVEN IF COMPANY HAS BEEN PREVIOUSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. EXCEPT AS PROHIBITED BY LAW, IF THERE IS LIABILITY FOUND ON THE PART OF COMPANY, IT WILL BE LIMITED TO THE AMOUNT PAID FOR THE PRODUCTS AND/OR SERVICES, AND UNDER NO CIRCUMSTANCES WILL THERE BE CONSEQUENTIAL OR PUNITIVE DAMAGES. SOME STATES DO NOT ALLOW THE EXCLUSION OR LIMITATION OF PUNITIVE, INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE PRIOR LIMITATION OR EXCLUSION MAY NOT APPLY TO YOU.</p>
                    <p>18. <b>Termination</b></p>
                    <p>We may terminate or suspend your account and bar access to Service immediately, without prior notice or liability, under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach of Terms.</p>
                    <p>If you wish to terminate your account, you may simply discontinue using Service.</p>
                    <p>All provisions of Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>
                    <p>19. <b>Governing Law</b></p>
                    <p>These Terms shall be governed and construed in accordance with the laws of Philippines, which governing law applies to agreement without regard to its conflict of law provisions.</p>
                    <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service and supersede and replace any prior agreements we might have had between us regarding Service.</p>
                    <p>20. <b>Changes To Service</b></p>
                    <p>We reserve the right to withdraw or amend our Service, and any service or material we provide via Service, in our sole discretion without notice. We will not be liable if for any reason all or any part of Service is unavailable at any time or for any period. From time to time, we may restrict access to some parts of Service, or the entire Service, to users, including registered users.</p>
                    <p>21. <b>Amendments To Terms</b></p>
                    <p>We may amend Terms at any time by posting the amended terms on this site. It is your responsibility to review these Terms periodically.</p>
                    <p>Your continued use of the Platform following the posting of revised Terms means that you accept and agree to the changes. You are expected to check this page frequently so you are aware of any changes, as they are binding on you.</p>
                    <p>By continuing to access or use our Service after any revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you are no longer authorized to use Service.</p>
                    <p>22. <b>Waiver And Severability</b></p>
                    <p>No waiver by Company of any term or condition set forth in Terms shall be deemed a further or continuing waiver of such term or condition or a waiver of any other term or condition, and any failure of Company to assert a right or provision under Terms shall not constitute a waiver of such right or provision.</p>
                    <p>If any provision of Terms is held by a court or other tribunal of competent jurisdiction to be invalid, illegal or unenforceable for any reason, such provision shall be eliminated or limited to the minimum extent such that the remaining provisions of Terms will continue in full force and effect.</p>
                    <p>23. <b>Acknowledgement</b></p>
                    <p>BY USING SERVICE OR OTHER SERVICES PROVIDED BY US, YOU ACKNOWLEDGE THAT YOU HAVE READ THESE TERMS OF SERVICE AND AGREE TO BE BOUND BY THEM.</p>
                    <p>24. <b>Contact Us</b></p>
                    <p>Please send your feedback, comments, requests for technical support by email: <b>binyangxitea@gmail.com</b>.</p>
                                    </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" data-dismiss="modal" style="background-color:#ff8a5d;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                  <button type="submit" class="btn btn-light btn-lg submit_register"
                    data-mdb-ripple-color="dark" name="submit_register" id="submit_register" disabled>Register</button>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    </div>
  </div>
</section>


<!-- <div class="container-fluid bg-trasparent my-4 p-4" style="position: relative; background-image:url('kape.jpg');"> 
    <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-2 g-3" id="register_form" style="width:800px; position:relative; left: 80px;"> 
            <div class="col" style="width: 18rem;" id="reg1">
              <div class="d-flex justify-content-center">
              <form id="reg_form" action="process.php" method="post" enctype="multipart/form-data">

                  <h5 class="fw-normal mb-2 pb-2 mt-3" style="letter-spacing: 1px;" >Register</h5>

                  <div class="form-outline mb-1">
                  <label class="form-label" style="margin:0;" >Email Address</label>
                    <input type="email" id="email" class="form-control form-control-sm" name="email" placeholder="" required/>
                  </div>

                  <div class="form-outline mb-1">
                  <label class="form-label" style="margin:0;" >Password</label>
                    <input type="password"  class="form-control form-control-sm" name="password"  required/>
                  </div>

                  <div class="form-outline mb-1">
                  <label class="form-label" style="margin:0;" >Confirm password</label>
                    <input type="password" class="form-control form-control-sm" name="password2"  required/>
                  </div>

                  <div class="form-outline mb-1">
                  <label class="form-label" style="margin:0;" >Mobile number</label>
                    <input type="number" class="form-control form-control-sm" name="mobile"  required  maxlength = "11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
                  </div>

                  <div class="form-outline mb-1">
                  <label class="form-label" style="margin:0;" >Full name</label>
                    <input type="text"  class="form-control form-control-sm" name="name" required/>
                  </div>
                  <div class="form-outline mb-1">
                    <label class="form-label" style="margin:0;" >Profile Photo</label>
                    <input type="file"  id="profile_photo" accept="image/gif, image/jpeg, image/png" name="image" class="form-control" > 
                  </div>      

                </div>
            </div>
            <div class="col" id="reg2">
                <div class="form-outline mb-1 mt-5" style="margin:0;">
                      <label class="form-label" style="margin:0;" >Street Address (Street, Floor/Unit/Room #)</label>
                      <input type="text"  class="form-control form-control-sm Street" required style="margin:0;"/>
                    </div>

                    <div class="form-outline mb-1" style="margin:0;">
                      <label class="form-label" style="margin:0;" >Landmark (optional)</label>
                      <input type="text"  class="form-control form-control-sm Landmark"  style="margin:0;"/>
                    </div>

                    <div class="form-outline mb-1" style="margin:0;">
                      <label class="form-label" style="margin:0;" >Town / City</label>
                      <input type="text"  class="form-control form-control-sm Town"   required style="margin:0;" value ='Biñan City, Laguna' disabled/>
                    </div>

                    <div class="form-outline mb-1" style="margin:0;">
                      <label class="form-label" style="margin:0;" >Country</label>
                      <input type="text"  class="form-control form-control-sm Country"  required style="margin:0;" value ='Philippines' disabled/>
                    </div>

                    <div class="form-outline mb-1" style="margin:0;">
                      <label class="form-label" style="margin:0;" >Postcode</label>
                      <input type="text"  class="form-control form-control-sm Postcode"  required style="margin:0;" value ='4024' disabled/>
                    </div>

                    <div class="form-outline mb-1"  style='pointer-events:none;'>
                      
                      <textarea name="address" id="delivery_address" cols="30" rows="3" class="form-control form-control-sm" placeholder="Address" required ></textarea>
                    </div>
                

            </div>
            <div class="pt-2 mb-3 mx-5" >
                      <button class="btn btn-success btn-md btn-block submit_register" type="submit" name="submit_register" style="float:right" id="reg_button">Register</button>
            </div>
            </form>
    </div>
</div> -->



<!-- <section class="vh-100" id="hero" >
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-5 text-black" id="register_form">

        <div class="d-flex align-items-center h-custom-2 px-2 ms-xl-4 mt-1 pt-1 pt-xl-0 mt-xl-n1">

          <form id="reg_form"style="width: 23rem;" action="process.php" method="post" enctype="multipart/form-data">

            <h5 class="fw-normal mb-2 pb-2 mt-3" style="letter-spacing: 1px;" >Register</h5>

            <div class="form-outline mb-1">
            <label class="form-label" style="margin:0;" >Email Address</label>
              <input type="email" id="email" class="form-control form-control-sm" name="email" placeholder="" required/>
            </div>

            <div class="form-outline mb-1">
            <label class="form-label" style="margin:0;" >Password</label>
              <input type="password"  class="form-control form-control-sm" name="password"  required/>
            </div>

            <div class="form-outline mb-1">
            <label class="form-label" style="margin:0;" >Confirm password</label>
              <input type="password" class="form-control form-control-sm" name="password2"  required/>
            </div>
            
            <div class="form-outline mb-1">
            <label class="form-label" style="margin:0;" >Mobile number</label>
              <input type="number" class="form-control form-control-sm" name="mobile"  required  maxlength = "11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
            </div>
            
            <div class="form-outline mb-1">
            <label class="form-label" style="margin:0;" >Full name</label>
              <input type="text"  class="form-control form-control-sm" name="name" required/>
            </div>
            <div class="form-outline mb-1">
              <label class="form-label" style="margin:0;" >Profile Photo</label>
              <input type="file"  id="profile_photo" accept="image/gif, image/jpeg, image/png" name="image" class="form-control" > 
            </div>      
        </div>
      </div>

      <div class="col-sm-5 text-black mx-4" id="register_form">
        <div class="justify-content-center">
                <div class="form-outline mb-1 mt-5" style="margin:0;">
                  <label class="form-label" style="margin:0;" >Street Address (Street, Floor/Unit/Room #)</label>
                  <input type="text"  class="form-control form-control-sm Street" required style="margin:0;"/>
                </div>

                <div class="form-outline mb-1" style="margin:0;">
                  <label class="form-label" style="margin:0;" >Landmark (optional)</label>
                  <input type="text"  class="form-control form-control-sm Landmark"  style="margin:0;"/>
                </div>

                <div class="form-outline mb-1" style="margin:0;">
                  <label class="form-label" style="margin:0;" >Town / City</label>
                  <input type="text"  class="form-control form-control-sm Town"   required style="margin:0;" value ='Biñan City, Laguna' disabled/>
                </div>

                <div class="form-outline mb-1" style="margin:0;">
                  <label class="form-label" style="margin:0;" >Country</label>
                  <input type="text"  class="form-control form-control-sm Country"  required style="margin:0;" value ='Philippines' disabled/>
                </div>

                <div class="form-outline mb-1" style="margin:0;">
                  <label class="form-label" style="margin:0;" >Postcode</label>
                  <input type="text"  class="form-control form-control-sm Postcode"  required style="margin:0;" value ='4024' disabled/>
                </div>

                <div class="form-outline mb-1"  style='pointer-events:none;'>
                  
                  <textarea name="address" id="delivery_address" cols="30" rows="3" class="form-control form-control-sm" placeholder="Address" required ></textarea>
                </div>
                <div class="pt-2 mb-3 mx-5" style="float:right">
                  <button class="btn btn-info btn-lg btn-block submit_register" type="submit" name="submit_register">Register</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</section> -->
  
        
</body>

 
<?php include('footer.php');?>

<script>
  // document.getElementById("email").focus();

  $(document).ready(function () {
    
    swal({
        title: "Notice.",
        text: "Bin Yang only takes orders within Biñan. Are you sure you want to register?",
        icon: "info",
        buttons: "OK",
        dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
         $('#email').focus();
      } 
    });


    //d kaya dahil sa file upload
    // $('#reg_form').on('submit',function (e) {
    //   e.preventDefault();
    //   console.log('submit_register');
    //   var delivery_address = $('#delivery_address').val();
    //     console.log(delivery_address);
    //   if(delivery_address!=''){

    //     console.log(delivery_address);
    //     var check_location_1 = delivery_address.includes("biñan");
    //     var check_location_2 = delivery_address.includes("binan");
    //     console.log(check_location_1);
    //     console.log(check_location_2);

    //     //continue submitting
    //     e.currentTarget.submit();
    //   }
    // });

    $('#delivery_address').text(
      $('.Street').val()+" "+
      $('.Landmark').val()+" "+
      $('.Town').val()+" "+
      $('.Country').val()+" "+
      $('.Postcode').val()+" "
    );

    $('.Street, .Landmark').on('keyup',function (e) {
        console.log('street');
        $('#delivery_address').text(
          $('.Street').val()+" "+
          $('.Landmark').val()+" "+
          $('.Town').val()+" "+
          $('.Country').val()+" "+
          $('.Postcode').val()+" "
        );
    });

    $('#email').on('keyup',function (e) {
      var email = $(this).val();
      console.log(email);
      console.log(email.length);
      if(email.length>=10){
        
        $.ajax({
            method: "POST",
            url: "process.php",
            data: {
                'check_email' : 1,
                'email' : email,
            },
            success: function (response) {
                // console.log(response); //for debug
                var obj = JSON.parse(response);

                if(obj.system_message=="Available"){
                  $('#email_validation').text(obj.system_message).addClass('text-success fw-bold');
                }else{
                  $('#email_validation').text(obj.system_message).addClass('text-danger fw-bold');
                }
            }
        });
      }

    });

  });

  $('.password, .password2').on('keyup',function (e) {
    var password = $('.password').val();
    var password2 = $('.password2').val();
    // console.log(password.length);

    if(password.length>1){

      if(password.length<8){
        $('#password_validation').html("<br> Your password should be more than 8 characters").addClass('text-danger fw-bold')
        $('#submit_register').attr('disabled', true);
      }else{
        $('#submit_register').attr('disabled', false);
        $('#password_validation').html("").removeClass('text-danger fw-bold')

        if(password.length>20){
          $('#password_validation').html("<br> Your password should be less than 20 characters").addClass('text-danger fw-bold')
          $('#submit_register').attr('disabled', true);
        }else{
          $('#submit_register').attr('disabled', false);
          $('#password_validation').html("").removeClass('text-danger fw-bold')
        }
      }

    }else{
      $('#password_validation').html("").removeClass('text-danger fw-bold')
    }
      


    if(password2.length>1){

      if(password2.length<8){
        $('#password2_validation').html("<br> Your password should be more than 8 characters").addClass('text-danger fw-bold')
        $('#submit_register').attr('disabled', true);
      }else{
        $('#submit_register').attr('disabled', false);
        $('#password2_validation').html("").removeClass('text-danger fw-bold')

        if(password2.length>20){
          $('#password2_validation').html("<br> Your password should be less than 20 characters").addClass('text-danger fw-bold')
          $('#submit_register').attr('disabled', true);
        }else{
          $('#submit_register').attr('disabled', false);
          $('#password2_validation').html("").removeClass('text-danger fw-bold')
        }
      }

    }else{
      $('#password2_validation').html("").removeClass('text-danger fw-bold')
    }


    if(password.length>=8 && password2.length>=8){
      if(password!=password2){
        $('#passwords_validation').html("<br> Password did not match.").addClass('text-danger fw-bold').fadeOut(200).fadeIn(200);
      }else{
        $('#passwords_validation').html("").removeClass('text-danger fw-bold').fadeOut(200);
      }
    }else{
      $('#passwords_validation').html("").removeClass('text-danger fw-bold').fadeOut(200);
    }


  });


  $('#terms').click(function () {
    //check if checkbox is checked
    if ($(this).is(':checked')) {
        
        $('#submit_register').removeAttr('disabled'); //enable input
        
    } else {
        $('#submit_register').attr('disabled', true); //disable input
    }
  });
</script>