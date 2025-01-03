
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
            

          <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Contact Form</h5>
              </div>
              <div class="card-body">

              <form action="contact.php" method="POST" enctype='multipart/form-data' id="uploadForm">

              <div class="form-group">
              <label for="inputName">Name</label>
              <input type="text" name="name" id="inputName" class="form-control" placeholder="Enter your Name" />
            </div>
            <div class="form-group">
              <label for="inputEmail">Recipient E-Mail</label>
              <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Enter Recipient Email" />
            </div>
            <div class="form-group">
              <label for="inputSubject">Subject</label>
              <input type="text" name="subject" id="inputSubject" class="form-control" placeholder="Enter your Subject" />
            </div>
            <div class="form-group">
              <label for="inputMessage">Message</label>
              <textarea id="inputMessage" name="text" class="form-control" placeholder="Enter message" rows="4"></textarea>
            </div>
            <div class="form-group">
              <label for="file">Choose a File/Image</label>
              <input type="file" name="attachment" class="form-control" id="file"/>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Send message">
            </div>

    <!-- Progress bar -->
    <div class="form-group">
        <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
        <h3 id="status"></h3>
        <p id="loaded_n_total"></p>
    </div>
            </form>
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

  
  <?php include_once"footer.php";
  ?>
<script>
document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var form = document.getElementById('uploadForm');
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', function(event) {
        if (event.lengthComputable) {
            var percentComplete = (event.loaded / event.total) * 100;
            document.getElementById('progressBar').value = Math.round(percentComplete);
            document.getElementById('status').innerHTML = Math.round(percentComplete) + '% uploaded... please wait';
            document.getElementById('loaded_n_total').innerHTML = 'Uploaded ' + event.loaded + ' bytes of ' + event.total;
        }
    }, false);

    xhr.addEventListener('load', function(event) {
        document.getElementById('status').innerHTML = 'Upload complete';
        document.getElementById('progressBar').value = 100; // Set progress bar to 100% on completion
    }, false);

    xhr.addEventListener('error', function(event) {
        document.getElementById('status').innerHTML = 'Upload failed';
    }, false);

    xhr.addEventListener('abort', function(event) {
        document.getElementById('status').innerHTML = 'Upload aborted';
    }, false);

    xhr.open('POST', 'contact.php');
    xhr.send(formData);
});
</script>