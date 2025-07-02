<?php
@include 'connection.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    $query = "SELECT profile_image FROM user_form WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['profile_image'])) {
            // Log the length of the binary data
            error_log("Profile image length: " . strlen($row['profile_image']));

            header("Content-Type: image/png"); // Adjust MIME type if needed
            echo $row['profile_image'];
        } else {
            error_log("No profile image found for user ID: $user_id");
            header("Content-Type: image/png");
            readfile("assets/images/default-profile.png"); // Default image
        }
    } else {
        error_log("No user found with ID: $user_id");
        http_response_code(404);
        echo "Image not found.";
    }
} else {
    error_log("Invalid request: No user ID provided");
    http_response_code(400);
    echo "Invalid request.";
}
?>
