<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Astonish</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">

  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <?php 
      include('header.php');
   ?>

    <!-- Page Content -->
   
      <div class="container">
        <div class="row">
        </div>
      </div>

    <div class="products">
      <div class="container">
        <div class="search-bar" style="margin: 20px 0; display: flex; justify-content: center; align-items: center;">
          <form method="GET" action="" style="display: flex; width: 100%; max-width: 600px;">
            <input type="text" name="search" placeholder="Search for products..." class="form-control" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px 0 0 4px; font-size: 16px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border: none; background-color: #007bff; color: #fff; font-size: 16px; border-radius: 0 4px 4px 0; cursor: pointer; transition: background-color 0.3s ease;">Search</button>
          </form>
        </div>
        <div class="row">

        <?php
        include('connection.php');
        $search_query = "";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $search_query = " WHERE p_name LIKE '%$search%' OR p_desc LIKE '%$search%'";
        }

        // Pagination settings
        $products_per_page = 6; // Number of products per page
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL, default to 1
        $offset = ($current_page - 1) * $products_per_page; // Calculate offset for SQL query

        // Get total number of products
        $total_products_query = "SELECT COUNT(*) AS total FROM products" . $search_query;
        $total_products_result = mysqli_query($conn, $total_products_query);
        $total_products_row = mysqli_fetch_assoc($total_products_result);
        $total_products = $total_products_row['total'];

        // Calculate total pages
        $total_pages = ceil($total_products / $products_per_page);

        // Fetch products for the current page
        $sql = "SELECT * FROM products" . $search_query . " LIMIT $offset, $products_per_page";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Loop through each row and print the product data
            while ($row = mysqli_fetch_assoc($result)) {
                $p_id = $row['p_id'];
                $p_name = $row['p_name'];
                $p_img = $row['p_img'];
                $p_mrp = $row['p_mrp'];
                $p_price = $row['p_price'];
                $p_desc = $row['p_desc'];
                ?>

              <div class="col-md-4">
                <div class="product-item">
                  <a href="product-details.php?p_id=<?php echo $p_id; ?>"><img src="assets\product-image\<?php echo $p_img; ?>" alt=""></a>
                  <div class="down-content">
                    <a href="product-details.php?p_id=<?php echo $p_id; ?>"><h4><?php echo $p_name; ?></h4></a>
                    <h6><small><del><?php echo $p_mrp; ?> DH</del></small><?php echo $p_price; ?> DH</h6>
                    <p><?php echo $p_desc; ?></p>
                  </div>
                </div>
              </div>  


                   <?php }
        } else {
            echo "<p>No products found.</p>";
        }
        mysqli_free_result($result);
        mysqli_close($conn);
      ?>   

          
          <div class="col-md-12">
            <ul class="pages">
              <?php if ($current_page > 1): ?>
                  <li><a href="?page=<?php echo $current_page - 1; ?>"><i class="fa fa-angle-double-left"></i></a></li>
              <?php endif; ?>

              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li class="<?php echo ($i == $current_page) ? 'active' : ''; ?>">
                      <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
              <?php endfor; ?>

              <?php if ($current_page < $total_pages): ?>
                  <li><a href="?page=<?php echo $current_page + 1; ?>"><i class="fa fa-angle-double-right"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <?php 
      include('footer.php');
   ?>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Book Now</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="contact-form">
              <form action="#" id="contact">
                  <div class="row">
                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Pick-up location" required="">
                          </fieldset>
                       </div>

                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Return location" required="">
                          </fieldset>
                       </div>
                  </div>

                  <div class="row">
                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Pick-up date/time" required="">
                          </fieldset>
                       </div>

                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Return date/time" required="">
                          </fieldset>
                       </div>
                  </div>
                  <input type="text" class="form-control" placeholder="Enter full name" required="">

                  <div class="row">
                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Enter email address" required="">
                          </fieldset>
                       </div>

                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Enter phone" required="">
                          </fieldset>
                       </div>
                  </div>
              </form>
           </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Book Now</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
  </body>

</html>
