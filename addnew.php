<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'dbconfig.php';
	
	if(isset($_POST['btnsave']))
	{
		$firstName = filter_input(INPUT_POST,'firstName',FILTER_SANITIZE_STRING);// name
		$lastName = filter_input(INPUT_POST,'lastName',FILTER_SANITIZE_STRING);// surname
		$emailAddress = filter_input(INPUT_POST,'emailAddress',FILTER_VALIDATE_EMAIL);// emailAddress
		$mobileNumber = filter_input(INPUT_POST,'mobileNumber',FILTER_SANITIZE_STRING);;// mobile
		
		
		if(empty($firstName)){
			$errMSG = "Please Enter Name.";
		}
		else if(empty($lastName)){
			$errMSG = "Please Enter Your Surname";
		}
		else if(empty($emailAddress)){
			$errMSG = "Please Enter Your email Address";
		}
		else if(empty($mobileNumber)){
			$errMSG = "Please Enter Your Mobile Number.";
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO address(name,surname,email,mobile) VALUES(:firstName, :lastName, :emailAddress,:mobileNumber)');
			$stmt->bindParam(':firstName',$firstName);
			$stmt->bindParam(':lastName',$lastName);
			$stmt->bindParam(':emailAddress',$emailAddress);
			$stmt->bindParam(':mobileNumber',$mobileNumber);
			
			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:5;index.php"); // redirects after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Insert New Record</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body>

<div class="container">

	<div class="page-header">
    	<h1 class="h2">Add New Address. <a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; view all </a></h1>
    </div>
    

	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post"  class="form-horizontal">
	    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">First Name.</label></td>
        <td><input class="form-control" type="text" name="firstName" placeholder="Enter First Name" value="<?php echo $firstName; ?>" /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Last Name.</label></td>
        <td><input class="form-control" type="text" name="lastName" placeholder="Enter Last Name" value="<?php echo $lastName; ?>" /></td>
    </tr>
	
	  <tr>
    	<td><label class="control-label">Email Address.</label></td>
        <td><input class="form-control" type="text" name="emailAddress" placeholder="Enetr Email Address" value="<?php echo $emailAddress; ?>" /></td>
    </tr>
	
	  <tr>
    	<td><label class="control-label">Mobile Number</label></td>
        <td><input class="form-control" type="text" name="mobileNumber" placeholder="Enter Mobile Number" value="<?php echo $mobileNumber ?>" /></td>
    </tr>
    
    
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>

    

</div>


<!--JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>