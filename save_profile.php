<?php

session_start();
 include "connection.php";
 
// Retrieve form data
if(isset($_POST['edit']))
 {
	$id  = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];  
    $position = $_POST['position'];
    $department = $_POST['department'];
	$contactnumber = $_POST['contactnumber'];

    // SQL query to insert data into the database
	
    $update = "update employee_profiles set name='$name' , email='$email' , position='$position', department = '$department' ,contactnumber ='$contactnumber 'where id='$id'";)
    $sql=mysqli_query($conn,$update);
	   
if($sql)
       { 
           /*Successful*/
           header('location:dashboard.html');
       }
       else
       {
           /*sorry your profile is not update*/
           header('location:save_profile.php');
       }
    }
    else
    {
        /*sorry your id is not match*/
        header('location:save_profile.php');
    }
 }

?>


