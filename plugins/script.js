jQuery(document).ready(function($) {
    // AJAX function to fetch and display student details
    $('.student-details').on('click', function(e) {
        e.preventDefault();
        var studentId = $(this).data('id');
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'get_student_details',
                student_id: studentId
            },
            success: function(response) {
                $('#studentDetailsBody').html(response);
                $('#studentDetailsModal').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.error(xhr.responseText);
            }
        });
    });
});

