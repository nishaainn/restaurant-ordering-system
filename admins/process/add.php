<?php

	session_start();
	require('../../config/database.php');
	
	// FILTER INPUT
	function filter_form_input($FInput) {
		$FInput = filter_var($FInput, FILTER_UNSAFE_RAW); 
		$FInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $FInput);
		
		return $FInput;
	}
	
	
$purpose = filter_input(INPUT_POST, 'purpose', FILTER_SANITIZE_STRING);

// ADD ADMIN
if($purpose == 'addAdmin') {

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$nric = filter_input(INPUT_POST, 'nric', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);


	$username = filter_form_input($username);
    $nric = filter_form_input($nric);
	$email = filter_form_input($email);
	$password = filter_form_input($password);
    $fname = filter_form_input($fname);
    $lname = filter_form_input($lname);
    $phone = filter_form_input($phone);
    $position = filter_form_input($position);

    //OTHER
    $hash = password_hash($password, PASSWORD_DEFAULT);
    

    $stmt = $con->prepare("SELECT first_name FROM user WHERE username = ? OR email = ? OR NRIC = ?");
    $errorchecking = $stmt->bind_param("sss",$username, $email, $nric);
    $errorchecking = $stmt->execute();
    $stmt -> bind_result($f_name);
    $stmt->store_result();
    $val = $stmt->num_rows;
    while ($stmt->fetch()) { $f_name = $f_name; }

    if($val > 0) {
        $_SESSION['result'] = "Failed!";
        $_SESSION['message'] = "Email or Nric Already Exist";
        $_SESSION['icon'] = "error";
        header( "Location: ../addAdmin.php" );
        exit();
    }
    else{
	$sql = "INSERT INTO user (username,nric,email,password,first_name,last_name,phoneno,position) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssss', $username, $nric, $email, $hash, $fname, $lname, $phone, $position );
    
        if(!mysqli_stmt_execute($stmt)) {

            $_SESSION['result'] = "Failed!";
            $_SESSION['message'] = "Please try again.";
            $_SESSION['icon'] = "error";
            header( "Location: ../addAdmin.php" );
            exit();
        
        }
        else{
            $_SESSION['result'] = "Success!";
            $_SESSION['message'] = "Data Saved Successfully";
            $_SESSION['icon'] = "success";
            header( "Location: ../addAdmin.php" );
            exit();
        }
    }
}	 
//END ADD ADMIN

//START ADD MENU
if($purpose == 'addMenu') {

    $menuid = filter_input(INPUT_POST, 'menu_code', FILTER_SANITIZE_STRING);
	$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'menu_name', FILTER_SANITIZE_STRING);
	$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);


	$menuid = filter_form_input($menuid);
    $category = filter_form_input($category);
	$image = filter_form_input($image);
	$name = filter_form_input($name);
    $description = filter_form_input($description);
    $price = filter_form_input($price);

    //OTHER
    $previous = $_SERVER['HTTP_REFERER'];
    $date = date('Y-m-d');

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

	$sql = "INSERT INTO menu (menuid,category,image,name,description,price,date) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssss', $menuid, $category, $upload_file, $name, $description, $price,$date );
    
        if(!mysqli_stmt_execute($stmt)) {

            $_SESSION['result'] = "Failed!";
            $_SESSION['message'] = "Please try again.";
            $_SESSION['icon'] = "error";
            header( "Location: $previous" );
            exit();
        
        }
        else{

            $_SESSION['result'] = "Success!";
            $_SESSION['message'] = "Data Saved Successfully";
            $_SESSION['icon'] = "success";
            header( "Location:  $previous" );
            exit();
        }
}
else {

	session_destroy();
	header('Location: ../index.php');
	exit();

}
?>