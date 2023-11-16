<?php
/* Enqueuing  Theme Styles */
function proj_wp_theme_styles() {
    wp_enqueue_style( 'project_styles',  get_template_directory_uri() . '/assets/main-style.css');
    wp_enqueue_script( 'project_script',  get_template_directory_uri() . '/assets/main-script.js' ,array( 'jquery' ), false, true );                      
}
add_action( 'wp_enqueue_scripts', 'proj_wp_theme_styles' );

// Register a new sidebar simply named 'sidebar'
function add_widget_support() {
               register_sidebar( array(
                               'name'          => 'Sidebar',
                               'id'            => 'sidebar',
                               'before_widget' => '<div>',
                               'after_widget'  => '</div>',
                               'before_title'  => '<h2>',
                               'after_title'   => '</h2>',
               ) );
}

add_action( 'widgets_init', 'add_widget_support' );

// Register a new navigation menu
function add_Main_Nav() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}


add_action( 'init', 'add_Main_Nav' );
//Adding Menu Locations
function theme_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
        )
    );

    
    register_nav_menus(
        array(
            'footer-menu' => __('Footer Menu'),
        )
    );
    
}
add_action('init', 'theme_menus');


// /redirect the user away from the site
function redirect_user_by_ipaddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $ip_address_check = '77.29';

   
    if (strpos($ip, $ip_address_check) === 0) {
       
        wp_redirect('https://www.google.com.pk'); 
        exit;
    }
}


add_action('init', 'redirect_user_by_ipaddr');




function register_projects_post_type() {
    $labels = array(
        'name'               => __('Project'),
        'singular_name'      => __('Project'),
        'add_new'            => __('Add New'),
        'add_new_item'       => __('Add New Project'),
        'edit_item'          => __('Edit Project'),
        'new_item'           => __('New Project'),
        'view_item'          => __('View Project'),
        'search_items'       => __('Search Projects'),
        'not_found'           => __('Not Found'),
        'not_found_in_trash'  => __('Not found in Trash'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Projects')
    );

    $args = array(
        'label'               => __('Project'),
        'labels'              => $labels,
        'description'         => __('My tasks projects'),
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'projects'),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'comments', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields')
    );

    register_post_type('projects', $args);

    $labels_taxonomy = array(
        'name'              => _x( 'Project Type', 'taxonomy general name'),
        'singular_name'     => _x( 'Project Type', 'taxonomy singular name'),
        'search_items'      => __( 'Search Project Type'),
        'all_items'         => __( 'All Project Types'),
        'parent_item'       => __( 'Parent Project Type' ),
        'parent_item_colon' => __( 'Parent Project Type:' ),
        'edit_item'         => __( 'Edit Project Type' ),
        'update_item'       => __( 'Update Project Type'),
        'add_new_item'      => __( 'Add New Project Type' ),
        'new_item_name'     => __( 'New Project Type Name'),
        'menu_name'         => __( 'Project Type'),
    );

    register_taxonomy('project_type', array('projects'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Project Types'),
        'show_admin_column' => true,
        'labels'            => $labels_taxonomy,
        'query_var' => true,
        'rewrite' => array('slug' => 'proj_type'),
    ));
}

add_action('init', 'register_projects_post_type');


//ajax call


    add_action('wp_ajax_nopriv_get_architecture_projects', 'get_architecture_projects');
    add_action('wp_ajax_get_architecture_projects', 'get_architecture_projects');


//add_action('init', 'custom_ajax_endpoint');
function get_architecture_projects() {
    $is_logged_in = is_user_logged_in();
    $posts_per_page = $is_logged_in ? 6 : 3;

    $term_name = 'Architecture';
    $taxonomy = 'project_type';
    $term = get_term_by('name', $term_name, $taxonomy);

    if (!$term) {
       
        echo json_encode(array('success' => false, 'message' => 'Term not found'));
        wp_die();
    }

    $term_id = $term->term_id;

    $args = array(
        'post_type'      => 'projects',
        'posts_per_page' => $posts_per_page,
        'tax_query'      => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query($args);

    $projects_data = array();

    while ($query->have_posts()) {
        $query->the_post();

        $project_data = array(
            'id'    => get_the_ID(),
            'title' => get_the_title(),
            'link'  => get_permalink(),
        );

        $projects_data[] = $project_data;
    }

    wp_reset_postdata();

    

    wp_send_json_success(array('success'=>true, 'projects' => $projects_data));
}

