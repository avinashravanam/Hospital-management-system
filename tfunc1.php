<?php
session_start();
$con=mysqli_connect("localhost","root","","tempdb");
if(isset($_POST['docsub1']))
{
	$demail=$_POST['username3'];
	$dpass=$_POST['password3'];

	$query="select * from doctor where email='$demail' and password='$dpass' and working_status=1;";
	$result=mysqli_query($con,$query);
	if(mysqli_num_rows($result)==1)
	{
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
    
		      $_SESSION['dname']=$row['name'];
              $_SESSION['doctor_id'] = $row['doctor_id'];
      
    }
		header("Location:tdoctorpanel.php");
	}
	else{
  
    echo("<script>alert('Invalid Username or Password. Try Again!');
          window.location.href = 'index.php';</script>");
  }
}

?>