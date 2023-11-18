<!-- <!DOCTYPE html> -->

<?php

session_start();

if (!isset($_SESSION['patient_id'])) {

    header("Location: index.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "tempdb");

// Retrieve session variables
$patient_id = $_SESSION['patient_id'];
$pname = $_SESSION['name'];
$email = $_SESSION['email'];
$gender = $_SESSION['gender'];
$contact = $_SESSION['contact'];

function display_specs() {
  global $con;
  $query="select distinct(specialization) from doctor where working_status = 1";
  $result=mysqli_query($con,$query);
  while($row=mysqli_fetch_array($result))
  {
    $specialization=$row['specialization'];
    echo '<option data-value="'.$specialization.'">'.$specialization.' </option>';
  }
}

function display_docs()
{
 global $con;
 $query = "select * from doctor where working_status = 1";
 $result = mysqli_query($con,$query);
 while( $row = mysqli_fetch_array($result) )
 {
  $username = $row['name'];
  $price = $row['fee'];
  $spec = $row['specialization'];
  echo '<option value="' .$username. '" data-value="'.$price.'" data-spec="'.$spec.'">'.$username.'</option>';
 }
}

if(isset($_POST['app-submit']))
{

  echo"<script>
            console.log('Appointment again why');
  </script>";

  $patient_id = $_SESSION['patient_id'];
  $pname = $_SESSION['name'];
  $email = $_SESSION['email'];
  $gender = $_SESSION['gender'];
  $contact = $_SESSION['contact'];

  $doctor  = $_POST['doctor'];
  $fee     = $_POST['docfees'];
  $appdate = $_POST['appdate'];
  $apptime = $_POST['apptime'];

  $cur_date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $cur_time = date("H:i:s");
  $apptime1 = strtotime($apptime);
  $appdate1 = strtotime($appdate);
	
  if(date("Y-m-d",$appdate1)>=$cur_date){
    if((date("Y-m-d",$appdate1)==$cur_date and date("H:i:s",$apptime1)>$cur_time) or date("Y-m-d",$appdate1)>$cur_date) {
      
      $doctor_id = "";
      $query1= "select doctor_id from doctor where name = '$doctor';";
      $result1 = mysqli_query($con,$query1);
      while( $row = mysqli_fetch_array($result1) )
      {
          $doctor_id = $row['doctor_id'];
      }

      $check_query = mysqli_query($con,"select time from appointment where doctor_id='$doctor_id' and date='$appdate' and time='$apptime'");

        if(mysqli_num_rows($check_query)==0){

          $query=mysqli_query($con,"insert into appointment (patient_id,doctor_id,date,time,app_status,patient_status,doctor_status) values('$patient_id','$doctor_id','$appdate','$apptime','1','1','1')");

          if($query)
          {
            echo "<script>
            console.log('Appointment again why');
            alert('Your appointment successfully booked');</script>";
          }
          else{
            echo "<script>alert('Unable to process your request. Please try again!');</script>";
          }
      }
      else{
        echo "<script>alert('We are sorry to inform that the doctor is not available in this time or date. Please choose different time or date!');</script>";
      }
    }
    else{
      echo "<script>alert('Select a time or date in the future!');</script>";
    }
  }
  else{
      echo "<script>alert('Select a time or date in the future!');</script>";
  }
  
}

if(isset($_GET['cancel']))
  {
    $query=mysqli_query($con,"update appointment set patient_status=0, app_status=0 where app_id = '".$_GET['app_id']."'");

    if($query)
    {
      echo "<script>alert('Your appointment successfully cancelled');</script>";
      
    }
  }

// if(isset($_POST['pay']))
//   {
//     $bill_id = $_POST['bill_id'];
//     $cur_date = date("d-m-Y");
//     $query=mysqli_query($con,"update bill set status=1 ,date='$cur_date' where bill_id = '".$_GET['bill_id']."'");

//     if($query)
//     {
//       echo "<script>alert('Your appointment successfully cancelled');</script>";
//     }
//   }

if (isset($_POST['pay'])) {

  echo"<script>
  console.log('pay bill');
</script>";
  $bill_id = $_POST['bill_id'];

  echo"<script>
  console.log('pay bill');
</script>";

  $cur_date = date("Y-m-d");

  echo"<script>
  console.log('pay bill');
</script>";

  $query = mysqli_query($con, "UPDATE bill SET status = 1, date = '$cur_date' WHERE bill_id = '$bill_id'");

  echo"<script>
  console.log('pay bill');
</script>";

  if ($query) {
      echo "<script>alert('Your bill payment is successful');</script>";
  } else {
      echo "<script>alert('Error updating bill status');</script>";
  }
}



?>

<html lang="en">
  <head>

    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    
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
        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
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
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $pname; ?> 
   </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:25%; margin-top: 3%">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
      <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Book Appointment</a>
      <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Appointment History</a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescriptions</a>
      <a class="list-group-item list-group-item-action" href="#list-bill" id="list-bill-list" role="tab" data-toggle="list" aria-controls="home">Bill history</a>

    </div><br>
  </div>

  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">

      <div class="tab-pane fade  show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white" >
              <div class="row">
               <div class="col-sm-4" style="left: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Book My Appointment</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>                      
                      <p class="links cl-effect-1">
                        <a href="#list-home" onclick="clickDiv('#list-home-list')">
                          Book Appointment
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">My Appointments</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                          View Appointment History
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

              </div>
               
              <br> <br>

              <div class="row">
                <div class="col-sm-4" style="left: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Prescriptions</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          View Prescription List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> View Bills</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>                      
                      <p class="links cl-effect-1">
                        <a href="#list-home" onclick="clickDiv('#list-bill-list')">
                          Bill History
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

              </div>

            </div>
  </div>

  
      <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">

              <center><h4>Create an appointment</h4></center><br>

              <form class="form-group" method="post" action="tadmin.php">
                <div class="row">

                    <div class="col-md-4">
                          <label for="spec">Specialization:</label>
                    </div>

                    <div class="col-md-8">
                          <select name="spec" class="form-control" id="spec">
                              <option value="" disabled selected>Select Specialization</option>
                              <?php
                                     display_specs();
                              ?>
                          </select>
                    </div>

                        <br><br>

                    <script>
                        document.getElementById('spec').onchange = function foo() {
                        let spec = this.value;   
                        console.log(spec)
                        let docs = [...document.getElementById('doctor').options];
                        
                        docs.forEach((el, ind, arr)=>{
                          arr[ind].setAttribute("style","");
                          if (el.getAttribute("data-spec") != spec ) {
                            arr[ind].setAttribute("style","display: none");
                          }
                        });
                      };

                    </script>



        

              <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                <div class="col-md-8">
                    <select name="doctor" class="form-control" id="doctor" required="required">
                      <option value="" disabled selected>Select Doctor</option>
                        
                      <?php
                       
                       display_docs();

                       ?>

                    </select>
                  </div><br/><br/> 


            <script>
              document.getElementById('doctor').onchange = function updateFees(e) {
                var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                document.getElementById('docfees').value = selection;
              };
            </script>

                  
          
                  
                  <div class="col-md-4"><label for="consultancyfees">
                                Consultancy Fees
                              </label></div>
                              <div class="col-md-8">
                              <input class="form-control" type="text" name="docfees" id="docfees" readonly="readonly"/>
                  </div><br><br>

                  <div class="col-md-4"><label>Appointment Date</label></div>
                  <div class="col-md-8"><input type="date" class="form-control datepicker" name="appdate"></div><br><br>

                  <div class="col-md-4"><label>Appointment Time</label></div>
                  <div class="col-md-8">

                    <select name="apptime" class="form-control" id="apptime" required="required">
                      <option value="" disabled selected>Select Time</option>
                      <option value="08:00:00">8:00 AM</option>
                      <option value="10:00:00">10:00 AM</option>
                      <option value="12:00:00">12:00 PM</option>
                      <option value="14:00:00">2:00 PM</option>
                      <option value="16:00:00">4:00 PM</option>
                    </select>

                  </div><br><br>

                  <div class="col-md-4">
                    <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                  </div>
                  <div class="col-md-8"></div>                  
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>

      <div class="tab-pane fade" id="app-hist" role="tabpanel" aria-labelledby="list-pat-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php 

                    $con=mysqli_connect("localhost","root","","tempdb");
                    global $con;

                    $query = "select app_id,name,fee,date,time,app_status,patient_status,doctor_status 
                    from appointment 
                    inner join doctor ON appointment.doctor_id = doctor.doctor_id
                    where patient_id = '$patient_id';";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>

                        <td><?php echo $row['app_id'];?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['fee'];?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo $row['time'];?></td>
                        <td>
                    <?php 
                    if(($row['patient_status']==1) && ($row['doctor_status']==1))  
                    {
                      echo "Active";
                    }
                    else if(($row['patient_status']==0) && ($row['doctor_status']==1))  
                    {
                      echo "Cancelled by You";
                    }

                    else if(($row['patient_status']==1) && ($row['doctor_status']==0))  
                    {
                      echo "Cancelled by Doctor";

                    }else if(($row['patient_status']==0) && ($row['doctor_status']==0))
                    {
                      echo "appointment completed";
                    }
                        ?></td>

                    <td>
                        <?php if(($row['patient_status']==1) && ($row['doctor_status']==1) && ($row['app_status']==1))  
                        { ?>

													
	                        <a href="tadmin.php?app_id=<?php echo $row['app_id']?>&cancel=update" 
                              onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
	                        <?php } else {

                                echo "Cancelled";
                                } ?>
                        
                        </td>

                    <?php } ?>



                </tbody>
              </table>
        <br>
      </div>
      
      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Diseases</th>
                    <th scope="col">Prescriptions</th>
                    
                  </tr>
                </thead>
                <tbody>
                <?php 

                      $con=mysqli_connect("localhost","root","","tempdb");
                      global $con;

                      $query = "SELECT prescription.app_id AS app_id,disease,medicine,doctor.name AS doctor,appointment.date AS date,appointment.time AS time
                                FROM prescription
                                JOIN appointment ON prescription.app_id = appointment.app_id
                                JOIN doctor ON prescription.doctor_id = doctor.doctor_id
                                WHERE appointment.patient_id = '$patient_id';";

                      $result = mysqli_query($con,$query);
                      if(!$result){
                        echo mysqli_error($con);
                      }


                      while ($row = mysqli_fetch_array($result)){
                      ?>
                        <tr>
                          <td><?php echo $row['doctor'];?></td>
                          <td><?php echo $row['app_id'];?></td>
                          <td><?php echo $row['date'];?></td>
                          <td><?php echo $row['time'];?></td>
                          <td><?php echo $row['disease'];?></td>
                          <td><?php echo $row['medicine'];?></td>
                        </tr>
                      <?php }
                      ?>
                </tbody>
              </table>
        <br>
      </div>

      <div class="tab-pane fade" id="list-bill" role="tabpanel" aria-labelledby="list-bill-list">
              
              <table class="table table-hover">

                <thead>
                  <tr>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Bill ID</th>
                    <th scope="col">Consultancy Fee</th>
                    <th scope="col">CurrentStatus</th>
                    <th scope="col">Paid on</th>
                  </tr>
                </thead>
                <tbody>
                <?php 

                      $con=mysqli_connect("localhost","root","","tempdb");
                      global $con;

                      $query = "SELECT app_id,bill_id,amount,status,date
                                FROM bill
                                WHERE patient_id = '$patient_id';";

                      $result = mysqli_query($con,$query);
                      if(!$result){
                        echo mysqli_error($con);
                      }


                      while ($row = mysqli_fetch_array($result)){
                    ?>
                        <tr>
                          <td><?php echo $row['app_id'];?></td>
                          <td><?php echo $row['bill_id'];?></td>
                          <td><?php echo $row['amount'];?></td>
                          <td>
                        <?php if(($row['status']==0))  
                        { ?>
                            <form method="post" action="tadmin.php">
                              <input type="hidden" name="bill_id" value="<?php echo $row['bill_id']; ?>">
                              <button type="submit" name="pay" class="btn btn-success" onclick="return confirmPayment(<?php echo $row['amount']; ?>)">
                                Pay Bill
                              </button>
                            </form>

                            <script>
                              function confirmPayment(amount) {
                                console.log('Pay Bill button clicked');
                                return confirm('Are you sure you want to pay the amount: Rs ' + amount + '?');
                              }
                            </script>
                                                
	                        <?php } else {

                                echo "Paid";
                                } ?>
                        
                        </td>

                        <td>
                        <?php if(($row['status']== 1))  
                        { 
                               
													  echo $row['date'];
	                      
                        }else{ 

                                echo "--";
                        } ?>
                        
                        </td>

                        <?php }
                      ?>
                      </tr>
                </tbody>
                



              </table>
      </div>


      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>Doctors name: </label>
          <input type="text" name="name" placeholder="Enter doctors name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>
   </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js">
   </script>



  </body>
</html>
