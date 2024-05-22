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


?>


<html>
    <head>
		<meta charset="utf-8">
		<title>Best customer</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
        <nav>
			<ul id="menu">
                <li><a href="#">Customers</a></li>
				<li><a href="profile.php"><i class="fas fa-user-circle"></i> <?=$_SESSION['name']?></a></li>
				<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
			</ul>
		</nav>
		<div class="content">
      <br><br><br><br>
      <h2>Best Customers</h2>
      <?php
        $table = mysqli_query($db,"SELECT * FROM Best_Customer");

        echo "<table border='1'>";
        
        $i = 0;
        while($row = $table->fetch_assoc())
        {
            if ($i == 0) {
              $i++;
              echo "<tr>";
              foreach ($row as $key => $value) {
                echo "<th>" . $key . "</th>";
              }
              echo "</tr>";
            }
            echo "<tr>";
            foreach ($row as $value) {
              echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>"; 

        $check = mysqli_num_rows($table);
        if ($check == 0){
          echo "<h3>No data found</h3>";
        }

        $table->close();
      ?>
		</div>

</body>
</html>