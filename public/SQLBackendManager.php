<html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <style>
  #snackbarGeneral {
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

  #snackbarGeneral.show {
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
<div id="snackbarGeneral" style="display: none;">Error. Please try again.</div>
<script>
function showErrors() {
    var x = document.getElementById("snackbarGeneral");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
}
</script>
</body>
</html>

<?php
require "../config.php";

// Triggered after submitting Update Manager Profile
if (isset($_POST['submitUpdate'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $update = [
			"UserId"    => $_SESSION["UserId"],
      "Password"  => $_POST['Password'],
      "Name"      => $_POST['Name'],
      "Phone"     => $_POST['Phone'],
      "Email"     => $_POST['Email'],
      "Portfolio_Managed" => $_POST['Portfolio_Managed']
    ];
		$sql = "UPDATE Manager
            SET UserId=:UserId, Password=:Password,
                Name=:Name, Phone=:Phone, Email=:Email,
                Portfolio_Managed=:Portfolio_Managed
            WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->execute($update);
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Get the info of all C and P managed by the logged in Manager
try  {
  $connection = new PDO($dsn, $username, $password, $options);

  $ManagerId=$_SESSION['UserId'];

  $sql = "SELECT R1.Pid, R1.Balance, R1.Since, C.UserId,
                 C.Name, C.Phone
          FROM Customer C, Portfolio_R1 R1, Portfolio_R2 R2
          WHERE R1.ManagerId=:ManagerId AND C.UserId=R2.CustomerId
                AND R2.Pid=R1.Pid";
  $statement = $connection->prepare($sql);
  $statement->bindValue(':ManagerId', $ManagerId);
  $statement->execute();
  $manageContent = $statement->fetchAll();
} catch(PDOException $error) {
    echo '<script>showErrors()</script>';
}

// Get the list the C and P with no manager
// Get the list the C and P with no manager
try  {
  $connection = new PDO($dsn, $username, $password, $options);

	$sql = "SELECT P1.Pid, C.UserId, C.Name, P1.Balance
          FROM Customer C, Portfolio_R1 P1, Portfolio_R2 P2
          WHERE P1.ManagerId is NULL AND C.UserId=P2.CustomerId
                AND P1.Pid=P2.Pid";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $noManager = $statement->fetchAll();
} catch(PDOException $error) {
  echo '<script>showErrors()</script>';
}


// Triggered after clicking Add Portfolio
if (isset($_POST['submitAdd'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $Pid=$_POST['Pid'];
    $ManagerId=$_SESSION['UserId'];


    // Update Customer record
    $sql = "UPDATE Portfolio_R1
            SET ManagerId=:ManagerId
            WHERE Pid=:Pid";

    $statement = $connection->prepare($sql);
    $statement->bindValue(":Pid", $Pid);
    $statement->bindValue(":ManagerId", $ManagerId);
    $statement->execute();


    // Get the current number of Portfolio Managed
    $sql = "SELECT Portfolio_Managed FROM Manager
            WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":UserId", $ManagerId);
    $statement->execute();
    $result = $statement->fetchColumn();
    $noManaged = $result + 1;

    // Update the number of Portfolio Managed after Add
		$sql = "UPDATE Manager
            SET Portfolio_Managed=:noManaged
            WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":noManaged", $noManaged);
    $statement->bindValue(":UserId", $ManagerId);
    $statement->execute();?>
    <script> window.location.reload() </script> <?php
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Get Leverage Requests pending for Approval
try  {
  $connection = new PDO($dsn, $username, $password, $options);

  $ManagerId=$_SESSION['UserId'];

  $sql = "SELECT R2.CreditId, U.UserId, U.Name, U.InstitutionId,
                 C.Institution, R2.Amount, R2.Safety_Margin,
                 R1.Interest_Rate
          FROM Leverage_R1 R1, Leverage_R2 R2, Customer U, Creditor C,
               Portfolio_R2 P2, Portfolio_R1 P1
          WHERE R1.Safety_Margin=R2.Safety_Margin
                AND R2.InstitutionId=C.InstitutionId
                AND R2.UserId=U.UserId
                AND U.InstitutionId=C.InstitutionId
                AND P2.CustomerId=U.UserId
                AND P2.Pid=P1.Pid
                AND P1.ManagerId=:ManagerId
                AND R2.Approved is NULL";
  $statement = $connection->prepare($sql);
  $statement->bindValue(':ManagerId', $ManagerId);
  $statement->execute();
  $leverageRequest = $statement->fetchAll();

} catch(PDOException $error) {
    echo '<script>showErrors()</script>';
}

// Get the Creditor request pending for Approval
try  {
  $connection = new PDO($dsn, $username, $password, $options);

  $ManagerId=$_SESSION['UserId'];

  $sql = "SELECT R1.Pid, R1.Balance, U.UserId, U.Name, U.InstitutionId,
                 C.Institution, C.Amount_Issued
          FROM Portfolio_R1 R1, Portfolio_R2 R2, Customer U, Creditor C
          WHERE R1.ManagerId=:ManagerId AND R1.Pid=R2.Pid
                AND R2.CustomerId=U.UserId
                AND U.InstitutionId=C.InstitutionId
                AND C.Approved is NULL";
  $statement = $connection->prepare($sql);
  $statement->bindValue(':ManagerId', $ManagerId);
  $statement->execute();
  $creditorRequest = $statement->fetchAll();

} catch(PDOException $error) {
    echo '<script>showErrors()</script>';
}

// Called to make decision for Customer Creditor request
// Triggered after clicking approval for Creditor requests
if (isset($_POST['ApproveInstitutionId'])) {
  $InstitutionId=$_POST['InstitutionId'];
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "UPDATE Creditor
            SET Approved=1
            WHERE InstitutionId=:InstitutionId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":InstitutionId", $InstitutionId);
    $statement->execute(); ?>
    <script> window.location.reload() </script> <?php
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Triggered after clicking Reject for Creditor requests
if (isset($_POST['RejectInstitutionId'])) {
  $InstitutionId=$_POST['InstitutionId'];
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "DELETE FROM Creditor
            WHERE InstitutionId=:InstitutionId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":InstitutionId", $InstitutionId);
    $statement->execute(); ?>
    <script> window.location.reload() </script> <?php
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}
?>
<?php
// Called to make decision for Customer Levereage request
function LevDecision($CreditId, $dec){
  require "../config.php";

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "UPDATE Leverage_R2
            SET Approved=$dec
            WHERE CreditId=:CreditId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":CreditId", $CreditId);
    $statement->execute();

  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Triggered after clicking approval for Leverage requests
if (isset($_POST['ApproveCreditId'])) {
  $CreditId=$_POST['CreditId'];
  LevDecision($CreditId, 1); ?>
  <script> window.location.reload() </script> <?php
}
?>
<?php
// Triggered after clicking Reject for Leverage requests
if (isset($_POST['RejectCreditId'])) {
  $CreditId=$_POST['CreditId'];
  LevDecision($CreditId, 0); ?>
  <script> window.location.reload() </script> <?php
} ?>
<?php
// Set session varaible when the pid to manage submitted
if (isset($_POST['submitPID'])) {
  $_SESSION['Pid']=$_POST['Pid'];
}

// Show the C and P content for the selected Pid only
try  {
  $connection = new PDO($dsn, $username, $password, $options);

  $ManagerId=$_SESSION['UserId'];
  $Pid=$_SESSION['Pid'];

  $sql = "SELECT R1.Pid, R1.Balance, R1.Since, C.UserId,
                 C.Name, C.Phone
          FROM Customer C, Portfolio_R1 R1, Portfolio_R2 R2
          WHERE R1.ManagerId=:ManagerId AND C.UserId=R2.CustomerId
                AND R2.Pid=R1.Pid AND R1.Pid=:Pid";
  $statement = $connection->prepare($sql);
  $statement->bindValue(':Pid', $Pid);
  $statement->bindValue(':ManagerId', $ManagerId);
  $statement->execute();
  $manageSingle = $statement->fetchAll();
} catch(PDOException $error) {
    echo '<script>showErrors()</script>';
}

// Triggered after submitting buying for selected Pid
if (isset($_POST['buyStockSubmitPort'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $Ticker=$_POST['ticker'];
    $Pid=$_SESSION['Pid'];

    // Get the Customer UserId using Pid
    $sql = "SELECT CustomerId FROM Portfolio_R2
            WHERE Pid=:Pid";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':Pid', $Pid);
    $statement->execute();
    $UserId = $statement->fetchColumn();

    // Update Customer Contains table
    $portfolio = [
			"Pid"       => $Pid,
      "UserId"     => $UserId,
      "Ticker"    => $Ticker
    ];
    $sql = "INSERT INTO Contains
            VALUES (:Pid, :UserId, :Ticker)";
    $statement = $connection->prepare($sql);
    $statement->execute($portfolio);

    // Check if the Stock pays Dividends
    $sql = "SELECT T_id
            FROM Dividends_R1
            WHERE Ticker=:Ticker";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':Ticker', $Ticker);
    $statement->execute();
    $tid=$statement->fetchColumn();

    // Pay Customer the Dividends if applicable
    if ($tid != null){
      $payDiv = [
        "T_id"    => $tid,
        "Pid"     => $Pid,
        "UserId"  => $UserId,
        "Ticker"  => $Ticker
      ];
      $sql = "INSERT INTO Dividends_R2
              VALUES (:T_id, :Pid, :UserId, :Ticker)";
      $statement = $connection->prepare($sql);
      $statement->execute($payDiv);
    }
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Triggered after submitting selling for selected Pid
if (isset($_POST['sellStockSubmitPort'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $Ticker=$_POST['ticker'];
    $Pid=$_SESSION['Pid'];

    // Update Customer Contains table
    $sql = "DELETE FROM Contains
            WHERE Pid=:Pid AND Ticker=:Ticker";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":Ticker", $Ticker);
    $statement->bindValue(":Pid", $Pid);
    $statement->execute();
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Get the portfolio content of the selected Pid
try  {
  $connection = new PDO($dsn, $username, $password, $options);

  $Pid=$_SESSION['Pid'];

  $sql = "SELECT Y.Ticker, Y.Name, Y.Industry,
                   Y.Price, W.EPS, W.ROI, W.PE_Ratio
          FROM Stocks_R1 W, Stocks_R4 Y, Contains C
          WHERE W.Report_Id=Y.Report_Id
                AND C.Pid=:Pid
                AND Y.Ticker=C.Ticker";

  $statement = $connection->prepare($sql);
  $statement->bindValue(':Pid', $Pid);
  $statement->execute();
  $sellSingle = $statement->fetchAll();
} catch(PDOException $error) {
    echo '<script>showErrors()</script>';
}
?>
