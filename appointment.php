<?php include 'db_connect.php'; ?>

<?php 
// !empty(userId) && !empty(appointmentDate) && !empty(typeOfServices) && !empty(request) && !empty(status)
// $sql = "INSERT INTO appointments (userId, appointmentDate, appointmentTime, typeOfServices, request, status) VALUES ('1', '2-3-2019', '09:00-11:00', 'hair-cutting', 'I might be late for a little bit', 'fulfilled')";

// use exec() because no results are returned

// $conn->exec($sql);
// echo "New record created successfully";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Shipping Details</title>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
  <script src="script.js"></script>
</head>
<body>
  <div class="container">
    <div class="purchase-flow-other">
      <div class="ui steps">
        <div id="date-step" class="active step">
          <i class="calendar alternate icon"></i>
          <div class="content">
            <div class="title">Date & Time</div>
            <div class="description">Personalize your time</div>
          </div>
        </div>
        <div id="service-step" class="step">
          <i class="shopping cart icon"></i>
          <div class="content">
            <div class="title">Services</div>
            <div class="description">Choose your service</div>
          </div>
        </div>
        <div id="request-step" class="step">
          <i class="bullhorn icon"></i>
          <div class="content">
            <div class="title">Special Request</div>
            <div class="description">We hear you</div>
          </div>
        </div>
        <div id="summary-step" class="disabled step">
          <i class="info icon"></i>
          <div class="content">
            <div class="title">Confirm Appointment</div>
          </div>
        </div>
      </div>
    </div>

    <!-- date and time form -->
    <form class="ui form" id="date-form">
      <h3 class="ui dividing header">Date & Time</h3>
      <div class="field">
        <label>Date</label>
        <div class="field">
          <input type="date" name="date" id="appointment-date">
        </div>
      </div>
        <div class="field">
          <label>Timeslot</label>
          <select class="ui fluid dropdown">
            <option value="">Pick your time</option>
            <option value="sab">09:00 - 11:00</option>
            <option value="sar">11:00 - 13:00</option>
            <option value="ked">13:00 - 15:00</option>
            <option value="per">15:00 - 17:00</option>
          </select>
        </div>
      <button type="button" class="btn btn-primary next-button" onclick="onCompleteDateInfo()">Next <i class="arrow right icon"></i></button>
    </form>


    <!-- services details form -->
    <form class="ui form" id="service-form">
      <h3 class="ui dividing header">Services</h3>
      <div class="field">
        <label>Type of services</label>
        <select class="ui fluid search dropdown" name="card[type]">
          <option value="">Choose your service</option>
          <option value="1">Hair-cutting</option>
          <option value="2">Hair-dyeing</option>
          <option value="3">Hair consultation</option>
        </select>
      </div>
      <div class="field">
        <label>Hairdresser</label>
        <select class="ui fluid search dropdown" name="card[type]">
          <option value="">Choose your service</option>
          <option value="1">David Cheam</option>
          <option value="2">Steven Lau</option>
          <option value="3">Joanne Cheong</option>
          <option value="4">Any</option>
        </select>
      </div>
      <button type="button" class="btn btn-primary next-button" onclick="onCompleteServicesInfo()">Next <i class="arrow right icon"></i></button>
      <button type="button" class="btn btn-primary next-button" onclick="onBackToDate()"><i class="arrow left icon"></i> Back to previous</button>
    </form>

    <!-- request form -->
    <form class="ui form" id="request-form">
      <h3 class="ui dividing header">Special Request</h3>
      <div class="field">
        <textarea placeholder="Enter you request" id="request-box"></textarea>
      </div>
      <div>
        <div class="ui checkbox">
          <input type="checkbox" name="example" id="hasRequest" onchange="onSwitchRequest()">
          <label for="hasRequest">I do not have any special requests</label>
        </div>
      </div>
      <button type="button" class="btn btn-primary next-button" onclick="onCompleteRequestInfo()">Next <i class="arrow right icon"></i></button>
      <button type="button" class="btn btn-primary next-button" onclick="onBackToService()"><i class="arrow left icon"></i> Back to previous</button>
    </form>


    <!-- summary form -->
    <form class="ui form" id="summary-form">
      <h3 class="ui dividing header">Appointment Summary</h3>
      <p class="summary-title">Date: </p>
      <p class="summary-title">Time: </p>
      <p class="summary-title">Service: </p>
      <p class="summary-title">Hairdresser: </p>
      <p class="summary-title">Special Request: </p>
      <button type="button" class="btn btn-primary next-button" onclick="onConfirmSummary()"><i class="check icon"></i> Confirm</button>
      <button type="button" class="btn btn-primary next-button" onclick="onEditSummary()"><i class="edit icon"></i> Edit</button>
    </form>

    <!-- Pop out confirmation -->
    <div class="ui basic modal modal-container">
      <div class="ui icon header">
        <i class="calendar check icon"></i>
        Appointment confirmed
      </div>
      <div class="content">
        <p class="modal-message">You have successfully booked the appointment. Have a nice day :)</p>
      </div>
      <div class="actions">
        <div class="ui orange ok inverted button okay-button-modal">
          <i class="checkmark icon"></i>
          Great
        </div>
      </div>
    </div>

  </div>
</body>
</html>

