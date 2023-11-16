<?php
/**
 * Template Name: Architecture
 */
get_header(); 

?>

<div id="primary" class="content-area">
    <h3> Ajax Result </h3>
    <main id="main-proj" class="site-main" role="main">


    <script>
    jQuery(document).ready(function ($) {
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        var security = '<?php echo wp_create_nonce('my_nonce_action'); ?>';

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'get_architecture_projects',
                security: security,
            },
            success: function (response) {
                if (response.success) {
    var projects = response.data.projects;
    var mainDiv = $('#main-proj');
    mainDiv.empty();

    projects.forEach(function (project) {
        // Create a paragraph for each project
        var projectHTML =
            
            '<p>ID: ' + project.id + ', Title: <a href="' + project.link + '">' + project.title + '</a></p>';

        // Append the project HTML to the container
        mainDiv.append(projectHTML);
    });
}

            else {
                    console.log('Error retrieving projects.');
                }
            }
        });
    });
</script>	
<?php
