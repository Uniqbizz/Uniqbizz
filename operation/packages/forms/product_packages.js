// Set Global Variables for next page button
var packageFormGeneralTitle = document.getElementById('package_form_general_title'),
	packageFormExtraTitle = document.getElementById('package_form_extra_title'),
	packageFormItineraryTitle = document.getElementById('package_form_itinerary_title'),
	packageFormPricingTitle = document.getElementById('package_form_pricing_title'),
	packageFormPictureTitle = document.getElementById('package_form_picture_title');
var packageFormGeneral = document.getElementById('package_form_general'),
	packageFormExtra = document.getElementById('package_form_extra'),
	packageFormItinerary = document.getElementById('package_form_itinerary'),
	packageFormPricing = document.getElementById('package_form_pricing'),
	packageFormPicture = document.getElementById('package_form_picture');
var packageFormGeneralNextBtn = document.getElementById('package_form_general_nextBtn'),
	packageFormExtraNextBtn = document.getElementById('package_form_extra_nextBtn'),
	packageFormItineraryNextBtn = document.getElementById('package_form_itinerary_nxtBtn'),
	packageFormPricingNextBtn = document.getElementById('package_form_pricing_nextBtn'),
	packageFormPictureNextBtn = document.getElementById('package_form_picture_nxtBtn');
// back button function
var view_page = document.getElementById('return_to_views_btn'),
	general_page = document.getElementById('return_to_general_btn'),
	extraInfo_page = document.getElementById('return_to_extraInfo_btn'),
	itinerary_page = document.getElementById('return_to_itinerary_btn'),
	pricing_page = document.getElementById('return_to_pricing_btn');

var occupancies = [];
var vehicles = [];

// Eventt listeners
packageFormGeneralNextBtn.addEventListener('click', generalFormNext, false);
packageFormExtraNextBtn.addEventListener('click', extraFormNext, false);
packageFormItineraryNextBtn.addEventListener('click', itineraryFormNext, false);
packageFormPricingNextBtn.addEventListener('click', pricingFormNext, false);
// return back function
general_page.addEventListener('click', showGeneralForm, false);
extraInfo_page.addEventListener('click', generalFormNext, false);
itinerary_page.addEventListener('click', extraFormNext, false);
pricing_page.addEventListener('click', itineraryFormNext, false);
// Fetch sub categories
document.getElementById('category_id').addEventListener('change', getSubCategories, false);
document.getElementById('sub_category_id').addEventListener('change', getSubCategory, false);
document.getElementById('sub_category_data').addEventListener('change', getSubCategory, false);
// submit form
document.getElementById('submit_form').addEventListener('click', submit_form_data, false);
document.getElementById('update_form').addEventListener('click', update_form_data, false);

// fetch sub category
function getSubCategories() {
	document.getElementById("sub_category_id").style.display = "block";
	document.getElementById("sub_category_data").style.display = "none";

	var cat_id = document.getElementById('category_id').value;
	// console.log('categoruy selected = ' +cat_id);

	$.ajax({
		type: 'POST',
		url: 'forms/get_sub_categories.php',
		data: 'cat_id=' + cat_id,
		success: function (e) {
			// console.log(e);
			$('#sub_category_id').html(e);
		},
		error: function (err) {
			console.log(err);
		},
	});

	getSubCategory();
}


var club_class_display = document.getElementById('club_class_display');
var stag_id = document.getElementById('stag_id');
var couple_id = document.getElementById('couple_id');
var family_id = document.getElementById('family_id');

var stag_id_field = document.getElementById('stag_id_field');
var couple_id_field = document.getElementById('couple_id_field');
var family_id_field = document.getElementById('family_id_field');

// get extra club data
function getSubCategory() {
	packageTypeValue = '';			// set package type null
	$('input:radio[name=package_type]').val(['']);

	getClubData();
}
function getClubData() {
	var cat_id = document.getElementById('category_id').value;
	var selected_cat_id = document.getElementById("selected_cat_id");
	if (cat_id) { } else {
		cat_id = selected_cat_id.value;
	}
	var sub_cat_id = document.getElementById('sub_category_id').value;
	var selected_sub_cat_id = document.getElementById("sub_category_data");
	if (sub_cat_id) { } else {
		sub_cat_id = selected_sub_cat_id.value;
	}
	// console.log(cat_id+ ' cat_id ,sub_cat_id '+sub_cat_id);

	// club
	if (cat_id == 1 && sub_cat_id == 1) {
		//  International
		club_class_display.style.display = "block";
		couple_id_field.style.display = "inline";
		family_id_field.style.display = "inline";
		stag_id_field.style.display = "none";
	} else if (cat_id == 2 && sub_cat_id == 4) {
		//  Domestic
		club_class_display.style.display = "block";
		couple_id_field.style.display = "inline";
		family_id_field.style.display = "inline";
		stag_id_field.style.display = "none";

		// Individual
	} else if (cat_id == 1 && sub_cat_id == 2) {
		//  International
		club_class_display.style.display = "none";
		$("#club_id").val('0');
		stag_id_field.style.display = "inline";
		couple_id_field.style.display = "none";
		family_id_field.style.display = "inline";
	} else if (cat_id == 2 && sub_cat_id == 5) {
		//  Domestic
		club_class_display.style.display = "none";
		$("#club_id").val('0');
		stag_id_field.style.display = "inline";
		couple_id_field.style.display = "none";
		family_id_field.style.display = "inline";

		// Group
	} else if (cat_id == 1 && sub_cat_id == 3) {
		//  Domestic & club
		club_class_display.style.display = "none";
		$("#club_id").val('0');
		stag_id_field.style.display = "inline";
		couple_id_field.style.display = "inline";
		family_id_field.style.display = "none";
	} else if (cat_id == 2 && sub_cat_id == 8) {
		//  Domestic & club
		club_class_display.style.display = "none";
		$("#club_id").val('0');
		stag_id_field.style.display = "inline";
		couple_id_field.style.display = "inline";
		family_id_field.style.display = "none";
	} else {
		club_class_display.style.display = "none";
		$("#club_id").val('0');
		stag_id_field.style.display = "inline";
		couple_id_field.style.display = "inline";
		family_id_field.style.display = "inline";
	}
}


//  validate data
var isValid_a1 = false, isValid_a2 = false;
var isValid_b1 = false, isValid_b2 = false, isValid_b3 = false;
var isValid_c1 = false, isValid_c2 = false, isValid_c3 = false, isValid_c4 = false, isValid_c5 = false, isValid_c6 = false;
var isValid_d1 = false, isValid_d2 = false;
var regexExp = /[^a-zA-Z0-9 ]/;		// letters, number, space
var regexExp_alphanumeric = /[^a-zA-Z0-9]/;		// letters, number
var regexExp_numeric = /[^0-9]/;			// number

// form 1
$('#name').on('keyup', function () {
	var nameID = document.getElementById("name");
	isValid_a1 = validateInput(
		regexExp,
		nameID,
		"Please enter valid Name !!"
	);
	// if (isValid_a1) {
	// check if the name does exist
	// validateIdenticalRecord('name', nameID, "Package Name is already been used !!");
	// }
});
$('#unique_code').on('keyup', function () {
	var codeID = document.getElementById("unique_code");

	isValid_a2 = validateInput(
		regexExp_alphanumeric,
		codeID,
		"Special characters are not allowed !!"
	);
	if (isValid_a2) {
		// check if the code does exist
		validateIdenticalRecord('unique_code', codeID, "This Code is already been used !!");
	}
});


// form 2
// 	$('#location').on('keyup', function(){
// 		isValid_b1 = validateInput(
// 						regexExp, 
// 						document.getElementById("location"), 
// 						"Special characters are not allowed !!"
// 					);
// 	});
$('#travel_from').on('keyup', function () {
	isValid_b2 = validateInput(
		regexExp,
		document.getElementById("travel_from"),
		"Special characters are not allowed !!"
	);
});
$('#travel_to').on('keyup', function () {
	isValid_b3 = validateInput(
		regexExp,
		document.getElementById("travel_to"),
		"Special characters are not allowed !!"
	);
});

// form 4
$('#netPriceAdult').on('keyup', function () {
	isValid_c1 = validateInput(
		regexExp_numeric,
		document.getElementById("netPriceAdult"),
		"Invalid Price for Adult!! "
	);
});
$('#netPriceChild').on('keyup', function () {
	isValid_c2 = validateInput(
		regexExp_numeric,
		document.getElementById("netPriceChild"),
		"Invalid Price for Child !! "
	);
});
$('#nGst').on('keyup', function () {
	isValid_c3 = validateInput(
		regexExp_numeric,
		document.getElementById("nGst"),
		"Invalid value for Net GST !! "
	);
});
$('#mpGst').on('keyup', function () {
	isValid_c4 = validateInput(
		regexExp_numeric,
		document.getElementById("markup"),
		"Invalid Markup Price!! "
	);
});
$('#mpGst').on('keyup', function () {
	isValid_c5 = validateInput(
		regexExp_numeric,
		document.getElementById("markup_loading_price"),
		"Invalid Markup Loading Price !! "
	);
});
$('#mpGst').on('keyup', function () {
	isValid_c6 = validateInput(
		regexExp_numeric,
		document.getElementById("mpGst"),
		"Invalid value for Makup GST !! "
	);
});


var packageTypeValue = '';
function packageTypeOnClick(data) {
	packageTypeValue = data.value;
	if (packageTypeValue == "couple") {
		document.getElementById("netPriceChildData").style.display = "none";
		document.getElementById("totalNetPriceChildData").style.display = "none";
		document.getElementById("net_gst_title").innerText = "Net GST for Adult :";
		document.getElementById('netPriceChild').value = 0;
		getNetPrice();
	} else {
		document.getElementById("netPriceChildData").style.display = "block";
		document.getElementById("totalNetPriceChildData").style.display = "block";
		document.getElementById("net_gst_title").innerText = "Net GST for Adult & Child :";
	}
}

var ocup_id, ocup_name = '';
// select occupanies to inerst in array
$('#occupancy_id').on('change', function () {
	ocup_id = $('#occupancy_id').val();
	// console.log(occupancies);

	// fetch occupancies
	if (ocup_id == '0') { } else {
		$.ajax({
			type: 'POST',
			url: 'forms/get_occupancy_categories.php',
			data: 'ocup_id=' + ocup_id,
			success: function (e) {
				// console.log(e);	// push data into array
				var data = {
					id: ocup_id,
					name: e
				};
				if (occupancies.some(data => data['id'] === ocup_id)) {
					console.log("Already Exist");
				} else {
					occupancies.push(data);
					showOccupancy();
					// $('#occupancy_data').html(occupancies.name);
				}
			},
			error: function (err) {
				console.log(err);
			},
		});
	}
});
function showOccupancy() {
	var newContainer = document.createElement("div");
	var outputOccupancy = $('#occupancy_data');
	outputOccupancy.empty();
	occupancies.forEach(function (occupancy, i) {
		var html = '<div class="card-header card-header-default occupancy_block_' + occupancy['id'] + '" style="padding: 2px 2px 0px 8px; width:100px; display:inline-flex">' +
			'<div class="row">' +
			'<div style="background-color: #4eb4cf; padding: 3px 3px 4px 5px; border-radius: 4px; color:white; font-weight:500; font-size:15px">' +
			occupancy['name'] + ' <a class="delete_occupancy" href="#" data-no="' + occupancy['id'] + '" style="margin-left: 5px;color: white;font-size: 18px;background-color: red;padding: 2px;border-radius: 5px"><i class="bx bx-trash"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>';
		// outputOccupancy.html(html);
		newContainer.innerHTML += html;
		// outputOccupancy[i].appendChild(newContainer);	// for sigle element to append
		outputOccupancy.append(newContainer);				// for multiple element to append
		// console.log(outputOccupancy);
	});
}
$(document).on('click', '.delete_occupancy', function () {
	let no = $(this).data('no');
	// console.log(no);
	occupancies.forEach(function (occupancy, i) {
		if (occupancy['id'] == no) {
			occupancies.splice(i, 1);
			$(".occupancy_block_" + no).remove();
			// console.log(occupancies);
		}
	});
});


var vehicle_id, vehicle_name = '';
// select vehicle to inerst in array
$('#vehicle_id').on('change', function () {
	vehicle_id = $('#vehicle_id').val();
	// console.log(vehicles);

	// fetch vehicles
	if (vehicle_id == '0') { } else {
		$.ajax({
			type: 'POST',
			url: 'forms/get_vehicles_categories.php',
			data: 'vehicle_id=' + vehicle_id,
			success: function (e) {
				// console.log(e);
				var data = {
					id: vehicle_id,
					name: e
				};
				if (vehicles.some(data => data['id'] === vehicle_id)) {
					console.log("Already Exist");
				} else {
					vehicles.push(data);		// push data into array
					showVehicle();
					$('#vehicle_data').html(vehicles.name);
				}
			},
			error: function (err) {
				console.log(err);
			},
		});
	}
});
function showVehicle() {
	var newContainerVehicle = document.createElement("div");
	var outputVehicle = $('#vehicle_data');
	outputVehicle.empty();
	vehicles.forEach(function (vehicle, i) {
		var html = '<div class="card-header card-header-default vehicle_block_' + vehicle['id'] + '" style="padding: 2px 2px 0px 8px; width:110px; display:inline-flex">' +
			'<div class="row">' +
			'<div style="background-color: #4eb4cf; padding: 3px 3px 4px 5px; border-radius: 4px; color:white; font-weight:500; font-size:15px">' +
			vehicle['name'] + ' <a class="delete_vehicle" href="#" data-no="' + vehicle['id'] + '" style="margin-left: 5px;color: white;font-size: 18px;background-color: red;padding: 2px;border-radius: 5px"><i class="bx bx-trash"></i></a>' +
			'</div>' +
			'</div>' +
			'</div>';
		// outputVehicle.innerHTML(html);
		newContainerVehicle.innerHTML += html;
		// outputVehicle[i].appendChild(newContainerVehicle);		// for sigle element to append
		outputVehicle.append(newContainerVehicle);				// for multiple element to append

		// console.log(outputVehicle);
	});
}
$(document).on('click', '.delete_vehicle', function () {
	let no = $(this).data('no');
	// console.log(no);
	vehicles.forEach(function (vehicle, i) {
		if (vehicle['id'] == no) {
			vehicles.splice(i, 1);
			$(".vehicle_block_" + no).remove();
			// console.log(vehicles);
		}
	});
});


// add days function
var wrapper = $(".input_fields_wrap"); 		// Fields wrapper
var add_button = $(".add_field_button"); 	// Add button
var max_fields = 16; 						// Max fields
var dayCount = 0; 							// Tracks total days added
var x = 1; 									// Tracks input boxes

$(document).ready(function () {
	$(add_button).click(function (e) {
		e.preventDefault();
		dayCount += 1;

		if (x < max_fields) {
			x++;
			$(wrapper).append(`<div class="row day-container">
						<div class="col-md-2 col-sm-2 col-12 d-flex justify-content-center align-items-center">
							<div class="">
								<a type="button" class="btn btn-success px-3 ms-4 dayval">Day: ${dayCount}</a>
							</div>
						</div>
						<div class="col-md-10 col-sm-10 col-12">
							<div class="row">
								<div class="card rounded-5 box" draggable="true">
									<div class="row px-4 pt-2 d-flex justify-content-between">
										<div class="col-md-9 col-sm-8 col-8">
											<div class="input-group mb-3">
												<span class="input-group-text">Title</span>
												<input type="text" class="form-control title" placeholder="Title">
											</div>
										</div>
										<div class="col-md-2 col-4 col-4">
											<button type="button" class="remove_field btn btn-danger px-3 ms-4">Remove</button>
										</div>
									</div>
									<div class="col-md-12 px-4 pb-2">
										<div class="input-group">
											<span class="input-group-text">Description</span>
											<textarea class="form-control description"></textarea>
										</div>
									</div>
									<div class="row px-4 py-2 pb-0">
										<div class="col-md-6">
											<div class="input-group mb-3">
												<span class="input-group-text">Meals Included</span>
												<input type="text" class="form-control meals" placeholder="Meals">
											</div>
										</div>
										<div class="col-md-6">
											<div class="input-group mb-3">
												<span class="input-group-text">Transport</span>
												<input type="text" class="form-control transport" placeholder="Transport">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>`);
			updateDayNumbers(); // Update numbering after adding
		}
	});

	// ✅ Remove button event using jQuery
	$(document).on("click", ".remove_field", function (e) {
		e.preventDefault();
		$(this).closest('.day-container').remove(); // Remove the closest .day-container
		updateDayNumbers(); // Re-number days after removing
	});

	// ✅ Function to update day numbers
	function updateDayNumbers() {
		$(".dayval").each(function (index) {
			$(this).text("Day: " + (index + 1)); // Re-assign correct day numbers
		});
	}
});
// var max_fields = 16, dayCount = 0;
// var wrapper = $(".input_fields_wrap"); 		//Fields wrapper
// var add_button = $(".add_field_button"); 	//Add button ID
// var x = 1; 									//initlal text box count
// $(document).ready(function () {
// 	$(add_button).click(function (e) { 			//on add input button click
// 		e.preventDefault();

// 		dayCount += 1;
// 		if (x < max_fields) { 					//max input box allowed
// 			x++; 								//text box increment
// 			$(wrapper).append(`<div class="row day-container" id="removeDiv">
// 						<div class="col-md-2 col-sm-2 col-12 d-flex justify-content-center align-items-center">
// 							<div class="">
// 								<a type="button" class="btn btn-success px-3 ms-4 dayval">Day:`+ dayCount + `</a>
// 							</div>
// 						</div>
// 						<div class="col-md-10 col-sm-10 col-12">
// 							<div class="row">
// 								<div class="card rounded-5 box" draggable="true" id="box`+ dayCount + `">
// 									<div class="row px-4 pt-2 d-flex justify-content-between">
// 										<div class="col-md-10">
// 											<div class="input-group mb-3">
// 												<span class="input-group-text" id="basic-addon1">Title</span>
// 												<input type="text" class="form-control title" placeholder="Title" aria-label="Username" aria-describedby="basic-addon1">
// 											</div>
// 										</div>
// 										<div class="col-md-2 col-4 col-4">
// 											<button type="button" class="remove_field btn btn-danger px-3 ms-4">Remove</button>
// 										</div>
// 									</div>
// 									<div class="col-md-12 px-4 pb-2">
// 										<div class="input-group">
// 											<span class="input-group-text">Description</span>
// 											<textarea class="form-control description" aria-label="With textarea"></textarea>
// 										</div>
// 									</div>
// 									<div class="row px-4 py-2 pb-0">
// 										<div class="col-md-6">
// 											<div class="input-group mb-3">
// 												<span class="input-group-text" id="basic-addon1">Meals Included</span>
// 												<input type="text" class="form-control meals" placeholder="Meals" aria-label="Meals" aria-describedby="basic-addon1">
// 											</div>
// 										</div>
// 										<div class="col-md-6">
// 											<div class="input-group mb-3">
// 												<span class="input-group-text" id="basic-addon1">Transport</span>
// 												<input type="text" class="form-control transport" placeholder="Transport" aria-label="Transport" aria-describedby="basic-addon1">
// 											</div>
// 										</div>
// 									</div>
// 								</div>
// 							</div>
// 						</div>
// 					</div>`



// 			); //add input box
// 		}
// 	});

// 	//user click on remove text

// 	document.querySelectorAll('.remove_field').forEach(button => {
// 		button.addEventListener('click', function(e) {
// 			e.preventDefault(); // Prevent default button action
// 			var dayContainer = this.closest('.day-container'); // Find the closest .day-container
// 			if (dayContainer) {
// 				dayContainer.remove();

// 				dayCount -= 1 
// 				$('.dayval').text('Day:'+dayCount);// Remove it from the DOM
// 			}
// 		});
// 	});
// });

// `<div style="display:flex; align-self: center; padding: 10px 0px;">
// 			<a href="#" class="col-1" style="padding: 0px 10px; align-self: center;">Day:`+ dayCount + ` </a>
// 			<textarea name="days[]" rows="2" cols="100" style="padding: 0px 10px; width: 78% !important;"></textarea>
// 			<a href="#" class="remove_field custom_btn btn2" class="col-1" style="padding: 14px 22px;">Remove</a>
// 		</div>`

// Add Days function -------------------------- NOT USING-------------------------------------
// var addDay, dayCount = 0;
// 	$('#add_day').on('click', function(){
// 		dayCount += 1;
// 		console.log(dayCount);
// 		addDay = '<span>Day-'+dayCount+' : <textarea id="day'+dayCount+'" name="day'+dayCount+'" rows="5" cols="50"></textarea> </span>\r\n';
// 		document.getElementById('wrapper').innerHTML += addDay;
// 		addingDay(dayCount);
// 	});
// 		function addingDay(dayCount) 
// 		{
// 			var dayValue = $('#day'+dayCount).value;
// 			var outputDays = $('#wrapper');
// 			var data = {
// 					id: 'day'+dayCount,
// 					name: 'day'+dayCount,
// 					value: dayValue
// 				};
// 				if(days.some(data => data['id'] === dayCount)){
// 					console.log("Already Exist");
// 				}else{
// 					days.push(data);
// 				}
// 			console.log(days);
// 		}
// 	$('#remove_day').on('click', function(){
// 		dayCount -= 1;
// 		console.log(dayCount);
// 		document.getElementById('wrapper').innerHTML -= addDay;
// 	});
// -------------------------- NOT USING-------------------------------------


// All functions
function generalformHide(d) {
	packageFormGeneralTitle.style.display = d;
	packageFormGeneral.style.display = d;
}
function extraformHide(d) {
	packageFormExtraTitle.style.display = d;
	packageFormExtra.style.display = d;
}
function itineraryformHide(d) {
	packageFormItineraryTitle.style.display = d;
	packageFormItinerary.style.display = d;
}
function pricingformHide(d) {
	packageFormPricingTitle.style.display = d;

	packageFormPricing.style.display = d;
}
function pictureformHide(d) {
	packageFormPictureTitle.style.display = d;
	packageFormPicture.style.display = d;
}
// form peginations
function showGeneralForm(e) {
	e.preventDefault();
	generalformHide("block");
	extraformHide("none");
	general_page.style.display = "none";
	view_page.style.display = "block";
}
function generalFormNext(e) {
	e.preventDefault();

	var category_id = $("#category_id").val();
	var sub_category_id = $("#sub_category_id").val();
	var selected_sub_cat_id = document.getElementById("sub_category_data");
	if (sub_category_id) { } else {
		sub_category_id = selected_sub_cat_id.value;
	}
	var club_id = $("#club_id").val();
	var name = $("#name").val();
	var unique_code = $("#unique_code").val();
	let pac_validity = $('#pac_validity').val();
	let tour_days = $('#tour_days').val();
	var description = $("#description").val();

	if (category_id == "" || sub_category_id == "" || name == "" || unique_code == "" || description == "" || pac_validity == "" || tour_days == "") {
		if (category_id == "") {
			alert("Please Select Category !");
		} else if (sub_category_id == "") {
			alert("Please Select Sub-categoy !");
		} else if (name == "") {
			alert("Please Enter name !");
		} else if (unique_code == "") {
			alert("Please Enter Unique Code !");
		} else if (pac_validity == "") {
			alert("Please Select the Package Validity !");
		} else if (tour_days == "") {
			alert("Please Enter Tours No of Days !");
		} else if (description == "") {
			alert("Description cannot be empty !");
		}
	} else if (sub_category_id == 1 && club_id == "0") {
		alert("Please Select Club-categoy !");
	} else if (sub_category_id == 4 && club_id == "0") {
		alert("Please Select Club-categoy !");
	} else if (packageTypeValue == "") {
		alert("Please Select Package Type !");
	} else if (isValid_a1 == false) {
		alert("Please enter valid Name !");
	} else if (isValid_a2 == false) {
		alert("Please enter valid Unique Code !");
	} else {
		// console.log('General Form Clicked');
		generalformHide("none");
		extraformHide("block");
		itineraryformHide("none");
		view_page.style.display = "none";
		general_page.style.display = "block";
		extraInfo_page.style.display = "none";
	}
}
function extraFormNext(e) {
	e.preventDefault();

	var destination = $("#destination").val();
	var location = $("#location").val();
	var travel_from = $("#travel_from").val();
	var travel_to = $("#travel_to").val();
	var sightseeing_type = $("#sightseeing_type").val();
	if (destination == "" || location == "" || travel_from == "" || travel_to == "" || sightseeing_type == "") {
		if (destination == "") {
			alert("Please enter Destination !");
		} else if (location == "") {
			alert("Please Enter Location !");
		} else if (travel_from == "") {
			alert("Please Enter starting point of travelling !");
		} else if (travel_to == "") {
			alert("Please Enter Travelling To !");
		} else if (sightseeing_type == "") {
			alert("Sightseeing cannot be empty !");
		}
		// } else if( isValid_b1 == false ) {
		// 	alert("Please enter valid Location Type !");
	} else if (isValid_b2 == false) {
		alert("Please enter valid Data !");
	} else if (isValid_b3 == false) {
		alert("Please enter valid Data !");
	} else {
		// console.log('Extra Form Clicked');
		extraformHide("none");
		itineraryformHide("block");
		pricingformHide("none");
		extraInfo_page.style.display = "block";
		general_page.style.display = "none";
		itinerary_page.style.display = "none";
	}
}
function itineraryFormNext(e) {
	e.preventDefault();

	var inclusion = $("#inclusion").val();
	var exclusion = $("#exclusion").val();

	if (inclusion == "" || exclusion == "") {
		if (inclusion == "") {
			alert("Please enter inclusion !");
		} else if (exclusion == "") {
			alert("Please Enter exclusion !");
		}
	} else {
		// console.log('Itinerary Form Clicked');
		itineraryformHide("none");
		pricingformHide("block");
		pictureformHide("none");
		extraInfo_page.style.display = "none";
		itinerary_page.style.display = "block";
		pricing_page.style.display = "none";
	}
}
function pricingFormNext(e) {
	e.preventDefault();

	var netPriceAdult = $("#netPriceAdult").val();
	var netPriceChild = $("#netPriceChild").val();
	var nGst = $("#nGst").val();
	var ta = $("#mp_ca_ta").val();
	var company = $('#mp_company').val();
	var cus = $('#mp_customer').val(), policy_1 = $('#can_per_1').val(), policy_2 = $('#can_per_2').val(), policy_3 = $('#can_per_3').val();
	var add_adult_p=$('#add_adult_price').val();
	//commented on 25 jan 2025 by sv
	// var markup = $("#markup").val();
	// var mpGst = $("#mpGst").val();
	// var markup_loading_price = $("#markup_loading_price").val();
	if (netPriceAdult == "" || netPriceChild == "" || nGst == "" || ta == "" || company == "" || cus == "" || policy_1 == '' || policy_2 == '' || policy_3 == ''
		|| netPriceAdult == 0 || netPriceChild == 0 || nGst == 0 || ta == 0 || company == 0 || cus == 0 || add_adult_p == '' || add_adult_p == 0) {
		if (netPriceAdult == 0) {
			alert("Please enter Net Price Per Adult !");
		} else if ((netPriceChild == "" || netPriceChild == 0) && (packageTypeValue == "stag" || packageTypeValue == "family")) {
			alert("Please enter Net Price Per Child !");
		} else if (nGst == "" || nGst == 0) {
			alert("Please Enter GST for Net Price !");
		}
		else if (ta == "" || ta == 0) {
			alert("Please enter Travel Agent value !");
		}
		else if (company == "" || company == 0) {
			alert("Please enter Company value !");
		} else if (cus == "" || cus == 0) {
			alert("Please enter Customer value !");
		} else if (add_adult_p == "" || add_adult_p == 0) {
			alert("Please enter Additional Adult Price !");
		} else if (policy_1 == '' || policy_2 == '' || policy_3 == '') {
			alert("Please fill all cancellation fields");
		}
		//commented on 25 jan 2025 by sv
		// } else if (markup == "") {
		// 	alert("Mark-up Price cannot be empty !");
		// } else if (mpGst == "") {
		// 	alert("Please Enter GST for Mark-Up Price !");
		// } else if (markup_loading_price == "") {
		// 	alert("Mark-up Loading cannot be empty !");
		// }
	} else if (isValid_c1 == false) {
		alert("Please enter valid Price for Adult ! ");
	} else if ((isValid_c2 == false) && (packageTypeValue == "stag" || packageTypeValue == "family")) {
		alert("Please enter valid Price for Child !");
	} else if (isValid_c3 == false) {
		alert("Please enter valid Value for Net GST !");
	}

	//commented on 25 jan 2025 by sv
	// else if (isValid_c4 == false) {
	// 	alert("Please enter valid Price for Markup ! ");
	// } else if (isValid_c5 == false) {
	// 	alert("Please enter valid Price for Markup Loading !");
	// } else if (isValid_c6 == false) {
	// 	alert("Please enter valid Value for Markup GST !");
	else {
		// console.log('Pricing Form Clicked');
		pricingformHide("none");
		pictureformHide("block");


		pricing_page.style.display = "block";
		itinerary_page.style.display = "none";
	}
}



var netPriceAdult = 0, netPriceChild = 0, netGst, totalNetPriceAdult, totalNetPriceChild, markUpPrice, loadingPrice, markupGst, markupPrice_LoadingPrice;
var netPriceAdultWithGST = 0, GSTofNetPriceAdult = 0, netPriceChildWithGST = 0, GSTofNetPriceChild = 0;
var netTotal, markupTotal, GSTofNetTotal, GSTofMarkUpTotal, finalPriceWithGST = 0, finalNetPriceWithGST = 0, finalMarkupPriceWithGST = 0, Product_PriceTotal, GST_PriceTotal, ca_mark_up = 0, ca_mark_up_comm = 0, ca_mark_up_ins = 0, bm_mark_up = 0, bm_mark_up_comm = 0, bm_mark_up_ins = 0, bdm_mark_up = 0, bdm_mark_up_comm = 0, bdm_mark_up_ins = 0, bcm_mark_up = 0, bcm_mark_up_comm = 0
	, bcm_mark_up_ins = 0

//for keeping 2 decimals without rounding added on 25-Jan-2025 by SV
function truncateToTwoDecimals(num) {
	return Math.trunc(num * 100) / 100;
}

// Auto package price functions
function getNetPrice() {
	netPriceAdult = document.getElementById('netPriceAdult').value;
	totalNetPriceAdult = document.getElementById('totalNetPriceAdult');
	netPriceChild = document.getElementById('netPriceChild').value;
	totalNetPriceChild = document.getElementById('totalNetPriceChild');
	netGst = document.getElementById('nGst').value;
	//comemted on 25 jan 2025 by sv
	// if (netPriceChild == "") {
	// 	netPriceChild = 0;
	// 	document.getElementById('netPriceChild').value = 0;
	// }
	netPriceAdult = parseInt(netPriceAdult, 10);
	netPriceChild = parseInt(netPriceChild, 10);

	// GST of Adult + Child
	GSTofNetPriceAdult = netPriceAdult * netGst / 100;
	GSTofNetPriceChild = netPriceChild * netGst / 100;

	netTotal = netPriceAdult + netPriceChild;
	GSTofNetTotal = GSTofNetPriceAdult + GSTofNetPriceChild;
	// adult + GST , child + GST
	netPriceAdultWithGST = netPriceAdult + GSTofNetPriceAdult;
	netPriceChildWithGST = netPriceChild + GSTofNetPriceChild;
	// assign value to input fields
	totalNetPriceAdult.value = netPriceAdultWithGST;
	totalNetPriceChild.value = netPriceChildWithGST;
	// Total Net Price
	finalNetPriceWithGST = netPriceAdultWithGST + netPriceChildWithGST;
	// console.log('finalNetPriceWithGST Total = ' +finalNetPriceWithGST);

	getFinalPrice();
}
function getMarkupPrice() { //changed on 23 Jan 2025 SV
	markUpPrice = document.getElementById('markup').value;
	loadingPrice = document.getElementById('markup_loading_price').value;
	markupGst = document.getElementById('mpGst').value;
	markupTotal = document.getElementById('totalMarkupPrice');

	markUpPrice = parseInt(markUpPrice, 10);
	loadingPrice = parseInt(loadingPrice, 10);
	markupPrice_LoadingPrice = markUpPrice + loadingPrice;
	// markup + loading * GST
	GSTofMarkUpTotal = markupPrice_LoadingPrice * markupGst / 100;
	// Total Markup Price
	finalMarkupPriceWithGST = markupPrice_LoadingPrice + GSTofMarkUpTotal;

	markupTotal.value = finalMarkupPriceWithGST;
	// console.log('MarkupPrice Total = ' +finalMarkupPriceWithGST);

	getFinalPrice();
	//commented on 25 jan 2025 by sv
	//getMarkUpDistribution();
}
function getFinalPrice() {//changed on 23 Jan 2025 SV

	var ta_mark_up = parseFloat(document.getElementById("mp_ca_ta").value) || 0;
	var company_share = parseFloat(document.getElementById("mp_company").value) || 0;
	var customer_share = parseFloat(document.getElementById("mp_customer").value) || 0;

	// Round the final values to 2 decimal places
	ca_mark_up = parseFloat(truncateToTwoDecimals(ca_mark_up));
	bm_mark_up = parseFloat(truncateToTwoDecimals(bm_mark_up));
	bdm_mark_up = parseFloat(truncateToTwoDecimals(bdm_mark_up));
	bcm_mark_up = parseFloat(truncateToTwoDecimals(bdm_mark_up));
	var company_share = $('#mp_company').val(); // new
	var customer_share = $('#mp_customer').val();

	var total_adult_price =
		netPriceAdultWithGST +
		parseFloat(ca_mark_up) +
		parseFloat(bm_mark_up) +
		parseFloat(bdm_mark_up) +
		parseFloat(bcm_mark_up) +
		parseFloat(ta_mark_up) +
		parseFloat(customer_share) +
		parseFloat(company_share);

	var total_child_price =
		netPriceChildWithGST +
		parseFloat(ca_mark_up) +
		parseFloat(bm_mark_up) +
		parseFloat(bdm_mark_up) +
		parseFloat(bcm_mark_up) +
		parseFloat(ta_mark_up) +
		parseFloat(customer_share) +
		parseFloat(company_share);
	total_adult_price = parseFloat(truncateToTwoDecimals(total_adult_price));
	total_adult_price = parseFloat(truncateToTwoDecimals(total_adult_price));
	//commented on 25 jan by sv
	// console.log('mrp_per_adult = ' + total_adult_price);
	// console.log('mrp_per_child = ' + total_child_price);
	// console.log('company_share = ' + company_share);
	// console.log('customer_share = ' + customer_share);
	document.getElementById("mrp_per_adult").value = total_adult_price;
	document.getElementById("mrp_per_child").value = total_child_price;
	//document.getElementById('mrp').value = '';
	// if (netPriceAdultWithGST > 0 && company_share > 0 && customer_share > 0) {
	// 	document.getElementById("mrp_per_adult").value = total_adult_price;
	// }
	// if (netPriceChildWithGST > 0 && company_share > 0 && customer_share > 0) {
	// 	document.getElementById("mrp_per_child").value = total_child_price;
	// }
	// console.log('gstPrice = '+GST_PriceTotal+'='+GSTofNetTotal+'+'+GSTofMarkUpTotal);
	// console.log('final price = '+finalPriceWithGST);
	// console.log('-----------------------------');
}

function finalfill() {//added on 23 Jan 2025 SV
	console.log("finalfill");
	var company_share = $("#mp_company").val()
	var customer_share = $("#mp_customer").val()
	console.log('company_share = ' + company_share);
	console.log('customer_share = ' + customer_share);
	if (company_share > 0 || customer_share > 0) {
		console.log("finalfill");
		getFinalPrice()
	}
}

function getMarkUpDistribution(payoutData) {// //changed on 23 Jan 2025 SV

	var ta_mark_up = document.getElementById("mp_ca_ta").value;

	// var company = markUpPrice * 50/100;


	const roleMap = {};
	payoutData.forEach(entry => {
		roleMap[entry.role] = entry;
	});

	//let ta_mark_up = document.getElementById("mp_ca_ta").value;
	//TE comission structure
	let ca_ovr_per = roleMap['TE']?.overall_percentage || 0;
	let ca_com_per = roleMap['TE']?.comm_percentage || 0;
	let ca_ins_per = roleMap['TE']?.ins_percentage || 0;
	//BM comission structure
	let bm_ovr_per = roleMap['BM']?.overall_percentage || 0;
	let bm_com_per = roleMap['BM']?.comm_percentage || 0;
	let bm_ins_per = roleMap['BM']?.ins_percentage || 0;
	//BDM comission structure
	let bdm_ovr_per = roleMap['BDM']?.overall_percentage || 0;
	let bdm_com_per = roleMap['BDM']?.comm_percentage || 0;
	let bdm_ins_per = roleMap['BDM']?.ins_percentage || 0;
	//BCM comission structure
	let bcm_ovr_per = roleMap['BCM']?.overall_percentage || 0;
	let bcm_com_per = roleMap['BCM']?.comm_percentage || 0;
	let bcm_ins_per = roleMap['BCM']?.ins_percentage || 0;
	//Prime customer comission structure
	let prime_ovr_per = roleMap['Prime']?.overall_percentage || 0;
	//L1 customer comission structure
	let l1_ovr_per = roleMap['L1']?.overall_percentage || 0;
	//L2 customer comission structure
	let l2_ovr_per = roleMap['L2']?.overall_percentage || 0;
	// TE (Travel Executive / CA) calculation
	ca_mark_up = ta_mark_up * (ca_ovr_per / 100);
	ca_mark_up_comm = ca_mark_up * (ca_com_per / 100);
	ca_mark_up_ins = ca_mark_up * (ca_ins_per / 100);

	// BM calculation
	bm_mark_up = ca_mark_up_comm * (bm_ovr_per / 100);
	bm_mark_up_comm = bm_mark_up * (bm_com_per / 100);
	bm_mark_up_ins = bm_mark_up * (bm_ins_per / 100);

	// BDM calculation
	bdm_mark_up = bm_mark_up_comm * (bdm_ovr_per / 100);
	bdm_mark_up_comm = bdm_mark_up * (bdm_com_per / 100);
	bdm_mark_up_ins = bdm_mark_up * (bdm_ins_per / 100);

	// BCM calculation
	bcm_mark_up = bdm_mark_up_comm * (bcm_ovr_per / 100);
	bcm_mark_up_comm = bcm_mark_up * (bcm_com_per / 100);
	bcm_mark_up_ins = bcm_mark_up * (bcm_ins_per / 100);

	//code change by pn 16-04-2025 adding customer amount
	customer_share = ta_mark_up * 43.75 / 100;
	// customer calculation
	prime_customer_share = ta_mark_up * (prime_ovr_per / 100);
	L1_customer_share = ta_mark_up * (l1_ovr_per / 100);
	L2_customer_share = ta_mark_up * (l2_ovr_per / 100);


	// keep last values to 2 decimal places
	// ca_mark_up = truncateToTwoDecimals(ca_mark_up);
	ca_mark_up_comm = truncateToTwoDecimals(ca_mark_up_comm);
	ca_mark_up_ins = truncateToTwoDecimals(ca_mark_up_ins);
	ca_mark_up = truncateToTwoDecimals(ca_mark_up_comm + ca_mark_up_ins);

	//bm_mark_up = truncateToTwoDecimals(bm_mark_up);
	bm_mark_up_comm = truncateToTwoDecimals(bm_mark_up_comm);
	bm_mark_up_ins = truncateToTwoDecimals(bm_mark_up_ins);
	bm_mark_up = truncateToTwoDecimals(bm_mark_up_comm + bm_mark_up_ins);

	// bdm_mark_up = truncateToTwoDecimals(bdm_mark_up);
	bdm_mark_up_comm = truncateToTwoDecimals(bdm_mark_up_comm);
	bdm_mark_up_ins = truncateToTwoDecimals(bdm_mark_up_ins);
	bdm_mark_up = truncateToTwoDecimals(bdm_mark_up_comm + bdm_mark_up_ins);

	// bcm_mark_up = truncateToTwoDecimals(bcm_mark_up);
	bcm_mark_up_comm = truncateToTwoDecimals(bcm_mark_up_comm);
	bcm_mark_up_ins = truncateToTwoDecimals(bcm_mark_up_ins);
	bcm_mark_up = truncateToTwoDecimals(bcm_mark_up_comm + bcm_mark_up_ins);

	//to show total
	$('#bcm_div label[for="bcm_div"]').html('Business Channel Manager (Total: ' + bcm_mark_up + ')');
	$('#bdm_div label[for="bdm_div"]').html('Business Development Manager (Total: ' + bdm_mark_up + ')');
	$('#bm_div label[for="bm_div"]').html('Business Consultant/Mentor (Total: ' + bm_mark_up + ')');
	$('#ca_div label[for="ca_div"]').html('Coporate Agency (Total: ' + ca_mark_up + ')');

	$('#mp_bcm_comm').val(bcm_mark_up_comm);
	$('#mp_bcm_ins').val(bcm_mark_up_ins);
	$('#mp_bdm_comm').val(bdm_mark_up_comm);
	$('#mp_bdm_ins').val(bdm_mark_up_ins);
	$('#mp_bm_comm').val(bm_mark_up_comm);
	$('#mp_bm_ins').val(bm_mark_up_ins);
	$('#mp_ca_comm').val(ca_mark_up_comm);
	$('#mp_ca_ins').val(ca_mark_up_ins);
	$('#mp_customer').val(customer_share);
	$('#prime_cust_comm').val(prime_customer_share);
	$('#l1_cust_comm').val(L1_customer_share);
	$('#l2_cust_comm').val(L2_customer_share);
	

	//for cheking data
	var data = {
		bcm: {
			bcm_mark_up: bcm_mark_up,
			commission: bcm_mark_up_comm,
			incentives: bcm_mark_up_ins
		},
		bdm: {
			bdm_mark_up: bdm_mark_up,
			commission: bdm_mark_up_comm,
			incentives: bdm_mark_up_ins
		},
		bm: {
			bm_mark_up: bm_mark_up,
			commission: bm_mark_up_comm,
			incentives: bm_mark_up_ins
		},
		ca: {
			ca_mark_up: ca_mark_up,
			commission: ca_mark_up_comm,
			incentives: ca_mark_up_ins
		},
		cu: {
			customer_share: customer_share,
			prime_customer_share: prime_customer_share,
			L1_customer_share: L1_customer_share,
			L2_customer_share: L2_customer_share
		}
	};
	console.log('data', data);
	getFinalPrice()
}



// Multiple images preview in browser
var input_image, images = [], j = 0;

$(function () {
	var imagesPreview = function (input, placeToInsertImagePreview) {
		if (input.files) {
			var filesAmount = input.files.length;
			for (i = 0; i < filesAmount; i++) {
				var reader = new FileReader();
				reader.onload = function (event) {
					$($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
					input_image = {
						"id": j,
						"name": event.target.result,
					};
					images.push(input_image);
					j++;
					// console.log(images);
				}
				reader.readAsDataURL(input.files[i]);
			}
		}
	};
	$('#gallery-photo-add').on('change', function () {
		imagesPreview(this, 'div.gallery');
	});
});

//  submit form changed on 25 jan 2025 by sv
function submit_form_data(e) {
	e.preventDefault();

	var image_data = $("#gallery-photo-add").val();
	if (image_data == "") {
		alert("Pictures cannot be Empty !");
	} else {
		var category_id = parseInt($('#category_id').val());
		var sub_category_id = parseInt($('#sub_category_id').val());
		var club_id = parseInt($('#club_id').val());
		// var package_type = packageType;
		var category_hotel_id = parseInt($('#category_hotel_id').val());
		var category_meal_id = parseInt($('#category_meal_id').val());
		var name = $('#name').val();
		var unique_code = $('#unique_code').val();
		var pac_validity = $('#pac_validity').val();
		var tour_days = $('#tour_days').val();
		var description = $('#description').val();
		var destination = $('#destination').val();
		var location = $('#location').val();
		var travel_from = $('#travel_from').val();
		var travel_to = $('#travel_to').val();
		var sightseeing_type = $('#sightseeing_type').val();
		var package_keywords = $('#package_keywords').val();
		var bcm_mark_up_comm = parseFloat($('#mp_bcm_comm').val());
		var bcm_mark_up_ins = parseFloat($('#mp_bcm_ins').val());
		var bdm_mark_up_comm = parseFloat($('#mp_bdm_comm').val());
		var bdm_mark_up_ins = parseFloat($('#mp_bdm_ins').val());
		var bm_mark_up_comm = parseFloat($('#mp_bm_comm').val());
		var bm_mark_up_ins = parseFloat($('#mp_bm_ins').val());
		var ca_mark_up_comm = parseFloat($('#mp_ca_comm').val());
		var ca_mark_up_ins = parseFloat($('#mp_ca_ins').val());
		var inclusion, exclusion, remark;
		var temp_inclusion = $('#inclusion').val();
		if (temp_inclusion) {
			inclusion = $('#inclusion').val();
		} else {
			inclusion = '';
		}
		var temp_exclusion = $('#exclusion').val();
		if (temp_exclusion) {
			exclusion = $('#exclusion').val();
		} else {
			exclusion = '';
		}
		var temp_remark = $('#remark').val();
		if (temp_remark) {
			remark = $('#remark').val();
		} else {
			remark = '';
		}
		var net_price_adult = $('#netPriceAdult').val(); // new
		var net_price_child = $('#netPriceChild').val(); // new
		var net_gst = $('#nGst').val();
		var net_price_adult_with_GST = $('#totalNetPriceAdult').val(); // new
		var net_price_child_with_GST = $('#totalNetPriceChild').val(); // new
		var total_package_price_per_adult = $('#mrp_per_adult').val();
		var total_package_price_per_child = $('#mrp_per_child').val().trim() || '0'
		// mark_up distribution
		var ta_mark_up = parseFloat($("#mp_ca_ta").val());
		var company_share = parseFloat($("#mp_company").val());
		var customer_share = parseFloat($("#mp_customer").val());
		
		// CA calculation
		var ca_mark_up = ca_mark_up_ins + ca_mark_up_comm;
		// BM calculation
		var bm_mark_up = bm_mark_up_ins + bm_mark_up_comm;
		// BDM calculation
		var bdm_mark_up = bdm_mark_up_ins + bdm_mark_up_comm;
		// BCM calculation
		var bcm_mark_up = bcm_mark_up_ins + bcm_mark_up_comm;
		//var details_of_day = document.getElementsByName('days[]');
		//addition adult price
		var add_adult_price=$('#add_adult_price').val();
		var prime_customer_share = $('#prime_cust_comm').val();
        var L1_customer_share = $('#l1_cust_comm').val();
        var L2_customer_share = $('#l2_cust_comm').val();
		//cancel policy
		var policy_1 = $('#can_per_1').val();
		var policy_2 = $('#can_per_2').val();
		var policy_3 = $('#can_per_3').val();
		var allTripDaysData = [];

		$(".day-container").each(function () {
			var dayData = {
				title: $(this).find(".title").val(),
				description: $(this).find(".description").val(),
				meals: $(this).find(".meals").val(),
				transport: $(this).find(".transport").val(),
			};
			allTripDaysData.push(dayData);
		});

		var formdata = {
			category_id: category_id,
			category_hotel_id: category_hotel_id,
			category_meal_id: category_meal_id,
			club_id: club_id,
			sub_category_id: sub_category_id,
			package_type: packageTypeValue,
			name: name,
			unique_code: unique_code,
			pac_validity: pac_validity,
			tour_days: tour_days,
			description: description,
			destination: destination,
			location: location,
			travel_from: travel_from,
			travel_to: travel_to,
			package_keywords: package_keywords,
			sightseeing_type: sightseeing_type,
			occupancies: [],
			vehicles: [],
			inclusion: inclusion,
			exclusion: exclusion,
			remark: remark,
			net_price_adult: net_price_adult,
			net_price_child: net_price_child,
			net_gst: net_gst,
			net_price_adult_with_GST: net_price_adult_with_GST,
			net_price_child_with_GST: net_price_child_with_GST,
			ta_mark_up: ta_mark_up,
			ca_mark_up: ca_mark_up,
			ca_mark_up_comm: ca_mark_up_comm,
			ca_mark_up_ins: ca_mark_up_ins,
			bm_mark_up: bm_mark_up,
			bm_mark_up_comm: bm_mark_up_comm,
			bm_mark_up_ins: bm_mark_up_ins,
			bdm_mark_up: bdm_mark_up,
			bdm_mark_up_comm: bdm_mark_up_comm,
			bdm_mark_up_ins: bdm_mark_up_ins,
			bcm_mark_up: bcm_mark_up,
			bcm_mark_up_comm: bcm_mark_up_comm,
			bcm_mark_up_ins: bcm_mark_up_ins,
			total_package_price_per_adult: total_package_price_per_adult,
			total_package_price_per_child: total_package_price_per_child,
			company_share: company_share,
			customer_share: customer_share,
			prime_customer_share: prime_customer_share,
			L1_customer_share: L1_customer_share,
			L2_customer_share: L2_customer_share,
			add_adult_price:add_adult_price,
			policy_1: policy_1,
			policy_2: policy_2,
			policy_3: policy_3,
			images: [],
			details_of_day: allTripDaysData
		};


		images.forEach(function (image, i) {
			formdata.images.push({
				'name': image.name
			});
		});
		occupancies.forEach(function (data, i) {
			formdata.occupancies.push({
				'id': data.id
			});
		});
		vehicles.forEach(function (data, i) {
			formdata.vehicles.push({
				'id': data.id
			});
		});

		//console.log(formdata);

		let data = JSON.stringify(formdata);
		console.log(data);
		showLoader(true);       // loader start
		$.ajax({
			type: "POST",
			url: 'forms/create.php',
			data: data,
			headers: {
				"Content-Type": "application/json",
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (res) {
				//	console.log(res);
				if (res.toString() == "success") {
					// console.log('Record Created');
					alert("Create successfully");
					window.location = "../packages/all_packages.php";
				} else {
					console.log('Failed to create data ');
				}
			},
			complete: function () {
				showLoader(false);   // loader end 
			},
			error: function (err) {
				console.log(err);
			}
		});
	}
}

// update form chaged on 25 jan 2025 by sv
function update_form_data(e) {
	e.preventDefault();
	// console.log("update data");


	//new data 25 jav 2025 SV
	var package_id = parseInt($('#package_id').val());
	var category_id = parseInt($('#category_id').val());
	var sub_category_id = parseInt($('#sub_category_id').val());
	var temp_sub_cat = parseInt($('#sub_category_data').val());
	if (temp_sub_cat) {
		sub_category_id = parseInt($('#sub_category_data').val());
	} else {
		sub_category_id = parseInt($('#sub_category_id').val());
	}
	var club_id = parseInt($('#club_id').val());
	var club_id = parseInt($('#club_id').val());
	// var package_type = packageType;
	var category_hotel_id = parseInt($('#category_hotel_id').val());
	var category_meal_id = parseInt($('#category_meal_id').val());
	var name = $('#name').val();
	var unique_code = $('#unique_code').val();
	var description = $('#description').val();
	var pac_validity = $('#pac_validity').val();
	var tour_days = $('#tour_days').val();
	var destination = $('#destination').val();
	var location = $('#location').val();
	var travel_from = $('#travel_from').val();
	var travel_to = $('#travel_to').val();
	var sightseeing_type = $('#sightseeing_type').val();
	var package_keywords = $('#package_keywords').val();
	var bcm_mark_up_comm = parseFloat($('#mp_bcm_comm').val());
	var bcm_mark_up_ins = parseFloat($('#mp_bcm_ins').val());
	var bdm_mark_up_comm = parseFloat($('#mp_bdm_comm').val());
	var bdm_mark_up_ins = parseFloat($('#mp_bdm_ins').val());
	var bm_mark_up_comm = parseFloat($('#mp_bm_comm').val());
	var bm_mark_up_ins = parseFloat($('#mp_bm_ins').val());
	var ca_mark_up_comm = parseFloat($('#mp_ca_comm').val());
	var ca_mark_up_ins = parseFloat($('#mp_ca_ins').val());
	var inclusion, exclusion, remark;
	var temp_inclusion = $('#inclusion').val();
	if (temp_inclusion) {
		inclusion = $('#inclusion').val();
	} else {
		inclusion = '';
	}
	var temp_exclusion = $('#exclusion').val();
	if (temp_exclusion) {
		exclusion = $('#exclusion').val();
	} else {
		exclusion = '';
	}
	var temp_remark = $('#remark').val();
	if (temp_remark) {
		remark = $('#remark').val();
	} else {
		remark = '';
	}
	var net_price_adult = $('#netPriceAdult').val(); // new
	var net_price_child = $('#netPriceChild').val(); // new
	var net_gst = $('#nGst').val();
	var net_price_adult_with_GST = $('#totalNetPriceAdult').val(); // new
	var net_price_child_with_GST = $('#totalNetPriceChild').val(); // new
	var total_package_price_per_adult = $('#mrp_per_adult').val();
	var total_package_price_per_child = $('#mrp_per_child').val().trim() || '0';
	// mark_up distribution
	var ta_mark_up = parseFloat($("#mp_ca_ta").val());
	var company_share = parseFloat($("#mp_company").val());
	var customer_share = parseFloat($("#mp_customer").val());
	// CA calculation
	var ca_mark_up = ca_mark_up_ins + ca_mark_up_comm;
	// BM calculation
	var bm_mark_up = bm_mark_up_ins + bm_mark_up_comm;
	// BDM calculation
	var bdm_mark_up = bdm_mark_up_ins + bdm_mark_up_comm;
	// BCM calculation
	var bcm_mark_up = bcm_mark_up_ins + bcm_mark_up_comm;
	//var details_of_day = document.getElementsByName('days[]');
	//addition adult price
	var add_adult_price=$('#add_adult_price').val();
	var prime_customer_share = $('#prime_cust_comm').val();
    var L1_customer_share = $('#l1_cust_comm').val();
    var L2_customer_share = $('#l2_cust_comm').val();
	//cancel policy
	var policy_1 = $('#can_per_1').val();
	var policy_2 = $('#can_per_2').val();
	var policy_3 = $('#can_per_3').val();
	var allTripDaysData = [];

	$(".day-container").each(function () {
		var dayData = {
			title: $(this).find(".title").val(),
			description: $(this).find(".description").val(),
			meals: $(this).find(".meals").val(),
			transport: $(this).find(".transport").val(),
		};
		allTripDaysData.push(dayData);
	});


	// new data 25 Jan 2025 by sv

	var formdata = {
		package_id: package_id,
		category_id: category_id,
		category_hotel_id: category_hotel_id,
		category_meal_id: category_meal_id,
		club_id: club_id,
		sub_category_id: sub_category_id,
		package_type: packageTypeValue,
		name: name,
		unique_code: unique_code,
		description: description,
		pac_validity: pac_validity,
		tour_days: tour_days,
		destination: destination,
		location: location,
		travel_from: travel_from,
		travel_to: travel_to,
		package_keywords: package_keywords,
		sightseeing_type: sightseeing_type,
		occupancies: [],
		vehicles: [],
		inclusion: inclusion,
		exclusion: exclusion,
		remark: remark,
		net_price_adult: net_price_adult,
		net_price_child: net_price_child,
		net_gst: net_gst,
		net_price_adult_with_GST: net_price_adult_with_GST,
		net_price_child_with_GST: net_price_child_with_GST,
		ta_mark_up: ta_mark_up,
		ca_mark_up: ca_mark_up,
		ca_mark_up_comm: ca_mark_up_comm,
		ca_mark_up_ins: ca_mark_up_ins,
		bm_mark_up: bm_mark_up,
		bm_mark_up_comm: bm_mark_up_comm,
		bm_mark_up_ins: bm_mark_up_ins,
		bdm_mark_up: bdm_mark_up,
		bdm_mark_up_comm: bdm_mark_up_comm,
		bdm_mark_up_ins: bdm_mark_up_ins,
		bcm_mark_up: bcm_mark_up,
		bcm_mark_up_comm: bcm_mark_up_comm,
		bcm_mark_up_ins: bcm_mark_up_ins,
		total_package_price_per_adult: total_package_price_per_adult,
		total_package_price_per_child: total_package_price_per_child,
		company_share: company_share,
		customer_share: customer_share,
		prime_customer_share: prime_customer_share,
		L1_customer_share: L1_customer_share,
		L2_customer_share: L2_customer_share,
		add_adult_price:add_adult_price,
		policy_1: policy_1,
		policy_2: policy_2,
		policy_3: policy_3,
		images: [],
		details_of_day: allTripDaysData
	};


	images.forEach(function (image, i) {
		formdata.images.push({
			'name': image.name
		});
	});
	occupancies.forEach(function (data, i) {
		formdata.occupancies.push({
			'id': data.id
		});
	});
	vehicles.forEach(function (data, i) {
		formdata.vehicles.push({
			'id': data.id
		});
	});

	console.log(formdata);

	let data = JSON.stringify(formdata);
	//console.log(data);
	showLoader(true);       // loader start 
	$.ajax({
		type: "POST",
		url: 'forms/update.php',
		data: data,
		headers: {
			"Content-Type": "application/json",
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success: function (res) {
			console.log(res);
			if (res.toString() == "success") {
				//console.log(res);

				//console.log('Record Updated');
				alert("Updated successfully");
				window.location = "../packages/all_packages.php";
			} else {
				console.log('Failed to update data ');
			}
		},
		complete: function () {
			showLoader(false);   // loader end 
		},
		error: function (err) {
			console.log(err);
		}
	});
}







var loader = document.getElementById("loading-loader");
var page_body = document.getElementById("page_body");

function showLoader(value) {
	if (value) {
		page_body.classList.add('parent_disable');
		loader.style.display = "block";
	} else {
		page_body.classList.remove('parent_disable')
		loader.style.display = "none";
		window.scrollTo(0, document.body.scrollHeight);
	}
}

// validate function
function validateInput(regex, elementID, errorMessage) {
	if (regex.test(elementID.value)) {
		showErrorMessage(errorMessage, elementID);
		return false;
	} else {
		hideErrorMessage(elementID);
		return true;
	}
}

function showErrorMessage(errorMessage, elementID) {
	showBottomSnackBar(errorMessage);
	elementID.classList.add('invalid_input');
}
function hideErrorMessage(elementID) {
	elementID.classList.remove('invalid_input');
}

function validateIdenticalRecord(type, elementID, errorMessage) {
	$.ajax({
		type: "POST",
		url: 'forms/validate_records.php',
		data: 'type=' + type + '&value=' + elementID.value,
		success: function (res) {

			if (res.toString() == 'success') {
				showErrorMessage(errorMessage, elementID);
				isValid_a2 = false;
			} else {
				hideErrorMessage(elementID);
				isValid_a2 = true;
			}
		},
		error: function (err) {
			console.log(err);
		}
	});
}

// disable next button
function showNextFormButton(isValid, showButton) {
	if (isValid == true) {
		showButton.classList.remove('disable_clickablea_area');
	} else {
		showButton.classList.add('disable_clickablea_area');
	}
}

// snack bar
function showBottomSnackBar(textString) {
	var x = document.getElementById("bottom-snackbar");
	x.style.display = "block";
	x.innerText = textString;

	setTimeout(function () {
		x.style.display = "none";
	}, 4000);
}