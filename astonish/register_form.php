<?php

@include 'connection.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $profile_image = null; // Default to null
   if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
       $image_data = file_get_contents($_FILES['profile_image']['tmp_name']);
       if ($image_data === false) {
           die('Failed to read image data.');
       }
   } else {
       die('Image upload failed: ' . $_FILES['profile_image']['error']);
   }

   $select = "SELECT * FROM user_form WHERE email = ? AND password = ?";
   $stmt = mysqli_prepare($conn, $select);
   mysqli_stmt_bind_param($stmt, 'ss', $email, $pass);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type, profile_image) VALUES(?, ?, ?, ?, ?)";
         $stmt = mysqli_prepare($conn, $insert);
         mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $pass, $user_type, $image_data);
         mysqli_stmt_send_long_data($stmt, 4, $image_data);
         mysqli_stmt_execute($stmt);
         header('location:login_form.php');
      }
   }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/login.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="enter your name">
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <select name="user_type">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <div class="form-group">
         <label for="profile_image">Profile Image</label>
         <input type="file" name="profile_image" id="profile_image" class="form-control" required>
      </div>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>

</body>
</html>