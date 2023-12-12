//users page
$(document).ready(function() {
    $(".approve-button").click(function() {
        var userId = $(this).data("user-id");

        // Make an AJAX request to update user approval status
        $.ajax({
            url: "update_user.php", // Create a new PHP file for handling this request
            method: "POST",
            data: { userId: userId, action: "approve" },
            success: function(response) {
                // Handle the response if needed
                console.log(response);
            }
        });
    });

    $(".reject-button").click(function() {
        var userId = $(this).data("user-id");

        // Make an AJAX request to delete the user
        $.ajax({
            url: "update_user.php", // Create a new PHP file for handling this request
            method: "POST",
            data: { userId: userId, action: "reject" },
            success: function(response) {
                // Handle the response if needed
                console.log(response);
            }
        });
    });

    $(".admin-button").click(function() {
        var userId = $(this).data("user-id");

        // Make an AJAX request to update user admin status
        $.ajax({
            url: "update_user.php",
            method: "POST",
            data: { userId: userId, action: "make_admin" },
            success: function(response) {
                // Handle the response if needed
                console.log(response);
                // You can update the UI or perform other actions based on the response
            }
        });
    });
});