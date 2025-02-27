<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'dealership';
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (isset($_POST['submit_button'])){
    if (isset($_POST['searchid'])){

        $searchid = mysqli_real_escape_string($db, $_POST["searchid"]);
        $raise = mysqli_real_escape_string($db, $_POST["raise"]);

        $sql = "CALL RaiseSalary('$searchid', '$raise')";
        if (mysqli_query($db, $sql)){
            echo "<script>
                alert('Salary raise done');
                </script>";
        } else {
            echo "<script>
                alert('Somethong went wrong');
                window.open(admin.php);
                </script>";
        }
    }
} 
?>

<html>
    <head>
		<meta charset="utf-8">
		<title>Admin Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
    <nav>
			<ul id="menu">
                <li><a href="admin.php">Admin Page</a></li>
                <li><a href="#">New employee</a></li>
				<li><a href="profile.php"><i class="fas fa-user-circle"></i> <?=$_SESSION['name']?></a></li>
				<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
			</ul>
		</nav>
		<div class="content">
            <br><br><br><br>
            <div class="cssform">
                <form id="signup" action="raise.php" method="post">
                    <div class="clearfix">
                    <label for="name">Enter EmployeeID</label>
                    <input type="text" name="searchid" id="name" required>
                    </div>
                    <div class="clearfix">
                    <label for="raise">Enter Salry raise percentage</label>
                    <input type="text" name="raise" id="raise" required>
                    </div><br>
                    <input type="submit" name ='submit_button'>
                </form>
            </div>
		</div>

</body>
</html>
