<?php include '../db_connect.php'; ?>

<?php

if (!empty($_POST['staffId']) && !empty($_POST['salesAmount']) && !empty($_POST['items'])) {
  $staffId = $_POST['staffId'];
  $salesAmount = $_POST['salesAmount'];
  $items = json_decode($_POST['items']);
  // $items = json_decode('[{"id": 5}]');
  $date = date("Y-m-d");

  $sql = "INSERT INTO sales (staffId, salesAmount, dateOfSales) VALUES ('$staffId', '$salesAmount', '$date')";

  for ($i=0; $i<sizeof($items); $i++) {
    $id = $items[$i]->id;
    $num = $items[$i]->num;

    $detailsSql = "INSERT INTO salesdetails (salesId, inventoryId, itemAmount) VALUES (34, '$id', '$num')";
  }

  if ($conn->exec($sql)) {
    // echo sizeof($items);
  }
  else {
    echo "failed";
  }

  // if ($conn->exec($detailsSql)) {
  //   echo 'success';
  // }
}

?>