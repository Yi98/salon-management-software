<?php include 'db_connect.php'; ?>

<?php 
if (!empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['service']) && !empty($_POST['hairdresser']) && !empty($_POST['request'])) {
  $date = $_POST['date'];
  $time = $_POST['time'];
  $service = $_POST['service'];
  $hairdresser = $_POST['hairdresser'];
  $request = $_POST['request'];

  $sql = "INSERT INTO appointments (userId, appointmentDate, appointmentTime, typeOfServices, request, status) VALUES ('1', '$date', '$time', '$service', '$request', 'unfulfilled')";

  if ($conn->exec($sql)) {
    echo "success";
  }
  else {
    echo "fail";
  }
}

?>