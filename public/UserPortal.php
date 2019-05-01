<?php
require "common.php";
require "SQLBackend.php";
?>
<!DOCTYPE html>
<html>
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
  <input type="radio" name="tabset" id="tab1" aria-controls="User" checked>
  <label for="tab1">User Profile</label>
  <?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $UserId = $_SESSION["UserId"];

    $sql = "SELECT Pid FROM Portfolio_R2 WHERE CustomerId = :UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':UserId', $UserId);
    $statement->execute();

    $result = $statement->fetchColumn();
    if ($result != null){
      $_SESSION['Pid']=$result;
      ?>
  <input type="radio" name="tabset" id="tab2" aria-controls="Portfolio">
  <label for="tab2">Portfolio</label>
  <?php }
  } catch(PDOException $error) {
    echo '<script>errorMessage()</script>';
  }
  ?>
  <input type="radio" name="tabset" id="tab3" aria-controls="Stock">
  <label for="tab3">Stocks</label>

  <?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $UserId = $_SESSION["UserId"];

    $sql = "SELECT InstitutionId FROM Customer WHERE UserId = :UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':UserId', $UserId);
    $statement->execute();

    $result = $statement->fetchColumn();
    if ($result != null){
      $_SESSION['Pid']=$result;
      ?>
  <input type="radio" name="tabset" id="tab4" aria-controls="Creditor">
  <label for="tab4">Creditor</label>
  <?php }
  } catch(PDOException $error) {
    echo '<script>errorMessage()</script>';
  }
  ?>
  <div class="tab-panels">
    <section id="User" class="tab-panel">
      <div class="test2">
      <div style="display:inline-block;vertical-align:50%;">
        <img src="img/user2.png" alt="img"/>
      </div>
      <div style="display:inline-block;" class="test">
        <h2><?php getField('Name', 'Customer'); ?></h2>
        <p><strong>UserId:</strong> <?php echo $_SESSION["UserId"]; ?></p>
        <p><strong>Email:</strong> <?php getField('Email', 'Customer'); ?></p>
        <p><strong>Phone:</strong> <?php getField('Phone', 'Customer'); ?></p>
        <p><strong>FICO Score:</strong> <?php getField('FICO_Score', 'Customer'); ?></p>
        <button onclick="document.getElementById('id01').style.display='block'" style="width:140px;">Edit Profile</button>
      </div>
    </div>

    <div id="id01" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    			<h2 align="center">Update User Profile</h2>
        </div>

        <div class="container">
          <label for="Name"><b>Full Name</b></label>
          <input type="text" placeholder="Enter Full name" name="Name" required value="<?php getField('Name', 'Customer'); ?>">

          <label for="Phone"><b>Phone Number</b></label>
          <input type="text" placeholder="Enter Phone Number" name="Phone" required value="<?php getField('Phone', 'Customer'); ?>">

          <label for="Email"><b>Email</b></label>
          <input type="text" placeholder="Enter Email" name="Email" required value="<?php getField('Email', 'Customer'); ?>">

          <label for="Password"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="Password" required value="<?php getField('Password', 'Customer'); ?>">

          <label for="FICO_Score"><b>FICO Score</b></label>
          <input type="text" placeholder="Preview FICO_Score" name="FICO_Score" required value="<?php getField('FICO_Score', 'Customer'); ?>" readonly>

          <label for="InstitutionId"><b>Institution ID</b></label>
          <input type="text" placeholder="None" name="InstitutionId" readonly value=<?php if (getField('InstitutionId', 'Customer') == null){?> "None" <?php }else ?> "<?php getField('InstitutionId', 'Customer')?>">
          <button type="submit" name="submitUpdate" class="test6">Update</button>

        </div>
      </form>
    </div>
<?php
try{
  $connection = new PDO($dsn, $username, $password, $options);

  $UserId = $_SESSION["UserId"];

  $sql = "SELECT Pid FROM Portfolio_R2 WHERE CustomerId = :UserId";
  $statement = $connection->prepare($sql);
  $statement->bindValue(':UserId', $UserId);
  $statement->execute();

  $result = $statement->fetchColumn();
  if ($result != null){
    $_SESSION['Pid']=$result;
    ?>
    <section class="test3">
    <h2>Portfolio</h2>
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
          <?php foreach ($portfolioContent as $row) : ?>
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
  <?php } else{?>
    <h3></h3>
    <form style="display:inline-block;" method="post">
    <button type="submit" name="createPort" style="width:180px;">Create Portfolio</button>
  </form>
  <?php }
} catch(PDOException $error) {
  echo '<script>errorMessage()</script>';
}

if (isset($_POST['createPort'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT COUNT(*) FROM Portfolio_R2 UNION SELECT COUNT(*) FROM Portfolio_R1";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $finalRes = max($result);
    $finalFinalRes = $finalRes[0];
    echo $finalFinalRes;
    $Pid = $finalFinalRes + 1;

    $date = date('Y-m-d', time());
    $balance = rand(0,500000);

    $new_user = [
			"Pid"  => $Pid,
      "Dates" =>  $date,
      "Balance"  => $balance,
      "Since"     => $date,
      "ManagerId"  => null,
    ];

    $new_user2 = [
      "Pid" => $Pid,
      "CustomerId" => $_SESSION["UserId"],
    ];
		$sql = "INSERT INTO Portfolio_R1 (Pid, Dates, Balance, Since, ManagerId) VALUES (:Pid, :Dates, :Balance, :Since, :ManagerId)";
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
    $sql = "INSERT INTO Portfolio_R2 (Pid, CustomerId) VALUES (:Pid, :CustomerId)";
    $statement = $connection->prepare($sql);
    $statement->execute($new_user2);?>
    <script> window.location.reload() </script> <?php
  } catch(PDOException $error) {
      echo '<script>errorMessage()</script>';
  }
}

?>
<!-- <div class="inline"> -->
<form style="display:inline-block;" method="post">
<button type="submit" name="deleteGoHome" style="width:160px">Delete Account</button>
<button type="submit" name="goHome" style="width:100px;">Log Out</button>
</form>
<!-- </div> -->
</section>
  <section id="Portfolio" class="tab-panel">
    <h2 class="test4">Manage Portfolio</h2>
    <section class="test5">
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
          <?php foreach ($portfolioContent as $row2) : ?>
          <tr>
            <td><?php echo ($row2["Ticker"]); ?></td>
            <td><?php echo ($row2["Name"]); ?></td>
            <td><?php echo ($row2["Industry"]); ?></td>
            <td><?php echo ($row2["Price"]); ?></td>
            <td><?php echo ($row2["EPS"]); ?></td>
            <td><?php echo ($row2["ROI"]); ?></td>
            <td><?php echo ($row2["PE_Ratio"]); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
    <button onclick="document.getElementById('id02').style.display='block'" style="width:100px;">Sell</button>
    <button onclick="document.getElementById('id03').style.display='block'" style="width:100px;">Buy</button>
    <button onclick="document.getElementById('id04').style.display='block'" style="width:130px;" name="showDiv">Dividends</button>
    <?php
    try {
      $connection = new PDO($dsn, $username, $password, $options);
      $UserId = $_SESSION['UserId'];

      $sql = "SELECT C.InstitutionId
                FROM Customer C
                WHERE C.UserId=:UserId";

      $statement = $connection->prepare($sql);
      $statement->bindValue(':UserId', $UserId);
      $statement->execute();
      $hasCreditor = $statement->fetchColumn();

      $sql = "SELECT P1.ManagerId
                FROM Customer C, Portfolio_R1 P1, Portfolio_R2 P2
                WHERE C.UserId=:UserId AND P2.CustomerId=C.UserId
                      AND P1.Pid=P2.Pid";

      $statement = $connection->prepare($sql);
      $statement->bindValue(':UserId', $UserId);
      $statement->execute();
      $hasManager = $statement->fetchColumn();


    } catch(PDOException $error) {
      echo '<script>errorMessage()</script>';
    }
    if ($hasCreditor != null || $hasManager != null) { ?>
      <button onclick="document.getElementById('id05').style.display='block'" style="width:180px;" name="ReqCreditor">Request Creditor</button>
    <?php
  }
    ?>

    <div id="id05" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
    			<h2 align="center">Request a Creditor</h2>
        </div>

        <div class="container">
          <label for="Institution"><b>Institution Name</b></label>
          <input type="text" placeholder="Enter Institution" name="Institution">

          <label for="Amount_Issued"><b>Credit Amount</b></label>
          <input type="text" placeholder="Enter credit amount" name="Amount_Issued">
          <button type="submit" name="submitReqCre" class="test6">Submit Request</button>
        </div>
      </form>
    </div>


    <div id="id02" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Sell Portfolio Stock</h2>
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
                <?php foreach ($portfolioContent as $row) : ?>
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
          <button type="submit" name="sellStockSubmit" class="test6">Sell Stock</button>
        </div>
      </form>
    </div>

    <div id="id03" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Buy Stock For Portfolio</h2>
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
                  <th>Sell</th>
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
          <button type="submit" name="buyStockSubmit" class="test6">Buy Stock</button>
        </div>
      </form>
    </div>

    <div id="id04" class="modal">

      <form class="modal-content animate" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
          <h2 align="center">Dividends Earned From Portfolio</h2>
        </div>

        <div class="container">
          <section class="test4">
          <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead>
                <tr>
                  <th>Ticker</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Yield Ratio</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <?php foreach ($portfolioContent3 as $row) : ?>
                <tr>
                  <td><?php echo ($row["Ticker"]); ?></td>
                  <td><?php echo ($row["Name"]); ?></td>
                  <td><?php echo ($row["Price"]); ?></td>
                  <td><?php echo ($row["Dividend_Yield"]); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>
        </div>
      </form>
    </div>
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

    <section id="Creditor" class="tab-panel">
          <div class="test20">
          <div class="test2">
          <div style="display:inline-block;vertical-align:top;">
            <img src="img/creditor.png" alt="img"/>
          </div>
          <div style="display:inline-block;" class="test">
            <?php foreach ($creditorTable as $row) : ?>
            <h2><?php echo ($row["Institution"]); ?> </h2>
            <p><strong>InstitutionId:</strong> <?php echo ($row["InstitutionId"]); ?> </p>
            <p><strong>Amount (Hundreds):</strong> <?php echo ($row["Amount_Issued"]); ?> </p>
            <p><strong>Approval:</strong> <?php if ($row["Approved"] == null) { echo "Pending Approval"; } else if ($row["Approved"] == 1) { echo "Approved"; } else { echo "Rejected"; } ?> </p>
            <?php endforeach; ?>
            <?php
            try{
              $connection = new PDO($dsn, $username, $password, $options);

              $UserId = $_SESSION["UserId"];

              $sql = "SELECT C.Approved
                      FROM Customer U, Creditor C
                      WHERE U.UserId = :UserId AND U.InstitutionId=C.InstitutionId";
              $statement = $connection->prepare($sql);
              $statement->bindValue(':UserId', $UserId);
              $statement->execute();

              $result = $statement->fetchColumn();
              if ($result == 1){ ?>
                <label for="AmountIssued"><b>Amount:</b></label>
              </div>
              <form style="display:inline-block;" method="post">
              <div style="display:inline-block;" class="test9">
                <input type="text" placeholder="Amount" name="AmountIssued">
              </div>
              <div style="display:inline-block;" class="test11">
                <button type="submit" name="submitReq" class="test10">Request</button>
              </div>
            </form>
            <?php }
            } catch(PDOException $error) {
              echo '<script>errorMessage()</script>';
            }
            ?>
        </div>
      </div>
        <div class="test3">
        <h2 class="test4">Leverage</h2>
        <section class="test5">
        <div class="tbl-header">
          <table cellpadding="0" cellspacing="0" border="0">
            <thead>
              <tr>
                <th>Credit ID</th>
                <th>Amount</th>
                <th>Safety Margin</th>
                <th>Interest Rate</th>
                <th>Approval</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="tbl-content-short">
          <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
              <?php foreach ($leverageContent as $row2) : ?>
              <tr>
                <td><?php echo ($row2["CreditId"]); ?></td>
                <td><?php echo ($row2["Amount"]); ?></td>
                <td><?php echo ($row2["Safety_Margin"]); ?></td>
                <td><?php echo ($row2["Interest_Rate"]); ?></td>
                <td><?php if ($row2["Approved"] == null) { echo "Pending Approval"; } else if ($row["Approved"] == 1) { echo "Approved"; } else { echo "Rejected"; } ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
    </section>

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
