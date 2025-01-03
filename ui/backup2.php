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

<style>
    #progressWrapper {
        width: 100%;
        background-color: #f3f3f3;
        border: 1px solid #ccc;
        margin-top: 20px;
    }
    #progressBar {
        width: 0%;
        height: 30px;
        background-color: #4caf50;
        text-align: center;
        line-height: 30px;
        color: white;
    }
    #progressWrapper2 {
        width: 100%;
        background-color: #f3f3f3;
        border: 1px solid #ccc;
        margin-top: 20px;
    }
    #progressBar2 {
      width: 0%;
        height: 30px;
        background-color: #4caf50;
        text-align: center;
        line-height: 30px;
        color: white;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">BackUp Data</h1>
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
            <form id="backupForm">
        <button type="button" onclick="startBackup()">Backup Now</button>
      </form>


      <div id="progressWrapper">
        <div id="progressBar">0%</div>
      </div>

      <div id="backupStatus"></div>

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
function startBackup() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "backup_process.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                document.getElementById('progressBar').innerText = response.progress + '%';
                document.getElementById('progressBar').style.width = response.progress + '%';
                document.getElementById('backupStatus').innerText = response.status;

                if (response.completed) {
                    swal.fire({
                        title: 'Backup Completed',
                        text: 'The backup process has been completed successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Refresh the page upon completion
                    });
                } else {
                    // Continue polling for progress updates
                    setTimeout(startBackup, 1000);
                }
            } else {
                console.error('Error: ' + xhr.status);
                swal.fire({
                    title: 'Error',
                    text: 'An error occurred: ' + xhr.status,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                document.getElementById('backupStatus').innerText = 'Error: ' + xhr.status;
            }
        }
    };  

    xhr.onerror = function() {
        console.error('Request failed');
        swal.fire({
            title: 'Request Failed',
            text: 'The request failed. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        document.getElementById('backupStatus').innerText = 'Request failed';
    };

    xhr.send("action=backup");
}



</script>

<script>
function startFormat() {
    // Your existing backup function
}

document.getElementById('deleteForm').onsubmit = function(event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_data.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.upload.onprogress = function(event) {
        if (event.lengthComputable) {
            var percentComplete = (event.loaded / event.total) * 100;
            document.getElementById('progressBar2').style.width = percentComplete + '%';
            document.getElementById('progressBar2').innerHTML = Math.round(percentComplete) + '%';
        }
    };

    xhr.onload = function() {
        if (xhr.status == 200) {
            document.getElementById('deleteStatus').innerHTML = 'Data deleted successfully';
        } else {
            document.getElementById('deleteStatus').innerHTML = 'Error deleting data';
        }
    };

    xhr.send(new FormData(document.getElementById('deleteForm')));
};
</script>