<?php
require "SQLBackendIndex.php";
?>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styleIndex.css"/>

    <title>MarketWatch</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round" rel="stylesheet">

  </head>

<body>
	<!-- Header -->
	<header id="home">
		<!-- Background Image -->
		<div class="bg-img" style="background-image: url('img/test1.jpg');">
			<div class="overlay"></div>
		</div>
		<!-- /Background Image -->

		<!-- Nav -->
		<nav id="nav" class="navbar nav-transparent">
			<div class="container">

				<div class="navbar-header">
					<!-- Logo -->
					<div class="navbar-brand">
						<a href="index.php">
							<img class="logo-alt" src="img/logo.png" alt="logo">
						</a>
					</div>
					<!-- /Logo -->

					<!-- Collapse nav button -->
					<div class="nav-collapse">
						<span></span>
					</div>
					<!-- /Collapse nav button -->
				</div>

				<!--  Main navigation  -->
				<ul class="main-nav nav navbar-nav navbar-right">
					<li><a href="index.php">Home</a></li>
					<li><a href="#" onclick="document.getElementById('id02').style.display='block'">Register</a></li>
					<li class="has-dropdown"><a href="#">Login</a>
						<ul class="dropdown">
							<li><a href="#" onclick="document.getElementById('id01').style.display='block'">User</a></li>
							<li><a href="#" onclick="document.getElementById('id03').style.display='block'">Admin</a></li>

						</ul>
					</li>
				</ul>
				<!-- /Main navigation -->

			</div>
		</nav>
		<!-- /Nav -->

		<!-- home wrapper -->
		<div class="home-wrapper">
			<div class="container">
				<div class="row">

					<!-- home content -->
					<div class="col-md-10 col-md-offset-1">
						<div class="home-content">
							<h1 class="white-text">CPSC 304 MarketWatch</h1>
							<p class="white-text">Welcome to a state of the art stock analysis and portfolio manager application</p>
							<button onclick="document.getElementById('id01').style.display='block'" class="white-btn">Exisiting Users</button>
							<button onclick="document.getElementById('id02').style.display='block'" class="main-btn">Get Started!</button>
						</div>
					</div>
					<!-- /home content -->

				</div>
			</div>
		</div>
		<!-- /home wrapper -->
	</header>
  <div id="id01" class="modal">

    <form class="modal-content animate" method="post">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
  			<h2 align="center">Login Form</h2>
  			<img src="img/user2.png" alt="Avatar" class="avatar">
      </div>

      <div class="Mcontainer">
        <label for="UserId" class="mlabel"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="UserId" required class="Minput">

        <label for="Password" class="mlabel"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="Password" required class="Minput">

        <button type="submit" name="submitLogin" class="Mbutton">Login</button>
      </div>
    </form>
  </div>

  <div id="id03" class="modal">

    <form class="modal-content animate" method="post">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
  			<h2 align="center">Admin Login Portal</h2>
  			<img src="img/user.png" alt="Avatar" class="avatar">
      </div>

      <div class="Mcontainer">
        <label for="UserId" class="mlabel"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="UserId" required class="Minput">

        <label for="Password" class="mlabel"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="Password" required class="Minput">

        <button type="submit" name="submitLoginManager" class="Mbutton">Login</button>
      </div>
    </form>
  </div>

  <div id="id02" class="modal">

    <form class="modal-content animate" method="post">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
  			<h2 align="center">Registration Form</h2>
  			<img src="img/user2.png" alt="Avatar" class="avatar">
      </div>

      <div class="Mcontainer">
        <label for="uname" class="mlabel"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="UserId" required class="Minput">

        <label for="Name" class="mlabel"><b>Full Name</b></label>
        <input type="text" placeholder="Enter Full name" name="Name" required class="Minput">

        <label for="Phone" class="mlabel"><b>Phone Number</b></label>
        <input type="text" placeholder="Enter Phone Number" name="Phone" required class="Minput">

        <label for="Email" class="mlabel"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="Email" required class="Minput">

        <label for="Password" class="mlabel"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="Password" required class="Minput">

        <button type="submit" name="submitRegister" class="Mbutton">Register</button>
      </div>
    </form>
  </div>

  <script>
  // Get the modal
  var modal = document.getElementById('id01');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
  </script>

  <script>
  // Get the modal
  var modal2 = document.getElementById('id02');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal2) {
          modal.style.display = "none";
      }
  }
  </script>
  <script>
  // Get the modal
  var modal3 = document.getElementById('id03');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal2) {
          modal.style.display = "none";
      }
  }
  </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  </body>
</html>
