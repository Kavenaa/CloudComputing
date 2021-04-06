<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>

    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script src="index.js"></script>
    <style>

table, th, td {
  border: 2px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
  border: 1px;
  margin: 50px;
}

h1 {
  position: relative;
  top: 0px;
  text-align: center;
  font-size: 24px;
  text-transform: uppercase;
  color: #303030;
  font-weight: 600;
  margin-bottom: 30px;
}

h2 {
  position: relative;
  top: 1px;
  text-align: center;
  color: Black;
  font-family: verdana;
  font-size: 100%;
}
.button {
  position: relative;
  top: 20px;
  left: 700px;
  border: none;
  padding: 15px 30px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px 2px;
  cursor: pointer;
}
body {
  background-color:lightseagreen;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}
caption {
  font-size: 28px;
  color: black;
  text-align: center;
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

.fas {
  align-items: center;
  display: flex;
  position: fixed;
  right: 25px;
  top: 18px;
  font-size:24px;
}
</style>

    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="topnav">
      <a href="#">About</a>
      <a href="#">Contact</a>
      <a href="#">Help</a>
      <i class='fas fa-cart-arrow-down'></i>
    </div>

    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="map.html" class="btn btn-warning">See Bus Stops</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    
    <table style="width:100%">
      <caption>Daily Tickets</caption>
      <tr>
        <th>Age</th>
        <th>Price</th>
        <th></th>
      </tr>
      <tr>
        <td>12yrs & under</td>
        <td>FREE</td>
        <td><button class="dailyKid" id="daily_free" type="button" value="12yrs & under" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>13yrs-17yrs</td>
        <td>$3.99</td>
        <td><button class="dailyTeen" id="daily_teen" type="button" value="13yrs-17yrs" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>Post-secondary Student</td>
        <td>$4.99</td>
        <td><button class="dailyStudent" id="daily_student" type="button" value="Post-secondary Student" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>Adults</td>
        <td>$6.99</td>
        <td><button class="dailyAdult" id="daily_adult" type="button" value="Adults" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>Seniors (65yrs+)</td>
        <td>$4.99</td>
        <td><button class="dailySenior" id="daily_senior" type="button" value="Seniors (65yrs+)" onclick="sendEmail()">Add to cart</button></td>
      </tr>
    </table>

    <table style="width:100%">
      <caption>Monthly Tickets</caption>
      <tr>
        <th>Age</th>
        <th>Price</th>
        <th></th>
      </tr>
      <tr>
        <td>12yrs & under</td>
        <td>FREE</td>
        <td><button class="monthlyKid" id="monthly_kid" type="button" value="12yrs & under" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>13yrs-17yrs</td>
        <td>$112.00</td>
        <td><button class="monthlyTeen" id="monthly_teen" type="button" value="13yrs-17yrs" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>Post-secondary Student</td>
        <td>$145.00</td>
        <td><button class="monthlyStudent" id="monthly_student" type="button" value="Post-secondary Student" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>Adults</td>
        <td>$210.00</td>
        <td><button class="monthlyAdult" id="monthly_adult" type="button" value="Adults" onclick="sendEmail()">Add to cart</button></td>
      </tr>
      <tr>
        <td>Seniors (65yrs+)</td>
        <td>$145.00</td>
        <td><button class="monthlySenior" id="monthly_senior" type="button" value="Seniors (65yrs+)" onclick="sendEmail()">Add to cart</button></td>
      </tr>
    </table>

    <div id="map" style="width:100%;height:400px;"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <input type = "text" class = "form-control" name = "term" id = "search" placeholder="Search..." value="">
    <button class="location" id="b1" type="button" value="submit" onclick="getLocation()">Get your location</button>
    <button class="zoomout" id="b2" type="button" value="submit" onclick="zoomOut()">Zoom Out</button>
    <button class="zoomin" id="b3" type="button" value="submit" onclick="zoomIn()">Zoom In</button>

<div id="info_div"></div>

<form method="post">

</form>


<script type="text/javascript">
      // document.getElementById("emailbtn").onclick = function() {sendEmail()};
       var email='<?php echo $_SESSION["email"]?>';
       var name='<?php echo $_SESSION["name"]?>';
       
     function sendEmail(){
         /* window.open('mailto:christopher.phan1@ontariotechu.net?subject=Train ticket Confirmation&body=Confirmation'); */

        console.log("testingccp425");
          Email.send({
              Host: "smtp.gmail.com",
              Username: "testingccp425@gmail.com",
              Password: "Asdf1234!1",
              To: email,
              From: "testingccp425@gmail.com",
              Subject:"Train ticket Confirmation - " + name,
              Body: "Name: " + name + ". You purchased: " + document.getElementById("daily_free").value,
          }).then(
            message => alert("Mail sent successful")
          );
           // alert("mailed");
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5Ibcb2PTtNPOZmNrVec89jNHlyUCTiIc&callback=myMap&libraries=places"></script>
</body>
</html>