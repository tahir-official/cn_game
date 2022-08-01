<?php
include_once('include/function.php'); 
$db = new functions();

$appUrls = $db->fetch_record_by_order('application_platforms', Null,'order by id desc');
$homeContents = $db->fetch_record_by_order('home_page_contents', Null,'order by id desc');
$other_content = $db->fetch_record('other_content', Null);
$other_content=$other_content[0];

$page_content = $db->fetch_record('page_content', Null);
$page_content = $page_content[0];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Mokia Club</title>

<!-- Begin Jekyll SEO tag v2.6.1 -->
  <meta name="generator" content="Jekyll v4.1.0" />
  <meta property="og:locale" content="en" />
  <link rel="canonical" href="index.php" />
  <meta property="og:url" content="index.php" />

  <meta name="viewport" content="width=device-width">
  <link rel="icon" type="image/png" sizes="32x32" href="admin/img/favicon-32x32.png">

  <link rel="stylesheet" href="assets/scss/main.css">


  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">


<style>.async-hide { opacity: 0 !important}
.s3{
  display: block;
    font-size: 1.5rem;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
    font-family: "brandon",Helvetica,sans-serif;
    line-height: 25px;
    color: #2d2d2d;
    margin-top:15px;
}
.s2{
font-size: 4.5rem !important;
    line-height: 5rem !important;
    font-family: "brandon-medium",Helvetica,sans-serif;
    line-height: 4rem;
    letter-spacing: -0.7px;
    margin-bottom: 30px;
    display: block;
    font-size: 2em;
    margin-block-start: 0.67em;
    margin-block-end: 0.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
    color: #2d2d2d;
}
.p1{
  font-size: 1.3rem;
  display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    color: #2d2d2d;
}
/*.mono1{
      margin-top: 10px;
}*/
.mono1 a
 {
  font-family: "brandon",Helvetica,sans-serif;
    margin-left: 30px;
 }

.mono-left{
  width: 25%;
}
.phone{
  margin-top: 30px;
}

 </style>


</head>
  <body class="homepage">
   
<div class="special">
	

<div class="header">
    <div class="container">
        <div class="grid">
            <div class="col-3 mono-left">
                <img src="admin/img/logo.png" class="logo hide-xs" alt="Mokia Club">
                <img src="admin/img/logo.png" class="logo--small visible-xs" alt="Mokia Club">
            </div>

            <div class="col-9 right">
              <div class="mono1">
                <?php
                  foreach($appUrls as $appUrl){
                ?>
                    <a href="<?=$appUrl['app_url'];?>">
                      <img style="width: 145px;margin-top: 31px;" src="<?=$appUrl['image'];?>" class="download__icon" alt="Google Play">
                    </a>
                <?php
                  }
                ?>
              </div>
            </div>
        </div>
    </div>
</div>

<?php
  foreach($homeContents as $serialNumber => $homeContent){
  	
    $number = $serialNumber + 1;
?>
    <div class="section welcome sleep" <?php if($serialNumber==0){ echo 'style="margin-top: 72px;"';} ?> >
      <div class="container">
        <div class="grid">
          <div class="wrapper">
            <?php
              if($number % 2 != 0){
            ?>
                <div class="col-sm-6">
                  <h3 class="s3"><?=$homeContent['sub_heading'];?></h3>
                  <h1 class="s2"><?=$homeContent['heading'];?></h1>
                  <p class="p1"><?=$homeContent['description'];?></p>
                  <?php
                    if(trim($homeContent['url'])){
                  ?>
                      <a href="<?=$homeContent['url'];?>" class="button">
                        View More
                      </a>
                  <?php
                    }
                  ?>
                </div>
                <div class="col-sm-6 hide-xs">
                  <div class="phone-holder">
                    <div class="phone">
                      <!-- <video autoplay autobuffer="" muted="" playsinline="" poster="assets/img/homepage/iphone_welcome_bg.jpg">
                        <source src="<?=$homeContent['video'];?>" type="video/mp4">
                        Your browser does not support the video tag.
                      </video> -->
                      <img  src="<?=$homeContent['video'];?>" >
                    </div>
                  </div>
                </div>
            <?php
              }else{
            ?>
                <div class="col-sm-6">
                  <div class="phone-holder">
                    <div class="phone">
                      <!-- <video autoplay autobuffer="" muted="" playsinline="" poster="assets/img/homepage/iphone_exercise_bg.jpg">
                        <source src="<?=$homeContent['video'];?>" type="video/mp4">
                        Your browser does not support the video tag.
                      </video> -->
                      <img  src="<?=$homeContent['video'];?>" >
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 space--top">
                  <h3 class="s3"><?=$homeContent['sub_heading'];?></h3>
                  <h2 class="s2"><?=$homeContent['heading'];?></h2>
                  <p class="p1"><?=$homeContent['description'];?></p>
                </div>
            <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
<?php
  }
?>
<div class="section download">
      <div class="container">
        <div class="grid">
          <div class="wrapper">
            <div class="col-sm-6">
              <img src="assets/img/homepage/ratings.png" class="download__rating" alt="Rating Asana Rebel" style="display:none;" >
              <h2><?=html_entity_decode($other_content['upper_footer_section'], ENT_QUOTES)?></h2>

              <div class="grid">
                <div class="col-sm-12">
                  <?php
                    foreach($appUrls as $appUrl){
                  ?>
                      <a href="<?=$appUrl['app_url'];?>">
                        <img class="download__icon" src="<?=$appUrl['image'];?>" class="download__icon" alt="<?=$appUrl['platform'];?>">
                      </a>
                  <?php
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div> 
    	<!-- <section id="contact" class="contact">
      <div class="container">

        

        <div class="row">

          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-6 info aos-init aos-animate" data-aos="fade-up">
                <i class="bx bx-map"></i>
                <h4>Address</h4>
                <p><?=html_entity_decode($other_content['address'], ENT_QUOTES)?></p>
              </div>
              <div class="col-lg-6 info aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <i class="bx bx-phone"></i>
                <h4>Call Us</h4>
                <p><?=html_entity_decode($other_content['call_detail'], ENT_QUOTES)?></p>
              </div>
              
            </div>
          </div>


        </div>

      </div>
    </section> -->

    <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          

        	
          <div class="col-lg-3 col-md-6 footer-links aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#" data-toggle="modal" data-target="#aboutModal">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#" data-toggle="modal" data-target="#termsModal" >Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#" data-toggle="modal" data-target="#privacyModal">Privacy policy</a></li>
            </ul>
          </div>

        
          <div class="col-lg-3 col-md-6 footer-links aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
          </div>
          <div class="col-lg-3 col-md-6 footer-links aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
          </div>
          <div class="col-lg-3 col-md-6 footer-links aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
            <h4>Our Social Networks</h4>
            <!-- <p><?=html_entity_decode($other_content['social_network_section'], ENT_QUOTES)?></p> -->
            <div class="social-links mt-3">
              <?php
              $social_links = $db->fetch_record_by_order('social_link', Null,'order by id asc');
              foreach ($social_links as  $social_link) {
              	?>
              	<a href="<?=$social_link['social_link']?>" ><i class="<?=$social_link['fa_icon']?>"></i></a>
              	<?php
              }
              ?>
              
              
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="container py-4" style="text-align: center;">
      <!-- <div class="copyright">
      	<?=html_entity_decode($other_content['Copyright_text'], ENT_QUOTES)?>
        
      </div> -->
      <?=html_entity_decode($other_content['Copyright_text'], ENT_QUOTES)?>
    </div>
  </footer>


<!-- About Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">About Us</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
       <?=html_entity_decode($page_content['about_content'], ENT_QUOTES)?>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div> 

<!-- terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Terms Conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
       <?=html_entity_decode($page_content['terms_conditions_content'], ENT_QUOTES)?>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>


<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Privacy Policy</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
       <?=html_entity_decode($page_content['privacy_content'], ENT_QUOTES)?>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>  

<script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/js/main.js"></script> 
  </body>
</html>