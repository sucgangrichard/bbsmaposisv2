<?php

include_once 'conndb.php';
session_start();


if($_SESSION['username']=="" ){

header('location:../index.php');

}


include_once "header.php";



$select =$pdo->prepare("select sum(total_due) as gt , count(invoice_id) as invoice from tbl_invoice");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_order=$row->invoice;
$grand_total=$row->gt;



$select =$pdo->prepare("select count(product_name) as pname from tbl_product");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_product=$row->pname;



$select =$pdo->prepare("select sum(stock) as cate from tbl_product");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_category=$row->cate;


$select = $pdo->prepare("SELECT SUM(total_due) as total_sales FROM tbl_invoice WHERE DATE(order_date) = CURDATE()");
$select->execute();

$row = $select->fetch(PDO::FETCH_OBJ);

$total_sales_today = $row->total_sales ?? 0;








?>

<?php

// Fetch data from the database
$sql = "SELECT product_name, stock FROM tbl_product";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$data = [];

foreach ($products as $product) {
    $labels[] = $product['product_name'];
    $data[] = $product['stock'];
}

// Fetch data from the database
$sql1 = "SELECT product_name, available FROM tbl_mmenu";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();
$products1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$labels1 = [];
$data1 = [];

foreach ($products1 as $product1) {
    $labels1[] = $product1['product_name'];
    $data1[] = $product1['available'];
}





// Fetch earnings data
$today = date('Y-m-d');
$firstOfMonth = date('Y-m-01');

// function getTotalSalesToday($pdo) {
//   $sql = "SELECT SUM(total_due) as total_sales 
//           FROM tbl_invoice 
//           WHERE DATE(order_date) = CURDATE()";
//   $stmt = $pdo->query($sql);
//   $result = $stmt->fetch(PDO::FETCH_ASSOC);

//   return $result['total_sales'] ?? 0;
//   $total_sales_today = getTotalSalesToday($pdo);
// }

// Function to get earnings for a given date
function getEarnings($date, $pdo) {
  $stmt = $pdo->prepare("SELECT SUM(total_due) as earnings FROM tbl_invoice WHERE order_date = :date");
  $stmt->execute(['date' => $date]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row ? $row['earnings'] : 0;
}
// Determine which month to display based on a query parameter
$month = isset($_GET['month']) ? $_GET['month'] : 'current';

// Calculate the start and end dates based on the selected month
if ($month === 'previous') {
    $firstOfMonth = date("Y-m-01", strtotime("first day of previous month"));
    $lastOfMonth = date("Y-m-t", strtotime("last day of previous month"));
} else {
    $firstOfMonth = date("Y-m-01");
    $lastOfMonth = date("Y-m-t");
}

$earningsData = [];
$currentDate = $firstOfMonth;
while (strtotime($currentDate) <= strtotime($today)) {
  $earningsData[$currentDate] = getEarnings($currentDate, $pdo);
  $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}
?>
<style>
  #refresh-timer {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 10px;
    border-radius: 5px;
    z-index: 1000;
    font-size: 14px;
  }

  @media (max-width: 768px) {
    #refresh-timer {
      font-size: 12px;
      padding: 8px;
    }
  }

  @media (max-width: 480px) {
    #refresh-timer {
      font-size: 10px;
      padding: 6px;
    }
  }
</style>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    
    <div class="container-fluid">
    
      <div class="row mb-2">
        <div class="col-sm-6">
        <div id="refresh-timer" class="d-none d-md-block">Page will refresh in <span id="timer">15</span> seconds</div>

        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">



        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $total_order;?></h3>

                <p>TOTAL INVOICE</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo number_format($grand_total,2); ?></h3>

                <p>TOTAL REVENUE(₱)</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo number_format ($total_sales_today,2);?></h3>

                <p>SALES TODAY(₱)</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $total_category;?></h3>

                <p>TOTAL STOCKS(INVENTORY)</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->










        <div class="card card-dark card-outline">
            <div class="card-header">
              <h5 class="m-0">Earning By Date</h5>
            </div>
            <div class="card-body">
            
<?php

$select = $pdo->prepare("select order_date , total_due  from tbl_invoice  group by order_date LIMIT 50");





          $select->execute();

          
          $ttl=[];
          $date=[];

          while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
extract($row);
// $total += $total_due;
$ttl[] = $grand_total; // Add total_due to the ttl array
$date[] = $order_date; // Add order_date to the date array




          }

             // Calculate total earnings
        $total_earnings = array_sum($ttl);

// echo json_encode($total);


?>






            <div >
            <!-- <a href="?month=current" class="btn btn-primary animate-link"><i class="fas fa-arrow-right"></i> Current Month</a> -->
    <a href="?month=previous" class="btn btn-secondary animate-link"><i class="fas fa-arrow-left"></i> Previous Month</a>
    <a href="?month=current" class="btn btn-primary animate-link"> Current Month<i class="fas fa-arrow-right"></i></a>


  <canvas id="myChart" style="height: 250px"></canvas>
</div>




            </div>

            <script>
            var earningsData = {
          labels: [<?php echo implode(', ', array_map(function($date) { return "'$date'"; }, array_keys($earningsData))); ?>],
          datasets: [{
          label: 'Earnings/Sales',
          data: [<?php echo implode(', ', $earningsData); ?>],
          backgroundColor: (function() {
            var data = [<?php echo implode(', ', $earningsData); ?>];
            var max = Math.max.apply(null, data);
            var min = Math.min.apply(null, data);
            return data.map(function(value) {
              if (value === max) {
                return 'rgba(255, 0, 0, 0.2)';
              }else if (value === min) {
                  return 'rgba(111, 0, 255, 0.4)';
              
              } else {
                return 'rgba(75, 192, 192, 0.2)';
              }
            });
          })(),
          borderColor: (function() {
            var data = [<?php echo implode(', ', $earningsData); ?>];
            var max = Math.max.apply(null, data);
            var min = Math.min.apply(null, data);
            return data.map(function(value) {
              if (value === max) {
                return 'rgba(255, 0, 0, 1)';
              }else if (value === min) {
                  return 'rgb(111, 0, 255)';
              } else {
                return 'rgba(75, 192, 192, 1)';
              }
            });
          })(),
          borderWidth: (function() {
            var data = [<?php echo implode(', ', $earningsData); ?>];
            var max = Math.max.apply(null, data);
            var min = Math.min.apply(null, data);
            return data.map(function(value) {
              if (value === max || value === min) {
                return 2;
              } else {
                return 1;
              }
            });
          })()
        },
          {
            label: 'Highest',
            // data: [<?php echo implode(', ', array_map(function($value) use ($earningsData) { return $value === max($earningsData) ? $value : 'null'; }, $earningsData)); ?>],
            backgroundColor: 'rgba(255, 0, 0, 0.2)',
            borderColor: 'rgba(255, 0, 0, 1)',
            borderWidth: 1
          },
        {
          label: 'Lowest',
          // data: [<?php echo implode(', ', array_map(function($value) use ($earningsData) { return $value === min($earningsData) ? $value : 'null'; }, $earningsData)); ?>],
          backgroundColor: 'rgba(111, 0, 255, 0.47)',
          borderColor: 'rgba(47, 7, 100, 0.63)',
          borderWidth: 1
        }]
        };

  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: earningsData,
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          },
          
      }
  });
          </script>





            </div>



  











            
          </div>
     

       
        </div>
        <!-- /.col-md-6 -->



        <div class="row">

<div class="col-md-6">
  
<div class="card card-dark card-outline">
            <div class="card-header">
              <h5 class="m-0">BEST SELLING PRODUCT</h5>
            </div>
            <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-hover " id="table_recentorder1">
                <thead>
                  <tr>
                  
                    <td>Product ID</td>
                    <td>Product Name</td>
                   
                    <td>Sold</td>
                    <!-- <td>Price</td> -->
                    <td>Total</td>
                  
                  

                  </tr>

                </thead>


                <tbody>

                  <?php

                  $select = $pdo->prepare("select menu_id,product_name,sum(qty) as q , sum(total_per_qty) as total from tbl_invoice_details group by menu_id order by sum(qty) DESC LIMIT 10");
                  $select->execute();

                  // Fetch all rows to determine the highest total quantity
$rows = $select->fetchAll(PDO::FETCH_OBJ);
$maxTotal = !empty($rows) ? max(array_column($rows, 'total')) : 0;

// Iterate through the rows and apply the green badge class to the product with the highest total quantity
foreach ($rows as $row) {
    $badgeClass = $row->total == $maxTotal ? 'badge-success' : 'badge-muted';

    echo '
<tr>
    <td><span class="badge ' . $badgeClass . '">' . $row->menu_id . '</span></td>
    <td><span class="badge ' . $badgeClass . '">' . $row->product_name . '</span></td>
    <td><span class="badge ' . $badgeClass . '">' . $row->q . '</span></td>
    <td><span class="badge ' . $badgeClass . '">' . $row->total . '</span></td>
</tr>
';
}
?>
                  </tbody>
                 </table>
                 </div>
            
                 <!-- <td>' . $row->menu_id   . '</td> -->
            </div></div>

</div>


<div class="col-md-6">
  
<div class="card card-dark card-outline">
            <div class="card-header">
              <h5 class="m-0">AVAILABILITY USAGE FORM</h5>
            </div>
            <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-hover " id="table_recentorder">
                <thead>
                  <tr>
                  
                    
                    <td>Product</td>
                    <td>Category</td>
                  
                    
                    <td>Availability</td>
                    <!-- <td>Payment Type</td> -->
                  
                  

                  </tr>

                </thead>


                <tbody>

                  <?php

$select = $pdo->prepare("select product_name, category, available from tbl_mmenu order by available ASC");
$select->execute();

while ($row = $select->fetch(PDO::FETCH_OBJ)) {
    $badgeClass = $row->available < 10 ? 'badge-danger' : 'badge-muted';
  
    echo '
  <tr>
  <td><span class="badge ' . $badgeClass . '">' . $row->product_name . '</span></td>
<td><span class="badge ' . $badgeClass . '">' . $row->category . '</span></td>
<td><span class="badge ' . $badgeClass . '">' . $row->available . '</span></td></tr>';

                  }
                  ?>
                  </tbody>
                 </table>

            
                 </div>
            </div>
          </div>

            

</div>

</div>

<div class="row">
    <div class="col-md-6">
    <div class="card card-dark card-outline">
              <div class="card-header">
                <h3 class="card-title ">STOCK USAGE CHART
                </h3>

                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div> -->
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
    </div>

    <div class="col-md-6">
    <div class="card card-dark card-outline">
              <div class="card-header">
                <h3 class="card-title">AVAILABILITY USAGE CHART</h3>

                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div> -->
              </div>
              <div class="card-body">
                <canvas id="donutChart1" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
    </div>


    <div class="col-md-12">
  
<div class="card card-dark card-outline">
            <div class="card-header">
              <h5 class="m-0">Stock Usage Form</h5>
            </div>
            <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-hover " id="table_recentorder2">
                <thead>
                  <tr>
                    <td>Barcode ID</td>
                    <td>Product ID</td>
                    <td>Product Name</td>
                   
                    <td>Quantity</td>
                    <td>Expiration Date</td>
                    
                  
                  

                  </tr>

                </thead>


                <tbody>

                <?php

                $select = $pdo->prepare("select id,  product_name, barcode, stock, expiration_date from tbl_product ORDER BY stock DESC LIMIT 10");
                $select->execute();
// Fetch all rows to determine the highest stock
$rows = $select->fetchAll(PDO::FETCH_OBJ);

if (!empty($rows)) {
    $maxStock = max(array_column($rows, 'stock'));

                // Iterate through the rows and apply the appropriate badge class
                foreach ($rows as $row) {
                    if ($row->stock == $maxStock) {
                        $badgeClass = 'badge-muted';
                    } elseif ($row->stock < 10) {
                        $badgeClass = 'badge-danger';
                    } else {
                        $badgeClass = 'badge-muted';
                    }

                    echo '
<tr>
    <td><span class="badge ' . $badgeClass . '">' . $row->barcode . '</span></td>
    <td><span class="badge ' . $badgeClass . '">' . $row->id . '</span></td>
    <td><span class="badge ' . $badgeClass . '">' . $row->product_name . '</span></td>
    <td><span class="badge ' . $badgeClass . '">' . $row->stock . '</span></td>
    <td><span class="badge ' . $badgeClass . '">' . $row->expiration_date . '</span></td>
</tr>
';
                }
              } else {
                echo '<tr><td colspan="5">No products found</td></tr>';
            }
            
                ?>
                  </tbody>
                 </table>
                 </div>
            
                 <!-- <td>' . $row->menu_id   . '</td> -->
            </div></div>

</div>
</div>


      </div>
      <!-- /.row -->











    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php

include_once "footer.php";


?>

<script>
  $(document).ready(function() {
    $('#table_recentorder').DataTable({

      "order":[[2,"asc"]]
    });
  });

  $(document).ready(function() {
    $('#table_recentorder1').DataTable({
      "order": [[2, "desc"]] // Order by the third column (QTY) in descending order
    });
  });

  $(document).ready(function() {
    $('#table_recentorder2').DataTable({
      "order": [[2, "desc"]] // Order by the third column (QTY) in descending order
    });
  });

  //  // Auto-refresh the page every 5 seconds (5000 milliseconds)
  var refreshInterval = 15000;
  var timer = refreshInterval / 1000;
  setInterval(function() {
    location.reload();
  }, refreshInterval);

  // // Update the countdown timer every second
  setInterval(function() {
    if (timer > 0) {
      timer--;
      document.getElementById('timer').textContent = timer;
    }
  }, 1000);
</script>


<script>
$(function () {
  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  var donutData = {
    labels: <?php echo json_encode($labels); ?>,
    datasets: [
      {
        data: <?php echo json_encode($data); ?>,
        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
      }
    ]
  }
  var donutOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    }
  }
  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })
})
</script>

<script>
$(function () {
  var donutChartCanvas = $('#donutChart1').get(0).getContext('2d')
  var donutData = {
    labels: <?php echo json_encode($labels1); ?>,
    datasets: [
      {
        data: <?php echo json_encode($data1); ?>,
        backgroundColor : ['#000000', '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#00FFFF', '#FF00FF',
  '#808080', '#D3D3D3', '#A9A9A9', '#C0C0C0', '#696969', '#2F4F4F', '#708090',
  '#FFA500', '#800080', '#FFC0CB', '#8B0000', '#808000', '#4682B4', '#5F9EA0',
  '#7FFF00', '#6A5ACD', '#1E90FF', '#32CD32', '#FFD700', '#ADFF2F', '#FF69B4',
  '#B22222', '#FF4500', '#DA70D6', '#BA55D3', '#9370DB', '#3CB371', '#7B68EE', 
  '#00FA9A', '#48D1CC', '#191970', '#20B2AA', '#F08080', '#8A2BE2', '#5F9EA0',
  '#6495ED', '#DC143C', '#FF7F50', '#6B8E23', '#2E8B57', '#D2691E', '#8B4513',
  '#FA8072', '#DDA0DD', '#EEE8AA', '#98FB98', '#AFEEEE', '#FFE4C4', '#FFDEAD',
  '#DEB887', '#B0C4DE', '#FFDAB9', '#F4A460', '#BC8F8F', '#B8860B', '#CD5C5C',
  '#F5DEB3', '#8FBC8F', '#66CDAA', '#7CFC00', '#4682B4', '#708090', '#778899',
  '#2F4F4F', '#D8BFD8', '#00CED1', '#00BFFF', '#1E90FF', '#6495ED', '#DC143C',
  '#7FFF00', '#FFFFE0', '#B0E0E6', '#98C9E7', '#FFD700', '#B0C4DE', '#D8BFD8',
  '#8B0000', '#B4EEB4', '#A52A2A', '#FAFAD2', '#F0E68C', '#4B0082', '#C71585',
  '#8B0000', '#FF6347', '#98FB98', '#32CD32', '#8B4513', '#228B22', '#A52A2A',
  '#D2691E', '#8B008B', '#8B0000', '#800000', '#8A2BE2', '#FFD700', '#8B4513'],
      }
    ]
  }
  var donutOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    }
  }
  new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })
})
</script>

<!-- FLOT CHARTS -->
<script src="../plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="../plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="../plugins/flot/plugins/jquery.flot.pie.js"></script>