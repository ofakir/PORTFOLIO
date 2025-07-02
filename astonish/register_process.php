<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Handle profile image upload
    $profile_image = null; // Default to null
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $image_data = file_get_contents($_FILES['profile_image']['tmp_name']);
        $profile_image = mysqli_real_escape_string($con, $image_data);
    }

    // Insert user data into the database
    $sql = "INSERT INTO user_form (name, email, password, profile_image) VALUES ('$username', '$email', '$password', '$profile_image')";
    if (mysqli_query($con, $sql)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>