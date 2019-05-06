<?php include '../db_connect.php'; ?>

<?php

if (!empty($_POST['staffId']) && !empty($_POST['salesAmount']) && !empty($_POST['items'])) {
  $staffId = $_POST['staffId'];
  $salesAmount = $_POST['salesAmount'];
  $items = json_decode($_POST['items']);
  // $items = json_decode('[{"id": 5}]');
  $date = date("Y-m-d");

  $sql = "INSERT INTO sales (staffId, salesAmount, dateOfSales) VALUES ('$staffId', '$salesAmount', '$date')";

  if ($conn->exec($sql)) {
    // echo "success";
    echo $items[0]->id;
  }
  else {
    echo "failed";
  }
}

?>