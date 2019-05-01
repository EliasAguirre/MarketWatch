<?php
require "common.php";
require "SQLBackendManager.php";
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>MarketWatch</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Overpass:300,400,600,800'>

  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
  #snackbarGeneralOther {
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

  #snackbarGeneralOther.show {
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
<h1 style="font-size:50px" align="center">CPSC 304 MarketWatch Application</h1>
<body>
<div class="tabset">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="Portfolio" checked>
  <label for="tab1">Portfolio</label>
  <input type="radio" name="tabset" id="tab2" aria-controls="Stocks">
  <label for="tab2">Stocks</label>
  <input type="radio" name="tabset" id="tab3" aria-controls="Manage">
  <label for="tab3">Manage</label>
  <input type="radio" name="tabset" id="tab4" aria-controls="Requests">
  <label for="tab4">Requests</label>

  <div class="tab-panels">

    <section id="User" class="tab-panel">
      <div class="test2">
      <div style="display:inline-block;vertical-align:50%;">
        <img src="img/user.png" alt="img"/>
      </div>
      <div style="display:inline-block;" class="test">
        <h2><?php getField('Name', 'Manager'); ?></h2>
        <p><strong>UserId:</strong> <?php echo $_SESSION["UserId"] ?></p>
        <p><strong>Email:</strong> <?php getField('Email', 'Manager'); ?></p>
        <p><strong>Phone:</strong> <?php getField('Phone', 'Manager'); ?></p>
        <p><strong>Number of Portfolio Managed:</strong> <?php getField('Portfolio_Managed', 'Manager'); ?></p>
        <button onclick="document.getElementById('id01').style.display='block'" style="width:140px;">Edit Profile</button>
      </div>
    </div>

    <div id="id01" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    			<h2 align="center">Update Admin Profile</h2>
        </div>

        <div class="container">
          <label for="Name"><b>Full Name</b></label>
          <input type="text" placeholder="Enter Full name" name="Name" required value="<?php getField('Name', 'Manager'); ?>">

          <label for="Phone"><b>Phone Number</b></label>
          <input type="text" placeholder="Enter Phone Number" name="Phone" required value="<?php getField('Phone', 'Manager'); ?>">

          <label for="Email"><b>Email</b></label>
          <input type="text" placeholder="Enter Email" name="Email" required value="<?php getField('Email', 'Manager'); ?>">

          <label for="Password"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="Password" required value="<?php getField('Password', 'Manager'); ?>">

          <label for="Portfolio_Managed"><b>Number of Portfolio Managed</b></label>
          <input type="text" placeholder="0" name="Portfolio_Managed" value="<?php getField('Portfolio_Managed', 'Manager'); ?>" readonly>
          <button type="submit" name="submitUpdate" class="test6">Update</button>

          <!--<input type="submit" name="submit" value="Submit">-->
        </div>
      </form>
    </div>
    <!--start of table-->

        <section class="test3">
        <h2>Portfolio</h2>
        <div class="tbl-header">
          <table cellpadding="0" cellspacing="0" border="0">
            <thead>
              <tr>
                <th>Pid</th>
                <th>Balance</th>
                <th>Since</th>
                <th>UserId</td>
                <th>Name</th>
                <th>Phone</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="tbl-content-short">
          <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <?php foreach ($manageContent as $row) : ?>
              <form method="post">
              <tr>
                <td><?php echo ($row["Pid"]); ?></td>
                <td><?php echo ($row["Balance"]); ?></td>
                <td><?php echo ($row["Since"]); ?></td>
                <td><?php echo ($row["UserId"]); ?></td>
                <td><?php echo ($row["Name"]); ?></td>
                <td><?php echo ($row["Phone"]); ?></td>
              </tr>
            </form>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
<div style="display:inline-block;">
<button onclick="document.getElementById('id02').style.display='block'" style="width:150px;">Add Portfolio</button>
<button onclick="document.getElementById('id03').style.display='block'" style="width:150px;">Drop Portfolio</button>
</div>
<div class="inline">
<form method="post">
<div style="display:inline-block;">
<button type="submit" name="goHome" style="width:100px;">Log Out</button>
</form>
</div>
</div>

<div id="id02" class="modal">

  <form class="modal-content animate" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <h2 align="center">Add Portfolio</h2>
    </div>

    <div class="container">
        <section class="test4">
        <div class="tbl-header">
          <table cellpadding="0" cellspacing="0" border="0">
            <thead>
              <tr>
                <th>Pid</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Balance</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="tbl-content-short">
          <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <?php foreach ($noManager as $row) : ?>
              <tr>
                <td><?php echo ($row["Pid"]); ?></td>
                <td><?php echo ($row["UserId"]); ?></td>
                <td><?php echo ($row["Name"]); ?></td>
                <td><?php echo ($row["Balance"]); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
      <label for="Pid"><b>Portfolio ID</b></label>
      <input type="text" placeholder="Enter Portfolio ID" name="Pid">
      <button type="submit" name="submitAdd" class="test6">Add Portfolio</button>

      <!--<input type="submit" name="submit" value="Submit">-->
    </div>
  </form>
</div>

<div id="id03" class="modal">

  <form class="modal-content animate" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
      <h2 align="center">Drop Portfolio</h2>
    </div>

    <div class="container">
        <section class="test4">
        <div class="tbl-header">
          <table cellpadding="0" cellspacing="0" border="0">
            <thead>
              <tr>
                <th>Pid</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Balance</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="tbl-content-short">
          <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <?php foreach ($manageContent as $row) : ?>
              <tr>
                <td><?php echo ($row["Pid"]); ?></td>
                <td><?php echo ($row["UserId"]); ?></td>
                <td><?php echo ($row["Name"]); ?></td>
                <td><?php echo ($row["Balance"]); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
      <label for="Pid"><b>Portfolio ID</b></label>
      <input type="text" placeholder="Enter Portfolio ID" name="Pid">
      <button type="submit" name="submitDrop" class="test6">Drop Portfolio</button>

      <!--<input type="submit" name="submit" value="Submit">-->
    </div>
  </form>
</div>

<?php
if (isset($_POST['submitDrop'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $Pid = $_POST['Pid'];
    $ManagerId=$_SESSION['UserId'];

    $sql = "UPDATE Portfolio_R1
            SET ManagerId=null
            WHERE Pid=:Pid";

    $statement = $connection->prepare($sql);
    $statement->bindValue(":Pid", $Pid);
    $statement->execute();

    // Get the current number of Portfolio Managed
    $sql = "SELECT Portfolio_Managed FROM Manager
            WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":UserId", $ManagerId);
    $statement->execute();
    $result = $statement->fetchColumn();
    $noManaged = $result - 1;

    // Update the number of Portfolio Managed after Add
    $sql = "UPDATE Manager
            SET Portfolio_Managed=:noManaged
            WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":noManaged", $noManaged);
    $statement->bindValue(":UserId", $ManagerId);
    $statement->execute(); ?>
    <script> window.location.reload() </script> <?php
  } catch(PDOException $error) {
      echo '<script>errorMessage()</script>';
  }
}
?>
</section>

<section id="Stock" class="tab-panel">
  <h2 class="test4">Stock Market</h2>
  <section class="test5">
  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th>Ticker</th>
          <th>Index</th>
          <th>Name</th>
          <th>Industry</th>
          <th>Price</th>
          <th>Shares (Millions)</th>
          <th>Market Cap (Billions)</th>
          <th>EPS</th>
          <th>ROI (%)</th>
          <th>P/E Ratio (Times)</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
          <?php foreach ($result2 as $row) : ?>
          <tr>
            <td><?php echo ($row["Ticker"]); ?></td>
            <td><?php echo ($row["Trade_Index"]); ?></td>
            <td><?php echo ($row["Name"]); ?></td>
            <td><?php echo ($row["Industry"]); ?></td>
            <td><?php echo ($row["Price"]); ?></td>
            <td><?php echo ($row["Shares_Outstanding"]); ?></th>
            <td><?php echo ($row["Market_Cap"]); ?></th>
            <td><?php echo ($row["EPS"]); ?></td>
            <td><?php echo ($row["ROI"]); ?></td>
            <td><?php echo ($row["PE_Ratio"]); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
    </table>
  </div>
</section>
</section>

  <section id="Manage" class="tab-panel">
    <h2 class="test4">Manage Portfolio</h2>
    <form style="display:inline-block;" method="post">
      <div style="display:inline-block;" class="test16">
        <label for="Pid"><b>Portfolio ID :</b></label>
      </div>
      <div style="display:inline-block;" class="test16">
        <input type="text" placeholder="Pid" name="Pid">
      </div>
      <div style="display:inline-block;" class="test16">
        <button type="submit" name="submitPID" class="test10">Manage</button>
          </div>
        </form>
      <section class="test5">

      <?php
      $current = $_SESSION['Pid'];
      if ($current != null) { ?>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Pid</th>
                  <th>Balance</th>
                  <th>Since</th>
                  <th>UserId</td>
                  <th>Name</th>
                  <th>Phone</th>

                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content-short">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <?php foreach ($manageSingle as $row) : ?>
                <tr>
                  <td><?php echo ($row["Pid"]); ?></td>
                  <td><?php echo ($row["Balance"]); ?></td>
                  <td><?php echo ($row["Since"]); ?></td>
                  <td><?php echo ($row["UserId"]); ?></td>
                  <td><?php echo ($row["Name"]); ?></td>
                  <td><?php echo ($row["Phone"]); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
      <?php
    } else { ?>
      <div class="tbl-header">
          <table cellpadding="0" cellspacing="0" border="0">
            <thead>
              <tr>
                <th>Pid</th>
                <th>Balance</th>
                <th>Since</th>
                <th>UserId</td>
                <th>Name</th>
                <th>Phone</th>

              </tr>
            </thead>
          </table>
        </div>
        <div class="tbl-content-short">
          <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <?php foreach ($manageContent as $row) : ?>
              <tr>
                <td><?php echo ($row["Pid"]); ?></td>
                <td><?php echo ($row["Balance"]); ?></td>
                <td><?php echo ($row["Since"]); ?></td>
                <td><?php echo ($row["UserId"]); ?></td>
                <td><?php echo ($row["Name"]); ?></td>
                <td><?php echo ($row["Phone"]); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php
    } ?>
    </section>
    <div style="display:inline-block;">
    <button onclick="document.getElementById('id04').style.display='block'" style="width:150px;">Sell Stock</button>
    <button onclick="document.getElementById('id05').style.display='block'" style="width:150px;">Buy Stock</button>
    </div>

    <div id="id04" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Sell Stock (Portfolio)</h2>
        </div>
        <div class="container">
          <section class="test4">
          <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Ticker</th>
                  <th>Name</th>
                  <th>Industry</th>
                  <th>Price</th>
                  <th>EPS</th>
                  <th>ROI</th>
                  <th>P/E Ratio</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content-short">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <?php foreach ($sellSingle as $row) : ?>
                <tr>
                  <td><?php echo ($row["Ticker"]); ?></td>
                  <td><?php echo ($row["Name"]); ?></td>
                  <td><?php echo ($row["Industry"]); ?></td>
                  <td><?php echo ($row["Price"]); ?></td>
                  <td><?php echo ($row["EPS"]); ?></td>
                  <td><?php echo ($row["ROI"]); ?></td>
                  <td><?php echo ($row["PE_Ratio"]); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          </section>
          <label for="ticker"><b>Stock Ticker</b></label>
          <input type="text" placeholder="Enter Stock Ticker" name="ticker">
          <button type="submit" name="sellStockSubmitPort" class="test6">Sell Stock</button>
        </div>
      </form>
    </div>

    <div id="id05" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Buy Stock (Portfolio)</h2>
        </div>
        <div class="container">
          <section class="test8">
          <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Ticker</th>
                  <th>Name</th>
                  <th>Industry</th>
                  <th>Price</th>
                  <th>EPS</th>
                  <th>ROI</th>
                  <th>P/E Ratio</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content-short">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <?php foreach ($result2 as $row) : ?>
                <tr>
                  <td><?php echo ($row["Ticker"]); ?></td>
                  <td><?php echo ($row["Name"]); ?></td>
                  <td><?php echo ($row["Industry"]); ?></td>
                  <td><?php echo ($row["Price"]); ?></td>
                  <td><?php echo ($row["EPS"]); ?></td>
                  <td><?php echo ($row["ROI"]); ?></td>
                  <td><?php echo ($row["PE_Ratio"]); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>
          <label for="ticker"><b>Stock Ticker</b></label>
          <input type="text" placeholder="Enter Stock Ticker" name="ticker">
          <button type="submit" name="buyStockSubmitPort" class="test6">Buy Stock</button>
        </div>
      </form>
    </div>
  </section>
  <section id="Requests" class="tab-panel">
      <h2 class="test4">Creditor Requests</h2>
      <section class="test5">
        <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
          <thead>
            <tr>
              <th>Pid</th>
              <th>Balance</th>
              <th>UserId</td>
              <th>Name</th>
              <th>InstitutionId</th>
              <th>Institution</th>
              <th>Amount</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="tbl-content-short">
        <table cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <?php foreach ($creditorRequest as $row) : ?>
            <form method="post">
            <tr>
              <td><?php echo ($row["Pid"]); ?></td>
              <td><?php echo ($row["Balance"]); ?></td>
              <td><?php echo ($row["UserId"]); ?></td>
              <td><?php echo ($row["Name"]); ?></td>
              <td><?php echo ($row["InstitutionId"]); ?></td>
              <td><?php echo ($row["Institution"]); ?></td>
              <td><?php echo ($row["Amount_Issued"]); ?></td>
            </tr>
          </form>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      </section>
      <button onclick="document.getElementById('id08').style.display='block'" style="width:100px;">Approve</button>
      <button onclick="document.getElementById('id09').style.display='block'" style="width:100px;">Reject</button>
      <h1> </h1>
      <h2 class="test4">Leverage Requests</h2>
      <section class="test5">
      <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
          <thead>
            <tr>
              <th>CreditId</th>
              <th>UserId</td>
              <th>Name</th>
              <th>InstitutionId</th>
              <th>Institution</th>
              <th>Amount</th>
              <th>Safety Margin</th>
              <th>Interest Rate</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="tbl-content-short">
        <table cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <?php foreach ($leverageRequest as $row) : ?>
            <form method="post">
            <tr>
              <td><?php echo ($row["CreditId"]); ?></td>
              <td><?php echo ($row["UserId"]); ?></td>
              <td><?php echo ($row["Name"]); ?></td>
              <td><?php echo ($row["InstitutionId"]); ?></td>
              <td><?php echo ($row["Institution"]); ?></td>
              <td><?php echo ($row["Amount"]); ?></td>
              <td><?php echo ($row["Safety_Margin"]); ?></td>
              <td><?php echo ($row["Interest_Rate"]); ?></td>
            </tr>
          </form>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
    <button onclick="document.getElementById('id10').style.display='block'" style="width:100px;">Approve</button>
    <button onclick="document.getElementById('id11').style.display='block'" style="width:100px;">Reject</button>
    </section>

    <div id="id08" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id08').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Approve Creditor</h2>
        </div>

        <div class="container">
          <section class="test4">
            <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Pid</th>
                  <th>Balance</th>
                  <th>UserId</td>
                  <th>Name</th>
                  <th>InstitutionId</th>
                  <th>Institution</th>
                  <th>Amount</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content-short">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <?php foreach ($creditorRequest as $row) : ?>
                <form method="post">
                <tr>
                  <td><?php echo ($row["Pid"]); ?></td>
                  <td><?php echo ($row["Balance"]); ?></td>
                  <td><?php echo ($row["UserId"]); ?></td>
                  <td><?php echo ($row["Name"]); ?></td>
                  <td><?php echo ($row["InstitutionId"]); ?></td>
                  <td><?php echo ($row["Institution"]); ?></td>
                  <td><?php echo ($row["Amount_Issued"]); ?></td>
                </tr>
              </form>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>
          <label for="InstitutionId"><b>Institution Id</b></label>
          <input type="text" placeholder="Enter Institution ID" name="InstitutionId">
          <button type="submit" name="ApproveInstitutionId" class="test6">Approve Credit</button>
        </div>
      </form>
    </div>

    <div id="id09" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id09').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Reject Creditor</h2>
        </div>

        <div class="container">
          <section class="test4">
            <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Pid</th>
                  <th>Balance</th>
                  <th>UserId</td>
                  <th>Name</th>
                  <th>InstitutionId</th>
                  <th>Institution</th>
                  <th>Amount</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content-short">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <?php foreach ($creditorRequest as $row) : ?>
                <form method="post">
                <tr>
                  <td><?php echo ($row["Pid"]); ?></td>
                  <td><?php echo ($row["Balance"]); ?></td>
                  <td><?php echo ($row["UserId"]); ?></td>
                  <td><?php echo ($row["Name"]); ?></td>
                  <td><?php echo ($row["InstitutionId"]); ?></td>
                  <td><?php echo ($row["Institution"]); ?></td>
                  <td><?php echo ($row["Amount_Issued"]); ?></td>
                </tr>
              </form>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>
        <label for="InstitutionId"><b>Institution Id</b></label>
        <input type="text" placeholder="Enter Institution ID" name="InstitutionId">
        <button type="submit" name="RejectInstitutionId" class="test6">Reject Credit</button>
        </div>
      </form>
    </div>

    <div id="id10" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id10').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Approve Leverage</h2>
        </div>

        <div class="container">
          <section class="test4">
            <div class="tbl-header">
              <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                  <tr>
                    <th>CreditId</th>
                    <th>UserId</td>
                    <th>Name</th>
                    <th>InstitutionId</th>
                    <th>Institution</th>
                    <th>Amount</th>
                    <th>Safety Margin</th>
                    <th>Interest Rate</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="tbl-content-short">
              <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <?php foreach ($leverageRequest as $row) : ?>
                  <form method="post">
                  <tr>
                    <td><?php echo ($row["CreditId"]); ?></td>
                    <td><?php echo ($row["UserId"]); ?></td>
                    <td><?php echo ($row["Name"]); ?></td>
                    <td><?php echo ($row["InstitutionId"]); ?></td>
                    <td><?php echo ($row["Institution"]); ?></td>
                    <td><?php echo ($row["Amount"]); ?></td>
                    <td><?php echo ($row["Safety_Margin"]); ?></td>
                    <td><?php echo ($row["Interest_Rate"]); ?></td>
                  </tr>
                </form>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
        </section>
          <label for="CreditId"><b>Credit ID</b></label>
          <input type="text" placeholder="Enter Credit ID" name="CreditId">
          <button type="submit" name="ApproveCreditId" class="test6">Approve Leverage</button>
        </div>
      </form>
    </div>

    <div id="id11" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id11').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Reject Leverage</h2>
        </div>

        <div class="container">
          <section class="test4">
            <div class="tbl-header">
              <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                  <tr>
                    <th>CreditId</th>
                    <th>UserId</td>
                    <th>Name</th>
                    <th>InstitutionId</th>
                    <th>Institution</th>
                    <th>Amount</th>
                    <th>Safety Margin</th>
                    <th>Interest Rate</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="tbl-content-short">
              <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <?php foreach ($leverageRequest as $row) : ?>
                  <form method="post">
                  <tr>
                    <td><?php echo ($row["CreditId"]); ?></td>
                    <td><?php echo ($row["UserId"]); ?></td>
                    <td><?php echo ($row["Name"]); ?></td>
                    <td><?php echo ($row["InstitutionId"]); ?></td>
                    <td><?php echo ($row["Institution"]); ?></td>
                    <td><?php echo ($row["Amount"]); ?></td>
                    <td><?php echo ($row["Safety_Margin"]); ?></td>
                    <td><?php echo ($row["Interest_Rate"]); ?></td>
                  </tr>
                </form>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
        </section>
          <label for="CreditId"><b>Credit ID</b></label>
          <input type="text" placeholder="Enter Credit ID" name="CreditId">
          <button type="submit" name="RejectCreditId" class="test6">Reject Leverage</button>
        </div>
      </form>
    </div>

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
var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id03');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id04');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('id05');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id06');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id07');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id08');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id09');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id10');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id11');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<div id="snackbarGeneralOther" style="display: none;">Error. Please try again.</div>
<script>
function errorMessage() {
    var x = document.getElementById("snackbarGeneralOther");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
}
</script>
</body>
</html>
