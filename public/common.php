<?php
require "../encryption.php";
require "../config.php";

// Print the field $attr from $table
function getField($attr, $table){
  $UserId=$_SESSION["UserId"];
  require "../config.php";
  try{
    $connection = new PDO($dsn, $username, $password, $options);
		$sql = "SELECT $attr FROM $table WHERE UserId='$UserId'";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchColumn();
    echo $result;
  } catch(Exception $error) {
      echo $sql . "<br>" . $error->getMessage() . (int)$error->getCode();
  }
}

// Log out
if (isset($_POST['goHome'])) {
  session_destroy();
  header("Location: index.php");
  exit;
}

// Get the list of ALL the stocks available
try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT Y.Ticker, X.Trade_Index, X.Name, X.Industry,
                 Y.Price, C.Shares_Outstanding, C.Market_Cap,
                 W.EPS, W.ROI, W.PE_Ratio
          FROM Stocks_R1 W, Stocks_R3 X, Stocks_R4 Y, Company C
          WHERE W.Report_Id=Y.Report_Id AND X.Name=Y.Name
                AND X.Industry=Y.Industry AND Y.Name=C.name
                AND Y.Industry=C.Industry";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result2 = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}


?>
