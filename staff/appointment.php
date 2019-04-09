<?php include '../db_connect.php'; ?>

<?php

$sql = 'SELECT * from appointments';

$q = $conn->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appointment List</title>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
  <script src="../script.js"></script>
</head>
<body>
  <div class="container">
    <h1 class="appointment-list-title">Appointment List</h1>
    <table class="ui striped table">
      <thead>
        <tr>
          <th>User</th>
          <th>Date</th>
          <th>Time</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John Lilki</td>
          <td>September 14, 2013</td>
          <td>jhlilk22@yahoo.com</td>
          <td><a onclick="onViewAppointment()">view details</a></td>
        </tr>
        <?php while ($row = $q->fetch()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['userId']) ?></td>
            <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
            <td><?php echo htmlspecialchars($row['appointmentTime']); ?></td>
            <td><a onclick="onViewAppointment()">view details</a></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <div class="ui modal" id="appointment-details-modal">
      <div class="header">Appointment details</div>
      <div class="content">
        <p class="appointment-details-title">User: </p>
        <p class="appointment-details-title">Appointment Date: </p>
        <p class="appointment-details-title">Appointment Time: </p>
        <p class="appointment-details-title">Service: </p>
        <p class="appointment-details-title">Request: </p>
      </div>
    </div>

  </div>
</body>
</html>

