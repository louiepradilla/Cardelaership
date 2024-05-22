<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'dealership';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['employeeid'], $_POST['password']) ) {
	exit('Please fill both the employeeid and password fields!');
}

if ($stmt = $con->prepare('SELECT EmployeeName, Password, Position FROM employee WHERE EmployeeID = ?')) {
	$stmt->bind_param('i', $_POST['employeeid']);
	$stmt->execute();
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $password, $position);
        $stmt->fetch();
        if ($_POST['password'] === $password) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['id'] = $_POST['employeeid'];
            $_SESSION['name'] = $name;
            $_SESSION['position'] = $position;

            if($_SESSION['position'] == "Assistant"){
                header("location: assistant.php");
            }else if($_SESSION['position'] == "Salesman"){
                   header("location: salesman.php");
            }else if($_SESSION['position'] == "Manager"){
                   header("location: admin.php");
            }else if($_SESSION['position'] == "CEO"){
               header("location: admin.php");
            }


        } else {
            echo 'Incorrect employeeid and/or password!';
        }
    } else {
        echo 'Incorrect employeeid and/or password!';
    }


	$stmt->close();
}
?>