<?php include 'db_connect.php'; ?>

<?php 
// book appointment
if (!empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['service']) && !empty($_POST['hairdresser']) && !empty($_POST['request'])) {

  $sql = "SELECT COUNT(*) AS 'total' from appointments WHERE userId=2";
  $q = $conn->query($sql);
  $result = $q->fetch();

  if ($result['total'] < 2) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];
    $hairdresser = $_POST['hairdresser'];
    $request = $_POST['request'];

    $sql = "INSERT INTO appointments (userId, appointmentDate, appointmentTime, typeOfServices, hairdresser, request, status) VALUES ('2', '$date', '$time', '$service', '$hairdresser', '$request', 'unfulfilled')";

    if ($conn->exec($sql)) {
      echo "success";
    }
    else {
      echo "fail";
    }
  }
  else {
    echo "over";
  }
  
}

// delete appointment
if (!empty($_POST['action']) && !empty($_POST['appId'])) {
  $id = $_POST['appId'];
  $sql = "DELETE FROM appointments WHERE appointmentId=$id";

  if ($conn->exec($sql)) {
    echo "success";
  }
  else {
    echo "fail";
  }
}

?>