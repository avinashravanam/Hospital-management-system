<!DOCTYPE html>
<?php

session_start();
$con=mysqli_connect("localhost","root","","tempdb");

$app_id = "";
$doctor_id = "";
if(isset($_GET['app_id']) && isset($_GET['doctor_id'])) {
  
   $app_id = $_GET['app_id'];
   $doctor_id = $_GET['doctor_id'];
   $patient_id = $_GET['patient_id'];
   $amount = $_GET['fee'];
}



if(isset($_POST['prescribe'])){


    echo "<script> console.log('prescribe');</script>";

    $disease = $_POST['disease'];
    $medicine = $_POST['medicine'];

    $app_id = $_POST['app_id'];
    $doctor_id = $_POST['doctor_id'];

    echo "<script> console.log('prescribe');</script>";

    $patient_id = $_POST['patient_id'];
    $amount = $_POST['amount'];
  
    $con=mysqli_connect("localhost","root","","tempdb");

    echo "<script> console.log('prescribe');</script>";

    $query=mysqli_query($con,"insert into prescription(doctor_id,app_id,disease,medicine) values ('$doctor_id','$app_id','$disease','$medicine')");

    echo "<script> console.log('prescribe');</script>";

    if($query)
    {

      $query1=mysqli_query($con,"UPDATE appointment
                                 SET doctor_status = 0,app_status = 0,patient_status = 0
                                 WHERE app_id = '$app_id';");

      echo "<script> console.log('prescribe');</script>";

      $query2=mysqli_query($con,"INSERT INTO bill(amount,app_id,patient_id,status)
                                 VALUES ('$amount','$app_id','$patient_id',0);");

      echo "<script> console.log('prescribe');</script>";

      echo "<script>alert('Prescribed successfully!');</script>";
      header("Location: tdoctorpanel.php");
      exit;
    }
    else{
      echo "<script>alert('Unable to process your request. Try again!');</script>";
    }
}

?>

<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, -scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Apollo </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <style >
    .bg-primary {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.list-group-item.active {
    z-index: 2;
    color: #fff;
    background-color: #342ac1;
    border-color: #007bff;
}
.text-primary {
    color: #342ac1!important;
}

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        
      </li>
       <li class="nav-item">
       <a class="nav-link" href="tdoctorpanel.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Back</a>
      </li>
    </ul>
  </div>
</nav>

</head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>

<body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome 
   </h3>

   <div class="tab-pane" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <form class="form-group" name="prescribeform" method="post" action="tprescribe.php">
        
          <div class="row">
                  <div class="col-md-4"><label>Disease:</label></div>
                  <div class="col-md-8">
                  <textarea id="disease" cols="86" rows ="5" name="disease" required></textarea>
                  </div><br><br><br>
                  
                  <div class="col-md-4"><label>Medicine:</label></div>
                  <div class="col-md-8">
                  <textarea id="medicine" cols="86" rows ="5" name="medicine" required></textarea>
                  </div><br><br><br>

                  <input type="hidden" name="doctor_id" value="<?php echo $doctor_id ?>" />
                  <input type="hidden" name="app_id" value="<?php echo $app_id ?>" />
                  <input type="hidden" name="patient_id" value="<?php echo $patient_id ?>" />
                  <input type="hidden" name="amount" value="<?php echo $amount ?>" />
                
          <input type="submit" name="prescribe" value="Prescribe" class="btn btn-primary" style="margin-left: 40pc;">
          
        </form>
        <br>
        
      </div>
      </div>
      

  
