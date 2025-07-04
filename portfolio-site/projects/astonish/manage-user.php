<?php 
include_once('includes/config.php');

// For deleting    
if(isset($_GET['del'])){
$u_id=$_GET['u_id'];

mysqli_query($con,"delete from user_form where user_id ='$u_id'");
echo "<script>alert('Data Deleted');</script>";
echo "<script>window.location.href='manage-user.php'</script>";
          }

if (isset($_POST['add_user'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = mysqli_real_escape_string($con, $_POST['user_type']);

    $query = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('User added successfully');</script>";
        echo "<script>window.location.href='manage-user.php'</script>";
    } else {
        echo "<script>alert('Error adding user');</script>";
    }
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
    <body class="sb-nav-fixed">
 <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
       <?php include_once('includes/leftbar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Manage User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage User</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-user-plus me-1"></i>
                                Add New User
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="user_type" class="form-label">User Type</label>
                                            <select class="form-control" id="user_type" name="user_type" required>
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               User Details
                            </div>
                            <div class="card-body table-responsive">
                            <table id="datatablesSimple" class="table table-striped table-bordered" >
                                    <thead>
                                        <tr>
                                        <th>Sr. no.</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>Sr. no.</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                   
                                    $query=mysqli_query($con,"SELECT * FROM user_form WHERE user_type='user' ");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>    

                                        <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row['user_id']);?></td> 
                                            <td><?php echo htmlentities($row['name']);?></td> 
                                            <td><?php echo htmlentities($row['email']);?></td>  
                                            <td><?php echo htmlentities($row['user_type']);?></td>                                          <td>
                                            <a href="update-user.php?u_id=<?php echo $row['user_id']?>"><i class="fas fa-edit"></i></a> | 
                                            <a href="manage-user.php?u_id=<?php echo $row['user_id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        </tr>
                                        <?php $cnt=$cnt+1; } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<?php include_once('includes/footer.php');?>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="assets/js/datatables-simple-demo.js"></script>
    </body>
</html>
