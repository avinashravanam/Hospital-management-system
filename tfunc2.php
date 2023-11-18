<?php
session_start();
$con=mysqli_connect("localhost","root","","tempdb");

if(isset($_POST['patsub1'])){

	$name=$_POST['name'];
  $age=$_POST['age'];
  $gender=$_POST['gender'];
  $email=$_POST['email'];
  $contact=$_POST['contact'];
	$password=$_POST['password'];
  $cpassword=$_POST['cpassword'];

  if($password == $cpassword){

    $query2="select * from patient where email='$email'";
    $result2=mysqli_query($con,$query2);

    echo "<script> console.log('working');</script>";

    if(mysqli_num_rows($result2)== 0){
     
      echo "<script> console.log('working1');</script>";
  	$query="insert into patient(name,email,password,contact,age,gender) values ('$name','$email','$password','$contact','$age','$gender');";
    $result=mysqli_query($con,$query);

    if($result){

        $_SESSION['name'] = $_POST['name'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['contact'] = $_POST['contact'];
        $_SESSION['email'] = $_POST['email'];

        $query1 = "select patient_id from patient where email = '$email';";
        $result1 = mysqli_query($con,$query1);
        
        if($result1){

          while( $row = mysqli_fetch_array($result1) )
          {
              $_SESSION['patient_id'] = $row['patient_id'];
          }

          header("Location:tadmin.php");
          exit;
        }
        else
        {
          header("Location:error1.php");
          exit;
        }

    }
    

       
    }else
    
    {  
      header("Location:texists.php");
      exit;
    }

  }
  else{

    echo "<script> console.log('working2');</script>";
    header("Location:error1.php");
    exit;
  }
}

?>
