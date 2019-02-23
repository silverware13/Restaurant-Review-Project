<?php
// start session to keep track of restaurant
session_start();
?>
<!DOCTYPE html>
<html>
<head>
     <title>Review Database</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="screen">
     <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
// setup database variables
$servername = "classmysql.engr.oregonstate.edu";
$username = "cs340_thomasza";
$password = file_get_contents('./db-password.txt', true);
$dbname = "cs340_thomasza";
?>

<div id="main">
     <div id="header-wrapper">
     <div id="header" class="container">
     	<div id="logo">
     		<h1><a href="./"><strong>Restaurant Review Database</strong></a></h1>
     	</div>
     </div></div>
     <div id="page" class="container">
     	<div id="contentFull">
               <h2>List of all restaurants and their ratings.</h2>
               <br>
               <?php
               try {
                    // create connection to database
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                    // set extra PDO settings
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                    // find all reviews
                    $stmt = $conn->prepare("SELECT rname, raddress, roverall, rfood, rservice, rvalue, ratmo FROM Rests, Rating WHERE Rests.rid = Rating.rid"); // use SQL to find all reviews.

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
</div>
</body>
</html>
