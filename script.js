var navTop = $("#navigation-bar").offset().top;

var stickyNav = function(){
    if ($(window).scrollTop() > navTop){
        $("#navigation-bar").addClass("sticky");
    } else {
        $("#navigation-bar").removeClass("sticky");
    }
};

stickyNav();

$(window).scroll(function(){
    stickyNav();
});

// functions when user presses next in booking appointment

function onCompleteDateInfo() {
	const dateForm = document.getElementById('date-form');
	const serviceForm = document.getElementById('service-form');
	const dateStep = document.getElementById('date-step');
	const serviceStep = document.getElementById('service-step');

	const appointmentDate = document.getElementById('appointment-date').value;
	const appointmentTime = document.getElementById('appointment-time').value;

	let allSlotsFull = true;

	if (!appointmentDate || appointmentTime == "none") {
		if (!appointmentDate) {
			$('#appointment-date')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}

		if (appointmentTime == "none") {
			$('#appointment-time')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}
	}
	else {
		sessionStorage.setItem("date", appointmentDate);
		sessionStorage.setItem("time", appointmentTime);

		const date = sessionStorage.getItem("date");
  	const time = sessionStorage.getItem("time");

		const http = new XMLHttpRequest();
    const url = 'appointment-process.php';
    const params = `date=${date}&time=${time}&action=checkAvailability`;
    http.open('POST', url, true);

    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
      if(http.readyState == 4 && http.status == 200) {
				let hairdressers = http.responseText.split("|");
				console.log(hairdressers);

				const hairdresserElement = document.getElementById('hairdresser');
				const nodes = hairdresserElement.getElementsByTagName('option');

	     	if (hairdressers.length >= 4) {
					for (let i=1; i<nodes.length; i++) {
						nodes[i].disabled = true;
						nodes[i].style.backgroundColor = "rgba(200, 200, 200, 0.3)";
					}
	       }
	       else {
					for (let i=0; i<nodes.length; i++) {
		       	if (hairdressers.includes(nodes[i].attributes.value.textContent) && nodes[i].attributes.value.textContent !== 'Any') {
		       		nodes[i].disabled = true;
		       		nodes[i].style.backgroundColor = "rgba(200, 200, 200, 0.3)";
		       	}
		       	else {
		       		nodes[i].disabled = false;
		     			nodes[i].style.backgroundColor = "white";
		       	}
		       }
	       }

				for (let i=1; i<nodes.length-1; i++) {
					if (nodes[i].disabled == false) {
						allSlotsFull = false;
					}
				}

				if (allSlotsFull) {
				 	nodes[nodes.length-1].disabled = true;
				 	nodes[nodes.length-1].style.backgroundColor = "rgba(200, 200, 200, 0.3)";
				}
      }
    }

    http.send(params);

		dateForm.style.display = "none";
		serviceForm.style.display = "block";

		dateStep.classList.remove("active");
		dateStep.classList.add("completed");
		serviceStep.classList.add("active");
	}	
}


function onCompleteServicesInfo() {
	const serviceForm = document.getElementById('service-form');
	const requestForm = document.getElementById('request-form');
	const serviceStep = document.getElementById('service-step');
	const requestStep = document.getElementById('request-step');

  const service = document.getElementById('service').value;
  const hairdresser = document.getElementById('hairdresser').value;

	if (service === "none" || hairdresser == "none") {
		if (service === "none") {
			$('#service')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}

		if (hairdresser == "none") {
			$('#hairdresser')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
		}
	}
	else {
		sessionStorage.setItem("service", service);
	  sessionStorage.setItem("hairdresser", hairdresser);

		serviceForm.style.display = "none";
		requestForm.style.display = "block";

		serviceStep.classList.remove("active");
		serviceStep.classList.add("completed");
		requestStep.classList.add("active");
	}

}


function onCompleteRequestInfo() {
	const requestForm = document.getElementById('request-form');
	const summaryForm = document.getElementById('summary-form');
	const requestStep = document.getElementById('request-step');
	const summaryStep = document.getElementById('summary-step');

  const request = document.getElementById('request-box').value;

	if (!document.getElementById('request-box').disabled && request == "") {
		$('#request-box')
		  .transition({
		  	animation: 'shake',
		  	duration: 200
		  })
		  .transition({
		  	animation: 'glow',
		  	duration: 1500
		  });
	}
	else {
		if (!request) {
			sessionStorage.setItem("request", "none");
		}
		else {
			sessionStorage.setItem("request", request);
		}

	  document.getElementById('summary-date').innerHTML = `Date: ${sessionStorage.getItem("date")}`;
	  document.getElementById('summary-time').innerHTML = `Time: ${sessionStorage.getItem("time")}`;
	  document.getElementById('summary-service').innerHTML = `Service: ${sessionStorage.getItem("service")}`;
	  document.getElementById('summary-hairdresser').innerHTML = `Hairdresser: ${sessionStorage.getItem("hairdresser")}`;
	  document.getElementById('summary-request').innerHTML = `Special Request: ${sessionStorage.getItem("request")}`;

	  requestForm.style.display = "none";
	  summaryForm.style.display = "block";
		
		requestStep.classList.remove("active");
		requestStep.classList.add("completed");
		summaryStep.classList.remove("disabled");
		summaryStep.classList.add("active");
	}
}


function onConfirmSummary() {
	const appointmentLoader = document.getElementById('appointment-loader');
	appointmentLoader.style.display = "block";

	const summaryForm = document.getElementById('summary-form');
	const summaryStep = document.getElementById('summary-step');
	const requestBox = document.getElementById('request-box');

  const date = sessionStorage.getItem("date");
  const time = sessionStorage.getItem("time");
  const service = sessionStorage.getItem("service");
  const hairdresser = sessionStorage.getItem("hairdresser");
  const request = sessionStorage.getItem("request");

	// sanitize content of special request
	if (requestBox.disabled == false && (requestBox.value.includes('<') || requestBox.value.includes('>'))) {
		alert ("Please don't include special characters in your request");
	} else {
    const http = new XMLHttpRequest();
    const url = 'appointment-process.php';
    const params = `date=${date}&time=${time}&service=${service}&hairdresser=${hairdresser}&request=${request}`;
    http.open('POST', url, true);

    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
      if(http.readyState == 4 && http.status == 200) {
        appointmentLoader.style.display = "none";
      	if (http.responseText.trim() == "success") {
      		$('#success-booking-modal')
            .modal('show');
      	}
      	else if (http.responseText.trim() == "fail") {
					$('#fail-booking-modal')
            .modal('show');
      	}
        else if (http.responseText.trim() == "over") {
          $('#over-booking-modal')
            .modal('show');
        }
        else if (http.responseText.trim() == "duplicate") {
        	$('#duplicate-booking-modal')
            .modal('show');
        }
      }
    }
    http.send(params);

		summaryStep.classList.add("completed");
		summaryStep.classList.remove("active");
	}
}


// functions when user presses back to previous in booking appointment

function onBackToDate() {
	const dateForm = document.getElementById('date-form');
	const serviceForm = document.getElementById('service-form');
	const dateStep = document.getElementById('date-step');
	const serviceStep = document.getElementById('service-step');

	serviceForm.style.display = "none";
	dateForm.style.display = "block";

	dateStep.classList.add("active");
	dateStep.classList.remove("completed");
	serviceStep.classList.remove("active");
}

function onBackToService() {
	const serviceForm = document.getElementById('service-form');
	const requestForm = document.getElementById('request-form');
	const serviceStep = document.getElementById('service-step');
	const requestStep = document.getElementById('request-step');

	requestForm.style.display = "none";
	serviceForm.style.display = "block";

	serviceStep.classList.add("active");
	serviceStep.classList.remove("completed");
	requestStep.classList.remove("active");
}


// function when users edit appointment summary

function onEditSummary() {
	const dateForm = document.getElementById('date-form');
	const serviceForm = document.getElementById('service-form');
	const summaryForm = document.getElementById('summary-form');

	const dateStep = document.getElementById('date-step');
	const serviceStep = document.getElementById('service-step');
	const requestStep = document.getElementById('request-step');
	const summaryStep = document.getElementById('summary-step');

	summaryForm.style.display = "none";
	dateForm.style.display = "block";

	dateStep.classList.remove("completed");
	dateStep.classList.add("active");
	serviceStep.classList.remove("completed");
	requestStep.classList.remove("completed");
	summaryStep.classList.remove("active");
}

function onSwitchRequest() {
	let hasRequest = document.getElementById('hasRequest').checked;
	let requestBox = document.getElementById('request-box');

	requestBox.disabled = hasRequest ? true : false;
}

/***** Sign Up validation *****/
function validateSignUpName() {
    // Should only contain alphabets and space
    let name = document.getElementById("name").value;
    let nameAlert = document.getElementById("signup-name-alert");
    let regex = /^[a-zA-Z ]*$/;
    let result = regex.test(name);
    if (name.length == 0 ) {
        nameAlert.textContent = "Name should not be empty";
        nameAlert.style.color = "red";
        return false;
    } else if (!result ) {
        nameAlert.textContent = "Name should only contains alphabets and spaces";
        nameAlert.style.color = "red";
        return false;
    } else {
        nameAlert.textContent = "";
        return true;
    }
    return true;
}

function validateSignUpEmail() {
    // Should meet the email format
    let email = document.getElementById("email").value;
    let emailAlert = document.getElementById("signup-email-alert");
    let regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    let result = regex.test(email);
    if (email.length == 0) {
        emailAlert.textContent = "Email should not be empty";
        emailAlert.style.color = "red";
        return false;
    } else if (!result) {
        emailAlert.textContent = "Email should be following the following format: johndoe@gmail.com";
        emailAlert.style.color = "red";
        return false;
    } else {
        emailAlert.textContent = "";
        return true;
    }
    return true;
}
function validateContact() {
    // Should meet the phone format
    let contact = document.getElementById("contact").value;
    let contactAlert = document.getElementById("contact-email-alert");
    let regex = /^\d{3}-\d{6,7}$/;
    let result = regex.test(contact);
    if (contact.length == 0) {
        contactAlert.textContent = "Contact should not be empty";
        contactAlert.style.color = "red";
        return false;
    } else if (!result) {
        contactAlert.textContent = "Contact should be following the following format: 0xx-xxxxxxx or 0xx-xxxxxx";
        contactAlert.style.color = "red";
        return false;
    } else {
        contactAlert.textContent = "";
        return true;
    }
    return true;
}

function validateSignUpPassword() {
    // Should between 6 to 12 characters
    let password = document.getElementById("pass").value;
    let passwordAlert = document.getElementById("signup-password-alert");
    if (password.length == 0) {
        passwordAlert.textContent = "Password should not be empty";
        passwordAlert.style.color = "red";
        return false;
    } else if (password.length < 6 || password.length > 12) {
        passwordAlert.  textContent = "Password length should in between 6 to 12 character(s)";
        passwordAlert.style.color = "red";
        return false;
    } else {
        passwordAlert.textContent = "";
        return true;
    }
    return true;
}

function validateSignUpRepeatPassword() {
    // Password and repeat password should be the same
    let repeatPassword = document.getElementById("re-pass").value;
    let password = document.getElementById("pass").value;
    let repeatPassAlert = document.getElementById("signup-retypepassword-alert");
    if (repeatPassword != password) {
        repeatPassAlert.textContent = "Repeat Password are not the same as the password typed above";
        repeatPassAlert.style.color = "red";
        return false;
    } else {
        repeatPassAlert.textContent = "";
        return true;
    }
    return true;
}

function startSignUpValidate() {
    let name = validateSignUpName();
    let email = validateSignUpEmail();
    let contact = validateContact();
    let password = validateSignUpPassword();
    let repeatPassword = validateSignUpRepeatPassword();

    if (name && email && contact && password && repeatPassword) {
        return true;
    }
    return false;
}

/***** Log In validation *****/
function validateLogInEmail() {
    // Should meet the email format
    let email = document.getElementById("login-email").value;
    let emailAlert = document.getElementById("login-email-alert");
    let regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    let result = regex.test(email);
    if (email.length == 0) {
        emailAlert.textContent = "Email should not be empty";
        emailAlert.style.color = "red";
        return false;
    } else if (!result) {
        emailAlert.textContent = "Email should be following the following format: johndoe@gmail.com";
        emailAlert.style.color = "red";
        return false;
    } else {
        emailAlert.textContent = "";
        return true;
    }
    return true;
}

function startLogInValidate() {
    let email = validateLogInEmail();

    if (email) {
        return true;
    }
    return false;
}

/***** Forgot Password validation *****/
function forgotPasswordEmailValidation() {
    let email = document.getElementById("forgot-password-email").value;
    let emailAlert = document.getElementById("forgot-password-email-alert");
    let regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    let result = regex.test(email);
    if (email.length == 0) {
        emailAlert.textContent = "Email should not be empty";
        emailAlert.style.color = "red";
        return false;
    } else if (!result) {
        emailAlert.textContent = "Email should be following the following format: johndoe@gmail.com";
        emailAlert.style.color = "red";
        return false;
    } else {
        emailAlert.textContent = "";
        return true;
    }
    return true;
}

/***** Reset Password validation *****/
function resetPasswordValidation() {
    // Should between 6 to 12 characters
    let password = document.getElementById("reset-password").value;
    let passwordAlert = document.getElementById("reset-password-alert");
    if (password.length == 0) {
        passwordAlert.textContent = "Password should not be empty";
        passwordAlert.style.color = "red";
        return false;
    } else if (password.length < 6 || password.length > 12) {
        passwordAlert.textContent = "Password length should in between 6 to 12 character(s)";
        passwordAlert.style.color = "red";
        return false;
    } else {
        passwordAlert.textContent = "";
        return true;
    }
    return true;
}

function resetRepeatPasswordValidation() {
    let repeatPassword = document.getElementById("reset-repeatpassword").value;
    let password = document.getElementById("reset-password").value;
    let repeatPassAlert = document.getElementById("reset-retypepassword-alert");
    if (repeatPassword != password) {
        repeatPassAlert.textContent = "Repeat Password are not the same as the password typed above";
        repeatPassAlert.style.color = "red";
        return false;
    } else {
        repeatPassAlert.textContent = "";
        return true;
    }
    return true;
}

function startResetPasswordValidate() {
    let pass = resetPasswordValidation();
    let re_pass = resetRepeatPasswordValidation();

    if (pass && re_pass) {
        return true;
    }
    return false;
}

/***** Add new staff email validation *****/
function addStaffValidation() {
    let email = document.getElementById("add-staff-email").value;
    let emailAlert = document.getElementById("add-staff-email-alert");
    let managerCheckbox = document.getElementById("add-manager-checkbox");
    let regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
    let result = regex.test(email);
    if (email.length == 0) {
        emailAlert.textContent = "Email should not be empty";
        emailAlert.style.color = "red";
        return false;
    } else if (!result) {
        emailAlert.textContent = "Email should be following the following format: johndoe@gmail.com";
        emailAlert.style.color = "red";
        return false;
    } else if (managerCheckbox.checked) {
        emailAlert.textContent = "";
        $.post("../addmanager.php", { email: email },
        function(data) {
	        $('#add-staff-email-alert').html(data);
            $('#add-staff-form')[0].reset();
        });
    } else {
        emailAlert.textContent = "";
        $.post("../addstaff.php", { email: email },
        function(data) {
	        $('#add-staff-email-alert').html(data);
            $('#add-staff-form')[0].reset();
        });
    }
    return false;
}

/* Show Hidden Form */
function openForm() {
    document.getElementById("myForm").style.display = "block";
    document.getElementById("archiveList").style.display="none";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

function onViewAppointment(status, appointmentId, email, date, time, service, hairdresser, request) {

	if (!$('#appointment-details-modal').modal('is active')) {
		sessionStorage.setItem('appId', appointmentId);

		document.getElementById('appDetails-user').innerHTML = email;
		document.getElementById('appDetails-date').innerHTML = date;
		document.getElementById('appDetails-time').innerHTML = time;
		document.getElementById('appDetails-service').innerHTML = service;
		document.getElementById('appDetails-hairdresser').innerHTML = hairdresser;
		document.getElementById('appDetails-request').innerHTML = request;
		const unfulfilledBtn = document.getElementById('unfulfilled-swicth');
		const fulfilledBtn = document.getElementById('fulfilled-swicth');

		fulfilledBtn.style.display = "inline";
		unfulfilledBtn.style.display = "inline";

		if (status === 'fulfilled') {
			fulfilledBtn.style.display = "none";
		}
		else {
			unfulfilledBtn.style.display = "none";
		}

		$('#appointment-details-modal')
	  	.modal('show');
	}
}

function onCloseAppDetail() {
	$('#appointment-details-modal')
  	.modal('hide');
}

function onHoverCloseDetail() {
	$('#close-app-mark')
	  .transition('tada');
}

function onDeleteAppointment() {
	$('#appointment-details-modal')
	  .modal({
	    allowMultiple: false
	  });

	$('.delete-app-modal')
		.modal({
			onApprove: function() {
				deleteApproved();
			}
		})
  	.modal('show');
}

function deleteApproved() {
  let appId = sessionStorage.getItem('appId');

  const http = new XMLHttpRequest();
  const url = '../appointment-process.php';
  const params = `appId=${appId}&action=delete`;
  http.open('POST', url, true);

  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  http.onreadystatechange = function() {
    if(http.readyState == 4 && http.status == 200) {
		  setTimeout(function() {
		  	document.location.reload();
		  }, 500);
    }
  }
  http.send(params);
}

function onHoverNext(context) {
  context.childNodes[1].style.paddingLeft="7px";
}

function onLeaveNext(context) {
  context.childNodes[1].style.padding = 0;
}

function onhoverPrevious(context) {
  context.childNodes[0].style.paddingRight = "7px";
}

function onLeavePrevious(context) {
  context.childNodes[0].style.padding = 0;
}

function filterUsers(){
  var table, tr, td, i;
  table = document.getElementById("userTable");
  tr = table.getElementsByTagName("tr");
  
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[7];
    if (td) {
      if (td.textContent == 'user') {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function filterStaffs(){
  var table, tr, td, i;
  table = document.getElementById("userTable");
  tr = table.getElementsByTagName("tr");
  
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[7];
    if (td) {
      if (td.textContent == 'staff') {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function filterAll(){
  var table, tr, td, i;
  table = document.getElementById("userTable");
  tr = table.getElementsByTagName("tr");
  
  for (i = 0; i < tr.length; i++) {
      tr[i].style.display = "";
  }
}

function searchUser() {
 
  var input, filter, table, tr, td, i, txtValue,table2,tr2,td2,j,txtValue2;
  input = document.getElementById("userInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("userTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
  
  table2 = document.getElementById("bannedUserTable");
  tr2 = table2.getElementsByTagName("tr");
  
  for (j = 0; j < tr2.length; j++) {
    td2 = tr2[j].getElementsByTagName("td")[2];
    if (td2) {
      txtValue2 = td2.textContent || td2.innerText;
      if (txtValue2.toUpperCase().indexOf(filter) > -1) {
        tr2[j].style.display = "";
      } else {
        tr2[j].style.display = "none";
      }
    } 
  }
  
}

function openUserEdit() {
    document.getElementById("userForm").style.display = "block";
}

function closeUserEdit() {
    document.getElementById("userForm").style.display = "none";

}

function showBannedUser() {
  document.getElementById("bannedUserTable").style.display = "block";
  
}

function hideBannedUser() {
  document.getElementById("bannedUserTable").style.display = "none";
}


function onSwitchStatus(stat) {
	const appId = sessionStorage.getItem('appId');

	const http = new XMLHttpRequest();
  const url = '../appointment-process.php';
  const params = `appId=${appId}&action=changeStatus&status=${stat}`;
  http.open('POST', url, true);

  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  http.onreadystatechange = function() {
    if(http.readyState == 4 && http.status == 200) {
    	console.log(http.responseText);
    	if (http.responseText.trim() == "updated") {
    		$('.change-status-modal')
    			.modal({
						onApprove: function() {
							setTimeout(function() {
						  	document.location.reload();
						  }, 500);
						}
					})
          .modal('show');
    	}
    	else if (http.responseText.trim() == "fail") {
    		alert("Something went wrong!");
    	}
    }
  }
  http.send(params);
}


function onFilterStatus() {
	const filterBox = document.getElementById('filterBox');
	const selectedValue = filterBox.options[filterBox.selectedIndex].value;

	const appRows = document.getElementsByClassName('appRow');


	for (row of appRows) {
		row.style.display = "";
	}

	for (row of appRows) {
		const stat = row.getElementsByClassName('appStatus')[0];
		if (selectedValue == 'all') {
			row.style.display = "";
		}
		else if (stat.textContent !== selectedValue) {
			row.style.display = "none";
		}
	}

}

function onUserCancelApp(appId) {
	$('.mini.modal')
		.modal({
			onApprove: function() {
				cancelAppApproved(appId);
			}
		})
  	.modal('show');
}


function cancelAppApproved(appId) {

  const http = new XMLHttpRequest();
  const url = 'appointment-process.php';
  const params = `appId=${appId}&action=delete`;
  http.open('POST', url, true);

  http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  http.onreadystatechange = function() {
    if(http.readyState == 4 && http.status == 200) {
		  setTimeout(function() {
		  	document.location.reload();
		  }, 500);
    }
  }
  http.send(params);
}

$(document).ready(function(){
    $("#archiveButton").click(function(){
        $("#archiveList").toggle();
    });
});

function searchItem() {
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue, table2, tr2, td2, j, txtValue2;
  input = document.getElementById("userInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("itemTable");
  table2 = document.getElementById("archiveTable");
  tr = table.getElementsByTagName("tr");
  tr2 = table2.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
  
  for (j = 0; j < tr2.length; j++) {
    td2 = tr2[j].getElementsByTagName("td")[1];
    if (td2) {
      txtValue2 = td2.textContent || td2.innerText;
      if (txtValue2.toUpperCase().indexOf(filter) > -1) {
        tr2[j].style.display = "";
      } else {
        tr2[j].style.display = "none";
      }
    } 
  }
}

function genderFilter(gender){
	var gender = gender.value;
	if (gender == "male"){
		var table, tr, td, i,table2,tr2,td2;
        table = document.getElementById("archiveTable");
        table2 = document.getElementById("itemTable");
        tr = table.getElementsByTagName("tr");
        tr2 = table2.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[10];
          if (td) {
            if (td.textContent == 'Male') {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          } 
        }

        for (i = 0; i < tr2.length; i++) {
          td2 = tr2[i].getElementsByTagName("td")[10];
          if (td2) {
            if (td2.textContent == 'Male') {
              tr2[i].style.display = "";
            } else {
              tr2[i].style.display = "none";
            }
          } 
        }
    }
  
    if(gender == "female"){
      var table, tr, td, i;
      table = document.getElementById("archiveTable");
      tr = table.getElementsByTagName("tr");
      table2 = document.getElementById("itemTable");
      tr2 = table2.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[10];
        if (td) {
          if (td.textContent == 'Female') {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        } 
      }

      for (i = 0; i < tr2.length; i++) {
        td2 = tr2[i].getElementsByTagName("td")[10];
        if (td2) {
          if (td2.textContent == 'Female') {
            tr2[i].style.display = "";
          } else {
            tr2[i].style.display = "none";
          }
        } 
      }
    }
  
  if(gender == "unisex"){
    var table, tr, td, i;
    table = document.getElementById("archiveTable");
    tr = table.getElementsByTagName("tr");
    table2 = document.getElementById("itemTable");
    tr2 = table2.getElementsByTagName("tr");


    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[10];
      if (td) {
        if (td.textContent == 'Unisex') {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      } 
    }

    for (i = 0; i < tr2.length; i++) {
      td2 = tr2[i].getElementsByTagName("td")[10];
      if (td2) {
        if (td2.textContent == 'Unisex') {
          tr2[i].style.display = "";
        } else {
          tr2[i].style.display = "none";
        }
      } 
    }
  }
  
  if(gender == "all"){
    var table, tr, td, i;
    table = document.getElementById("archiveTable");
    tr = table.getElementsByTagName("tr");
    table2 = document.getElementById("itemTable");
    tr2 = table2.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        tr[i].style.display = ""; 
    }

    for (i = 0; i < tr2.length; i++) {
        tr2[i].style.display = ""; 
    }
  }
}


function categoryFilter(category){
    var category = category.value;
  
    if(category == "all"){
      var table, tr, td, i;
      table = document.getElementById("archiveTable");
      tr = table.getElementsByTagName("tr");
      table2 = document.getElementById("itemTable");
      tr2 = table2.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
          tr[i].style.display = ""; 
      }

      for (i = 0; i < tr2.length; i++) {
          tr2[i].style.display = ""; 
      }
    }
    
    if (category == "hs"){
      var table, tr, td, i,table2,tr2,td2;
      table = document.getElementById("archiveTable");
      table2 = document.getElementById("itemTable");
      tr = table.getElementsByTagName("tr");
      tr2 = table2.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[11];
        if (td) {
          if (td.textContent == 'Hair Shampoo') {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        } 
      }

      for (i = 0; i < tr2.length; i++) {
        td2 = tr2[i].getElementsByTagName("td")[11];
        if (td2) {
          if (td2.textContent == 'Hair Shampoo') {
            tr2[i].style.display = "";
          } else {
            tr2[i].style.display = "none";
          }
        } 
      }
    }
  
    if(category == "cd"){
      var table, tr, td, i,table2,tr2,td2;
      table = document.getElementById("archiveTable");
      table2 = document.getElementById("itemTable");
      tr = table.getElementsByTagName("tr");
      tr2 = table2.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[11];
        if (td) {
          if (td.textContent == 'Conditioner') {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        } 
      }

      for (i = 0; i < tr2.length; i++) {
        td2 = tr2[i].getElementsByTagName("td")[11];
        if (td2) {
          if (td2.textContent == 'Conditioner') {
            tr2[i].style.display = "";
          } else {
            tr2[i].style.display = "none";
          }
        } 
      }
    }
    
    if(category == "ho"){
      var table, tr, td, i,table2,tr2,td2;
      table = document.getElementById("archiveTable");
      table2 = document.getElementById("itemTable");
      tr = table.getElementsByTagName("tr");
      tr2 = table2.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[11];
        if (td) {
          if (td.textContent == 'Hair Oils') {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        } 
      }

      for (i = 0; i < tr2.length; i++) {
        td2 = tr2[i].getElementsByTagName("td")[11];
        if (td2) {
          if (td2.textContent == 'Hair Oils') {
            tr2[i].style.display = "";
          } else {
            tr2[i].style.display = "none";
          }
        } 
      }
    }
    
    if(category == "hw"){
      var table, tr, td, i,table2,tr2,td2;
      table = document.getElementById("archiveTable");
      table2 = document.getElementById("itemTable");
      tr = table.getElementsByTagName("tr");
      tr2 = table2.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[11];
        if (td) {
          if (td.textContent == 'Hair Wax') {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        } 
      }

      for (i = 0; i < tr2.length; i++) {
        td2 = tr2[i].getElementsByTagName("td")[11];
        if (td2) {
          if (td2.textContent == 'Hair Wax') {
            tr2[i].style.display = "";
          } else {
            tr2[i].style.display = "none";
          }
        } 
      }
    } 
}

function onPayCart() {
	const price = document.getElementById('total-amount').innerHTML;
	const items = [];

	document.getElementById('header-amount').innerHTML = price;

	const carts = document.getElementById('cart-ul');

	for (let i=1; i<carts.children.length; i++) {
		let cart = carts.children[i];

		let id = cart.getElementsByClassName('inventoryId')[0].value;
        let type = cart.getElementsByClassName('inventoryType')[0].value;
		let num = cart.getElementsByClassName('cart-num')[0].innerHTML;

		items.push({id, num, type});
	}

	const stringItems = JSON.stringify(items);

	$('#pay-cart-modal')
		.modal({
			closable: false,
			onApprove: function() {
				const totalAmount = document.getElementById('header-amount').innerHTML;
				const staffId = document.getElementById('staffId').value;

				const http = new XMLHttpRequest();
		    const url = 'staff/../pos-process.php';
		    const params = `staffId=${staffId}&salesAmount=${totalAmount}&items=${stringItems}`;
		    http.open('POST', url, true);

		    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		    http.onreadystatechange = function() {
		      if(http.readyState == 4 && http.status == 200) {
	      		console.log(http.responseText);
                setTimeout(_ => document.location.reload(), 500);
  		        }
		    }

        http.send(params);
    }
    })
   .modal('show');

}

function onAddCart() {
	const cartSelect = document.getElementById('cart-select').value;
	const selected = JSON.parse(cartSelect);
	let productName;


	if (selected.name.length > 15) {
		productName = selected.name.substring(0, 15) + "...";
	}	else {
		productName = selected.name;
	}

	let cartItems = document.getElementById('cart-ul').innerHTML;

	if (document.getElementById('cart-ul').children.length > 0) {
		document.getElementById('sample-li-cart').classList.remove('show-li');
		document.getElementById('sample-li-cart').classList.add('hide-li');	
	}
	else {
		document.getElementById('sample-li-cart').classList.add('show-li');
		document.getElementById('sample-li-cart').classList.remove('hide-li');
	}

	document.getElementById("cart-ul").innerHTML += `
		<li class="list-group-item justify-content-between align-items-center cart-list mb-2">
			<div class="row">
				<div class="col-md-2">
				   <img class="cart-img" src="data:${selected.mime};base64,${selected.imageName}" alt="Product item">
				</div>
				<div class="col-md-2 cart-criteria">
					<p class="cart-product-title m-0 cart-product-text" title="${selected.name}">${productName}</p>
				</div>
				<div class="col-md-2 cart-criteria">
					<p class="cart-product-price m-0 cart-product-text">RM <span class="price-num">${selected.price.toFixed(2)}</span></p>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-2 cart-badge-num cart-criteria">
					<i class="fas fa-minus" onclick="onModifyNum(this, 0)"></i>
          <span class="badge badge-primary badge-pill cart-num">1</span>   
          <i class="fas fa-plus" onclick="onModifyNum(this, 1)"></i>
        </div>
				<div class="col-md-2 cart-criteria">
	    		<p class="remove-text" onclick="onRemoveCart(this)">Remove</p>		
				</div>
        <input type="hidden" class="inventoryId" value="${selected.id}">
      <input type="hidden" class="inventoryType" value="${selected.type}">
			</div>
	  </li>`;

	  sumUpCart();

    checkDisableCart();
    checkDisablePayBtn();
}

function onModifyNum(element, action) {
	const parentCount = element.parentNode.parentNode;
	let num = parentCount.getElementsByTagName('span')[1].innerHTML;

	const parentPrice = parentCount.parentNode;
	let currentPrice = Number(parentPrice.getElementsByTagName('span')[0].innerHTML);
	let unitPrice = currentPrice / parentCount.getElementsByTagName('span')[1].innerHTML;

	if (action) {
		parentCount.getElementsByTagName('span')[1].innerHTML++;
		parentPrice.getElementsByTagName('span')[0].innerHTML = (currentPrice + unitPrice).toFixed(2);
	}
	else if (num != 1) {
		parentCount.getElementsByTagName('span')[1].innerHTML--;
		parentPrice.getElementsByTagName('span')[0].innerHTML = (currentPrice - unitPrice).toFixed(2);
	}

	sumUpCart();
}


function sumUpCart() {
	const allPrices = [];

	const totalAmount = document.getElementById('total-amount');
	const allPricesElements = document.getElementsByClassName('price-num');

	for (let i=0; i< allPricesElements.length; i++) {
		allPrices.push(Number(allPricesElements[i].textContent));
	}

	if (allPrices.length !== 0) {
		totalAmount.innerHTML = (allPrices.reduce((num, total) => num + total)).toFixed(2);
	}
	else {
		totalAmount.innerHTML = (0).toFixed(2);
	}
}

function onCashPaidChange() {
	const cashPaid = document.getElementById('cash-paid').value;
	const totalAmount = document.getElementById('header-amount').innerHTML;

	let changes = (cashPaid - totalAmount).toFixed(2);

	document.getElementById('total-changes').innerHTML = changes > 0 ? changes : 0.00.toFixed(2);
}

function onRemoveCart(element) {
	element.parentNode.parentNode.parentNode.remove();
	sumUpCart();

	if (document.getElementById('cart-ul').children.length > 1) {
		document.getElementById('sample-li-cart').classList.remove('show-li');
		document.getElementById('sample-li-cart').classList.add('hide-li');	
	}
	else {
		document.getElementById('sample-li-cart').classList.add('show-li');
		document.getElementById('sample-li-cart').classList.remove('hide-li');
	}

  checkDisableCart();
  checkDisablePayBtn();

}


function checkDisableCart() {
  const select = document.getElementById('cart-select').options;
  const exists = document.getElementsByClassName('cart-product-title');

  for (let i=0; i<select.length; i++) {
    select[i].disabled = false;
    select[i].style.backgroundColor = "white";
    for (let j=0; j<exists.length; j++) {
      if (select[i].innerHTML === exists[j].title) {
        select[i].disabled = true;
        select[i].style.backgroundColor = "rgba(200, 200, 200, 0.3)";
      }
    }
  }
}

function checkDisablePayBtn() {
  const amount = document.getElementById('total-amount').innerHTML;

  if (amount > 0) {
    document.getElementById('pay-cart-btn').disabled = false;
  }
  else {
    document.getElementById('pay-cart-btn').disabled = true;
  }
}

function checkStatus() {
  checkDisablePayBtn();
}


function loadChart(data) {
  const labelsData = [];
  const labelsCount = [];

  data.forEach(item => {
    if (item.productName.length > 15) {
      item.productName = item.productName.substring(0, 15) + "...";
    }
    labelsData.push(item.productName);
    labelsCount.push(item.count);
  });

  var ctx = document.getElementById('product_chart').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: labelsData,
          datasets: [{
              label: 'Number of Sales',
              data: labelsCount,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
}

function loadDetailsChart(data, type, num) {

  const buttons = document.getElementsByClassName('type-alternative');
  for (let i=0; i<buttons.length; i++) {
    if (i == num) {
      buttons[i].classList.add('clickedButton');
    }
    else {
      buttons[i].classList.remove('clickedButton');
    }
  }

  // destroy old canvas and replace with a new canvas
  document.getElementById('product_details_chart').remove();
  let canvas = document.createElement('canvas');
  canvas.setAttribute('id','product_details_chart');
  canvas.setAttribute('width','400');
  canvas.setAttribute('height','200');
  document.querySelector('#canvas-container').appendChild(canvas);  
  

  if (type == 'daily') {
    generateDailySalesChart(data);
  }
  else if (type == 'weekly') {
    generateWeeklySalesChart(data);
  }
  else if (type == 'monthly') {
    generateMonthlySalesChart(data);
  }
  else if (type == 'yearly') {
    generateYearlySalesChart(data);
  }
}


function generateDailySalesChart(data) {
  let totalDailySales = 0;  

  data.forEach(item => {
    if (moment(item.dateOfSales).isSame(moment(), 'day')) {
      totalDailySales += Number(item.salesAmount);
    } 
  });

  let ctx = document.getElementById('product_details_chart').getContext('2d');
  let myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: [(moment().format()).split('T')[0]],
          datasets: [{
              label: 'Ringgit Malaysia (MYR)',
              data: [totalDailySales],
              backgroundColor: [
                  '#00d1cd',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  '#00d1cd',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
}


function generateWeeklySalesChart(data) {
  let firstDay = moment().startOf('month');
  let secondWeek = firstDay.add(7, 'days');
  let thirdWeek = moment(secondWeek).add(7, 'days');
  let fourthWeek = moment(thirdWeek).add(7, 'days');

  const weeksInMonth = [];
  weeksInMonth.push(moment().startOf('month').format('YYYY-MM-DD'));
  weeksInMonth.push(secondWeek.format('YYYY-MM-DD'));
  weeksInMonth.push(thirdWeek.format('YYYY-MM-DD'));
  weeksInMonth.push(fourthWeek.format('YYYY-MM-DD'));
  weeksInMonth.push(moment().endOf('month').format('YYYY-MM-DD'));

  console.log(weeksInMonth);

  const weeklySalesData = [];

  for (let i=0; i<5; i++) {
    weeklySalesData.push(0);
  }

  for (let i=0; i<data.length; i++) {
    for (let j=0; j<weeksInMonth.length; j++) {
      if (moment(data[i].dateOfSales).isSameOrAfter(weeksInMonth[j], 'month')) {
        if (moment(data[i].dateOfSales).isSameOrBefore(weeksInMonth[j+1], 'days')) {
          weeklySalesData[j+1] += Number(data[i].salesAmount);
          break;
        }
      }
    }
  }

  for (let i=0; i<weeklySalesData.length; i++) {
    weeklySalesData[i] = weeklySalesData[i].toFixed(2);
  }


  let ctx = document.getElementById('product_details_chart').getContext('2d');
  let myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: weeksInMonth,
          datasets: [{
              label: 'Ringgit Malaysia (MYR)',
              backgroundColor: '#8f71ff',
              borderColor: '#8f71ff',
              data: weeklySalesData
          }]
      },
      options: {}
  });
}


function generateMonthlySalesChart(data) {
  let monthlySalesData = [];
  const start = moment([2019, 0, 1]);

  for(let i=0; i<12; i++) {
    monthlySalesData.push(0);
  }

  data.forEach(item => {
    const current = item.dateOfSales.split('-');
    const end = moment(current);
    let month = end.diff(start, 'month');
    monthlySalesData[month-1] += Number(item.salesAmount);
  });


  for (let i=0; i<monthlySalesData.length; i++) {
    monthlySalesData[i] = monthlySalesData[i].toFixed(2);
  }

  let ctx = document.getElementById('product_details_chart').getContext('2d');
  let myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: ['Jan', 'Feb', 'Mac', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [{
              label: 'Ringgit Malaysia (MYR)',
              backgroundColor: '#f30067',
              borderColor: '#f30067',
              data: monthlySalesData
          }]
      },
      options: {}
  });
}


function generateYearlySalesChart(data) {
  let yearlySalesData = [];
  const start = moment([2019, 11]);

  for(let i=0; i<5; i++) {
    yearlySalesData.push(0);
  }


  data.forEach(item => {
    const current = item.dateOfSales.split('-');
    const end = moment(current);
    let year = start.diff(end, 'year');

    yearlySalesData[4-year] += Number(item.salesAmount);
  });

  for (let i=0; i<yearlySalesData.length; i++) {
    yearlySalesData[i] = yearlySalesData[i].toFixed(2);
  }

  let ctx = document.getElementById('product_details_chart').getContext('2d');
  let myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: ['2015', '2016', '2017', '2018', '2019'],
          datasets: [{
              label: 'Ringgit Malaysia (MYR)',
              backgroundColor: '#ff5959',
              borderColor: '#ff5959',
              data: yearlySalesData
          }]
      },
      options: {}
  });
}

function loadStaffPerformanceSimpleChart(data) {
    var chartLabels = [];
    var dataSet = [];
    var dataSetLabel = [];
    var colorObtainedHistory = [];
    var colorObtained;
    var temp = [];
    
    data.forEach(item => {
        temp.push(item.name);
    })
    
    data.forEach(item => {
        colorObtained = "";
        var start = moment();
        var currentYear = moment().year();
        var found = false;
        var maxYear = 4;
        
        dataSet.push(item.salesAmount);
        
        chartLabels = temp;

        yearDifference = moment(item.date).diff(moment(), 'year');
        
        colorObtained = generateRandomColorsRgba();
    });
    
    var ctx = document.getElementById('performanceStaff').getContext('2d');
        let myChart = new Chart(ctx, {
            type: "bar",
            data: {
            labels: chartLabels,
            datasets: [{label:"Total Sales Made (RM)",
                        data:dataSet,
                        backgroundColor: generateRandomColorsRgba()
                       }
                      ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
            
        }
    });
}

// Ng Yi Sensei method
function loadStaffPerformanceChart(data, mode, num) {
    const buttons = document.getElementsByClassName('type-alternative');

    for (let i=0; i<buttons.length; i++) {
        if (i == num) {
          buttons[i].classList.add('clickedButton');
        }
        else {
          buttons[i].classList.remove('clickedButton');
        }
    }
    
    // destroy old canvas and replace with a new canvas
    document.getElementById('performanceStaff').remove();
    let canvas = document.createElement('canvas');
    canvas.setAttribute('id','performanceStaff');
    canvas.setAttribute('width','400');
    canvas.setAttribute('height','200');
    document.querySelector('#canvas_container').appendChild(canvas);

    if (mode == "yearly") {
        generateYearlyStaffPerformanceChart(data);
    } else if (mode == "monthly") {
        generateMonthlyStaffPerformanceChart(data);
    } else if (mode == "weekly") {
        generateWeeklyStaffPerformanceChart(data);
    } else {
        generateDailyStaffPerformanceChart(data);  
    }   
}

function generateDailyStaffPerformanceChart(data) {
    const chartLabels = [];
    const dataSet = [];
    const dataSetLabel = [];
    var colorObtained;
    var found = false;
    // iF MORE THAN ONE THEN UNABLE TO GENERATE
    colorObtained = generateRandomColorsRgba();
    data.forEach(item => {
        if (moment(item.date).isSame(moment(), "d")) {
            if (chartLabels.length != 0) {
                for (let i = 0; i < chartLabels.length; i++) {
                    if (chartLabels[i] == item.name) {
                        dataSet[i] += Number(item.salesAmount);
                        found = true;
                    }
                } 
                if (found == false) {
                    chartLabels.push(item.name);
                    dataSetLabel.push(item.name);
                    dataSet.push(Number(item.salesAmount));
                }
            } else {
                chartLabels.push(item.name);
                dataSetLabel.push(item.name);
                dataSet.push(Number(item.salesAmount));
            }
        }

    });
    
    var ctx = document.getElementById('performanceStaff').getContext('2d');
    let myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: chartLabels,
            datasets: [{
                label: dataSetLabel,
                data: dataSet,
                borderColor: colorObtained, 
                backgroundColor: colorObtained
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

function generateWeeklyStaffPerformanceChart(data) {
    var chartLabels = [];
    var dataSet = [];
    var dataSetLabel = [];
    
    var colorObtained;
    
    
    data.forEach(item => {
        let firstDay = moment().startOf('month');
        let secondWeek = firstDay.add(7, 'days');
        let thirdWeek = moment(secondWeek).add(7, 'days');
        let fourthWeek = moment(thirdWeek).add(7, 'days');

        const weeksInMonth = [];
        var temp = [];
        temp.push(moment().startOf('month').format('YYYY-MM-DD'));
        temp.push(secondWeek.format('YYYY-MM-DD'));
        temp.push(thirdWeek.format('YYYY-MM-DD'));
        temp.push(fourthWeek.format('YYYY-MM-DD'));
        temp.push(moment().endOf('month').format('YYYY-MM-DD'));
        chartLabels = temp;
        
        colorObtained = generateRandomColorsRgba();
        
        var found = false;
        for (let j=0; j<chartLabels.length; j++) {
          if (moment(item.date).isSameOrAfter(chartLabels[j], 'month')) {
            if (moment(item.date).isBefore(chartLabels[j+1], 'days')) {
                if (dataSet.length != 0) {
                    for (let i = 0; i < dataSet.length; i++) {
                        if (dataSet[i].label == item.name) {
                            dataSet[i].data[j] += Number(item.salesAmount);
                            found = true;
                        } 
                    }
                    if (found == false) {
                        dataSet.push({label: item.name, data: [0,0,0,0,0],  borderColor: colorObtained, backgroundColor: colorObtained});
                            for (let i = 0; i < dataSet.length; i++) {
                                if (dataSet[i].label == item.name) {
                                    dataSet[i].data[j] += Number(item.salesAmount);
                                }
                            }
                    }
                } else {
                    dataSet.push({label: item.name, data: [0,0,0,0,0],  borderColor: colorObtained, backgroundColor: colorObtained});
                    for (let i = 0; i < dataSet.length; i++) {
                        if (dataSet[i].label == item.name) {
                                dataSet[i].data[j] += Number(item.salesAmount);
                            }
                        }
                }
                break;
            }
          }
        }
    });
                 
    var ctx = document.getElementById('performanceStaff').getContext('2d');
    let myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: chartLabels,
            datasets: dataSet
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

}

function generateMonthlyStaffPerformanceChart(data) {
    var chartLabels = [];
    var dataSet = [];
    var dataSetLabel = [];
    const start = moment().startOf('year');
    
    chartLabels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
    
    var colorObtained;
    
    data.forEach(item => {
        colorObtained = generateRandomColorsRgba();
        
        var found = false;
        if (moment(item.date).isSame(moment(), 'year')) {
            if (dataSet.length != 0) {
                    for (let i = 0; i < dataSet.length; i++) {
                        if (dataSet[i].label == item.name) {
                            dataSet[i].data[moment(item.date).month()] += Number(item.salesAmount);
                            found = true;
                        }
                    }
                    if (found == false) {
                        dataSet.push({label: item.name, data: [0,0,0,0,0,0,0,0,0,0,0,0],  borderColor: colorObtained, backgroundColor: colorObtained});
                            for (let j = 0; j < dataSet.length; j++) {
                                if (dataSet[j].label == item.name) {
                                    dataSet[j].data[moment(item.date).month()] += Number(item.salesAmount);
                                }
                            }
                        found = true;
                    }
            } else {
                dataSet.push({label: item.name, data: [0,0,0,0,0,0,0,0,0,0,0,0],  borderColor: colorObtained, backgroundColor: colorObtained});
                for (let i = 0; i < dataSet.length; i++) {
                    if (dataSet[i].label == item.name) {
                        dataSet[i].data[moment(item.date).month()] += Number(item.salesAmount);
                    }
                }
            }
        }
    });
    
    var ctx = document.getElementById('performanceStaff').getContext('2d');
    let myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: chartLabels,
                datasets: dataSet
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
}

function generateYearlyStaffPerformanceChart(data) {
    var chartLabels = [];
    var dataSet = [];
    var dataSetLabel = [];
    var colorObtainedHistory = [];
    var colorObtained;
    
    data.forEach(item => {
        colorObtained = "";
        var start = moment();
        var currentYear = moment().year();
        var found = false;
        var temp = [];
        var maxYear = 4;
        
        for (var i = 0; i <= maxYear; i++) {
            temp.push(currentYear - (maxYear - i));
        }
        chartLabels = temp;

        yearDifference = moment(item.date).diff(moment(), 'year');
        
        colorObtained = generateRandomColorsRgba();
            
        if ((yearDifference*-1) <= maxYear) {
            if (dataSet.length != 0) {
                    for (let i = 0; i < dataSet.length; i++) {
                        if (dataSet[i].label == item.name) {
                            dataSet[i].data[maxYear + yearDifference] += Number(item.salesAmount);
                            found = true;
                        }
                    }
                    if (found == false) {
                        dataSet.push({label: item.name, data: [0,0,0,0,0], borderColor: colorObtained, backgroundColor: colorObtained});
                        for (let j = 0; j < dataSet.length; j++) {
                            if (dataSet[j].label == item.name) {
                                dataSet[j].data[maxYear + yearDifference] += Number(item.salesAmount);
                            }
                        }
                        found = true;
                    }
            } else {
                
                dataSet.push({label: item.name, data: [0,0,0,0,0], borderColor: colorObtained, backgroundColor: colorObtained });
                for (let i = 0; i < dataSet.length; i++) {
                    if (dataSet[i].label == item.name) {
                        dataSet[i].data[maxYear + yearDifference] += Number(item.salesAmount);
                    }
                }
            }
        }
    });
    
    var ctx = document.getElementById('performanceStaff').getContext('2d');
        let myChart = new Chart(ctx, {
            type: "line",
            data: {
            labels: chartLabels,
            datasets: dataSet
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
            
        }
    });
}

function generateRandomColorsRgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ', 0.5)';
}


function loadRanking(productData, serviceData) {
  // et current month
  const months = document.getElementsByClassName('current-month');
  const recents = document.getElementsByClassName('current-few-month');

  for (let i=0; i<months.length; i++) {
    months[i].innerHTML = moment().format('MMMM');
  } 

  for (let i=0; i<recents.length; i++) {
    recents[i].innerHTML = moment().subtract(2, 'months').format('MMMM') + " - " + moment().format('MMMM');
  } 

  getTopImprover(productData, 'product');
  getTopImprover(serviceData, 'service');
  getTopConsitent(productData, 'product');
  getTopConsitent(serviceData, 'service');
}


function getTopImprover(data, type) {
  const previous = [];
  const current = [];

  for (let i=0; i<data.length; i++) {
    if (moment(data[i].saleDate).format('Y') == moment().format('Y')) {
      if (moment(data[i].saleDate).format('M') == moment().format('M')) {

        let exist = false;

        for (let j=0; j<current.length; j++) {
          if (data[i].productName == current[j].name) {
            exist = true;
            current[j].amount += Number(data[i].amount);
          }
        }

        if (!exist) {
          let item = {'name': data[i].productName, 'amount': Number(data[i].amount)};
          current.push(item);
        }
      }
      else if (moment(data[i].saleDate).format('M') == moment().format('M')-1) {

        let exist = false;

        for (let j=0; j<previous.length; j++) {
          if (data[i].productName == previous[j].name) {
            exist = true;
            previous[j].amount += Number(data[i].amount);
          }
        }

        if (!exist) {
          let item = {'name': data[i].productName, 'amount': Number(data[i].amount)};
          previous.push(item);
        }
      }
    }
  }

  // initialize 0 to item that does not existed last month
  for (let i=0; i<current.length; i++) {
    let exist = false;
    for (let j=0; j<previous.length; j++) {
      if (current[i].name == previous[j].name) {
        exist = true;
      }
    }

    if (!exist) {
      let item = {'name': current[i].name, 'amount': 0};
      previous.push(item);
    }
  }

  let topImprover = "None";
  let topImproverScore = 0;

  for (let i=0; i<previous.length; i++) {
    let currentItem = previous[i].name;
    for (let j=0; j<current.length; j++) {
      if (currentItem == current[j].name) {
        let diff = current[j].amount - previous[i].amount;
        if (diff > topImproverScore) {
          topImproverScore = diff;
          topImprover = currentItem;
        }
      }
    }
  }

  if (type == 'product') {
    document.getElementById('top_improved_product').innerHTML = topImprover;
    document.getElementById('top_improved_product_score').innerHTML = "Improved by: " + topImproverScore + " sales";
  }
  else if (type == 'service') {
    document.getElementById('top_improved_service').innerHTML = topImprover;
    document.getElementById('top_improved_service_score').innerHTML = "Improved by: " + topImproverScore + " sales";
  }
}

function getTopConsitent(data, type) {
  const currentMonth = moment().format('M');

  const consistenceData = [];
  const results = [];

  let topConsistent = "None";
  let topConsistentScore = 10000;

  for (let i=0; i<data.length; i++) {
    let exist = false;
    for (let j=0; j<consistenceData.length; j++) {
      if (data[i].productName == consistenceData[j].name) {
        exist = true;
      }
    }
    if (!exist) {
      let item = {'name': data[i].productName, sales: [0, 0, 0]};
      consistenceData.push(item);
    }
  
  };

  for (let i=0; i<data.length; i++) {
    if (moment(data[i].saleDate).format('M') >= currentMonth-2 && moment(data[i].saleDate).format('M') <= currentMonth) {
      if (moment(data[i].saleDate).format('M') == currentMonth-2) {
        for (let j=0; j<consistenceData.length; j++) {
          if (data[i].productName == consistenceData[j].name) {
            consistenceData[j].sales[0] += Number(data[i].amount);
          }
        }
      }
      else if (moment(data[i].saleDate).format('M') == currentMonth-1) {
        for (let j=0; j<consistenceData.length; j++) {
          if (data[i].productName == consistenceData[j].name) {
            consistenceData[j].sales[1] += Number(data[i].amount);
          }
        }
      }
      else if (moment(data[i].saleDate).format('M') == currentMonth) {
        for (let j=0; j<consistenceData.length; j++) {
          if (data[i].productName == consistenceData[j].name) {
            consistenceData[j].sales[2] += Number(data[i].amount);
          }
        }
      }
    } 
  }

  for (let i=0; i<consistenceData.length; i++) {
    let item = {'name': consistenceData[i].name, 'score': 99999};
    results.push(item);

    let firstDiff = Math.abs(consistenceData[i].sales[0] - consistenceData[i].sales[1]);
    let secondDiff = Math.abs(consistenceData[i].sales[1] - consistenceData[i].sales[2]);

    let consistencyValue = (firstDiff + secondDiff) / 2;

    for (let j=0; j<consistenceData[i].sales.length; j++) {
      if (consistenceData[i].sales[j] == 0) {
        consistencyValue += 100; // for fairness
      }
    }

    results[i].score = consistencyValue;
  }

  for (let i=0; i<results.length; i++) {
    if (results[i].score <= topConsistentScore) {
      topConsistent = results[i].name;
      topConsistentScore = results[i].score;
    }
  }

  
  if (type == 'product') {
    document.getElementById('top_consistent_product').innerHTML = topConsistent;
  }
  else if (type == 'service') {
    document.getElementById('top_consistent_service').innerHTML = topConsistent;
  }
}