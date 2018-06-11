<?php

	error_reporting( ~E_NOTICE );
	
	require_once 'dbconfig.php';
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		
		$stmt_edit = $DB_con->prepare('SELECT id,name,surname,email,mobile FROM address WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);

	}
	else
	{
		header("Location: index.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
		$firstName = $_POST['firstName'];// Name
		$lastName = $_POST['lastName'];// Surname
		$emailAddress = $_POST['emailAddress'];// email
		$mobileNumber = $_POST['mobileNumber'];// mobile			
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE address
									     SET name=:firstName, 
										     surname=:lastName, 
										     email=:emailAddress,
											 mobile=:mobileNumber
								       WHERE id=:uid');
			$stmt->bindParam(':firstName',$firstName);
			$stmt->bindParam(':lastName',$lastName);
			$stmt->bindParam(':emailAddress',$emailAddress);
			$stmt->bindParam(':mobileNumber',$mobileNumber);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='index.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		
		}
		
						
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update User Information</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<!-- stylesheet -->
<link rel="stylesheet" href="style.css">

<!--  JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<script src="jquery-1.11.3-jquery.min.js"></script>
</head>
<body>

<div class="container">


	<div class="page-header">
    	<h1 class="h2">Update Address <a class="btn btn-default" href="index.php"> all members </a></h1>
    </div>

<div class="clearfix"></div>

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">First Name</label></td>
        <td><input class="form-control" type="text" name="firstName" value="<?php echo $name; ?>" required /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Last Name</label></td>
        <td><input class="form-control" type="text" name="lastName" value="<?php echo $surname; ?>" required /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Email Address</label></td>
        <td><input class="form-control" type="text" name="emailAddress" value="<?php echo $email; ?>" required /></td>
    </tr>
    
   <tr>
    	<td><label class="control-label">Mobile Number</label></td>
        <td><input class="form-control" type="text" name="mobileNumber" value="<?php echo $mobile; ?>" required /></td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>
</body>
</html>