<html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <style>
  #snackbar, #snackbar2, #snackbarGeneral {
  	border-radius: 7px;
      visibility: hidden;
      min-width: 400px;
      margin-left: -220px;
      background-color: #B22222;
      color: #fff;
      text-align: center;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      top: 40px;
      font-size: 17px;
  }

  #snackbar.show, #snackbar2.show, #snackbarGeneral.show {
      visibility: visible;
      -webkit-animation: fadein 1.5s, fadeout 1.5s 2.5s;
      animation: fadein 1.5s, fadeout 1.5s 2.5s;
  }
  @-webkit-keyframes fadein {
      from {top: 0; opacity: 0;}
      to {top: 40px; opacity: 1;}
  }

  @keyframes fadein {
      from {top: 0; opacity: 0;}
      to {top: 40px; opacity: 1;}
  }

  @-webkit-keyframes fadeout {
      from {top: 40px; opacity: 1;}
      to {top: 0; opacity: 0;}
  }

  @keyframes fadeout {
      from {top: 40px; opacity: 1;}
      to {top: 0; opacity: 0;}
  }
  </style>
</head>
<body>
<div id="snackbar" style="display: none;">Invalid Username or Password. Please try again.</div>
<script>
function myFunction() {
    var x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
}
</script>
<div id="snackbar2" style="display: none;">Please enter unique information (User, Phone, Email).</div>
<script>
function myFunction2() {
    var x = document.getElementById("snackbar2");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
}
</script>
<div id="snackbarGeneral" style="display: none;">Invalid Input. Please try again.</div>
<script>
function myFunction3() {
    var x = document.getElementById("snackbarGeneral");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
}
</script>
</body>
</html>
<?php
require "../config.php";
if (isset($_POST['submitRegister'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $FICOScore = RAND(100,500);

    $new_user = [
			"UserId"  => $_POST["UserId"],
      "Name" =>  $_POST['Name'],
      "Phone"  => $_POST['Phone'],
      "Email"     => $_POST['Email'],
      "Password"  => $_POST['Password'],
      "FICO_Score" => $FICOScore,
      "InstitutionId" => null,
    ];
		$sql = "INSERT INTO Customer (UserId, Password, Name, Phone, Email, FICO_Score, InstitutionId) VALUES (:UserId, :Password, :Name, :Phone, :Email, :FICO_Score, :InstitutionId)";
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo '<script>myFunction2()</script>';
  }
}
if (isset($_POST['submitLogin'])){
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $new_test = [
      "UserId"  => $_POST['UserId']
    ];

		$sql = "SELECT Password FROM Customer WHERE UserId=(:UserId)";
    $statement = $connection->prepare($sql);
    $statement->execute($new_test);

    $result = $statement->fetchColumn();
    if ($result == $_POST['Password']){
      session_start();
      $_SESSION['UserId'] = $_POST['UserId'];
      header("Location: UserPortal.php");
      exit;
    } else{
    echo '<script>myFunction()</script>';
    }
  } catch(PDOException $error) {
    echo '<script>myFunction3()</script>';
  }
}
if (isset($_POST['submitLoginManager'])){
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $new_test = [
      "UserId"  => $_POST['UserId']
    ];

		$sql = "SELECT Password FROM Manager WHERE UserId=(:UserId)";
    $statement = $connection->prepare($sql);
    $statement->execute($new_test);

    $result = $statement->fetchColumn();
    if ($result == $_POST['Password']){
      session_start();
      $_SESSION['UserId'] = $_POST['UserId'];
      header("Location: AdminPortal.php");
      exit;
    } else{
      echo '<script>myFunction()</script>';
    }
  } catch(PDOException $error) {
      echo '<script>myFunction3()</script>';
  }
}
?>
