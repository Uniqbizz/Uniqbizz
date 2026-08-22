//for current and future dates only
document.getElementById("pacValidity").min = new Date().toISOString().split("T")[0];
//to accept only alpha numerics 
function allowedCharset(inputId) {
    const input = document.getElementById(inputId);

    if (!input) return;

    input.addEventListener("keypress", function (e) {
        const char = String.fromCharCode(e.which || e.keyCode);
		//only alphabets and spaces
        // if (!/^[a-zA-Z\s]$/.test(char)) {
        //     e.preventDefault();
        // }
		//only alphabets, numbers and spaces
		// if (!/^[a-zA-Z0-9\s]$/.test(char)) {
		// 	e.preventDefault();
		// }

		// Only alphabets, numbers, spaces, hyphen (-) and underscore (_)
		// if (!/^[a-zA-Z0-9\s_-]$/.test(char)) {
		// 	e.preventDefault();
		// }
		// Allow letters, numbers, spaces ,common sentence punctuation and new line
		if (!/^[a-zA-Z0-9\s.,'"():;\/&+\-_@#!%?\r\n]$/.test(char)) {
			e.preventDefault();
		}
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

let gst = 0;

$.ajax({
    url: "forms/gst_percentage.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
        gst = parseFloat(response.gst) || 0;
        // console.log(gst);
    },
    error: function (xhr, status, error) {
        console.error(error);
    }
});
// fetch sub category

function getSubCategories(selected = '') {

    document.getElementById("subCategoryId").style.display = "block";
    document.getElementById("subCategoryData").style.display = "none";

    var cat_id = $('#categoryId').val();

    $.ajax({
        type: 'POST',
        url: 'forms/get_sub_categories.php',
        data: {
            cat_id: cat_id,
            selected: selected
        },
        success: function (e) {
            $('#subCategoryId').html(e);
        },
        error: function (err) {
            console.log(err);
        }
    });
}


const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
        console.log("Changed:", mutation.target.textContent);
        
        // Your logic here
    });
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
		//icon section removed on 29-07-2026 by SV
		// <div class="col-md-2 col-sm-2 col-12 mb-2">
		// 					<div class="upload-card icon-upload-card" data-title="Icons" data-index="${dayCount}">
		// 						<input type="hidden" id="img_path${dayCount}" value="">
    	// 						<input type="hidden" id="img_base64${dayCount}" value="">
								
		// 						<input type="file" class="file-input" accept="image/*,.pdf" id="upload_file${dayCount}">
		// 						<div class="upload-content">
		// 							<div class="upload-icon">
		// 								<i class="fa-solid fa-user"></i>
		// 							</div>
		// 							<h6>Add Icons</h6>
		// 							<p>Click to upload<br>or drag and drop</p>
		// 							<small>(JPG, PNG, PDF)</small>
		// 						</div>
		// 					</div>
 		// 				</div>
		if (x < max_fields) {
			x++;
			$(wrapper).append(`<div class="row day-container">
						
						<div class="col-md-12 col-sm-12 col-12">
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
$(document).on('input change', '.title, .description, .meals, .transport', function() {
    $(this).removeClass('border-danger');
    $(this).closest('.input-group').next('.error-message').remove();
});

// Clear errors when adding/removing days
$(document).on('click', '.add_field_button, .remove_field', function() {
    $('.error-message').remove();
    $('.border-danger').removeClass('border-danger');
    $("#days_error").text("");
});
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
	let mrpPerAdultGst = adultMaxTotal + (adultMaxTotal * (gst / 100));
	let mrpPerChildGst = childMaxTotal + (childMaxTotal * (gst / 100));

    // Set MRP
    $("#mrpPerAdult").val(truncateToTwoDecimals(adultMaxTotal));
    $("#mrpPerChild").val(truncateToTwoDecimals(childMaxTotal));

    // Set MRP with GST
    $("#mrpPerAdultWithGst").val(truncateToTwoDecimals(mrpPerAdultGst));
    $("#mrpPerChildWithGst").val(truncateToTwoDecimals(mrpPerChildGst));

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
//show section
function showSection(target) {

	// Hide all sections
	sections.forEach(function (section) {
		$(section).hide();
	});

	// Show selected section
	$(target).show();

	// Update active step
	$(".step-link").removeClass("active");
	$(".roundedCircle").removeClass("active");

	$('.step-link[href="' + target + '"]').addClass("active");
	$('.step-link[href="' + target + '"] .roundedCircle').addClass("active");

	// Update page title
	$("#pageTitle").text(pageData[target].title);

	// Update return text
	$("#pageSubTitle").text(pageData[target].backText);

	// Update back button target
	$("#dynamicBackBtn").attr("data-target", pageData[target].backLink);
}
//validation common functions
function showFileError(fileId, message) {

    const input = $("#" + fileId);

    input.closest(".upload-card").addClass("error");

    $("#" + fileId + "_error").text(message);

    input.trigger("click"); // Opens file selector
}
function clearFileError(fileId) {

    $("#" + fileId)
        .closest(".upload-card")
        .removeClass("error");
}
function validateDayFields() {
    let isValid = true;
    let errorMessages = [];
    let firstErrorDay = null;
    
    // Clear previous error styles
    $('.field-error-indicator').remove();
    $('.border-danger').removeClass('border-danger');
    $('.input-group-text-danger').removeClass('input-group-text-danger');
    
    $(".day-container").each(function(index) {
        const dayNumber = index + 1;
        const title = $(this).find(".title").val().trim();
        const description = $(this).find(".description").val().trim();
        const meals = $(this).find(".meals").val().trim();
        const transport = $(this).find(".transport").eq(0).val().trim();
        const stay = $(this).find(".transport").eq(1).val().trim();
        // Check if icon is uploaded
        // const fileInput = $(this).find('.file-input');
        // const iconUploaded = fileInput.val() !== '';
        // const hiddenIconPath = $(this).find('#img_path'+index).val();
        // const hasIcon = iconUploaded || (hiddenIconPath && hiddenIconPath !== '');
        let dayHasError = false;
        
        // Validate Title
        if (!title) {
            $(this).find(".title").addClass('border-danger');
            // Add error message after the input group
            const titleInputGroup = $(this).find(".title").closest('.input-group');
            if (!titleInputGroup.next('.error-message').length) {
                titleInputGroup.after(`<div class="error-message text-danger small mt-1">Title is required</div>`);
            }
            dayHasError = true;
        }
        
        // Validate Description
        if (!description) {
            $(this).find(".description").addClass('border-danger');
            const descInputGroup = $(this).find(".description").closest('.input-group');
            if (!descInputGroup.next('.error-message').length) {
                descInputGroup.after(`<div class="error-message text-danger small mt-1">Description is required</div>`);
            }
            dayHasError = true;
        }
        
        // Validate Meals
        if (!meals) {
            $(this).find(".meals").addClass('border-danger');
            const mealsInputGroup = $(this).find(".meals").closest('.input-group');
            if (!mealsInputGroup.next('.error-message').length) {
                mealsInputGroup.after(`<div class="error-message text-danger small mt-1">Meals are required</div>`);
            }
            dayHasError = true;
        }
        
        // Validate Transport
        if (!transport) {
            $(this).find(".transport").eq(0).addClass('border-danger');
            const transportInputGroup = $(this).find(".transport").eq(0).closest('.input-group');
            if (!transportInputGroup.next('.error-message').length) {
                transportInputGroup.after(`<div class="error-message text-danger small mt-1">Transport is required</div>`);
            }
            dayHasError = true;
        }
        
        // Validate Stay
        if (!stay) {
            $(this).find(".transport").eq(1).addClass('border-danger');
            const stayInputGroup = $(this).find(".transport").eq(1).closest('.input-group');
            if (!stayInputGroup.next('.error-message').length) {
                stayInputGroup.after(`<div class="error-message text-danger small mt-1">Stay is required</div>`);
            }
            dayHasError = true;
        }
		 // Validate Icon
        // if (!hasIcon) {
		// 	const uploadCard = $(this).find('.upload-card');
		// 	uploadCard.addClass('border-danger upload-card-error');
			
		// 	// Add error message below the upload card
		// 	const uploadContent = uploadCard.find('.upload-content');
		// 	if (!uploadCard.find('.icon-error-message').length) {
		// 		uploadCard.append(`<div class="icon-error-message text-danger small mt-1 px-2">Icon is required</div>`);
		// 	}
		//     dayHasError = true;
        // }
        
        if (dayHasError) {
            isValid = false;
            if (!firstErrorDay) {
                firstErrorDay = dayNumber;
            }
            errorMessages.push(`Day ${dayNumber}: All fields are required`);
        }
    });
    
    return { isValid, errorMessages, firstErrorDay };
}
function showError(fieldId, message) {

    $("#" + fieldId)
        .addClass("is-invalid")
        .focus();

    $("#" + fieldId + "_error").text(message);
}

function clearError(fieldId) {

    $("#" + fieldId)
        .removeClass("is-invalid");

    $("#" + fieldId + "_error").text("");
}

function clearAllErrors() {

    $(".form-control, .form-select").removeClass("is-invalid");
    $(".error-message").text("");
}
function showTravelThemeError(message){

    $("#travelTheme_wrapper")
        .addClass("error")
        .attr("tabindex","-1")
        .focus();

    $("#travelTheme_error").text(message);
}

function clearTravelThemeError(){

    $("#travelTheme_wrapper").removeClass("error");

    $("#travelTheme_error").text("");
}

$(".travelTheme").on("change",function(){

    clearTravelThemeError();

});
//cities
function showHighlightContainerError(message){

    $("#highlightContainer_wrapper")
        .addClass("error")
        .attr("tabindex","-1")
        .focus();

    $("#highlightContainer_error").text(message);
}

function clearHighlightContainerError(){

    $("#highlightContainer_wrapper").removeClass("error");

    $("#highlightContainer_error").text("");
}
function showCouponRuleError(message) {

    $("#couponRule_wrapper")
        .addClass("error")
        .attr("tabindex", "-1")
        .focus();

    $("#couponRule_error").text(message);
}
function clearCouponRuleError() {
    $("#couponRule_wrapper").removeClass("error");
    $("#couponRule_error").text("");
}
function showOtherPolicyError(message) {

    $("#otherPolicy_wrapper")
        .addClass("error")
        .attr("tabindex", "-1")
        .focus();

    $("#otherPolicy_error").text(message);
}

function clearOtherPolicyError() {

    $("#otherPolicy_wrapper").removeClass("error");
    $("#otherPolicy_error").text("");

}
$(".highlight-tag").on("change",function(){

    clearHighlightContainerError();

});
//package type
function showPackageTypeError(message){

    $("#packageType_wrapper")
        .addClass("error")
        .attr("tabindex","-1")
        .focus();

    $("#packageType_error").text(message);
}

function clearPackageTypeError(){

    $("#packageType_wrapper").removeClass("error");

    $("#packageType_error").text("");
}

$(".packageType").on("change",function(){

    clearPackageTypeError();

});
//visa type
function showVisaTypeError(message) {

    $("#visaType_wrapper")
        .addClass("error")
        .attr("tabindex", "-1")
        .focus();

    $("#visaType_error").text(message);
}


function clearVisaTypeError() {

    $("#visaType_wrapper").removeClass("error");

    $("#visaType_error").text("");
}


function validateVisaType() {

    const selectedVisa =
        $('input[name="visaType"]:checked').val();


    // Nothing selected
    if (selectedVisa === undefined) {

        showVisaTypeError(
            "Please select Yes or No."
        );

        return false;
    }


    // Valid selection
    clearVisaTypeError();

    return true;
}


$(".visaType").on("change", function () {

    clearVisaTypeError();

});
//package keywords
function showPackageKeyWordsError(message){

    $("#packageKeyWords_wrapper")
        .addClass("error")
        .attr("tabindex","-1")
        .focus();

    $("#packageKeyWords_error").text(message);
}

function clearPackageKeyWordsError(){

    $("#packageKeyWords_wrapper").removeClass("error");

    $("#packageKeyWords_error").text("");
}
// Error handling functions for lists
function showListError(listId, message) {
    // Remove any existing error message
    $(`#${listId} .list-error`).remove();
    
    // Add error message after the list
    $(`#${listId}`).after(`<div class="list-error text-danger mt-1">${message}</div>`);
    
    // Add error class to the list container
    $(`#${listId}`).addClass('border border-danger');
}

function clearListError(listId) {
    // Remove error message
    $(`#${listId} .list-error`).remove();
    
    // Remove error class
    $(`#${listId}`).removeClass('border border-danger');
}
$(".packageKeyWords").on("change",function(){

    clearPackageKeyWordsError();

});
//------------------------------------


const sections = [
	"#package_form_general",
	"#package_form_extra",
	"#package_form_itinerary",
	"#package_form_pricing",
	"#package_form_policy",
	"#package_form_picture"
];

const isEdit = $("#editFlag").length && $("#editFlag").val() == "1";
const actionText = isEdit ? "Edit Package" : "Add New Package";

const pageData = {
	"#package_form_general": {
		title: `${actionText} - General Information`,
		backText: "Return to Package Listing",
		backLink: "all_packages.php"
	},
	"#package_form_extra": {
		title: `${actionText} - Extra Information`,
		backText: "Return to General Information",
		backLink: "#package_form_general"
	},
	"#package_form_itinerary": {
		title: `${actionText} - Itinerary & Inclusions`,
		backText: "Return to Extra Information",
		backLink: "#package_form_extra"
	},
	"#package_form_pricing": {
		title: `${actionText} - Pricing`,
		backText: "Return to Itinerary & Inclusions",
		backLink: "#package_form_itinerary"
	},
	"#package_form_policy": {
		title: `${actionText} - Policy`,
		backText: "Return to Pricing",
		backLink: "#package_form_pricing"
	},
	"#package_form_picture": {
		title: `${actionText} - Pictures & Media`,
		backText: "Return to Policy",
		backLink: "#package_form_policy"
	}
};

// function showSection(target) {

// 	// Hide all sections
// 	sections.forEach(function (section) {
// 		$(section).hide();
// 	});

// 	// Show selected section
// 	$(target).show();

// 	// Update active step
// 	$(".step-link").removeClass("active");
// 	$(".roundedCircle").removeClass("active");

// 	$('.step-link[href="' + target + '"]').addClass("active");
// 	$('.step-link[href="' + target + '"] .roundedCircle').addClass("active");

// 	// Update page title
// 	$("#pageTitle").text(pageData[target].title);

// 	// Update return text
// 	$("#pageSubTitle").text(pageData[target].backText);

// 	// Update back button target
// 	$("#dynamicBackBtn").attr("data-target", pageData[target].backLink);
// }

// Initial load
showSection("#package_form_general");

// Stepper navigation click
$(".step-link").on("click", function (e) {

    e.preventDefault();

    const target = $(this).attr("href");

    if (!validateAndCollectAll()) {
        return false;
    }

    showSection(target);

});

// Back button click
$("#dynamicBackBtn").on("click", function (e) {

    e.preventDefault();

    const target = $(this).attr("data-target");

    if (target === "all_packages.php") {
        window.location.href = target;
        return;
    }

    showSection(target);

});

let payLoadData={};
function validateAndCollectAll() {

    if (!validateGeneralInfo()) {
        showSection("#package_form_general");
        return false;
    }
    collectGeneralInfo();

    if (!validateExtraInfo()) {
        showSection("#package_form_extra");
        return false;
    }
    collectExtraInfo();

    if (!validateItinerary()) {
        showSection("#package_form_itinerary");
        return false;
    }
    collectItinerary();

    if (!validatePricing()) {
        showSection("#package_form_pricing");
        return false;
    }
    collectPricing();

    if (!validatePolicy()) {
        showSection("#package_form_policy");
        return false;
    }
    collectPolicy();

    if (!validateMedia()) {
        showSection("#package_form_picture");
        return false;
    }
    collectMedia();

    return true;
}
function collectGeneralInfo() {

    payLoadData.general_info = {

        packName: $('#packName').val().trim(),
        uniqueCode: $('#uniqueCode').val().trim(),
        categoryId: $('#categoryId').val(),
        subCategoryId: $('#subCategoryId').val(),
        travelTheme: $('input[name="travelTheme"]:checked').val(),
        tourDays: $('#tourDays').val(),
        pacValidity: $('#pacValidity').val(),
        season: $('#season').val(),
        pacLocation: $('#pacLocation').val(),
        cities: [...new Set(
            [...document.querySelectorAll(".highlight-tag")]
                .map(tag => tag.dataset.city?.trim())
                .filter(Boolean)
        )],

        description: $('#description').val(),
        descriptionDetail: $('#descriptionDetail').val(),

        packageType: $('input[name="packageType"]:checked').val(),

        visaType : $('#visaYes').is(':checked') ? 1 : 0,

        dropPriceCheck: $('#dropPriceCheck').is(":checked") ? 1 : 0,

        dropPrice: $('#dropPrice').val()

    };
    // console.log(payLoadData.general_info);
    

}
function validateGeneralInfo() {

    return new Promise((resolve) => {

        clearAllErrors();
        clearTravelThemeError();
        clearHighlightContainerError();
        clearPackageTypeError();
        clearVisaTypeError();

        let packName = $('#packName').val().trim();
        let uniqueCode = $('#uniqueCode').val().trim();
        let categoryId = $('#categoryId').val();
        let subCategoryId = $('#subCategoryId').val();
        let travelTheme = $('input[name="travelTheme"]:checked').val();
        let tourDays = $('#tourDays').val();
        let pacValidity = $('#pacValidity').val();
        let pacLocation = $('#pacLocation').val();
        let cities = [...document.querySelectorAll(".highlight-tag")]
            .map(tag => tag.dataset.city);
        let description = $('#description').val().trim();
        let descriptionDetail = $('#descriptionDetail').val().trim();
        let packageType = $('input[name="packageType"]:checked').val();
        let visaSelected = $('input[name="visaType"]:checked').val();

        let visaType = visaSelected === "visaYes" ? 1 : 0;
        let dropPrice = $('#dropPrice').val();

        const isEdit = $("#editFlag").length &&
                       $("#editFlag").val() == "1";

        // Package Name
        if (packName === "") {
            showError("packName", "Please enter Package Name.");
            return resolve(false);
        }

        // Unique Code
        if (uniqueCode === "") {
            showError("uniqueCode", "Please enter Unique Code.");
            return resolve(false);
        }

        function continueValidation() {

            if (!categoryId) {
                showError("categoryId", "Please select Category.");
                return false;
            }

            if (!subCategoryId) {
                showError("subCategoryId", "Please select Sub Category.");
                return false;
            }

            if (!travelTheme) {
                showTravelThemeError("Please select a Travel Theme.");
                return false;
            }

            if (tourDays === "") {
                showError("tourDays", "Please enter Tour Days.");
                return false;
            }

            if (pacValidity === "") {
                showError("pacValidity", "Please select Package Validity.");
                return false;
            }

            if (pacLocation === "") {
                showError("pacLocation", "Please enter Package Location.");
                return false;
            }

            if (cities.length === 0) {
                showHighlightContainerError("Please add at least one City.");
                return false;
            }

            if (description === "") {
                showError("description", "Please enter Short Description.");
                return false;
            }

            if (descriptionDetail === "") {
                showError("descriptionDetail", "Please enter Detailed Description.");
                return false;
            }

            if (!packageType) {
                showPackageTypeError("Please select Package Type.");
                return false;
            }

            if (!visaSelected) {
                showVisaTypeError("Please select Visa Type.");
                return false;
            }

            if (dropPrice === "") {
                showError("dropPrice", "Please select a Drop Price.");
                return false;
            }

            return true;
        }

        // Edit mode - skip unique code check
        if (isEdit) {
            return resolve(continueValidation());
        }

        // Add mode - verify unique code
        $.ajax({
            url: "forms/unique_code_vefication.php",
            type: "POST",
            data: {
                uniqueCode: uniqueCode
            },
            dataType: "json",
            success: function (res) {

                if (res.exists) {
                    showError("uniqueCode", "Unique Code already exists.");
                    return resolve(false);
                }

                resolve(continueValidation());

            },
            error: function () {

                Swal.fire(
                    "Error",
                    "Unable to verify Unique Code.",
                    "error"
                );

                resolve(false);

            }

        });

    });

}
function collectExtraInfo() {

    payLoadData.extra_info = {

		destination:$('#destination').val().trim(),
    	travelFrom:$('#travelFrom').val().trim(),
    	travelTo:$('#travelTo').val().trim(),
    	sightseeingType:$('#sightseeingType').val().trim(),
    	categoryHotelId:$('#categoryHotelId').val(),
    	occupancyId:$('#occupancyId').val(),
    	categoryMealId:$('#categoryMealId').val(),
    	vehicleId:$('#vehicleId').val(),
    	languageType:$('#languageType').val().trim(),
    	packageKeywords:[...document.querySelectorAll(".package-tag")]
        .map(tag => tag.dataset.packageKey),

    };

}
function validateExtraInfo() {

    clearAllErrors();
    clearPackageKeyWordsError();

    let destination = $('#destination').val().trim();
    let travelFrom = $('#travelFrom').val().trim();
    let travelTo = $('#travelTo').val().trim();
    let sightseeingType = $('#sightseeingType').val().trim();
    let categoryHotelId = $('#categoryHotelId').val();
    let occupancyId = $('#occupancyId').val();
    let categoryMealId = $('#categoryMealId').val();
    let vehicleId = $('#vehicleId').val();
    let languageType = $('#languageType').val().trim();

    let packageKeywords = [...document.querySelectorAll(".package-tag")]
        .map(tag => tag.dataset.packageKey);

    // Destination
    if (destination === "") {
        showError("destination", "Please enter Destination.");
        return false;
    }

    // Pick Up Point
    if (travelFrom === "") {
        showError("travelFrom", "Please enter Pick Up Point.");
        return false;
    }

    // Drop Point
    if (travelTo === "") {
        showError("travelTo", "Please enter Drop Point.");
        return false;
    }

    // Sightseeing Type
    if (sightseeingType === "") {
        showError("sightseeingType", "Please enter Sightseeing Type.");
        return false;
    }

    // Hotel Category
    if (categoryHotelId === "" || categoryHotelId == 0) {
        showError("categoryHotelId", "Please select Hotel Category.");
        return false;
    }

    // Occupancy
    if (occupancyId === "" || occupancyId == 0) {
        showError("occupancyId", "Please select Occupancy Category.");
        return false;
    }

    // Meal Category
    if (categoryMealId === "" || categoryMealId == 0) {
        showError("categoryMealId", "Please select Meal Category.");
        return false;
    }

    // Vehicle Category
    if (vehicleId === "" || vehicleId == 0) {
        showError("vehicleId", "Please select Vehicle Category.");
        return false;
    }

    // Language
    if (languageType === "") {
        showError("languageType", "Please enter Language Type.");
        return false;
    }

    // Package Keywords
    if (packageKeywords.length === 0) {
        showPackageKeyWordsError("Please add at least one Package Keyword.");
        return false;
    }

    return true;

}
function collectItinerary() {

    // Day Details
    const dayData = [];

    $(".day-container").each(function () {

        const dayObj = {

            day: $(this).find(".dayval").text().trim(),
            title: $(this).find(".title").val().trim(),
            description: $(this).find(".description").val().trim(),
            meals: $(this).find(".meals").val().trim(),
            transport: $(this).find(".transport").eq(0).val().trim(),
            stay: $(this).find(".transport").eq(1).val().trim()

        };

        dayData.push(dayObj);

    });

    payLoadData.itinerary = {

        highlights: $("#hightlightList .remark-text").map(function () {
            return $(this).text().trim();
        }).get(),

        inclusions: $("#inclusionList .inclusion-text").map(function () {
            return $(this).text().trim();
        }).get(),

        exclusions: $("#exclusionList .exclusion-text").map(function () {
            return $(this).text().trim();
        }).get(),

        remarks: $("#remarkList .remark-text").map(function () {
            return $(this).text().trim();
        }).get(),

        thingsToKnow: $("#thingsList .things-text").map(function () {
            return $(this).text().trim();
        }).get(),

        days: dayData

    };

}
function validateItinerary() {

    clearListError("hightlightList");
    clearListError("inclusionList");
    clearListError("exclusionList");
    clearListError("remarkList");
    clearListError("thingsList");

    // Put all your current validation code here

    return true;

}
function collectPricing() {

    let customer1 = $("#customer1").val().trim();
    let customer2 = $("#customer2").val().trim();
    let customer3 = $("#customer3").val().trim();

    let mrpPerAdult = $("#mrpPerAdult").val().trim();
    let mrpPerChild = $("#mrpPerChild").val().trim();

    payLoadData.pricing = {

        netPriceAdult: $("#netPriceAdult").val().trim(),
        netPriceChild: $("#netPriceChild").val().trim(),
        extraMatress: $("#extraMatress").val().trim(),
        companyMarkup: $("#companyMarkup").val().trim(),
        couponAdjustment: $("#couponAdjustment").val().trim(),

        guestUser: $("#switchCheckGuestUser").is(":checked") ? 1 : 0,

        guestPricingType:
            $("#radioDefault1").is(":checked") ? "fixed" :
            $("#radioDefault2").is(":checked") ? "percentage" : "",

        guestAmount: $("#guestAmount").prop("disabled")
            ? ""
            : $("#guestAmount").val().trim(),

        guestPercentage: $("#guestPercentage").prop("disabled")
            ? ""
            : $("#guestPercentage").val().trim(),

        travelConsultant: $("#travelConsultant").val().trim(),

        cteComm: $("#cteComm").text().replace(/₹/g, "").trim(),
        cteIns: $("#cteIns").text().replace(/₹/g, "").trim(),
        cteCommInsTotal: $("#cteCommInsTotal").text().replace(/₹/g, "").trim(),

        eteComm: $("#eteComm").text().replace(/₹/g, "").trim(),
        eteIns: $("#eteIns").text().replace(/₹/g, "").trim(),
        eteCommInsTotal: $("#eteCommInsTotal").text().replace(/₹/g, "").trim(),

        steComm: $("#steComm").text().replace(/₹/g, "").trim(),
        steIns: $("#steIns").text().replace(/₹/g, "").trim(),
        steCommInsTotal: $("#steCommInsTotal").text().replace(/₹/g, "").trim(),

        cTeFComm: $("#cTeFComm").text().replace(/₹/g, "").trim(),
        cTeFIns: $("#cTeFIns").text().replace(/₹/g, "").trim(),
        cTeFCommInsTotal: $("#cTeFCommInsTotal").text().replace(/₹/g, "").trim(),

        cteChainCommTotal: $("#cteChainCommTotal").text().replace(/₹/g, "").trim(),
        cteChainInsTotal: $("#cteChainInsTotal").text().replace(/₹/g, "").trim(),
        cteChainCommInsTotal: $("#cteChainCommInsTotal").text().replace(/₹/g, "").trim(),
        cteSuspence: $("#cteSuspence").val().trim(),

        teBmComm: $("#teBmComm").text().replace(/₹/g, "").trim(),
        teBmIns: $("#teBmIns").text().replace(/₹/g, "").trim(),
        teBmComInsTotal: $("#teBmComInsTotal").text().replace(/₹/g, "").trim(),

        bmTeComm: $("#bmTeComm").text().replace(/₹/g, "").trim(),
        bmTeIns: $("#bmTeIns").text().replace(/₹/g, "").trim(),
        bmTeCommInsTotal: $("#bmTeCommInsTotal").text().replace(/₹/g, "").trim(),

        bmTeChainCommTotal: $("#bmTeChainCommTotal").text().replace(/₹/g, "").trim(),
        bmTeChainInsTotal: $("#bmTeChainInsTotal").text().replace(/₹/g, "").trim(),
        bmTeChainCommInsTotal: $("#bmTeChainCommInsTotal").text().replace(/₹/g, "").trim(),
        bmSuspence: $("#bmSuspence").val().trim(),

        iBmComm: $("#iBmComm").text().replace(/₹/g, "").trim(),
        iBmIns: $("#iBmIns").text().replace(/₹/g, "").trim(),
        iBmCommInsTotal: $("#iBmCommInsTotal").text().replace(/₹/g, "").trim(),

        bmIComm: $("#bmIComm").text().replace(/₹/g, "").trim(),
        bmICommInsTotal: $("#bmICommInsTotal").text().replace(/₹/g, "").trim(),
        bmIComTotal: $("#bmIComTotal").text().replace(/₹/g, "").trim(),
        bmIInsTotal: $("#bmIInsTotal").text().replace(/₹/g, "").trim(),
        bmIComInsTotal: $("#bmIComInsTotal").text().replace(/₹/g, "").trim(),
        bmISuspence: $("#bmISuspence").val().trim(),

        iCteComm: $("#iCteComm").text().replace(/₹/g, "").trim(),
        iCteIns: $("#iCteIns").text().replace(/₹/g, "").trim(),
        iCteCommInsTotal: $("#iCteCommInsTotal").text().replace(/₹/g, "").trim(),

        iEteComm: $("#iEteComm").text().replace(/₹/g, "").trim(),
        iEteIns: $("#iEteIns").text().replace(/₹/g, "").trim(),
        iEteCommInsTotal: $("#iEteCommInsTotal").text().replace(/₹/g, "").trim(),

        cteIComm: $("#cteIComm").text().replace(/₹/g, "").trim(),
        cteICommInsTotal: $("#cteICommInsTotal").text().replace(/₹/g, "").trim(),

        iCteComTotal: $("#iCteComTotal").text().replace(/₹/g, "").trim(),
        iCteInsTotal: $("#iCteInsTotal").text().replace(/₹/g, "").trim(),
        iCteComInsTotal: $("#iCteComInsTotal").text().replace(/₹/g, "").trim(),
        cteISuspence: $("#cteISuspence").val().trim(),

        customer1,
        customer2,
        customer3,

        totalCustomerShare:
            Number(customer1) +
            Number(customer2) +
            Number(customer3),

        mrpPerAdult,
        mrpPerChild,

        mrpPerAdultGst:
            Number(mrpPerAdult) +
            (Number(mrpPerAdult) * gst / 100),

        mrpPerChildGst:
            Number(mrpPerChild) +
            (Number(mrpPerChild) * gst / 100),

        cancellationPercentage1: $("#cancellationPercentage1").val().trim(),
        cancellationPercentage2: $("#cancellationPercentage2").val().trim(),
        cancellationPercentage3: $("#cancellationPercentage3").val().trim(),
        cancellationPercentage4: $("#cancellationPercentage4").val().trim(),
        cancellationPercentage5: $("#cancellationPercentage5").val().trim()

    };

}
function validatePricing() {

    clearAllErrors();

    let netPriceAdult = $('#netPriceAdult').val().trim();
    let netPriceChild = $('#netPriceChild').val().trim();
    let extraMatress = $('#extraMatress').val().trim();
    let companyMarkup = $('#companyMarkup').val().trim();
    let couponAdjustment = $('#couponAdjustment').val().trim();

    let guestAmount = $("#guestAmount").prop("disabled")
        ? ""
        : $("#guestAmount").val().trim();

    let guestPercentage = $("#guestPercentage").prop("disabled")
        ? ""
        : $("#guestPercentage").val().trim();

    let travelConsultant = $("#travelConsultant").val().trim();

    // Base Price Adult
    if (netPriceAdult === "") {
        showError("netPriceAdult", "Please enter Base Price for per Adult.");
        return false;
    }

    // Base Price Child
    if (netPriceChild === "") {
        showError("netPriceChild", "Please enter Base Price for per Child.");
        return false;
    }

    // Extra Mattress
    if (extraMatress === "") {
        showError("extraMatress", "Please enter Extra Mattress.");
        return false;
    }

    // Company Markup
    if (companyMarkup === "") {
        showError("companyMarkup", "Please enter Company Markup.");
        return false;
    }

    // Coupon Adjustment
    if (couponAdjustment === "") {
        showError("couponAdjustment", "Please enter Default Coupon Adjustment.");
        return false;
    }

    // Guest User Validation
    if ($("#switchCheckGuestUser").is(":checked")) {

        if (
            !$("#radioDefault1").is(":checked") &&
            !$("#radioDefault2").is(":checked")
        ) {
            showError("guestAmount", "Please select either Fixed Amount or Percentage.");
            return false;
        }

        if ($("#radioDefault1").is(":checked")) {

            if (guestAmount === "") {
                showError("guestAmount", "Please enter Fixed Amount.");
                return false;
            }

        }

        if ($("#radioDefault2").is(":checked")) {

            if (guestPercentage === "") {
                showError("guestPercentage", "Please enter Percentage.");
                return false;
            }

            if (
                isNaN(guestPercentage) ||
                Number(guestPercentage) < 0 ||
                Number(guestPercentage) > 100
            ) {
                showError("guestPercentage", "Percentage must be between 0 and 100.");
                return false;
            }

        }
    }

    // Travel Consultant
    if (travelConsultant === "") {
        showError("travelConsultant", "Please enter Travel Consultant.");
        return false;
    }

    // Cancellation Percentage
    for (let i = 1; i <= 5; i++) {

        let value = $(`#cancellationPercentage${i}`).val().trim();

        if (value === "") {
            showError(
                `cancellationPercentage${i}`,
                "Please enter Cancellation Percentage."
            );
            return false;
        }

    }

    return true;

}
function collectPolicy() {
    console.log(window.attachments);
    let switchCoupon = $('#switchCoupon').is(':checked') ? 1 : 0;
    let switchCombine = $('#switchCombine').is(':checked') ? 1 : 0;
    let bookingPercentage = $('#bookingPercentage').val().trim();
    let bookingDay = $('#bookingDay').val().trim();

    let existingDocuments = [];
    let newDocuments = [];

    // Reuse existing FormData if available
    let formData = window.packageFormData || new FormData();

    // Remove previously added documents if collectPolicy() can be called multiple times
    if (typeof formData.delete === "function") {
        formData.delete("documents[]");
    }

    attachments.forEach(function (item) {

        if (item.existing) {

            existingDocuments.push({
                id: item.id,
                title: item.title,
                fileName: item.file_name,
                existing: true
            });

        } else {

            newDocuments.push({
                id: item.id,
                title: item.title,
                fileName: item.file.name,
                type: item.file.name.split(".").pop().toUpperCase(),
                size: (item.file.size / (1024 * 1024)).toFixed(2) + " MB",
                uploadedOn: new Date().toLocaleDateString("en-GB"),
                existing: false
            });

            formData.append("documents[]", item.file);
        }
    });

    payLoadData.policy = {
        couponRule: {
            couponAllowed: switchCoupon,
            combineWithOffers: switchCombine
        },
        booking: {
            bookingPercentage,
            bookingDay
        },
        existingDocuments,
        documents: newDocuments,
        deletedDocuments
    };

    formData.set("payload", JSON.stringify(payLoadData));

    window.packageFormData = formData;
    console.log("collectPolicy called");
    console.log("Attachments:", attachments);

    window.attachments.forEach((item, index) => {
        console.log("Item", index, item);
        console.log("File:", item.file);
    });
    
}
function validatePolicy() {

    clearAllErrors();
    clearCouponRuleError();
    clearOtherPolicyError();

    let switchCoupon = $('#switchCoupon').is(':checked') ? 1 : 0;
    let switchCombine = $('#switchCombine').is(':checked') ? 1 : 0;
    let bookingPercentage = $('#bookingPercentage').val().trim();
    let bookingDay = $('#bookingDay').val().trim();

    let tableData = [];

    // Coupon Rule Validation
    // if (!switchCoupon && !switchCombine) {
    //     showCouponRuleError("Please enable at least one coupon rule.");
    //     return false;
    // }

    // Booking Validation
    if (bookingPercentage === "") {
        showError("bookingPercentage", "Please enter Minimum Advance Payment.");
        return false;
    }

    if (bookingDay === "") {
        showError("bookingDay", "Please enter Full Payment Before Travel.");
        return false;
    }

    // Document Validation
    // if (attachments.length === 0) {
    //     showOtherPolicyError("Please add at least one document.");
    //     return false;
    // }

    // Build document metadata
    window.attachments.forEach(function(item) {

        if (item.existing) {

            tableData.push({
                id: item.id,
                title: item.title,
                fileName: item.file_name,
                existing: true
            });

        } else {

            tableData.push({
                id: item.id,
                title: item.title,
                fileName: item.file.name,
                type: item.file.name.split(".").pop().toUpperCase(),
                size: (item.file.size / (1024 * 1024)).toFixed(2) + " MB",
                uploadedOn: new Date().toLocaleDateString("en-GB"),
                existing: false
            });

        }

    });

    payLoadData.policy = {
        couponRule: {
            couponAllowed: switchCoupon,
            combineWithOffers: switchCombine
        },
        booking: {
            bookingPercentage,
            bookingDay
        },
        documents: tableData,
        deletedDocuments: deletedDocuments
    };

    let formData = new FormData();

    formData.append("payload", JSON.stringify(payLoadData));

    window.attachments.forEach(item => {
        if (!item.existing && item.file) {
            formData.append("documents[]", item.file);
        }
    });

    window.packageFormData = formData;

    return true;
}
function collectMedia() {

    let formData =
        window.packageFormData || new FormData();


    // Cover Image
    const coverImage = {
        name: $("#coverImageUrl").data("base64") || "",
        url: $("#coverImageUrl").val().trim()
    };


    // Gallery Images
    const gallery = galleryImages.map(img => ({
        name: img.src,
        url: img.url
    }));


    // Videos
    const videos = window.videoFiles.map(file => ({
        name: file.name,
        size: file.size,
        type: "video"
    }));


    // Remove previously appended videos
    formData.delete("videos[]");


    // Save payload
    payLoadData.media = {
        coverImage,
        gallery,
        videos
    };


    // Append actual files
    window.videoFiles.forEach(function (file) {

        console.log(
            "Appending video:",
            file.name,
            file.size,
            file.type
        );

        formData.append(
            "videos[]",
            file,
            file.name
        );

    });


    // Update payload
    formData.set(
        "payload",
        JSON.stringify(payLoadData)
    );


    window.packageFormData = formData;


    // DEBUG
    console.log("========== FORMDATA ==========");

    for (const [key, value] of formData.entries()) {

        if (value instanceof File) {

            console.log(
                key,
                "FILE:",
                value.name,
                value.size,
                value.type
            );

        } else {

            console.log(key, value);

        }

    }

    console.log("==============================");
}
function validateMedia() {

    clearAllErrors();


    // Cover Image
    const coverImage = {
        name: $("#coverImageUrl").data("base64") || "",
        url: $("#coverImageUrl").val().trim()
    };

    if (!coverImage.name && !coverImage.url) {

        showCoverImageError(
            "Please upload a Cover Image."
        );

        return false;
    }


    // Gallery Images
    const gallery = galleryImages.map(img => ({
        name: img.src,
        url: img.url
    }));

    if (gallery.length === 0) {

        showGalleryError(
            "Please upload at least one Gallery Image."
        );

        return false;
    }


    // Videos
    const videos = window.videoFiles.map(file => ({
        name: file.name,
        size: file.size,
        type: "video"
    }));


    // Save payload
    payLoadData.media = {
        coverImage,
        gallery,
        videos
    };


    return true;
}
function collectEditMedia() {

    const coverImage = {

        deleted: coverImageDeleted,

        existing: !coverImageDeleted && !$("#coverImageUrl").data("base64"),

        name: $("#coverImageUrl").data("base64") || "",

        url: $("#coverImageUrl").val().trim()

    };

    const gallery = galleryImages.map(img => ({

        id: img.existing ? img.id : null,

        existing: img.existing || false,

        deleted: img.deleted || false,

        name: img.base64 || "",

        url: img.url

    }));

    const videos = [];

    $("#videoPreviewList .video-preview-item").each(function () {

        videos.push({
            url: $(this).find(".video-url").text().trim()
        });

    });

    payLoadData.media = {

        coverImage,

        gallery,

        deletedGallery: deletedGalleryImages,

        videos

    };

    payLoadData.package_id = $("#package_id").val();
}
function validateEditMedia() {

    clearAllErrors();

    // Cover Image
    const hasCover =
        !coverImageDeleted &&
        ($("#coverImageUrl").val().trim() !== "" ||
         $("#coverImageUrl").data("base64"));

    if (!hasCover) {
        showCoverImageError("Please upload a Cover Image.");
        return false;
    }

    // Gallery
    const activeGallery = galleryImages.filter(img => !img.deleted);

    if (activeGallery.length === 0) {
        showGalleryError("Please upload at least one Gallery Image.");
        return false;
    }

    return true;
}
//general information next
$('#package_form_general_nextBtn').on('click', async function (e) {

    e.preventDefault();

    if (!(await validateGeneralInfo())) {
        return;
    }

    collectGeneralInfo();

    showSection("#package_form_extra");

});
//Extra Informtion
$('#package_form_extra_nextBtn').on('click', function (e) {

    e.preventDefault();

    if (!validateExtraInfo()) {
        return;
    }

    collectExtraInfo();

    showSection("#package_form_itinerary");

});
//itenerary & inclusion
$('#package_form_itinerary_nxtBtn').on('click', function (e) {

    e.preventDefault();

    if (!validateItinerary()) {
        return;
    }

    collectItinerary();

    showSection("#package_form_pricing");

});
//pricing
$('#package_form_pricing_nextBtn').on('click', function (e) {

    e.preventDefault();

    if (!validatePricing()) {
        return;
    }

    collectPricing();

    showSection("#package_form_policy");

});
//policy
$('#package_form_policy_nextBtn').on('click', function (e) {

    e.preventDefault();

    if (!validatePolicy()) {
        return false;
    }
    collectPolicy();
    console.log(payLoadData);
    console.log(window.packageFormData);

    showSection("#package_form_picture");
});
//  submit form changed on 25 jan 2025 by sv
$("#update_form").on("click", function (e) {

    e.preventDefault();


    // ============================================================
    // VALIDATE + COLLECT ALL DATA
    // ============================================================

    if (!validateAndCollectAll()) {
        return false;
    }


    // ============================================================
    // CREATE FINAL FORMDATA
    // ============================================================

    let formData = new FormData();


    // ============================================================
    // POLICY DOCUMENTS
    // ============================================================

    window.attachments.forEach(function (item) {

        if (!item.existing && item.file) {

            formData.append(
                "documents[]",
                item.file,
                item.file.name
            );

        }

    });


    // ============================================================
    // VIDEO FILES
    // ============================================================

    console.log(
        "FINAL VIDEO FILES:",
        window.videoFiles
    );


    window.videoFiles.forEach(function (file) {

        console.log(
            "Appending video:",
            file.name,
            file.size,
            file.type
        );

        formData.append(
            "videos[]",
            file,
            file.name
        );

    });


    // ============================================================
    // GALLERY IMAGES
    // ============================================================

    const galleryInput = $("#galleryInput")[0];

    if (galleryInput && galleryInput.files.length > 0) {

        Array.from(galleryInput.files).forEach(function (file) {

            formData.append(
                "galleryImages[]",
                file,
                file.name
            );

        });

    }


    // ============================================================
    // PAYLOAD
    // ============================================================

    formData.append(
        "payload",
        JSON.stringify(payLoadData)
    );


    // ============================================================
    // DEBUG FORMDATA
    // ============================================================

    console.log("========== FINAL FORMDATA ==========");

    for (const [key, value] of formData.entries()) {

        if (value instanceof File) {

            console.log(
                key,
                "FILE:",
                value.name,
                value.size,
                value.type
            );

        } else {

            console.log(
                key,
                value
            );

        }

    }

    console.log("====================================");


    // ============================================================
    // LOADING
    // ============================================================

    Swal.fire({

        title: "Creating Package...",

        text: "Please wait while we save your package.",

        allowOutsideClick: false,

        allowEscapeKey: false,

        didOpen: () => {

            Swal.showLoading();

        }

    });


    // ============================================================
    // AJAX
    // ============================================================

    $.ajax({

        type: "POST",

        url: "forms/add_pacakage.php",

        data: formData,

        processData: false,

        contentType: false,

        dataType: "json",

        headers: {

            "X-CSRF-TOKEN":
                $('meta[name="csrf-token"]').attr("content")

        },


        success: function (res) {

            Swal.close();


            if (res.status) {

                Swal.fire({

                    icon: "success",

                    title: "Success!",

                    text: "Package created successfully.",

                    confirmButtonText: "OK"

                }).then(() => {

                    window.location.href =
                        "../packages/all_packages.php";

                });

            } else {

                Swal.fire({

                    icon: "error",

                    title: "Failed!",

                    text:
                        res.message ||
                        "Unable to create package."

                });

            }

        },


        error: function (xhr) {

            Swal.close();


            let message =
                "Something went wrong. Please try again.";


            if (
                xhr.responseJSON &&
                xhr.responseJSON.message
            ) {

                message =
                    xhr.responseJSON.message;

            }


            Swal.fire({

                icon: "error",

                title: "Error",

                text: message

            });


            console.error(
                "AJAX ERROR:",
                xhr
            );

        }

    });

});

// update form chaged on 31 july 2026 by sv
$("#edit_package").on("click", function (e) {

    e.preventDefault();


    // ============================================================
    // VALIDATE MEDIA
    // ============================================================

    if (!validateEditMedia()) {
        return false;
    }


    // ============================================================
    // COLLECT MEDIA
    // ============================================================

    collectEditMedia();


    // ============================================================
    // CREATE FINAL FORMDATA
    // ============================================================

    let formData = new FormData();


    // ============================================================
    // POLICY DOCUMENTS
    // ============================================================

    window.attachments.forEach(function (item) {

        if (!item.existing && item.file) {

            formData.append(
                "documents[]",
                item.file
            );

        }

    });


    // ============================================================
    // VIDEO FILES
    // ============================================================

    console.log(
        "FINAL VIDEO FILES:",
        window.videoFiles
    );


    window.videoFiles.forEach(function (file) {

        console.log(
            "Appending video:",
            file.name,
            file.size,
            file.type
        );

        formData.append(
            "videos[]",
            file,
            file.name
        );

    });


    // ============================================================
    // GALLERY IMAGES
    // ============================================================

    const galleryInput = $("#galleryInput")[0];

    if (galleryInput && galleryInput.files.length > 0) {

        Array.from(galleryInput.files).forEach(function (file) {

            formData.append(
                "galleryImages[]",
                file
            );

        });

    }


    // ============================================================
    // PAYLOAD
    // ============================================================

    formData.append(
        "payload",
        JSON.stringify(payLoadData)
    );


    // ============================================================
    // FINAL FORMDATA DEBUG
    // ============================================================

    console.log("========== FINAL FORMDATA ==========");

    for (const [key, value] of formData.entries()) {

        if (value instanceof File) {

            console.log(
                key,
                "FILE:",
                value.name,
                value.size,
                value.type
            );

        } else {

            console.log(
                key,
                value
            );

        }

    }

    console.log("====================================");


    // ============================================================
    // LOADING
    // ============================================================

    Swal.fire({

        title: "Updating Package...",

        text: "Please wait while we update your package.",

        allowOutsideClick: false,

        allowEscapeKey: false,

        didOpen: () => {

            Swal.showLoading();

        }

    });


    // ============================================================
    // AJAX
    // ============================================================

    $.ajax({

        type: "POST",

        url: "forms/edit_package.php",

        data: formData,

        processData: false,

        contentType: false,

        dataType: "json",

        headers: {

            "X-CSRF-TOKEN":
                $('meta[name="csrf-token"]').attr("content")

        },


        success: function (res) {

            Swal.close();


            if (res.status) {

                Swal.fire({

                    icon: "success",

                    title: "Success!",

                    text: res.message,

                    confirmButtonText: "OK"

                }).then(() => {

                    window.location.href =
                        "../packages/all_packages.php";

                });

            } else {

                Swal.fire({

                    icon: "error",

                    title: "Failed!",

                    text:
                        res.message ||
                        "Unable to update package."

                });

            }

        },


        error: function (xhr) {

            Swal.close();


            let message =
                "Something went wrong. Please try again.";


            if (
                xhr.responseJSON &&
                xhr.responseJSON.message
            ) {

                message =
                    xhr.responseJSON.message;

            }


            Swal.fire({

                icon: "error",

                title: "Error",

                text: message

            });


            console.error(
                "AJAX ERROR:",
                xhr
            );

        }

    });

});