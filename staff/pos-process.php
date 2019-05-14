<?php include '../db_connect.php'; ?>

<?php

if (!empty($_POST['staffId']) && !empty($_POST['salesAmount']) && !empty($_POST['items'])) {
  $staffId = $_POST['staffId'];
  $salesAmount = $_POST['salesAmount'];
  $items = json_decode($_POST['items']);
  $date = date("Y-m-d");

  $sql = "INSERT INTO sales (staffId, salesAmount, dateOfSales) VALUES ('$staffId', '$salesAmount', '$date')";

  if ($conn->exec($sql)) {
    $salesIdQuery = "SELECT salesId FROM sales ORDER BY salesId DESC LIMIT 1";

    $currentObj = $conn->query($salesIdQuery);
    $currentObj->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $currentObj->fetch()) {
      $currentId = $row['salesId'];
    }

    for ($i=0; $i<sizeof($items); $i++) {
      $id = $items[$i]->id;
      $num = $items[$i]->num;
      $type = $items[$i]->type;

      if ($type == 'product') {
        echo "productSelected";
        $detailsSql = "INSERT INTO salesdetails (salesId, inventoryId, itemAmount) VALUES ('$currentId', '$id', '$num')";
      } else {
        echo "serviceSelected";
        $detailsSql = "INSERT INTO salesdetails (salesId, inventoryId, itemAmount) VALUES ('$currentId', '$id', '$num')";
      }


      if ($conn->exec($detailsSql)) {
        echo 'success';
      }
    }
  }
  else {
    echo "failed";
  }
}

?>