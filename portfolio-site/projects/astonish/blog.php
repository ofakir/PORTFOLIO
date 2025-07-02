<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Astonish</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <style>
        header {
            position: relative;
            top: -20px; /* Move the navbar slightly higher */
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Latest Blog Posts</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/blog-1-370x270.jpg" class="card-img-top" alt="Blog 1">
                    <div class="card-body">
                        <h5 class="card-title">Cleanse</h5>
                        <p class="card-text">Learn about the importance of cleansing your skin and the best products to use.</p>
                        <a href="#" class="btn btn-primary">Read More: Tips for a Healthy Skin</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/blog-2-370x270.jpg" class="card-img-top" alt="Blog 2">
                    <div class="card-body">
                        <h5 class="card-title">Treat</h5>
                        <p class="card-text">Discover effective treatments for common skin concerns like acne and dryness.</p>
                        <a href="#" class="btn btn-primary">Read More: Effective Skin Treatments</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="assets/images/blog-3-370x270.jpg" class="card-img-top" alt="Blog 3">
                    <div class="card-body">
                        <h5 class="card-title">Protect</h5>
                        <p class="card-text">Understand the importance of sun protection and how to choose the right sunscreen.</p>
                        <a href="#" class="btn btn-primary">Read More: Sunscreen Essentials</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
