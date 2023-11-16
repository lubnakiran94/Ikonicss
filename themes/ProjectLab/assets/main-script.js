jQuery(document).ready(function ($) {
    var ajaxurl = $('#url').val();

    $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'get_architecture_projects',
        },
        success: function (response) {
            if (response.success) {
                var projects = response.data;
                console.log(projects);
            } else {
                console.log('Error retrieving projects.');
            }
        },
    });
});
