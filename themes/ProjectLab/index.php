<?php
get_header();
?>

<section class="white section-inner">
    <div class="inner-page-content">
        <div class="container">
            <div class="row">
                <div class="d-none d-md-block col-md-2">
                </div>
                <div class="col-12 col-md-8 inner-content">                   
                <?php 
                    echo get_the_content( );
                ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
  get_footer();