<?php
session_start();
require('../../config/database.php');
// require('../../config/security.php');



// FILTER INPUT
function filter_form_input($FInput) {
    $FInput = filter_var($FInput, FILTER_UNSAFE_RAW); 
    $FInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $FInput);
    
    return $FInput;
}


$purpose = filter_input(INPUT_POST, 'purpose', FILTER_SANITIZE_STRING);

// EDIT PROFILE
if($purpose == 'editprofile') {

    $nric = filter_input(INPUT_POST, 'nric', FILTER_SANITIZE_STRING);
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
	$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
	$position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);



    $fname = filter_form_input($fname);
    $lname = filter_form_input($lname);
    $username = filter_form_input($username);
	$email = filter_form_input($email);
    $phone = filter_form_input($phone);
	$status = filter_form_input($status);
	$position = filter_form_input($position);



	// OTHER
	$date = date("Y-m-d");
	$previous = $_SERVER['HTTP_REFERER'];

	if($stmt = $con->prepare("UPDATE user SET first_name = ?, last_name = ?, username = ?, email = ?, phoneno = ?, status = ?, position = ? WHERE NRIC = ?"));
    {	
        $stmt->bind_param( "ssssssss", $fname, $lname, $username, $email, $phone, $status, $position,$nric);
            
		if(!$stmt->execute()) {

			$_SESSION['result'] = "Failed!"; 
			$_SESSION['message'] = "Data not saved.Please try again.";
			$_SESSION['icon'] = "error";
			header( "Location: $previous" );
			exit();
			
		} else {
			
			$stmt->close();
			$con->close();
		
			$_SESSION['result'] = "Success!";
			$_SESSION['message'] = "Update save successfully.";
			$_SESSION['icon'] = "success";
			header( "Location: $previous" );
			exit();
		}
	} 
}
//END EDIT PROFILE

//UPDATE DRINK
if($purpose == 'updatedrink') {

	$menuid = filter_input(INPUT_POST, 'menuid', FILTER_SANITIZE_STRING);
    $prodname = filter_input(INPUT_POST, 'prodname', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    $prodname = filter_form_input($prodname);
    $description = filter_form_input($description);
    $price = filter_form_input($price);
	$status = filter_form_input($status);

	// OTHER
	$date = date("Y-m-d");
	$previous = $_SERVER['HTTP_REFERER'];

    if(isset($_FILES['image'])){

		// IMAGE DETAILS
        $file_name = $_FILES['image']['name'];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $tmp_name = $_FILES['image']['tmp_name'];
		$file_size = $_FILES['image']['size'];
		$file_error = $_FILES['image']['error'];
        
		// IMAGE TO BE UPLOAD
        $upload_file = "img-".uniqid().".".$file_type;
        $upload_path = "../assets/image/menu/".$upload_file;
          
        if($file_error === 0){

            // CHECK FILE SIZE
            if($_FILES['file-input']['size'] >= 5000000){
                $_SESSION['icon'] = "Failed!";
				$_SESSION['message'] = "Image may exceed less than 5mb";
				$_SESSION['alert'] = "error";
				header( "Location: $previous" );
				exit();
            }
            // CHECK FILE EXTENSION
            if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"){
                $_SESSION['result'] = "Failed!";
				$_SESSION['message'] = "Only PNG, JPG dan JPEG Allowed.";
				$_SESSION['icon'] = "error";
				header( "Location:  $previous" );
				exit();
            }

            // UPLOAD TO DB AND SERVER
            if($file_type != '') {
                move_uploaded_file($tmp_name, $upload_path);

                // $stmt = $con->prepare("UPDATE users SET image = ? WHERE email = ?");
                // $errorchecking = $stmt->bind_param("ss", $upload_file, $email);
                // $errorchecking = $stmt->execute();
            }
        }
    }


	if($stmt = $con->prepare("UPDATE menu SET name = ?, description = ?,  price = ?, status = ?, date = ? WHERE menuid = ?"));
    {	
        $stmt->bind_param( "ssssss", $prodname, $description, $price, $status, $date, $menuid);
            
		if(!$stmt->execute()) {

			$_SESSION['result'] = "Failed!";
			$_SESSION['message'] = "Data not saved.Please try again.";
			$_SESSION['icon'] = "error";
			header( "Location: $previous" );
			exit();
			
		} else {
			
			$stmt->close();
			$con->close();
		
			$_SESSION['result'] = "Success!";
			$_SESSION['message'] = "Menu Update save successfully.";
			$_SESSION['icon'] = "success";
			header( "Location: $previous" );
			exit();
		}
	} 
}
//END UPDATE DRINK

//UPDATE DRINK
if($purpose == 'updatePizza') {

	$menuid = filter_input(INPUT_POST, 'menuid', FILTER_SANITIZE_STRING);
    $prodname = filter_input(INPUT_POST, 'prodname', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    $prodname = filter_form_input($prodname);
    $description = filter_form_input($description);
    $price = filter_form_input($price);
	$status = filter_form_input($status);

	// OTHER
	$date = date("Y-m-d");
	$previous = $_SERVER['HTTP_REFERER'];

	
    if(isset($_FILES['image'])){

		// IMAGE DETAILS
        $file_name = $_FILES['image']['name'];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $tmp_name = $_FILES['image']['tmp_name'];
		$file_size = $_FILES['image']['size'];
		$file_error = $_FILES['image']['error'];
        
		// IMAGE TO BE UPLOAD
        $upload_file = "img-".uniqid().".".$file_type;
        $upload_path = "../assets/image/menu/".$upload_file;
          
        if($file_error === 0){

            // CHECK FILE SIZE
            if($_FILES['file-input']['size'] >= 5000000){
                $_SESSION['icon'] = "Failed!";
				$_SESSION['message'] = "Image may exceed less than 5mb";
				$_SESSION['alert'] = "error";
				header( "Location: $previous" );
				exit();
            }
            // CHECK FILE EXTENSION
            if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"){
                $_SESSION['result'] = "Failed!";
				$_SESSION['message'] = "Only PNG, JPG dan JPEG Allowed.";
				$_SESSION['icon'] = "error";
				header( "Location:  $previous" );
				exit();
            }

            // UPLOAD TO DB AND SERVER
            if($file_type != '') {
                move_uploaded_file($tmp_name, $upload_path);

                // $stmt = $con->prepare("UPDATE users SET image = ? WHERE email = ?");
                // $errorchecking = $stmt->bind_param("ss", $upload_file, $email);
                // $errorchecking = $stmt->execute();
            }
        }
    }


	if($stmt = $con->prepare("UPDATE menu SET name = ?, description = ?,  price = ?, status = ?, date = ? WHERE menuid = ?"));
    {	
        $stmt->bind_param( "ssssss", $prodname, $description, $price, $status, $date, $menuid);
            
		if(!$stmt->execute()) {

			$_SESSION['result'] = "Failed!";
			$_SESSION['message'] = "Data not saved.Please try again.";
			$_SESSION['icon'] = "error";
			header( "Location: $previous" );
			exit();
			
		} else {
			
			$stmt->close();
			$con->close();
		
			$_SESSION['result'] = "Success!";
			$_SESSION['message'] = "Menu Update save successfully.";
			$_SESSION['icon'] = "success";
			header( "Location: $previous" );
			exit();
		}
	} 
}
//END UPDATE DRINK
 
// CHANGE PASSWORD
if($purpose == 'changePassword') {
	
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$oldPass = filter_input(INPUT_POST, 'oldPass', FILTER_SANITIZE_STRING);
    $newPass = filter_input(INPUT_POST, 'newPass', FILTER_SANITIZE_STRING);
    $confirmPass = filter_input(INPUT_POST, 'confirmPass', FILTER_SANITIZE_STRING);

	$oldPass = filter_form_input($oldPass);
    $newPass = filter_form_input($newPass);
    $confirmPass = filter_form_input($confirmPass);

    // OTHER
	$hash = password_hash($newPass, PASSWORD_DEFAULT);
	$previous = $_SERVER['HTTP_REFERER'];

    // CHECK BOTH INPUT
	if($confirmPass != $newPass){
        session_destroy();
        header( "Location: ../index.php" );
        exit();
    }

	// CHECK OLD PASS IN DATABASE
	$stmt = $con->prepare("SELECT password FROM user WHERE username = ? ");
	$errorchecking = $stmt->bind_param("s", $username);
	$errorchecking = $stmt->execute();
	$stmt -> bind_result($password);
	$stmt->store_result();
	$val = $stmt->num_rows; 
	while ($stmt->fetch()){ 
		$password = $password; 
	}

	

	if(!password_verify($oldPass, $password)) {	
        $_SESSION['result'] = "Failed!";
		$_SESSION['message'] = "Check your old password.";
		$_SESSION['icon'] = "error";
        header( "Location: $previous" );
        exit();
    }

	// START PROCESSING
	if($stmt = $con->prepare("UPDATE user SET password = ? WHERE username = ?"))
    {	
        $stmt->bind_param( "ss", $hash, $username );
            
		if(!$stmt->execute()) {

			$_SESSION['result'] = "Failed!";
			$_SESSION['message'] = "Please try again.";
			$_SESSION['icon'] = "error";
			header( "Location: $previous" );
			exit();
			
		} else {
			
			$stmt->close();
			$con->close();
		
			$_SESSION['result'] = "Success!";
			$_SESSION['message'] = "Password saved.";
			$_SESSION['icon'] = "success";
			header( "Location: $previous" );
			exit();
		}
	} else{

		$_SESSION['result'] = "Failed!";
		$_SESSION['message'] = "Please try again.";
		$_SESSION['icon'] = "error";
        header( "Location: $previous" );
        exit();
		
	}
}
// END CHANGE PASSWORD
else
{
	session_destroy();
    header('Location: ../index.php');
	exit();
}

?>