<?php
// start session to keep track of restaurant
session_start();
?>

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
$username = "cs340_thomasza";
$password = file_get_contents('./db-password.txt', true);
$dbname = "cs340_thomasza";
?>


<div id="header-wrapper">
<div id="header" class="container">
<div id="logo" class="container">
	<h1><a href="#">Restaurant<span>Reviews</span>Database</a></h1>
	<p>Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a></p>
</div>
 </div></div>
 
<div id="menu" class="container">
	<ul>
		<li><a href="index.html" accesskey="1" title="">Homepage</a></li>
		<li class="current_page_item"><a href="#" accesskey="2" title="">Restaurant Reviews</a></li>
	</ul>
</div>
<div id="banner" class="container"> <img src="images/pic01.jpg" width="1200" height="500" alt="" /></div>
 
<div id="three-column" class="container">
	<div id="tbox1" style="width:100%;">
		<h2>Restaurant Reviews:</h2>

				   <?php
			   try {
					// create connection to database
					$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

					// set extra PDO settings
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
					$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

					// find all reviews
					$stmt = $conn->prepare("SELECT rname, raddress, roverall, rfood, rservice, rvalue, ratmo, source FROM Rests, Rating WHERE Rests.rid = Rating.rid"); // use SQL to find all reviews.

					// add a string for each review
					if($stmt->execute()) {
						 while($row = $stmt->fetch()) {
						 ?>
							  <form enctype="multipart/form-data" action="" method="post">
								   <input type="submit" name="submit" value="<?php echo $row["rname"]?>" id="hyperlink-style-button" class="restraunt_name"/>
							  </form>
						 <?php
						 }
					}
			   }
			   catch(\PDOException $e)
			   {
					//$error_message = $e->getMessage();
					//echo "<tr><td>", $error_message, "</td></tr>\n";
			   }

			   $conn->close(); //close the connection
			   ?>
		
	</div>
</div>


<div id="copyright" class="container">
<p>Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
</div>

</body>
</html>
