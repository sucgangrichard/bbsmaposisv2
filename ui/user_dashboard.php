<?php

include_once 'conndb.php';
session_start();


if($_SESSION['username']=="" ){

header('location:../index.php');

}


include_once "headeruser.php";



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
$yesterday = date('Y-m-d', strtotime('-1 day'));

// Function to get earnings for a given date
function getEarnings($date, $pdo) {
  $stmt = $pdo->prepare("SELECT SUM(total_due) as earnings FROM tbl_invoice WHERE order_date = :date");
  $stmt->execute(['date' => $date]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row ? $row['earnings'] : 0;
}

$earningsToday = getEarnings($today, $pdo);
$earningsYesterday = getEarnings($yesterday, $pdo);
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
          <h1 class="m-0">User Dashboard</h1>
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
              labels: ['Yesterday', 'Today'],
              datasets: [{
                  label: 'Earnings',
                  data: [<?php echo $earningsYesterday; ?>, <?php echo $earningsToday; ?>],
                  backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                  borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
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
                  }
              }
          });
          </script>





            </div>















            
          </div>
     

       
        </div>
        <!-- /.col-md-6 -->



        <div class="row">


<div class="col-md-6">
  
<div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">BEST SELLING PRODUCT</h5>
            </div>
            <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-hover " id="table_bestsellingproduct">
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
              <h5 class="m-0">Earning By Date</h5>
            </div>
            <div class="card-body">

            <table class="table table-striped table-hover " id="table_recentorder">
                <thead>
                  <tr>
                  
                    <td>Invoice ID</td>
                    <td>Order Date</td>
                   
                  
                    
                    <td>Total</td>
                    <td>Payment Type</td>
                  
                  

                  </tr>

                </thead>


                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_invoice  order by invoice_id DESC LIMIT 30");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
<tr>

<td><a href="editorderpos.php?id='. $row->invoice_id.'">'.$row->invoice_id.'</a></td>
<td><span class="badge badge-dark">' . $row->order_date   . '</td></span>
<td><span class="badge badge-danger">' . $row->total_due . '</td>';



if($row->payment_type=="Cash"){
  echo'<td><span class="badge badge-warning">'.$row->payment_type.'</td></span></td>';
}else if($row->payment_type=="Gcash"){

  echo'<td><span class="badge badge-success">'.$row->payment_type.'</td></span></td>';
}else if($row->payment_type=="Maya"){

  echo'<td><span class="badge badge-success">'.$row->payment_type.'</td></span></td>';
}else if($row->payment_type=="Debit/Credit"){

  echo'<td><span class="badge badge-success">'.$row->payment_type.'</td></span></td>';
}else{
  echo'<td><span class="badge badge-danger">'.$row->payment_type.'</td></span></td>';

}




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
</script>