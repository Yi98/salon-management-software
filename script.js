// functions when user presses next in booking appointment

function onCompleteDateInfo() {
	const dateForm = document.getElementById('date-form');
	const serviceForm = document.getElementById('service-form');
	const dateStep = document.getElementById('date-step');
	const serviceStep = document.getElementById('service-step');

	dateForm.style.display = "none";
	serviceForm.style.display = "block";

	dateStep.classList.remove("active");
	dateStep.classList.add("completed");
	serviceStep.classList.add("active");
}


function onCompleteServicesInfo() {
	// use xhr here
	const serviceForm = document.getElementById('service-form');
	const requestForm = document.getElementById('request-form');
	const serviceStep = document.getElementById('service-step');
	const requestStep = document.getElementById('request-step');

	serviceForm.style.display = "none";
	requestForm.style.display = "block";

	serviceStep.classList.remove("active");
	serviceStep.classList.add("completed");
	requestStep.classList.add("active");
}


function onCompleteRequestInfo() {
	const requestForm = document.getElementById('request-form');
	const summaryForm = document.getElementById('summary-form');
	const requestStep = document.getElementById('request-step');
	const summaryStep = document.getElementById('summary-step');


	requestForm.style.display = "none";
	summaryForm.style.display = "block";

	requestStep.classList.remove("active");
	requestStep.classList.add("completed");
	summaryStep.classList.remove("disabled");
	summaryStep.classList.add("active");
}


function onConfirmSummary() {
	const summaryForm = document.getElementById('summary-form');
	const summaryStep = document.getElementById('summary-step');


	summaryStep.classList.add("completed");
	summaryStep.classList.remove("active");
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