<?php 
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = mysqli_query($conn, "SELECT * FROM `user_form` WHERE user_id = '$user_id'") or die('Query failed');
$user_data = mysqli_fetch_assoc($user_query);

// Handle form submission for updating user info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

    // Debugging output
    error_log("Name: $name");
    error_log("Email: $email");
    error_log("Password: $password");

    if (!empty($name) && !empty($email) && !empty($password)) {
        $profile_image = null;
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $image_data = file_get_contents($_FILES['profile_image']['tmp_name']);
            if ($image_data !== false) {
                $profile_image = mysqli_real_escape_string($conn, $image_data);
            } else {
                error_log("Failed to read image data.");
            }
        } elseif (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            error_log("File upload error: " . $_FILES['profile_image']['error']);
        }

        if ($profile_image) {
            $update_query = "UPDATE `user_form` SET name = '$name', email = '$email', password = '$password', profile_image = '$profile_image' WHERE user_id = '$user_id'";
        } else {
            $update_query = "UPDATE `user_form` SET name = '$name', email = '$email', password = '$password' WHERE user_id = '$user_id'";
        }

        if (mysqli_query($conn, $update_query)) {
            $_SESSION['user_name'] = $name; // Update session name
            echo "<script>alert('Profile updated successfully!');</script>";
            header("Location: profile.php"); // Redirect back to profile page
            exit;
        } else {
            echo "<script>alert('Failed to update profile.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
    <div class="main-container">
        <div class="middle-container container" style="margin: 0 auto; margin-top: 50px;">
            <div class="profile block">
                <h1 class="user-name">Edit Profile</h1>
                <form method="POST" action="" class="edit-profile-form" enctype="multipart/form-data">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $user_data['name']; ?>" required><br><br>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required><br><br>

                    <label for="profile_image">Profile Image:</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*"><br><br>
                    
                    <button type="submit" class="subscribe button" style="color: white">Update Profile</button>
                </form>
                <a class="subscribe button" href="profile.php" style="color: white; margin-top: 10px;">Back to Profile</a>
            </div>
        </div>
    </div>
</body>
</html>

