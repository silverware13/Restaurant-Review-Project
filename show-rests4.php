<?php
// start session to keep track of restaurant
session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>

<?php
// setup database variables
$servername = "classmysql.engr.oregonstate.edu";
$username = "cs440_thomasza";
$password = file_get_contents('./db-password.txt', true);
$dbname = "cs440_thomasza";
?>

<div id="logo" class="container">
	<h1><a href="#">Restaurant<span>Reviews</span>Database</a></h1>
	<p>Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a></p>
</div>

<div id="menu" class="container">
	<ul>
		<li><a href="index.html" accesskey="1" title=""><a href="index.html" accesskey="1" title="">Homepage</a></li>
		<li><a href="./show-rests.php" accesskey="2" title="">RI+RR+RS</a></li>
		<li><a href="./show-rests2" accesskey="3" title="">RI+C</a></li>
		<li><a href="./show-rests3" accesskey="4" title="">RI+MI</a></li>
		<li class="current_page_item"><a href="#" accesskey="5" title="">RI="Fried Calamari"</a></li>
	</ul>
</div>

<div id="banner" class="container"> <img src="images/pic03.jpg" width="1200" height="500" alt="" /></div>

<div id="three-column" class="container">
	<div id="tbox1" style="width:92%;">
		<h2>Restaurant Info for restaurants that sell Fried Calamari</h2>
		<h3><b>SQL QUERY:<b/><br />
		<i>SELECT rname AS Restaurant, raddress AS Address, GROUP_CONCAT(DISTINCT mname) AS Menu<br />
		FROM Rests AS R, Meals AS M, Rests_Meals AS RM<br />
		WHERE R.rid = RM.rid AND M.mid = RM.mid AND M.mname = "Fried Calamari"<br />
		GROUP BY rname<br />
		ORDER BY rname;<i/><br /><br /><br /></h3>
		
		<!-- create table from restaurant info -->
		<table width="100%" style="border: 1px solid black;table-layout: fixed;">
		<thead>
		  <tr style="border: 1px solid black;">
			<td style="border: 1px solid black;">Restaurant</td>
			<td style="border: 1px solid black;">Address</td>
			<td style="border: 1px solid black;">Menu</td>
		  </tr>
		</thead>
		<tbody>
		
		<?php
			// create connection.
			$conn = new mysqli($servername, $username, $password, $dbname);
			// check connection.
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			// get data from the database with an SQL query.
			$sql = 
			"SELECT rname AS Restaurant, raddress AS Address, GROUP_CONCAT(DISTINCT mname) AS Menu
			FROM Rests AS R, Meals AS M, Rests_Meals AS RM
			WHERE R.rid = RM.rid AND M.mid = RM.mid AND M.mname = 'Fried Calamari'
			GROUP BY rname
			ORDER BY rname";
			$result = $conn->query($sql);
			// add a row to the table for each restaurant review.
			while($row = $result->fetch_assoc()) {
			?>
			  <tr width="600" style="border: 1px solid black;">
			  <td style="border: 1px solid black;"><?php echo $row["Restaurant"]?></td>
			  <td style="border: 1px solid black;"><?php echo $row["Address"]?></td>
			  <td style="border: 1px solid black;"><?php echo $row["Menu"]?></td>
			  </tr>
		<?php
		}
		$conn->close(); //close the connection.
		?>
		</table>
		
	</div>
</div>

<div id="copyright" class="container">
	<p>Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
</div>

</body>
</html>
