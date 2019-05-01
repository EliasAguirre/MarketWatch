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

// Triggered after submitting Update Customer Profile
if (isset($_POST['submitUpdate'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_user = [
			"UserId"  => $_SESSION["UserId"],
      "Name" =>  $_POST['Name'],
      "Phone"  => $_POST['Phone'],
      "Email"     => $_POST['Email'],
      "Password"  => $_POST['Password'],
      "FICO_Score" => $_POST['FICO_Score'],
      "InstitutionId" => $_POST['InstitutionId'],
    ];
		$sql = "UPDATE Customer SET UserId=:UserId, Password=:Password, Name=:Name, Phone=:Phone, Email=:Email, FICO_Score=:FICO_Score, InstitutionId=:InstitutionId WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Delete Customer Account
if (isset($_POST["deleteGoHome"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $UserId = $_SESSION["UserId"];

    $sql = "DELETE FROM Customer WHERE UserId = :UserId";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':UserId', $UserId);
    $statement->execute();
    session_destroy();
    header("Location: index.php");
    exit;
  } catch(PDOException $error) {
    echo '<script>showErrors()</script>';
  }
}

// Sell(Delete) the selected Stock from Customer Portfolio
if (isset($_POST['sellStockSubmit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sell_stock = [
      "Pid"     => $_SESSION['Pid'],
      "UserId"  => $_SESSION['UserId'],
      "Ticker"  => $_POST['ticker']
    ];

    $sql = "DELETE FROM Contains
            WHERE UserId=:UserId AND Pid=:Pid AND Ticker=:Ticker";

    $statement = $connection->prepare($sql);
    $statement->execute($sell_stock);
  } catch(PDOException $error) {
    echo '<script>showErrors()</script>';
  }
}

// Buy(Insert) the selected Stock into Customer Portfolio
if (isset($_POST['buyStockSubmit'])) {
// todo
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $Ticker=$_POST['ticker'];

    // Update the Contains Table for buying the stock
    $buy_stock = [
      "Pid"     => $_SESSION['Pid'],
      "UserId"  => $_SESSION['UserId'],
      "Ticker"  => $Ticker
    ];
    $sql = "INSERT INTO Contains(Pid, UserId, Ticker)
            VALUES (:Pid, :UserId, :Ticker)";
    $statement = $connection->prepare($sql);
    $statement->execute($buy_stock);

    // Check if the Stock pays Dividends
    $sql = "SELECT R.T_id
            FROM Dividends_R1 R
            WHERE R.Ticker=:Ticker";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':Ticker', $Ticker);
    $statement->execute();
    $tid=$statement->fetchColumn();

    // Pay Customer the Dividends if applicable
    if ($tid != null){
      $div2 = [
        "T_id"    => $tid,
        "Pid"     => $_SESSION['Pid'],
        "UserId"  => $_SESSION['UserId'],
        "Ticker"  => $_POST['ticker']
      ];
      $sql = "INSERT INTO Dividends_R2(T_id, Pid, UserId, Ticker)
              VALUES (:T_id, :Pid, :UserId, :Ticker)";
      $statement = $connection->prepare($sql);
      $statement->execute($div2);
    }

  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Show all the stocks contained in Customer's Portfolio
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $UserId = $_SESSION['UserId'];

  $sql = "SELECT Y.Ticker, Y.Name, Y.Industry,
                   Y.Price, W.EPS, W.ROI, W.PE_Ratio
            FROM Stocks_R1 W, Stocks_R4 Y, Contains C
            WHERE W.Report_Id=Y.Report_Id AND C.UserId=:UserId AND Y.Ticker=C.Ticker";

  $statement = $connection->prepare($sql);
  $statement->bindValue(':UserId', $UserId);
  $statement->execute();
  $portfolioContent = $statement->fetchAll();
} catch(PDOException $error) {
  echo '<script>showErrors()</script>';
}

// Show All the Dividends earned by Customer
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $UserId = $_SESSION['UserId'];

  $sql = "SELECT S.Ticker, S.Name,
                   S.Price, R1.Dividend_Yield
            FROM Stocks_R4 S, Dividends_R1 R1, Dividends_R2 R2, Contains C
            WHERE C.UserId=:UserId AND C.Ticker=S.Ticker AND C.TICKER=R1.TICKER AND C.TICKER=R2.TICKER AND R1.T_id=R2.T_id";

  $statement = $connection->prepare($sql);
  $statement->bindValue(':UserId', $UserId);
  $statement->execute();
  $portfolioContent3 = $statement->fetchAll();

} catch(PDOException $error) {
  echo '<script>showErrors()</script>';
}

// Get the info for Creditor
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $UserId = $_SESSION['UserId'];

  $sql = "SELECT C.InstitutionId, C.Institution,
                   C.Amount_Issued, C.Approved
            FROM Creditor C, Customer U
            WHERE U.UserId=:UserId AND U.InstitutionId=C.InstitutionId";

  $statement = $connection->prepare($sql);
  $statement->bindValue(':UserId', $UserId);
  $statement->execute();
  $creditorTable = $statement->fetchAll();
} catch(PDOException $error) {
  echo '<script>showErrors()</script>';
}

// Request for a leverage
if (isset($_POST['submitReq'])) {
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    $Amount = $_POST['AmountIssued'];

    // Get the number of records in Leverage_R2
    // To calculate the next CreditId
    $sql = "SELECT COUNT(*) FROM Leverage_R2";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchColumn();
    $CreditId = $result + 1;

    $UserId=$_SESSION['UserId'];

    // Get the Customer's InstitutionId
    $sql = "SELECT InstitutionId FROM Customer
            WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":UserId", $UserId);
    $statement->execute();
    $InstitutionId = $statement->fetchColumn();

    // Insert the request in Leverage_R2
    $Safety_Margin=rand(-10, 10);
    $leverage = [
      "CreditId" => $CreditId,
      "InstitutionId" => $InstitutionId,
      "UserId"  => $UserId,
      "Amount"  => $Amount,
      "Safety_Margin" => $Safety_Margin,
      "Approved" => null
    ];

    $sql = "INSERT INTO Leverage_R2(CreditId, InstitutionId, UserId, Amount, Safety_Margin, Approved)
            VALUES (:CreditId, :InstitutionId, :UserId, :Amount, :Safety_Margin, :Approved)";
    $statement = $connection->prepare($sql);
    $statement->execute($leverage);
  } catch(PDOException $error) {
      echo '<script>showErrors()</script>';
  }
}

// Get all the leverage the Customer has (requested)
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $UserId = $_SESSION['UserId'];

  $sql = "SELECT R2.CreditId, R2.Amount, R2.Safety_Margin, R1.Interest_Rate, R2.Approved
          FROM Leverage_R1 R1, Leverage_R2 R2
          WHERE R2.UserId=:UserId AND R1.Safety_Margin=R2.Safety_Margin";

  $statement = $connection->prepare($sql);
  $statement->bindValue(':UserId', $UserId);
  $statement->execute();
  $leverageContent = $statement->fetchAll();
} catch(PDOException $error) {
  echo '<script>showErrors()</script>';
}

// Submit a request for a Creditor
if (isset($_POST['submitReqCre'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $UserId = $_SESSION['UserId'];

    // Get InstitutionId
    $sql = "SELECT COUNT(*) FROM Creditor";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchColumn();
    $InstitutionId = $result + 1;

    // Insert a request
    $creditor = [
      "InstitutionId" => $InstitutionId,
      "Amount_Issued"  => $_POST['Amount_Issued'],
      "Institution" => $_POST['Institution'],
      "Approved" => null
    ];
    $sql = "INSERT INTO Creditor(InstitutionId, Amount_Issued, Institution, Approved)
            VALUES (:InstitutionId, :Amount_Issued, :Institution, :Approved)";
    $statement = $connection->prepare($sql);
    $statement->execute($creditor);

    // Update Customer record
    $sql = "UPDATE Customer
            SET InstitutionId=:InstitutionId
            WHERE UserId=:UserId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(":InstitutionId", $InstitutionId);
    $statement->bindValue(":UserId", $UserId);
    $statement->execute(); ?>
    <script> window.location.reload() </script> <?php
  } catch(PDOException $error) {
    echo '<script>showErrors()</script>';
  }
}

?>
