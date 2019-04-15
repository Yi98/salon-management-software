<?php include 'db_connect.php'; ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

?>

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
    
      $mail = new PHPMailer(true);

      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );

      try {
          //Server settings
          $mail->SMTPDebug = 0;                                       // Enable verbose debug output
          $mail->isSMTP();                                            // Set mailer to use SMTP
          $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'smileandstylesalon@gmail.com';                     // SMTP username
          $mail->Password   = 'smileandstyle';                               // SMTP password
          $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
          $mail->Port       = 587;                                    // TCP port to connect to

          //Recipients
          $mail->setFrom('smileandstylesalon@gmail.com', 'Smile And Style Salon');
          $mail->addAddress('ngyi07285@hotmail.com', 'Joe User');     // Add a recipient

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Appointment booking acknowledgment';
          $mail->Body  = '
          <h3>Dear valued customer, we are happy to notify you that your appointment has been confirmed.</h3>
          <h4 class="ui dividing header">Appointment Summary</h4>
          <p><b>Date: </b>'.$date.'</p>
          <p><b>Time: </b>'.$time.'</p>
          <p><b>Service: </b>'.$service.'</p>
          <p><b>Hairdresser: </b>'.$hairdresser.'</p>
          <p><b>Special Request: </b>'.$request.'</p>';
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          $mail->send();
          // echo 'Message has been sent';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

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

if (!empty($_POST['action']) && !empty($_POST['date']) && !empty($_POST['time'])) {
  $date = $_POST['date'];
  $time = $_POST['time'];

  if ($_POST['action'] === 'checkAvailability') {
    $sql = "SELECT hairdresser FROM appointments WHERE appointmentDate='$date' AND appointmentTime='$time'";
    $q = $conn->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $q->fetch()) {
      echo "|";
      print_r($row['hairdresser']);
    }
  }
}

?>