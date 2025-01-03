<!DOCTYPE html>
<?php

// session_start();
date_default_timezone_set("Asia/Manila");
if (!isset($_SESSION['login_time'])) {
    $_SESSION['login_time'] = date("Y-m-d H:i:s");
}
?>


<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | Management</title>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> -->

   <!-- iCheck for checkboxes and radio inputs -->
   <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"/>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
       <li class="nav-item">
       <a class="nav-link"><span class="time-display d-none d-md-inline">
                <i class="nav-icon fas fa-clock"></i>
                <strong>Login Time: <?php echo $_SESSION['login_time']; ?></strong></span>
            </a>
        
      </li> 
      <li class="nav-item">
            <a class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <strong>Current Time: <span id="current-time"></strong></span>
            </a>
        </li>

      <!-- Messages Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a> -->
        <!-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> -->
          <!-- <a href="#" class="dropdown-item">
            
            <div class="media">
              <img src="../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
        
          </a> -->
          <!-- <div class="dropdown-divider"></div> -->
          <!-- <a href="#" class="dropdown-item">
            
            <div class="media">
              <img src="../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            
          </a> -->
          <!-- <div class="dropdown-divider"></div> -->
          <!-- <a href="#" class="dropdown-item">
            
            <div class="media">
              <img src="../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
        
          </a> -->
          <!-- <div class="dropdown-divider"></div> -->
          <!-- <a href="#" class="dropdown-item dropdown-footer">See All Messages</a> -->
        <!-- </div> -->
      <!-- </li> -->
      <!-- Notifications Dropdown Menu -->
      <?php
      
      function sendSMS($message, $to) {
        $api_key = '0e90cb305305ed1a4dc08d4ddf87b1d6';
        $url = 'https://api.semaphore.co/api/v4/messages';
    
        $data = array(
            'apikey' => $api_key,
            'number' => $to,
            'message' => $message,
            'sendername' => 'SEMAPHORE'
        );
    
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
    
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
    
        if ($result === FALSE) {
            // Handle error
        }
    
        return $result;
    }
// Initialize the session variable if not set
if (!isset($_SESSION['notified_items'])) {
  $_SESSION['notified_items'] = array();
}


      function getLowStockItems($pdo) {
        $sql = "SELECT product_name, stock FROM tbl_product WHERE stock < 10"; // Adjust the threshold as needed
        $result = $pdo->query($sql);
    
        $lowStockItems = [];
        if ($result->rowCount() > 0) {
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $lowStockItems[] = $row;
            }
        }
    
        return $lowStockItems;
    }
    
    function getLowAvailableItems($pdo) {
        $sql = "SELECT product_name, available FROM tbl_mmenu WHERE available < 10"; // Adjust the threshold as needed
        $result = $pdo->query($sql);
    
        $lowAvailableItems = [];
        if ($result->rowCount() > 0) {
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $lowAvailableItems[] = $row;
            }
        }
    
        return $lowAvailableItems;
    }
    
    $lowStockItems = getLowStockItems($pdo);
    $lowAvailableItems = getLowAvailableItems($pdo);
    
    $notifications = array_merge($lowStockItems, $lowAvailableItems);
    $lowStockCount = count($notifications);
    ?> 
<style>
.notification-text {
  display: inline-block;
  max-width: calc(100% - 50px); /* Adjust based on icon and padding */
  white-space: normal;
}
</style>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php echo $lowStockCount; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header"><?php echo $lowStockCount; ?> Low Stock Notifications</span>
          <div class="dropdown-divider"></div>
          <?php foreach ($notifications as $item): ?>
        <a href="#" class="dropdown-item">
          <i class="fas fa-exclamation-triangle mr-2"></i> 
          <span class="notification-text">
          <?php 
            if (isset($item['stock']) && $item['stock'] < 10) {
                $item_id = $item['id']; // Assuming each item has a unique ID
                if (!in_array($item_id, $_SESSION['notified_items'])) {
                    $message = htmlspecialchars($item['product_name']) . ' is low on stock. Only ' . $item['stock'] . ' left.';
                    sendSMS($message, '09671966512');
                    $_SESSION['notified_items'][] = $item_id;
                }
                echo htmlspecialchars($item['product_name']) . ' is low on stock.';
            } else {
                echo htmlspecialchars($item['product_name']) . ' is low on avail.qty#.';
            }
            ?>
          </span>
          <span class="float-right text-muted text-sm">
          <?php 
        if (isset($item['stock'])) {
            echo $item['stock'] . ' left on stock for inventory';
        } else {
            echo $item['available'] . ' left on avail.qty# for menu order';
        }
        ?>
                </span>
            </a>
        <div class="dropdown-divider"></div>
          <?php endforeach; ?>
          <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="./iconspng/logo.png" alt="Our Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./iconspng/setting.png" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username'];?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item" >
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 2em;">
            <li class="nav-item">
                <a href="add_productwithchart.php" class="nav-link">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>Add Stocks Barcoding</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="deducted_stock.php" class="nav-link">
                  <i class="nav-icon fas fa-circle-minus"></i>
                  <p>Stock Usage Monitor</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="stock_list.php" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Stock List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="stock_registry.php" class="nav-link">
                  <i class="nav-icon fas fa-plus-square"></i>
                  <p>Stock Registry</p>
                </a>
              </li>

              <li class="nav-item">
            <a href="category.php" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
              <p>Category</p>
            </a>
          </li>
             
            </ul>
          </li>

          

          <li class="nav-item" >
            <a href="dine_in.php" class="nav-link">
              <i class="nav-icon fas fa-smile"></i>
              <p>
                POS
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
            <!-- <ul class="nav nav-treeview" style="margin-left: 2em;">
            <li class="nav-item">
                <a href="dine_in.php" class="nav-link">
                  <i class="nav-icon fas fa-hand-point-right"></i>
                  <p>Add Order</p>
                </a>
              </li> -->

              <!-- <li class="nav-item">
                <a href="do.php" class="nav-link">
                  <i class="nav-icon fas fa-hand-point-right"></i>
                  <p>D/O Category</p>
                </a>
              </li> -->

              
             
            <!-- </ul> -->
          </li>

          

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-pencil"></i>
              <p>
                Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 2em;">
            <li class="nav-item">
                <a href="add_menu.php" class="nav-link">
                  <i class="nav-icon fas fa-plus"></i>
                  <p>Add Product Menu</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="menu_list1.php" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Product Menu List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="menu_category.php" class="nav-link">
                  <i class="nav-icon fa fa-ellipsis-h"></i>
                  <p>Product Menu Category</p>
                </a>
              </li>

              
             
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bar-chart"></i>
              <p>
              Sales Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 2em;">
            <li class="nav-item">
                <a href="order_list.php" class="nav-link">
                  <i class="nav-icon fas fa-exchange"></i>
                  <p>Orders</p>
                </a>
              </li>

               <li class="nav-item">
                <a href="tablereport.php" class="nav-link">
                  <i class="nav-icon fas fa-chart-line"></i>
                  <p>Table Report</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="graphreport.php" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>Graph Report</p>
                </a>
              </li>
<!--
              <li class="nav-item">
                <a href="menu_category.php" class="nav-link">
                  <i class="nav-icon fa fa-ellipsis-h"></i>
                  <p>Menu Category</p>
                </a>
              </li> -->

              
             
            </ul>
          </li>
          <!-- <li class="nav-item">
            <a href="order_list.php" class="nav-link">
            <i class="nav-icon fas fa-bar-chart"></i>
              <p>
                Sales Report
                
              </p>
            </a>
          </li>  -->
<!--
          <li class="nav-item">
            <a href="productlist.php" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
              <p>
                Product List
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
              <p>
                POS
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
              <p>
                Order List
                
              </p>
            </a>
          </li> -->

          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Sales Report
                
              </p>
            </a>
          </li> -->

          <li class="nav-item">
            <a href="taxdis.php" class="nav-link">
            <i class="nav-icon fas fa-calculator"></i>
              <p>
                Tax
                
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="users.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
              <p>
                Manage Users
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-gear"></i>
              <p>
              Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 2em;">
            <li class="nav-item">
                <a href="backup.php" class="nav-link">
                  <i class="nav-icon fas fa-exchange"></i>
                  <p>Back Up Data</p>
                </a>
              
              </li>

          

          <!-- <li class="nav-item">
            <a href="changepassword.php" class="nav-link">
            <i class="nav-icon fas fa-user-lock"></i>
              <p>
              Change Password
              </p>
            </a>
          </li> -->

          <li class="nav-item">
            <a href="logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
                
              </p>
            </a>
          </li>

        </ul>

        <li class="nav-item">
            <a href="contactform.php" class="nav-link">
            <i class="nav-icon fas fa-at"></i>
              <p>
                Contact/Report
                
              </p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <script>
function updateTime() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    var currentTime = hours + ':' + minutes + ':' + seconds;
    document.getElementById('current-time').textContent = currentTime;
}

setInterval(updateTime, 1000);
updateTime(); // initial call to display time immediately
</script>

<script>
$(document).ready(function() {
    function fetchLowStockCount() {
        $.ajax({
            url: 'fetch_low_stock.php',
            method: 'GET',
            success: function(data) {
                var result = JSON.parse(data);
                var lowStockCount = result.lowStockCount;
                $('#low-stock-badge').text(lowStockCount);
            }
        });
    }

    // Fetch low stock count every 30 seconds
    setInterval(fetchLowStockCount, 30000);
    fetchLowStockCount(); // Initial fetch
});
</script>