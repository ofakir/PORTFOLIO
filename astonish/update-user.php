<?php 
include_once('includes/config.php');

    //For Adding categories
    if (isset($_POST['submit'])) {
        
        $u_id = intval($_GET['u_id']);
        $u_name = $_POST['username'];
        $u_email = $_POST['useremail'];
        $u_type = $_POST['usertype'];

        $profile_image = $_FILES['profile_image']['name'] ?? '';
        if ($profile_image) {
            $target_dir = "assets/images/";
            $target_file = $target_dir . basename($profile_image);
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);
            $sql = "UPDATE user_form SET name='$u_name', email='$u_email', user_type='$u_type', profile_image='$profile_image' WHERE user_id ='$u_id'";
        } else {
            $sql = "UPDATE user_form SET name='$u_name', email='$u_email', user_type='$u_type' WHERE user_id ='$u_id'";
        }

        mysqli_query($con, $sql);
        echo "<script>alert('User Details updated');</script>";
        echo "<script>window.location.href='manage-user.php'</script>";
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Astonish</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="assets/css/admin_styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php include_once('includes/header.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/leftbar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Update User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update User</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <?php
                                $u_id = intval($_GET['u_id']);
                                
                                $query = mysqli_query($con, "select * from user_form where user_id='$u_id' ");
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-4">User ID</div>
                                            <div class="col-6"><input type="text"
                                                    value="<?php echo htmlentities($row['user_id']); ?>" name="userid"
                                                    class="form-control" required></div>

                                            <div class="col-4" style="margin-top:10px;">User Name</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="text"
                                                    value="<?php echo htmlentities($row['name']); ?>" name="username"
                                                    class="form-control" required></div>

                                            <div class="col-4" style="margin-top:10px;">User Email</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="email"
                                                    value="<?php echo htmlentities($row['email']); ?>" name="useremail"
                                                    class="form-control" required></div>

                                            <div class="col-4" style="margin-top:10px;">User Type</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="text"
                                                    value="<?php echo htmlentities($row['user_type']); ?>" name="usertype"
                                                    class="form-control" required></div>

                                            <div class="col-4" style="margin-top:10px;">Profile Image</div>
                                            <div class="col-6" style="margin-top:10px;"><input type="file" name="profile_image" class="form-control"></div>

                                        </div>

                                        <div class="row" style="margin-left:500px; margin-top:20px">
                                            <div class="col-2"><button type="submit" name="submit"
                                                    class="btn btn-primary">Update</button></div>
                                        </div>

                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="assets/js/datatables-simple-demo.js"></script>
    </body>

    </html>
