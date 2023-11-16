<?php
/**
 * Template Name: Projects Archive
 */
get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="project-cards">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $proj_args = array(
                'post_type'      => 'projects',
                'posts_per_page' => 6,
                'paged'          => $paged,
                'order'          => 'ASC',
                'orderby'        => 'date',
            );
            $query = new WP_Query($proj_args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post(); ?>
                    <div class="project-card">
                        <?php if (has_post_thumbnail()) {?>
                            <div class="project-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php }
                        else{
                         ?>
                         <div class="project-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                   <img src="<?php echo get_template_directory_uri() .'/assets/images/project-image.png';?>"> 
                                </a>
                            </div>
                            <?php }
                            ?>
                        <div class="project-details">
                            <h3 class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="project-meta">
                                <span class="project-author">Author: <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>"><?php the_author(); ?></a></span>
                                <span class="project-date">Date: <?php the_time('jS F Y') ?></span>
                            </p>
                            <div class="project-description">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                // Pagination
                echo '<div class="pagination">';
                echo paginate_links(array(
                    'total'     => $query->max_num_pages,
                    'current'   => max(1, get_query_var('paged')),
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                ));
                echo '</div>';

                wp_reset_postdata();
            } else {
                echo '<p>No projects found.</p>';
            }
            ?>
        </div>
    </main>
</div>

<?php

function hs_give_me_coffee() {
    $response = wp_remote_get('https://api.kanye.rest/');
    
    if (is_wp_error($response)) {
        return 'There is an error while fetching Kanye West quotes.';
    }

    $body = wp_remote_retrieve_body( $response );
    $body = json_decode( $body);

    if (!$body || empty($body->quote)) {
        return 'No Kanye West quotes available.';
    }

    return $body->quote;
}
?>
<div id="kanye-quotes">
    <h3> Five Quotes </h3>
    <?php
    for ($i = 0; $i < 5; $i++) {
        echo '<p>' . hs_give_me_coffee() . '</p>';
    }
    ?>
    <?php

