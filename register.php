<?php

$servername = "aa1j2ay19mvo8dl.cew1fvzp06l6.us-east-2.rds.amazonaws.com";
$username = "cap";
$password = "capstonedb";

try {
  $conn = new PDO("mysql:host=$servername;dbname=ebdb", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // echo "Connected successfully";

  // insert a row
  $name = $_POST["name"];
  $email = $_POST["email"];
  $upassword = $_POST["upassword"];

  // hashing password
  $param_password = password_hash($upassword, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO test (name, email, upassword) VALUES (:name, :email, :upassword)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':upassword', $param_password);


  $stmt->execute();


 // echo "New records created successfully";
  header("refresh:2; url=login.php");
}catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
$conn = null;

// define variables and set to empty values
$nameErr = $emailErr = $passErr = "";
$name = $email = $upassword = "";

if (isset($_POST["login"])) {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  if (empty($_POST["upassword"])) {
    $passErr = "Password is required";
  } else {
    $upassword = test_input($_POST["upassword"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Train Ticket System</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
* {
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
}

.wrapper { 
    width: 350px; 
    padding: 20px;
    position: relative;
    left: -25px;
    display: inline-block;
    text-align: right;
}

.wrapper__button { 
    width: 350px; 
    padding: 20px;
    position: relative;
    left: 395px;
    top: -50px;
}

body {
  margin: 0;
  background-color: lightseagreen;
  font-family: Arial, Helvetica, sans-serif;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Style the content */
.content {
  background-color: #ddd;
  padding: 10px;
  height: 200px; /* Should be removed. Only for demonstration */
}

/* Style the footer */
.footer {
  background-color: #f1f1f1;
  padding: 10px;
}


h1 {
  text-align: center;
  color: Black;
  font-family: verdana;
  font-size: 180%;
}

h2 {
  text-align: center;
  color: Black;
  font-family: verdana;
  font-size: 150%;
}

p  {
  text-align: center;
  color: black;
  font-family: verdana;
  font-size: 100%;
}

div {
  text-align: center;
}

</style>
</head>
<body>

<div class="topnav">
  <a href="#">About</a>
  <a href="#">Contact</a>
  <a href="#">Help</a>
</div>

<div class="container">
    <div class="wrapper">

    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
         Name: <input type="text" name="name">
    <span class="error">* <?php echo $nameErr;?></span>
    <br><br>
    Password: <input type="text" name="upassword">
    <span class="error">* <?php echo $passErr;?></span>
    <br><br>
         E-mail: <input type="text" name="email">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>
    </div>

<div class="wrapper__button">
    <input type="submit" name="submit" value="Submit" />  
</div>
</form>
</div>
</body>
</html>