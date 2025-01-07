<?php
include_once 'conndb.php';
session_start();



if($_SESSION['username']==""  OR $_SESSION['role']=="User"){

  header('location:../index.php');
  
  }


  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
  
    include_once'headeruser.php';
  }

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">BackUp Data</h1> -->
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
        

        <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">BackUp Data</h5>
            </div>
            <div class="card-body">


            <form id="backupForm" action="backup99.php" method="post">
                <button type="submit" class="btn btn-primary">Download Backup</button>
              </form>
              
              <div class="progress mt-3">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
              </div>

      <hr>

      <!-- <form id="deleteForm" method="post" action="delete_data.php">
                            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete the data?');">Delete Data</button>
                        </form>

                        <div id="progressWrapper2">
                            <div id="progressBar2">0%</div>
                        </div>

                        <div id="deleteStatus"></div> -->


      
</div>
          </div>
     

       
        </div>
        <!-- /.col-md-6 -->
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
document.getElementById('backupForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var progressBar = document.getElementById('progressBar');
    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'backup99.php', true);

    xhr.upload.onprogress = function(event) {
        if (event.lengthComputable) {
            var percentComplete = (event.loaded / event.total) * 100;
            progressBar.style.width = percentComplete + '%';
            progressBar.setAttribute('aria-valuenow', percentComplete);
            progressBar.innerHTML = Math.round(percentComplete) + '%';
        }
    };

    xhr.onload = function() {
        if (xhr.status === 200) {
            progressBar.style.width = '100%';
            progressBar.setAttribute('aria-valuenow', 100);
            progressBar.innerHTML = '100%';
            Swal.fire({
                title: 'Backup Complete!',
                text: 'Your backup has been successfully created.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'backup99.php';
                    // location.reload();
                }
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'There was an error creating the backup.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    };

    xhr.send(formData);
});
</script>