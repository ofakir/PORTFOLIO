<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('includes/config.php');

// Debugging database connection
if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Calculate total revenue
$total_revenue = 0;
$revenue_query = mysqli_query($con, "SELECT SUM(total_price) AS revenue FROM orders WHERE status = 'Completed'") or die(mysqli_error($con));
if ($revenue_row = mysqli_fetch_assoc($revenue_query)) {
    $total_revenue = $revenue_row['revenue'] ?? 0;
}

// Fetch total stock
$total_stock = 0;
$stock_query = mysqli_query($con, "SELECT SUM(stock) AS total_stock FROM products") or die(mysqli_error($con));
if ($stock_row = mysqli_fetch_assoc($stock_query)) {
    $total_stock = $stock_row['total_stock'] ?? 0;
}

// Fetch recent orders
$recent_orders_query = mysqli_query($con, "
    SELECT orders.order_id, orders.total_price, user_form.name 
    FROM orders 
    JOIN user_form ON orders.user_id = user_form.user_id 
    ORDER BY orders.order_date DESC 
    LIMIT 5
") or die(mysqli_error($con));

// Fetch sales trend data
$sales_trend_query = mysqli_query($con, "
    SELECT MONTH(order_date) AS month, SUM(total_price) AS total_sales 
    FROM orders 
    WHERE status = 'Completed' 
    GROUP BY MONTH(order_date)
") or die(mysqli_error($con));

$sales_data = [];
while ($row = mysqli_fetch_assoc($sales_trend_query)) {
    $sales_data[$row['month']] = $row['total_sales'];
}

// Fetch low stock products
$low_stock_query = mysqli_query($con, "SELECT p_name, stock FROM products WHERE stock < 10 LIMIT 5") or die(mysqli_error($con));
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
    <?php include_once('includes/header.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/leftbar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <hr />
                    <div class="row">
                        <?php
                        $cart_number=0;  
                        $cart_number = mysqli_query($con, "SELECT * FROM `category`;") or die('query failed');
                        $cart_number = mysqli_num_rows($cart_number); 

                        $product_number=0;  
                        $product_number = mysqli_query($con, "SELECT * FROM `products`;") or die('query failed');
                        $product_number = mysqli_num_rows($product_number);

                        $order_number=0;  
                        $order_number = mysqli_query($con, "SELECT * FROM `orders`;") or die('query failed');
                        $order_number = mysqli_num_rows($order_number);

                        $user_number=0;  
                        $user_number = mysqli_query($con, "SELECT * FROM `user_form`;") or die('query failed');
                        $user_number = mysqli_num_rows($user_number);

                        $testimonial_number=0;  
                        $testimonial_number = mysqli_query($con, "SELECT * FROM `testimonial`;") or die('query failed');
                        $testimonial_number = mysqli_num_rows($testimonial_number);
                        ?>
                        <div class="col-lg-6 col-xl-2 mb-4"></div>

                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card bg-dark text-white h-100" style="border-radius:20px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Listed Categories<sapn style="font-size:20px; margin-left:170px;"><?php echo $cart_number; ?></span></div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                            <path fill="currentColor" d="M14 25h14v2H14zm-6.83 1l-2.58 2.58L6 30l4-4l-4-4l-1.42 1.41L7.17 26zM14 15h14v2H14zm-6.83 1l-2.58 2.58L6 20l4-4l-4-4l-1.42 1.41L7.17 16zM14 5h14v2H14zM7.17 6L4.59 8.58L6 10l4-4l-4-4l-1.42 1.41L7.17 6z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="manage-categories.php">View Details</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card bg-dark text-white h-100" style="border-radius:20px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Total Products<sapn style="font-size:20px; margin-left:180px;"><?php echo $product_number; ?></span></span></div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M22 3H2v6h1v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9h1V3zM4 5h16v2H4V5zm15 15H5V9h14v11zM9 11h6a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="manage-product.php">View Details</a>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card bg-dark text-white h-100" style="border-radius:20px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Orders<sapn style="font-size:20px; margin-left:230px;"><?php echo $order_number; ?></span></span></div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="currentColor" d="M4 16h12v2H4zm-2-5h10v2H2z"/>
                                        <path fill="currentColor" d="m29.919 16.606l-3-7A.999.999 0 0 0 26 9h-3V7a1 1 0 0 0-1-1H6v2h15v12.556A3.992 3.992 0 0 0 19.142 23h-6.284a4 4 0 1 0 0 2h6.284a3.98 3.98 0 0 0 7.716 0H29a1 1 0 0 0 1-1v-7a.997.997 0 0 0-.081-.394ZM9 26a2 2 0 1 1 2-2a2.002 2.002 0 0 1-2 2Zm14-15h2.34l2.144 5H23Zm0 15a2 2 0 1 1 2-2a2.002 2.002 0 0 1-2 2Zm5-3h-1.142A3.995 3.995 0 0 0 23 20v-2h5Z"/></svg>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="manage-orders.php">View Details</a>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card bg-dark text-white h-100" style="border-radius:20px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Users<sapn style="font-size:20px; margin-left:250px;"><?php echo $user_number; ?></span></span></div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16 17v2H2v-2s0-4 7-4s7 4 7 4m-3.5-9.5A3.5 3.5 0 1 0 9 11a3.5 3.5 0 0 0 3.5-3.5m3.44 5.5A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4M15 4a3.39 3.39 0 0 0-1.93.59a5 5 0 0 1 0 5.82A3.39 3.39 0 0 0 15 11a3.5 3.5 0 0 0 0-7Z"/></svg>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="manage-user.php">View Details</a>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card bg-dark text-white h-100" style="border-radius:20px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Testimonials<sapn style="font-size:20px; margin-left:200px;"><?php echo $testimonial_number; ?></span></span></div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054c.062-.372.166-.703.31-.992c.145-.29.331-.517.559-.683c.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992a4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054c.062-.372.166-.703.31-.992c.145-.29.331-.517.559-.683c.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992a4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"/>   
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="manage-testimonials.php">View Details</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Revenue Metrics -->
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card bg-success text-white h-100" style="border-radius:20px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Total Revenue</div>
                                            <div class="text-lg fw-bold">$<?php echo number_format($total_revenue, 2); ?></div>
                                        </div>
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header">Recent Orders</div>
                                <div class="card-body">
                                    <ul>
                                        <?php while ($order = mysqli_fetch_assoc($recent_orders_query)) { ?>
                                            <li>Order #<?php echo $order['order_id']; ?> - <?php echo $order['name']; ?> - $<?php echo $order['total_price']; ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Low Stock Alerts -->
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header">Low Stock Alerts</div>
                                <div class="card-body">
                                    <ul>
                                        <?php while ($product = mysqli_fetch_assoc($low_stock_query)) { ?>
                                            <li><?php echo $product['p_name']; ?> - Stock: <?php echo $product['stock']; ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Sales Trend Chart -->
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header">Sales Trend</div>
                                <div class="card-body">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header">Quick Actions</div>
                                <div class="card-body">
                                    <a href="add-product.php" class="btn btn-primary">Add Product</a>
                                    <a href="add-category.php" class="btn btn-secondary">Add Category</a>
                                    <a href="add-testimonials.php" class="btn btn-success">Add Testimonial</a>
                                </div>
                            </div>
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
    <script>
        // Sales Trend Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'], // Example labels
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 3000, 5000, 2000], // Example data
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Sales Trend'
                    }
                }
            }
        });
    </script>
</body>

</html>
