var payoutData1 = '';
//for current and future dates only
document.getElementById("pac_validity").min = new Date().toISOString().split("T")[0];
//to accept only alpha numerics 
function allowedCharset(inputId) {
    const input = document.getElementById(inputId);

    if (!input) return;

    input.addEventListener("keypress", function (e) {
        const char = String.fromCharCode(e.which || e.keyCode);
		//only alphabets and spaces
        if (!/^[a-zA-Z\s]$/.test(char)) {
            e.preventDefault();
        }
		//only alphabets, numbers and spaces
		// if (!/^[a-zA-Z0-9\s]$/.test(char)) {
		// 	e.preventDefault();
		// }

		// Only alphabets, numbers, spaces, hyphen (-) and underscore (_)
		// if (!/^[a-zA-Z0-9\s_-]$/.test(char)) {
		// 	e.preventDefault();
		// }
    });

    input.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
    });
}
//pacLocation
allowedCharset("pacLocation");
//language_type
allowedCharset("language_type");

$.ajax({
    url: 'forms/payout_data.php', // fixed file name
    type: 'GET',            // GET is fine since we’re not sending sensitive data
    dataType: 'json',       // expecting JSON from PHP
    success: function(response) {
        payoutData1 = response;
        // console.log('Payout Data1:', payoutData1);
    },
    error: function(xhr, status, error) {
        console.error('AJAX Error:', error);
    }
});

$.ajax({
    url: "forms/get_institution_slab.php",
    type: "GET",
    dataType: "json",
    success: function (response) {

        let html = "";

        if (response.length > 0) {

            response.forEach(function (row) {

                html += `
                    <tr>
                        <td>${Number(row.lower_limit).toLocaleString("en-IN")} - ${Number(row.upper_limit).toLocaleString("en-IN")}</td>
                        <td class="text-start">${Number(row.institution_commission).toLocaleString("en-IN")}</td>
                    </tr>
                `;

            });

        } else {

            html = `
                <tr>
                    <td colspan="2" class="text-center text-muted">
                        No records found
                    </td>
                </tr>
            `;

        }

        $("#commissionTableBody").html(html);

    },
    error: function (xhr, status, error) {
        console.error(error);
    }
});


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
var total_mark_up=0;
let mark_up_title = newmark_up_title = coupon_title = newcoupon_title = insmark_up_title = inscoupon_title = 0;
function getMarkupValues() {

    let text = $('#mark_up_title').text();
    let text2 = $('#new_mark_up_title').text();
    let text3 = $('#cup_title').text();
    let text4 = $('#newcup_title').text();
	let text5 = $('#ins_mark_up_title').text();
	let text6 = $('#inscup_title').text();

    mark_up_title = parseFloat(text.match(/[\d.]+/)?.[0]) || 0;
    newmark_up_title = parseFloat(text2.match(/[\d.]+/)?.[0]) || 0;
    coupon_title = parseFloat(text3.match(/[\d.]+/)?.[0]) || 0;
    newcoupon_title = parseFloat(text4.match(/[\d.]+/)?.[0]) || 0;
    insmark_up_title = parseFloat(text3.match(/[\d.]+/)?.[0]) || 0;
    inscoupon_title = parseFloat(text4.match(/[\d.]+/)?.[0]) || 0;

	//equate the old markup with new on change
	insmark_up_title = newmark_up_title = mark_up_title 

    console.log({
        mark_up_title,
        newmark_up_title,
		insmark_up_title,
        coupon_title,
        newcoupon_title,
		inscoupon_title
    });
}


// observe text changes in spans/divs/labels
const observer = new MutationObserver(function (mutations) {
    getMarkupValues();
});


// target elements
[
    '#mark_up_title',
    '#new_mark_up_title',
    '#cup_title',
    '#newcup_title',
	'#ins_mark_up_title',
	'#inscup_title'
].forEach(selector => {

    let target = document.querySelector(selector);

    if (target) {
        observer.observe(target, {
            childList: true,
            characterData: true,
            subtree: true
        });
    }
});


// initial load
getMarkupValues();

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
		document.getElementById("net_gst_title").innerText = "Net GST (%) for Adult :";
		document.getElementById('netPriceChild').value = 0;
		getNetPrice();
	} else {
		document.getElementById("netPriceChildData").style.display = "block";
		document.getElementById("totalNetPriceChildData").style.display = "block";
		document.getElementById("net_gst_title").innerText = "Net GST (%) for Adult & Child :";
	}
}

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
						<div class="col-md-2 col-sm-2 col-12 mb-2">
							<div class="upload-card icon-upload-card" data-title="Icons" data-index="1">
								<input type="hidden" id="img_path1" value="">
								<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file1">
								<div class="upload-content">
									<div class="upload-icon">
										<i class="fa-solid fa-user"></i>
									</div>
									<h6>Add Icons</h6>
									<p>Click to upload<br>or drag and drop</p>
									<small>(JPG, PNG, PDF)</small>
								</div>
							</div>
 						</div>
						<div class="col-md-10 col-sm-10 col-12">
							<div class="card rounded-5 box border border-1 px-3 pt-3" draggable="true">
								<div class="row">
									<div class="col-md-2 col-sm-3 col-3">
										<a type="button" class="btn btn-success px-3 dayval">Day: ${dayCount}</a>
									</div>
									<div class="col-md-8 col-sm-6 col-6">
										<div class="input-group mb-3">
											<span class="input-group-text">Title</span>
											<input type="text" class="form-control title" placeholder="Title">
										</div>
									</div>
									<div class="col-md-2 col-sm-3 col-3">
										<div class="d-flex justify-content-end">
											<button type="button" class="remove_field btn btn-danger px-3 ms-4">Remove</button>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="input-group mb-3">
											<span class="input-group-text">Description</span>
											<textarea class="form-control description"></textarea>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="input-group mb-3">
											<span class="input-group-text">Meals Included</span>
											<input type="text" class="form-control meals" placeholder="Meals">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="input-group mb-3">
											<span class="input-group-text">Transport</span>
											<input type="text" class="form-control transport" placeholder="Transport">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-12">
										<div class="input-group mb-3">
											<span class="input-group-text">Stay</span>
											<input type="text" class="form-control transport" placeholder="Stay">
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
	var cus = $('#mp_customer').val();
	var L1_customer_share=$('#l1_cust_comm').val();
	//new markup variables dded on 09 may 2026 by SV
	var newta = $("#new_mp_ca_ta").val();
	var newcus = $('#mp_customer').val();
	var newL1_customer_share=$('#new_l1_cust_comm').val();
	// ins markup validation add on 12-05-2026 by SV
	var ins_mp_ca_ta = $("#ins_mp_ca_ta").val();
	var inscus = $('#ins_mp_customer').val();
	var insL1_customer_share=$('#ins_l1_cust_comm').val();
	//--------------
	var policy_1 = $('#can_per_1').val(), policy_2 = $('#can_per_2').val(), policy_3 = $('#can_per_3').val();
	var add_adult_p=$('#add_adult_price').val();
	//commented on 25 jan 2025 by sv
	// var markup = $("#markup").val();
	// var mpGst = $("#mpGst").val();
	// var markup_loading_price = $("#markup_loading_price").val();
	if (netPriceAdult == "" || netPriceChild == "" || nGst == "" || ta == "" 
		|| company == "" || L1_customer_share=="" || policy_1 == '' || policy_2 == '' || policy_3 == ''
		|| netPriceAdult == 0 || netPriceChild == 0 || nGst == 0 || ta == 0 || company == 0 
		|| add_adult_p == '' || add_adult_p == 0 || newta == "" || newta == 0 || newL1_customer_share == "" || newL1_customer_share == 0
		|| ins_mp_ca_ta == "" || ins_mp_ca_ta == 0 || insL1_customer_share == "" || insL1_customer_share == 0) {
			
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
		} else if (L1_customer_share=="" || L1_customer_share==0) {
			alert("Please enter L1 Customer value !");
		} else if (add_adult_p == "" || add_adult_p == 0) {
			alert("Please enter Additional Adult Price !");
		} else if (policy_1 == '' || policy_2 == '' || policy_3 == '') {
			alert("Please fill all cancellation fields");
		}
		//new chief techno markup validation add on 09 may 2026 by SV
		else if (newta == "" || newta == 0) {
			alert("Please enter chief techno Travel Agent value !");
		}else if (newL1_customer_share=="" || newL1_customer_share==0) {
			alert("Please enter chief techno L1 Customer value !");
		}
		//new institution markup validation add on 09 may 2026 by SV
		else if (ins_mp_ca_ta == "" || ins_mp_ca_ta == 0) {
			alert("Please enter Instituion value !");
		}else if (insL1_customer_share=="" || insL1_customer_share==0) {
			alert("Please enter Instituion L1 Customer value !");
		}
	} else if (isValid_c1 == false) {
		alert("Please enter valid Price for Adult ! ");
	} else if ((isValid_c2 == false) && (packageTypeValue == "stag" || packageTypeValue == "family")) {
		alert("Please enter valid Price for Child !");
	} else if (isValid_c3 == false) {
		alert("Please enter valid Value for Net GST !");
	}

	else {
		console.log('Pricing Form Completed');
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
//suspence and final price calculation
const recalculateFields = [
    "#customer1",
    "#customer2",
    "#customer3",
    "#netPriceAdult",
    "#netPriceChild",
    "#companyMarkup",
    "#couponAdjustment",
	"#travelConsultant"
];

$(document).on("input change", recalculateFields.join(","), function () {
    calculateEverything();
});

let previousValues = {};

$(document).on("input change", recalculateFields.join(","), function () {

    const id = this.id;
    const value = $(this).val();

    if (previousValues[id] === value) {
        return;
    }

    previousValues[id] = value;

    calculateEverything();
});

function calculateEverything() {

    calculatePackagePrice(payoutData);

    calculatePackagePriceNew(payoutDataNew);

    calculatePackagePriceIns(payoutDataInsBm);

    calculatePackagePriceInsCte(payoutDataInsCte);

    calculateFinalValues();
}

//get all the values and calculate suspence and then diter mine the final price of adult and child
function calculateFinalValues() {

    let apValue = parseFloat($("#netPriceAdult").val()) || 0;   // Adult
    let cpValue = parseFloat($("#netPriceChild").val()) || 0;   // Child
    let cmValue = parseFloat($("#companyMarkup").val()) || 0;
    let cAdjValue = parseFloat($("#couponAdjustment").val()) || 0;

    function getAmount(selector) {
		return parseFloat(
			$(selector)
				.text()
				.replace(/,/g, "")
				.replace(/[^\d.-]/g, "")
		) || 0;
	}

	let cteChainTotalValue = getAmount("#cteChainCommInsTotal");
	let bmTeChainTotalValue = getAmount("#bmTeChainCommInsTotal");
	let bmIComInsTotal = getAmount("#bmIComInsTotal");
	let iCteComInsTotal = getAmount("#iCteComInsTotal");

    let tcValue = parseFloat($("#travelConsultant").val()) || 0;

    let customer1 = parseFloat($("#customer1").val()) || 0;
    let customer2 = parseFloat($("#customer2").val()) || 0;
    let customer3 = parseFloat($("#customer3").val()) || 0;

    // Common amount
    let adultCommon =
        apValue +
        cmValue +
        cAdjValue +
        customer1 +
        customer2 +
        customer3;
    let childCommon =
        cpValue +
        cmValue +
        cAdjValue +
        customer1 +
        customer2 +
        customer3;

    // Four possible totals
    let adultTotal1 = adultCommon + tcValue + cteChainTotalValue;
    let adultTotal2 = adultCommon + tcValue + bmTeChainTotalValue;
    let adultTotal3 = adultCommon + bmIComInsTotal;
    let adultTotal4 = adultCommon + iCteComInsTotal;

    let childTotal1 = childCommon + tcValue + cteChainTotalValue;
    let childTotal2 = childCommon + tcValue + bmTeChainTotalValue;
    let childTotal3 = childCommon + bmIComInsTotal;
    let childTotal4 = childCommon + iCteComInsTotal;
	// console.log("adultTotal1:"+adultTotal1);
	// console.log("adultTotal2:"+adultTotal2);
	// console.log("adultTotal3:"+adultTotal3);
	// console.log("adultTotal4:"+adultTotal4);
	
    // Find the maximum
    let adultMaxTotal = Math.max(adultTotal1, adultTotal2, adultTotal3, adultTotal4);
    let childMaxTotal = Math.max(childTotal1, childTotal2, childTotal3, childTotal4);

    // Set MRP
    $("#mrp_per_adult").val(truncateToTwoDecimals(adultMaxTotal));
    $("#mrp_per_child").val(truncateToTwoDecimals(childMaxTotal));

    // Suspense values
    $("#cteSuspence").val((truncateToTwoDecimals(adultMaxTotal - adultTotal1)));
    $("#bmSuspence").val((truncateToTwoDecimals(adultMaxTotal - adultTotal2)));
    $("#bmISuspence").val((truncateToTwoDecimals(adultMaxTotal - adultTotal3)));
    $("#cteISuspence").val((truncateToTwoDecimals(adultMaxTotal - adultTotal4)));

    // 
    // return {
    //     total1,
    //     total2,
    //     total3,
    //     total4,
    //     maxTotal
    // };
}
//customer commission
$(document).on("input", "#customer1", function () {

    let customer1 = parseFloat($(this).val()) || 0;

    // Customer 2
    let per2 = parseFloat($("#customer2").data("per")) || 0;
    let customer2 = customer1 * (per2 / 100);
    $("#customer2").val(customer2.toFixed(2));

    // Customer 3 (based on Customer 2)
    let per3 = parseFloat($("#customer3").data("per")) || 0;
    let customer3 = customer2 * (per3 / 100);
    $("#customer3").val(customer3.toFixed(2));

});

//new cheif techno calulation funtion for new markup structure
document.getElementById('travelConsultant').addEventListener('input', function () {
	calculatePackagePriceNew(payoutDataNew);
	calculatePackagePrice(payoutData);
});
//calculate Institution base of adult price
document.getElementById('netPriceAdult').addEventListener('input', function () {
	calculatePackagePriceIns(payoutDataInsBm);
	calculatePackagePriceInsCte(payoutDataInsCte);
});
//cte->ete->ste->te
function calculatePackagePriceNew(payoutData) {

    let tcValue = parseFloat($("#travelConsultant").val()) || 0;

    //=========================
    // Percentages
    //=========================

    const teComPer  = parseFloat(payoutData.TE.comm_percentage)  || 0;
    const teInsPer  = parseFloat(payoutData.TE.ins_percentage)   || 0;

    const steComPer = parseFloat(payoutData.STE.comm_percentage) || 0;
    const steInsPer = parseFloat(payoutData.STE.ins_percentage)  || 0;

    const eteComPer = parseFloat(payoutData.ETE.comm_percentage) || 0;
    const eteInsPer = parseFloat(payoutData.ETE.ins_percentage)  || 0;

    const cteComPer = parseFloat(payoutData.CTE.comm_percentage) || 0;
    const cteInsPer = parseFloat(payoutData.CTE.ins_percentage)  || 0;


    //=========================
    // TE
    //=========================

    let teComm = truncateToTwoDecimals(tcValue * teComPer / 100);
    let teIns  = truncateToTwoDecimals(tcValue * teInsPer / 100);

    //=========================
    // STE
    //=========================

    let steComm = truncateToTwoDecimals(teComm * steComPer / 100);
    let steIns  = truncateToTwoDecimals(teComm * steInsPer / 100);

    //=========================
    // ETE
    //=========================

    let eteComm = truncateToTwoDecimals(steComm * eteComPer / 100);
    let eteIns  = truncateToTwoDecimals(steComm * eteInsPer / 100);

    //=========================
    // CTE
    //=========================

    let cteComm = truncateToTwoDecimals(eteComm * cteComPer / 100);
    let cteIns  = truncateToTwoDecimals(eteComm * cteInsPer / 100);



    //=========================
    // Update Table
    //=========================

    updateRole(
        "#cTeFComm",
        "#cTeFIns",
        "#cTeFCommInsTotal",
        teComm,
        teIns
    );

    updateRole(
        "#steComm",
        "#steIns",
        "#steCommInsTotal",
        steComm,
        steIns
    );

    updateRole(
        "#eteComm",
        "#eteIns",
        "#eteCommInsTotal",
        eteComm,
        eteIns
    );

    updateRole(
        "#cteComm",
        "#cteIns",
        "#cteCommInsTotal",
        cteComm,
        cteIns
    );


    //=========================
    // Footer Totals
    //=========================

    const totalComm =
        teComm +
        steComm +
        eteComm +
        cteComm;

    const totalIns =
        teIns +
        steIns +
        eteIns +
        cteIns;

    $("#cteChainCommTotal")
        .text("₹ " + formatNumber(totalComm));

    $("#cteChainInsTotal")
        .text("₹ " + formatNumber(totalIns));

    $("#cteChainCommInsTotal")
        .text("₹ " + formatNumber(totalComm + totalIns));

}
//bm/mf/sf->te/f
function calculatePackagePrice(payoutData) {
    let tcValue = parseFloat($("#travelConsultant").val()) || 0;

    //=========================
    // Percentages
    //=========================

    const teComPer  = parseFloat(payoutData.TE.comm_percentage)  || 0;
    const teInsPer  = parseFloat(payoutData.TE.ins_percentage)   || 0;

    const bmComPer = parseFloat(payoutData.BM.comm_percentage) || 0;
    const bmInsPer = parseFloat(payoutData.BM.ins_percentage)  || 0;

    //=========================
    // TE
    //=========================

    let teComm = truncateToTwoDecimals(tcValue * teComPer / 100);
    let teIns  = truncateToTwoDecimals(tcValue * teInsPer / 100);

    //=========================
    // BM/MF/SF
    //=========================

    let bmComm = truncateToTwoDecimals(teComm * bmComPer / 100);
    let bmIns  = truncateToTwoDecimals(teComm * bmInsPer / 100);

    //=========================
    // Update Table
    //=========================

    updateRole(
        "#bmTeComm",
        "#bmTeIns",
        "#bmTeCommInsTotal",
        teComm,
        teIns
    );

    updateRole(
        "#teBmComm",
        "#teBmIns",
        "#teBmComInsTotal",
        bmComm,
        bmIns
    );

    //=========================
    // Footer Totals
    //=========================

    const totalComm =
        teComm +
        bmComm ;

    const totalIns =
        teIns +
        bmIns ;

    $("#bmTeChainCommTotal")
        .text("₹ " + formatNumber(totalComm));

    $("#bmTeChainInsTotal")
        .text("₹ " + formatNumber(totalIns));

    $("#bmTeChainCommInsTotal")
        .text("₹ " + formatNumber(totalComm + totalIns));
}
//bm/mf/sf->I
function calculatePackagePriceIns(payoutData) {
    let apValue = parseFloat($("#netPriceAdult").val()) || 0;

    //=========================
    // Percentages
    //=========================

    const bmComPer = parseFloat(payoutData.roles.BM.comm_percentage) || 0;
    const bmInsPer = parseFloat(payoutData.roles.BM.ins_percentage)  || 0;

    //=========================
    // I
    //=========================
	let teComm = 0;

	for (const slab of payoutData.slabs) {

		if (
			apValue >= Number(slab.lower_limit) &&
			apValue <= Number(slab.upper_limit)
		) {
			teComm = Number(slab.institution_commission);
			break; // Stop once the matching slab is found
		}

	}

    

    //=========================
    // BM/MF/SF
    //=========================

    let bmComm = truncateToTwoDecimals(teComm * bmComPer / 100);
    let bmIns  = truncateToTwoDecimals(teComm * bmInsPer / 100);

    //=========================
    // Update Table
    //=========================

    updateRole(
        "#bmIComm",
        "#bmIIns",
        "#bmICommInsTotal",
        teComm,
        "NA"
    );

    updateRole(
        "#iBmComm",
        "#iBmIns",
        "#iBmCommInsTotal",
        bmComm,
        bmIns
    );

    //=========================
    // Footer Totals
    //=========================

    const totalComm =
        teComm +
        bmComm ;

    const totalIns =
        bmIns ;

    $("#bmIComTotal")
        .text("₹ " + formatNumber(totalComm));

    $("#bmIInsTotal")
        .text("₹ " + formatNumber(totalIns));

    $("#bmIComInsTotal")
        .text("₹ " + formatNumber(totalComm + totalIns));
}
//CTE->ETE->I
function calculatePackagePriceInsCte(payoutData) {
	
    let apValue = parseFloat($("#netPriceAdult").val()) || 0;

    //=========================
    // Percentages
    //=========================
	// console.log(payoutData);
	
    const cteComPer = parseFloat(payoutData.roles.CTE.comm_percentage) || 0;
    const cteInsPer = parseFloat(payoutData.roles.CTE.ins_percentage)  || 0;
    const eteComPer = parseFloat(payoutData.roles.ETE.comm_percentage) || 0;
    const eteInsPer = parseFloat(payoutData.roles.ETE.ins_percentage)  || 0;

    //=========================
    // I
    //=========================
	let teComm = 0;

	for (const slab of payoutData.slabs) {

		if (
			apValue >= Number(slab.lower_limit) &&
			apValue <= Number(slab.upper_limit)
		) {
			teComm = Number(slab.institution_commission);
			break; // Stop once the matching slab is found
		}

	}

    

    //=========================
    // ETE/CTE
    //=========================

    let eteComm = truncateToTwoDecimals(teComm * eteComPer / 100);
    let eteIns  = truncateToTwoDecimals(teComm * eteInsPer / 100);
    let cteComm = truncateToTwoDecimals(eteComm * cteComPer / 100);
    let cteIns  = truncateToTwoDecimals(eteComm * cteInsPer / 100);

    //=========================
    // Update Table
    //=========================

    updateRole(
        "#cteIComm",
        "#cteIIns",
        "#cteICommInsTotal",
        teComm,
        "NA"
    );
    updateRole(
        "#iCteComm",
        "#iCteIns",
        "#iCteCommInsTotal",
        cteComm,
        cteIns
    );

    updateRole(
        "#iEteComm",
        "#iEteIns",
        "#iEteCommInsTotal",
        eteComm,
        eteIns
    );

    //=========================
    // Footer Totals
    //=========================

    const totalComm =
        teComm +
        eteComm + 
        cteComm ;

    const totalIns =
        eteIns +
        cteIns ;

    $("#iCteComTotal")
        .text("₹ " + formatNumber(totalComm));

    $("#iCteInsTotal")
        .text("₹ " + formatNumber(totalIns));

    $("#iCteComInsTotal")
        .text("₹ " + formatNumber(totalComm + totalIns));
	
}

//reuable table field update 
function updateRole(commId, insId, totalId, comm, ins) {

    comm = (comm === "NA" || comm == null || isNaN(comm)) ? 0 : Number(comm);
    ins  = (ins === "NA" || ins == null || isNaN(ins)) ? 0 : Number(ins);

    updateCell($(commId), comm);
    updateCell($(insId), ins);

    $(totalId).html("₹ " + formatNumber(comm + ins));
}

function updateCell(cell, value) {

    value = parseFloat(value) || 0;

    // If user manually edited this cell,
    // don't overwrite its HTML.
    if (cell.data("edited")) {
        return;
    }

    cell.data("value", value);
    cell.attr("data-value", value);

    cell.html(`₹ ${formatNumber(value)}`);
}
function formatNumber(value) {

    return Number(value).toLocaleString("en-IN", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

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
		var te_mark_up_comm = parseFloat($('#new_mp_ca_comm').val());
		var te_mark_up_ins = parseFloat($('#new_mp_ca_ins').val());
		var cte_mark_up_comm = parseFloat($('#mp_cte_comm').val());
		var cte_mark_up_ins = parseFloat($('#mp_cte_ins').val());
		var ste_mark_up_comm = parseFloat($('#mp_ste_comm').val());
		var ste_mark_up_ins = parseFloat($('#mp_ste_ins').val());
		var ete_mark_up_comm = parseFloat($('#mp_ete_comm').val());
		var ete_mark_up_ins = parseFloat($('#mp_ete_ins').val());
		var newca_mark_up_comm = parseFloat($('#new_mp_ca_comm').val());
		var newca_mark_up_ins = parseFloat($('#new_mp_ca_ins').val());
		var ins_bm_mf_sf_comm = parseFloat($('#ins_bm_mf_sf_comm').val());
		var ins_bm_mf_sf_ins = parseFloat($('#ins_bm_mf_sf_ins').val());
		var ins_mp_company = parseFloat($('#ins_mp_company').val());
		var ins_mp_ca_ta = parseFloat($('#ins_mp_ca_ta').val());
		var ins_mp_customer = parseFloat($('#ins_mp_customer').val());
		var ins_l1_cust_comm = parseFloat($('#ins_l1_cust_comm').val());
		var ins_l2_cust_comm = parseFloat($('#ins_l2_cust_comm').val());
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
		var newta_mark_up = parseFloat($("#new_mp_ca_ta").val());
		var newcompany_share = parseFloat($("#new_mp_company").val());
		var newcustomer_share = parseFloat($("#new_mp_customer").val());
		
		// CA calculation
		var ca_mark_up = ca_mark_up_ins + ca_mark_up_comm;
		// BM calculation
		var bm_mark_up = bm_mark_up_ins + bm_mark_up_comm;
		// BDM calculation
		var bdm_mark_up = bdm_mark_up_ins + bdm_mark_up_comm;
		// BCM calculation
		var bcm_mark_up = bcm_mark_up_ins + bcm_mark_up_comm;

		// New TE calculation
		var te_mark_up = te_mark_up_ins + te_mark_up_comm;
		// ETE calculation
		var ete_mark_up = ete_mark_up_ins + ete_mark_up_comm;
		// STE calculation
		var ste_mark_up = ste_mark_up_ins + ste_mark_up_comm;
		// CTE calculation
		var cte_mark_up = cte_mark_up_ins + cte_mark_up_comm;
		//institution markup
		// BM | MF | SF calculation
		var ins_bm_mf_sf_total = ins_bm_mf_sf_comm + ins_bm_mf_sf_ins;
		//var details_of_day = document.getElementsByName('days[]');
		//addition adult price
		var add_adult_price=$('#add_adult_price').val();
		var L1_customer_share = $('#l1_cust_comm').val();
        var L2_customer_share = $('#l2_cust_comm').val();
		var newL1_customer_share = $('#new_l1_cust_comm').val();
        var newL2_customer_share = $('#new_l2_cust_comm').val();
        var L3_customer_share = $('#l3_cust_comm').val();
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
			coupon_amt:coupon_title,
			newta_mark_up: newta_mark_up,
			te_mark_up: te_mark_up,
			te_mark_up_comm: te_mark_up_comm,
			te_mark_up_ins: te_mark_up_ins,
			ete_mark_up: ete_mark_up,
			ete_mark_up_comm: ete_mark_up_comm,
			ete_mark_up_ins: ete_mark_up_ins,
			ste_mark_up: ste_mark_up,
			ste_mark_up_comm: ste_mark_up_comm,
			ste_mark_up_ins: ste_mark_up_ins,
			cte_mark_up: cte_mark_up,
			cte_mark_up_comm: cte_mark_up_comm,
			cte_mark_up_ins: cte_mark_up_ins,
			newcoupon_amt:newcoupon_title,
			ins_bm_mf_sf_comm:ins_bm_mf_sf_comm,
			ins_bm_mf_sf_ins:ins_bm_mf_sf_ins,
			ins_bm_mf_sf_total:ins_bm_mf_sf_total,
			ins_l1_cust_comm:ins_l1_cust_comm,
			ins_l2_cust_comm:ins_l2_cust_comm,
			ins_mp_ca_ta:ins_mp_ca_ta,
			ins_mp_company:ins_mp_company,
			ins_mp_customer:ins_mp_customer,
			inscoupon_title:inscoupon_title,
			insmark_up_title:insmark_up_title,
			total_package_price_per_adult: total_package_price_per_adult,
			total_package_price_per_child: total_package_price_per_child,
			company_share: company_share,
			customer_share: customer_share,
			newcompany_share: newcompany_share,
			newcustomer_share: newcustomer_share,
			L1_customer_share: L1_customer_share,
			L2_customer_share: L2_customer_share,
			newL1_customer_share: newL1_customer_share,
			newL2_customer_share: newL2_customer_share,
			L3_customer_share: L3_customer_share,
			total_mark_up:mark_up_title,
			newtotal_mark_up:newmark_up_title,
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

		// console.log(formdata);

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
	var te_mark_up_comm = parseFloat($('#new_mp_ca_comm').val());
	var te_mark_up_ins = parseFloat($('#new_mp_ca_ins').val());
	var cte_mark_up_comm = parseFloat($('#mp_cte_comm').val());
	var cte_mark_up_ins = parseFloat($('#mp_cte_ins').val());
	var ste_mark_up_comm = parseFloat($('#mp_ste_comm').val());
	var ste_mark_up_ins = parseFloat($('#mp_ste_ins').val());
	var ete_mark_up_comm = parseFloat($('#mp_ete_comm').val());
	var ete_mark_up_ins = parseFloat($('#mp_ete_ins').val());
	var newca_mark_up_comm = parseFloat($('#new_mp_ca_comm').val());
	var newca_mark_up_ins = parseFloat($('#new_mp_ca_ins').val());
	var ins_bm_mf_sf_comm = parseFloat($('#ins_bm_mf_sf_comm').val());
	var ins_bm_mf_sf_ins = parseFloat($('#ins_bm_mf_sf_ins').val());
	var ins_mp_company = parseFloat($('#ins_mp_company').val());
	var ins_mp_ca_ta = parseFloat($('#ins_mp_ca_ta').val());
	var ins_mp_customer = parseFloat($('#ins_mp_customer').val());
	var ins_l1_cust_comm = parseFloat($('#ins_l1_cust_comm').val());
	var ins_l2_cust_comm = parseFloat($('#ins_l2_cust_comm').val());
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
	var newta_mark_up = parseFloat($("#new_mp_ca_ta").val());
	var newcompany_share = parseFloat($("#new_mp_company").val());
	var newcustomer_share = parseFloat($("#new_mp_customer").val());
	// CA calculation
	var ca_mark_up = ca_mark_up_ins + ca_mark_up_comm;
	// BM calculation
	var bm_mark_up = bm_mark_up_ins + bm_mark_up_comm;
	// BDM calculation
	var bdm_mark_up = bdm_mark_up_ins + bdm_mark_up_comm;
	// BCM calculation
	var bcm_mark_up = bcm_mark_up_ins + bcm_mark_up_comm;

	// New TE calculation
	var te_mark_up = te_mark_up_ins + te_mark_up_comm;
	// ETE calculation
	var ete_mark_up = ete_mark_up_ins + ete_mark_up_comm;
	// STE calculation
	var ste_mark_up = ste_mark_up_ins + ste_mark_up_comm;
	// CTE calculation
	var cte_mark_up = cte_mark_up_ins + cte_mark_up_comm;

	//institution markup
	// BM | MF | SF calculation
	var ins_bm_mf_sf_total = ins_bm_mf_sf_comm + ins_bm_mf_sf_ins;
	//var details_of_day = document.getElementsByName('days[]');
	//addition adult price
	var add_adult_price=$('#add_adult_price').val();
	var L1_customer_share = $('#l1_cust_comm').val();
    var L2_customer_share = $('#l2_cust_comm').val();
	var newL1_customer_share = $('#new_l1_cust_comm').val();
	var newL2_customer_share = $('#new_l2_cust_comm').val();
    var L3_customer_share = $('#l3_cust_comm').val();
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
		coupon_amt:coupon_title,
		newta_mark_up: newta_mark_up,
		te_mark_up: te_mark_up,
		te_mark_up_comm: te_mark_up_comm,
		te_mark_up_ins: te_mark_up_ins,
		ete_mark_up: ete_mark_up,
		ete_mark_up_comm: ete_mark_up_comm,
		ete_mark_up_ins: ete_mark_up_ins,
		ste_mark_up: ste_mark_up,
		ste_mark_up_comm: ste_mark_up_comm,
		ste_mark_up_ins: ste_mark_up_ins,
		cte_mark_up: cte_mark_up,
		cte_mark_up_comm: cte_mark_up_comm,
		cte_mark_up_ins: cte_mark_up_ins,
		newcoupon_amt:newcoupon_title,
		ins_bm_mf_sf_comm:ins_bm_mf_sf_comm,
		ins_bm_mf_sf_ins:ins_bm_mf_sf_ins,
		ins_bm_mf_sf_total:ins_bm_mf_sf_total,
		ins_l1_cust_comm:ins_l1_cust_comm,
		ins_l2_cust_comm:ins_l2_cust_comm,
		ins_mp_ca_ta:ins_mp_ca_ta,
		ins_mp_company:ins_mp_company,
		ins_mp_customer:ins_mp_customer,
		inscoupon_title:inscoupon_title,
		insmark_up_title:insmark_up_title,
		total_package_price_per_adult: total_package_price_per_adult,
		total_package_price_per_child: total_package_price_per_child,
		company_share: company_share,
		customer_share: customer_share,
		newcompany_share: newcompany_share,
		newcustomer_share: newcustomer_share,
		L1_customer_share: L1_customer_share,
		L2_customer_share: L2_customer_share,
		newL1_customer_share: newL1_customer_share,
		newL2_customer_share: newL2_customer_share,
		L3_customer_share: L3_customer_share,
		total_mark_up:mark_up_title,
		newtotal_mark_up:newmark_up_title,
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