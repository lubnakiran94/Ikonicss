<!doctype html>
<html lang="en">

<head>
    <!-- Fonts -->    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <?php
      wp_head(); 
           
    ?>

</head>
 <body>
    
  <div class="col-12 col-xl-8 col-lg-8">
            <div class="row">  
              <div class="col-4 col-sm-2 col-lg-2">
                <a href=>    
                <img class="logo" src="<?php echo get_template_directory_uri() .'/assets/images/logo-brown.png';?>" alt="Your Logo" /></a>
              </div>
            <div class="col-6 col-sm-4 col-lg-3">
  <?php
wp_nav_menu(array(
    'theme_location' => 'custom-menu',
    'menu_class' => 'custom-menu-class',
));
?>
</div>
</div>
</div>
<?php
