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



$select =$pdo->prepare("select count(product_name) as pname from tbl_mmenu");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_product=$row->pname;



$select =$pdo->prepare("select count(category) as cate from tbl_menu_category");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_category=$row->cate;









?>

<?php





// Fetch earnings data
$today = date('Y-m-d');
$firstOfMonth = date('Y-m-01');

// Function to get earnings for a given date
function getEarnings($date, $pdo) {
  $stmt = $pdo->prepare("SELECT SUM(total_due) as earnings FROM tbl_invoice WHERE order_date = :date");
  $stmt->execute(['date' => $date]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row ? $row['earnings'] : 0;
}

$earningsData = [];
$currentDate = $firstOfMonth;
while (strtotime($currentDate) <= strtotime($today)) {
  $earningsData[$currentDate] = getEarnings($currentDate, $pdo);
  $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}
?>

<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
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
                <h3><?php echo $total_product;?></h3>

                <p>TOTAL PRODUCT</p>
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

                <p>TOTAL CATEGORY</p>
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










        <div class="card card-primary card-outline">
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
  <canvas id="myChart" style="height: 250px"></canvas>
</div>




            </div>

            <script>
          var earningsData = {
      labels: [<?php echo implode(',', array_map(function($date) { return "'$date'"; }, array_keys($earningsData))); ?>],
      datasets: [{
        label: 'Earnings',
        data: [<?php echo implode(',', $earningsData); ?>],
        backgroundColor: (function() {
            var data = [<?php echo implode(',', $earningsData); ?>];
            var max = Math.max.apply(null, data);
            var secondMax = Math.max.apply(null, data.filter(function(value) { return value !== max; }));
            var thirdMax = Math.max.apply(null, data.filter(function(value) { return value !== max && value !== secondMax; }));
            var min = Math.min.apply(null, data);
            return data.map(function(value) {
                if (value === max) {
                    return 'rgba(255, 0, 0, 0.2)';
                } else if (value === secondMax) {
                    return 'rgba(255, 165, 0, 0.2)';
                } else if (value === thirdMax) {
                    return 'rgba(21, 255, 0, 0.2)';
                } else if (value === min) {
                    return 'rgba(0, 0, 255, 0.2)';
                } else {
                    return 'rgba(75, 192, 192, 0.2)';
                }
            });
        })(),
        borderColor: (function() {
            var data = [<?php echo implode(',', $earningsData); ?>];
            var max = Math.max.apply(null, data);
            var secondMax = Math.max.apply(null, data.filter(function(value) { return value !== max; }));
            var thirdMax = Math.max.apply(null, data.filter(function(value) { return value !== max && value !== secondMax; }));
            var min = Math.min.apply(null, data);
            return data.map(function(value) {
                if (value === max) {
                    return 'rgba(255, 0, 0, 1)';
                } else if (value === secondMax) {
                    return 'rgba(255, 165, 0, 1)';
                } else if (value === thirdMax) {
                    return 'rgb(41, 145, 0)';
                } else if (value === min) {
                    return 'rgba(0, 0, 255, 1)';
                } else {
                    return 'rgba(75, 192, 192, 1)';
                }
            });
        })(),
        borderWidth: (function() {
            var data = [<?php echo implode(',', $earningsData); ?>];
            var max = Math.max.apply(null, data);
            var secondMax = Math.max.apply(null, data.filter(function(value) { return value !== max; }));
            var thirdMax = Math.max.apply(null, data.filter(function(value) { return value !== max && value !== secondMax; }));
            var min = Math.min.apply(null, data);
            return data.map(function(value) {
                if (value === max || value === secondMax || value === thirdMax || value === min) {
                    return 2;
                } else {
                    return 1;
                }
            });
        })()
    },
    {
        label: 'Highest',
        // data: [<?php echo implode(',', array_map(function($value) use ($earningsData) { return $value === max($earningsData) ? $value : 'null'; }, $earningsData)); ?>],
        backgroundColor: 'rgba(255, 0, 0, 0.2)',
        borderColor: 'rgba(255, 0, 0, 1)',
        borderWidth: 1
    },
    {
        label: 'Lowest',
        // data: [<?php echo implode(',', array_map(function($value) use ($earningsData) { return $value === min($earningsData) ? $value : 'null'; }, $earningsData)); ?>],
        backgroundColor: 'rgba(0, 0, 255, 0.2)',
        borderColor: 'rgba(0, 0, 255, 1)',
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
        <div class=" col-6">
            <!-- small box -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">AVAILABILITY USAGE CHART</h5>
              </div>
              <div class="card-body">
               
              <div id="donut-chart1" style="height: 300px;"></div>
                      <div style="text-align: center; margin: 20px;">
      <button class="btn btn-danger" onclick="confirmRefresh()">
          <i class="fa-solid fa-arrows-rotate"></i>
      </button>
  </div>
  
  <script>
  function confirmRefresh() {
      Swal.fire({
          title: 'Save the data before you proceed!',
          text: "Data must saved before refreshing a page!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, refresh it!'
      }).then((result) => {
          if (result.isConfirmed) {
              refreshPage();
          }
      })
  }
  
  function refreshPage() {
      location.reload();
  }   
  </script>
              
  
              </div></div>
          </div>
<!--======================-->
<div class="col-md-6">
  
  <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">STOCK USAGE CHART</h5>
              </div>
              <div class="card-body">
               
              <div id="donut-chart" style="height: 300px;"></div>
                      <div style="text-align: center; margin: 20px;">
      <button class="btn btn-danger" onclick="confirmRefresh()">
          <i class="fa-solid fa-arrows-rotate"></i>
      </button>
  </div>
  
  <script>
  function confirmRefresh() {
      Swal.fire({
          title: 'Save the data before you proceed!',
          text: "Data must saved before refreshing a page!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, refresh it!'
      }).then((result) => {
          if (result.isConfirmed) {
              refreshPage();
          }
      })
  }
  
  function refreshPage() {
      location.reload();
  }   
  </script>
              
  
              </div></div>
  
  </div>
                  <!--======================-->

<div class="col-md-6">
  
<div class="card card-primary card-outline">
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
                   
                    <td>QTY</td>
                    <!-- <td>Price</td> -->
                    <td>Total</td>
                  
                  

                  </tr>

                </thead>


                <tbody>

                  <?php

                  $select = $pdo->prepare("select menu_id,product_name,sum(qty) as q , sum(total_per_qty) as total from tbl_invoice_details group by menu_id order by sum(qty) DESC LIMIT 10");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
<tr>

<td>' . $row->menu_id   . '</td>
<td><span class="badge badge-dark">' . $row->product_name   . '</td></span>

<td><span class="badge badge-success">' . $row->q   . '</td></span>


<td><span class="badge badge-danger">' . $row->total . '</td>';








                  }
                  ?>
                  </tbody>
                 </table>
                 </div>
            

            </div></div>

</div>


<div class="col-md-6">
  
<div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">AVAILABILITY USAGE FORM</h5>
            </div>
            <div class="card-body">

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
                    $badgeClass = $row->available < 10 ? 'badge-danger' : 'badge-dark';
                  
                    echo '
                  <tr>
                  <td><span class="badge ' . $badgeClass . '">' . $row->product_name . '</span></td>
<td><span class="badge ' . $badgeClass . '">' . $row->category . '</span></td>
<td><span class="badge ' . $badgeClass . '">' . $row->available . '</span></td><tr>';






                  }
                  ?>
                  </tbody>
                 </table>

            

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

      "order":[[0,"desc"]]
    });
  });

  $(document).ready(function() {
    $('#table_recentorder1').DataTable({
      "order": [[2, "desc"]] // Order by the third column (QTY) in descending order
    });
  });
</script>
<script>
  // Function to fetch new data and update the donut chart
  function fetchDonutData1() {
    fetch('path_to_your_data_endpoint1.php')
      .then(response => response.json())
      .then(data => {
        // Update the donut chart with the new data
        $.plot('#donut-chart1', data, {
          series: {
            pie: {
              show       : true,
              radius     : 1,
              innerRadius: 0.5,
              label      : {
                show     : true,
                radius   : 2 / 3,
                formatter: labelFormatter1,
                threshold: 0.1
              }
            }
          }
        });
      })
      .catch(error => console.error('Error fetching donut data:', error));
  }

  // Call fetchDonutData every 5 seconds
  setInterval(fetchDonutData1, 1000);

  $(document).ready(function() {
    // Initial plot
    $.plot('#donut-chart1', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter1,
            threshold: 0.1
          }
        }
      }
    });

    // Start auto-refresh
    fetchDonutData1();
  });
</script>

<script>
  // Function to fetch new data and update the donut chart
  function fetchDonutData() {
    fetch('path_to_your_data_endpoint.php')
      .then(response => response.json())
      .then(data => {
        // Update the donut chart with the new data
        $.plot('#donut-chart', data, {
          series: {
            pie: {
              show       : true,
              radius     : 1,
              innerRadius: 0.5,
              label      : {
                show     : true,
                radius   : 2 / 3,
                formatter: labelFormatter,
                threshold: 0.1
              }
            }
          }
        });
      })
      .catch(error => console.error('Error fetching donut data:', error));
  }

  // Call fetchDonutData every 5 seconds
  setInterval(fetchDonutData, 1000);

  $(document).ready(function() {
    // Initial plot
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }
        }
      }
    });

    // Start auto-refresh
    fetchDonutData();
  });
</script>

<script>
  function labelFormatter(label, series) {
    return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">' +
      label + '<br>' + Math.round(series.percent) + '%</div>';
  }
</script>

<script>
  function labelFormatter1(label, series) {
    return '<div style="font-size:8pt;text-align:left;padding:2px;color:white;display:inline-block;margin-left:10px;text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">' +
      label + '<br>' + Math.round(series.percent) + '%</div>';
}
</script>



<!-- FLOT CHARTS -->
<script src="../plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="../plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="../plugins/flot/plugins/jquery.flot.pie.js"></script>