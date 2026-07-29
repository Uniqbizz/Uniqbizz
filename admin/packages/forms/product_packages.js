//for current and future dates only
document.getElementById("pacValidity").min = new Date().toISOString().split("T")[0];
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
function getSubCategories() {
	document.getElementById("subCategoryId").style.display = "block";
	document.getElementById("subCategoryData").style.display = "none";

	var cat_id = document.getElementById('categoryId').value;
	// console.log('categoruy selected = ' +cat_id);

	$.ajax({
		type: 'POST',
		url: 'forms/get_sub_categories.php',
		data: 'cat_id=' + cat_id,
		success: function (e) {
			// console.log(e);
			$('#subCategoryId').html(e);
		},
		error: function (err) {
			console.log(err);
		},
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

    // Set MRP
    $("#mrpPerAdult").val(truncateToTwoDecimals(adultMaxTotal));
    $("#mrpPerChild").val(truncateToTwoDecimals(childMaxTotal));

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
function showVisaTypeError(message){

    $("#visaType_wrapper")
        .addClass("error")
        .attr("tabindex","-1")
        .focus();

    $("#visaType_error").text(message);
}

function clearVisaTypeError(){

    $("#visaType_wrapper").removeClass("error");

    $("#visaType_error").text("");
}

$(".visaType").on("change",function(){

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

	const pageData = {
		"#package_form_general": {
			title: "Add New Package - General Information",
			backText: "Return to Package Listing",
			backLink: "all_packages.php"
		},
		"#package_form_extra": {
			title: "Add New Package - Extra Information",
			backText: "Return to General Information",
			backLink: "#package_form_general"
		},
		"#package_form_itinerary": {
			title: "Add New Package - Itinerary & Inclusions",
			backText: "Return to Extra Information",
			backLink: "#package_form_extra"
		},
		"#package_form_pricing": {
			title: "Add New Package - Pricing",
			backText: "Return to Itinerary & Inclusions",
			backLink: "#package_form_itinerary"
		},
		"#package_form_policy": {
			title: "Add New Package - Policy",
			backText: "Return to Pricing",
			backLink: "#package_form_pricing"
		},
		"#package_form_picture": {
			title: "Add New Package - Pictures & Media",
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

		let target = $(this).attr("href");
		showSection(target);
	});

	// Back button click
	$("#dynamicBackBtn").on("click", function (e) {
		e.preventDefault();

		let target = $(this).attr("data-target");

		if (target === "all_packages.php") {
			window.location.href = target;
			return;
		}

		showSection(target);
	});

let payLoadData={};
//general information next
$('#package_form_general_nextBtn').on('click',function (e){
	e.preventDefault();
	clearAllErrors();
    clearTravelThemeError();
    clearHighlightContainerError();
    clearPackageTypeError();
    clearVisaTypeError();
	let packName=$('#packName').val();
	let uniqueCode=$('#uniqueCode').val();
	let categoryId=$('#categoryId').val();
	let subCategoryId=$('#subCategoryId').val();
	let travelTheme = $('input[name="travelTheme"]:checked').val();
	let tourDays=$('#tourDays').val();
	let pacValidity=$('#pacValidity').val();
	let season=$('#season').val();
	let pacLocation=$('#pacLocation').val();
	let cities = [...document.querySelectorAll(".highlight-tag")].map(tag => tag.dataset.city);
	let description=$('#description').val();
	let descriptionDetail=$('#descriptionDetail').val();
	let packageType = $('input[name="packageType"]:checked').val();
	let visaType = $('input[name="visaType"]:checked').val();
	let dropPriceCheck = $('input[name="dropPriceCheck"]:checked').val();
	let dropPrice=$('#dropPrice').val();

	//validation
	// Package Name
    if (packName === "") {
        showError("packName", "Please enter Package Name.");
        return false;
    }

    // Unique Code
    if (uniqueCode === "") {
        showError("uniqueCode", "Please enter Unique Code.");
        return false;
    }
	$.ajax({
		url: "forms/unique_code_vefication.php",
		type: "POST",
		data: { uniqueCode },
		dataType: "json",
		success: function (res) {

			if (res.exists) {
				showError("uniqueCode", "Unique Code already exists.");
				return false;
			}
			// Continue with the remaining validations
			// Category
			if (categoryId === "" || categoryId == null) {
				showError("categoryId", "Please select Category.");
				return false;
			}

			// Sub Category
			if (subCategoryId === "" || subCategoryId == null) {
				showError("subCategoryId", "Please select Sub Category.");
				return false;
			}

			// Travel Theme
			if (!travelTheme) {
				showTravelThemeError("Please select a Travel Theme.");
				return false;
			}

			// Tour Days
			if (tourDays === "") {
				showError("tourDays", "Please enter Tour Days.");
				return false;
			}

			// Package Validity
			if (pacValidity === "") {
				showError("pacValidity", "Please select Package Validity.");
				return false;
			}

			// Package Location
			if (pacLocation === "") {
				showError("pacLocation", "Please enter Package Location.");
				return false;
			}

			// Cities
			if (cities.length === 0) {
				showHighlightContainerError("Please add at least one City.");
				return false;
			}

			// Description
			if (description === "") {
				showError("description", "Please enter Short Description.");
				return false;
			}

			// Detailed Description
			if (descriptionDetail === "") {
				showError("descriptionDetail", "Please enter Detailed Description.");
				return false;
			}

			// Package Type
			if (!packageType) {
				showPackageTypeError("Please select Package Type.");
				return false;
			}

			// Visa Type
			if (!visaType) {
				showVisaTypeError("Please select Visa Type.");
				return false;
			}

			// Drop Price
			if (dropPrice === "") {
				showError("dropPrice", "Please select a Drop Price.");
				return false;
			}

		}
	});

    
	payLoadData.general_info = {
		packName,
		uniqueCode,
		categoryId,
		subCategoryId,
		travelTheme,
		tourDays,
		pacValidity,
		season,
		pacLocation,
		cities,
		description,
		descriptionDetail,
		packageType,
		visaType,
		dropPriceCheck,
		dropPrice
	};

	showSection("#package_form_extra");

});
//Extra Informtion
$('#package_form_extra_nextBtn').on('click', function (e) {

    e.preventDefault();

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

    // Validation
    if (destination === "") {
        showError("destination", "Please enter Destination.");
        return false;
    }

    if (travelFrom === "") {
        showError("travelFrom", "Please enter Pick Up Point.");
        return false;
    }

    if (travelTo === "") {
        showError("travelTo", "Please enter Drop Point.");
        return false;
    }

    if (sightseeingType === "") {
        showError("sightseeingType", "Please enter Sightseeing Type.");
        return false;
    }

    if (categoryHotelId === "" || categoryHotelId == 0) {
        showError("categoryHotelId", "Please select Hotel Category.");
        return false;
    }

    if (occupancyId === "" || occupancyId == 0) {
        showError("occupancyId", "Please select Occupancy Category.");
        return false;
    }

    if (categoryMealId === "" || categoryMealId == 0) {
        showError("categoryMealId", "Please select Meal Category.");
        return false;
    }

    if (vehicleId === "" || vehicleId == 0) {
        showError("vehicleId", "Please select Vehicle Category.");
        return false;
    }

    if (languageType === "") {
        showError("languageType", "Please enter Language Type.");
        return false;
    }

    if (packageKeywords.length === 0) {
        showPackageKeyWordsError("Please add at least one Package Keyword.");
        return false;
    }

    // Save data
    payLoadData.extra_info = {
        destination,
        travelFrom,
        travelTo,
        sightseeingType,
        categoryHotelId,
        occupancyId,
        categoryMealId,
        vehicleId,
        languageType,
        packageKeywords
    };

    showSection("#package_form_itinerary");
});
//itenerary & inclusion
$('#package_form_itinerary_nxtBtn').on('click', function (e) {

    e.preventDefault();

    clearListError("hightlightList");
    clearListError("inclusionList");
    clearListError("exclusionList");
    clearListError("remarkList");
    clearListError("thingsList");

    // Highlights
    const highlightList = $("#hightlightList");

	if (
		highlightList.find(".remark-item").length === 0 ||
		highlightList.text().trim().includes("Placeholder Text")
	) {
        showListError("hightlightList", "Please add at least one Highlight.");
        return false;
    }

    // Days validation
    const dayContainers = $(".input_fields_wrap .day-container");
    if (dayContainers.length === 0) {
        $("#days_error").text("Please add at least one Day.");
        return false;
    } else {
        $("#days_error").text("");
    }

    // Validate all day fields
    const dayValidation = validateDayFields();
    if (!dayValidation.isValid) {
        // Show SweetAlert with all errors
        let errorMessage = 'Please fill all required fields in each day:\n\n';
        dayValidation.errorMessages.forEach((msg, index) => {
            errorMessage += `${index + 1}. ${msg}\n`;
        });
        
        Swal.fire({
            icon: 'error',
            title: 'Incomplete Day Fields',
            html: errorMessage.replace(/\n/g, '<br>'),
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
            width: '500px'
        });
        
        // Scroll to first error
        if (dayValidation.firstErrorDay) {
            const targetDay = $(`.day-container:eq(${dayValidation.firstErrorDay - 1})`);
            if (targetDay.length) {
                $('html, body').animate({
                    scrollTop: targetDay.offset().top - 100
                }, 500);
            }
        }
        
        return false;
    }

    // Inclusions
	const inclusionList = $("#inclusionList");

	if (
		inclusionList.find(".inclusion-item").length === 0 ||
		inclusionList.text().trim().includes("Placeholder Text")
	)
    {
        showListError("inclusionList", "Please add at least one Inclusion.");
        return false;
    }

    // Exclusions
	const exclusionList = $("#exclusionList");

	if (
		exclusionList.find(".exclusion-item").length === 0 ||
		exclusionList.text().trim().includes("Placeholder Text")
	)
    {
        showListError("exclusionList", "Please add at least one Exclusion.");
        return false;
    }

    // Remarks
	const remarkList = $("#remarkList");

	if (
		remarkList.find(".remark-item").length === 0 ||
		remarkList.text().trim().includes("Placeholder Text")
	)
    {
        showListError("remarkList", "Please add at least one Remark.");
        return false;
    }

    // Things to Know
	const thingsList = $("#thingsList");

	if (
		thingsList.find(".things-item").length === 0 ||
		thingsList.text().trim().includes("Placeholder Text")
	)
    {
        showListError("thingsList", "Please add at least one Thing to Know.");
        return false;
    }

    // Save data with day details
    const dayData = [];
    $(".day-container").each(function() {
		const index = $(this).find(".upload-card").data("index");
        const dayObj = {
            day: $(this).find(".dayval").text().trim(),
            title: $(this).find(".title").val().trim(),
            description: $(this).find(".description").val().trim(),
            meals: $(this).find(".meals").val().trim(),
            transport: $(this).find(".transport").eq(0).val().trim(),
            stay: $(this).find(".transport").eq(1).val().trim()
            // icon: index !== undefined ? $("#img_path" + index).val().trim() : "",
        	// iconBase64: index !== undefined ? $("#img_base64" + index).val().trim() : ""
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
        
        days: dayData // Add the days data
    };

    // console.log(payLoadData);

    showSection("#package_form_pricing");
});
//pricing
$('#package_form_pricing_nextBtn').on('click', function (e) {

    e.preventDefault();

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
	let travelConsultant= $("#travelConsultant").val().trim();
	let cteComm= $("#cteComm").text().replace("&#8377;", "").trim();
	let cteIns= $("#cteIns").text().replace("&#8377;", "").trim();
	let cteCommInsTotal= $("#cteCommInsTotal").text().replace("&#8377;", "").trim();
	let eteComm= $("#eteComm").text().replace("&#8377;", "").trim();
	let eteIns= $("#eteIns").text().replace("&#8377;", "").trim();
	let eteCommInsTotal= $("#eteCommInsTotal").text().replace("&#8377;", "").trim();
	let steComm= $("#steComm").text().replace("&#8377;", "").trim();
	let steIns= $("#steIns").text().replace("&#8377;", "").trim();
	let steCommInsTotal= $("#steCommInsTotal").text().replace("&#8377;", "").trim();
	let cTeFComm= $("#cTeFComm").text().replace("&#8377;", "").trim();
	let cTeFIns= $("#cTeFIns").text().replace("&#8377;", "").trim();
	let cTeFCommInsTotal= $("#cTeFCommInsTotal").text().replace("&#8377;", "").trim();
	let cteChainCommTotal= $("#cteChainCommTotal").text().replace("&#8377;", "").trim();
	let cteChainInsTotal= $("#cteChainInsTotal").text().replace("&#8377;", "").trim();
	let cteChainCommInsTotal= $("#cteChainCommInsTotal").text().replace("&#8377;", "").trim();
	let cteSuspence= $("#cteSuspence").val().trim();
	let teBmComm= $("#teBmComm").text().replace("&#8377;", "").trim();
	let teBmIns= $("#teBmIns").text().replace("&#8377;", "").trim();
	let teBmComInsTotal= $("#teBmComInsTotal").text().replace("&#8377;", "").trim();
	let bmTeComm= $("#bmTeComm").text().replace("&#8377;", "").trim();
	let bmTeIns= $("#bmTeIns").text().replace("&#8377;", "").trim();
	let bmTeCommInsTotal= $("#bmTeCommInsTotal").text().replace("&#8377;", "").trim();
	let bmTeChainCommTotal= $("#bmTeChainCommTotal").text().replace("&#8377;", "").trim();
	let bmTeChainInsTotal= $("#bmTeChainInsTotal").text().replace("&#8377;", "").trim();
	let bmTeChainCommInsTotal= $("#bmTeChainCommInsTotal").text().replace("&#8377;", "").trim();
	let bmSuspence= $("#bmSuspence").val().trim();
	let iBmComm= $("#iBmComm").text().replace("&#8377;", "").trim();
	let iBmIns= $("#iBmIns").text().replace("&#8377;", "").trim();
	let bmIComm= $("#bmIComm").text().replace("&#8377;", "").trim();
	let bmICommInsTotal= $("#bmICommInsTotal").text().replace("&#8377;", "").trim();
	let iBmCommInsTotal= $("#iBmCommInsTotal").text().replace("&#8377;", "").trim();
	let bmIComTotal= $("#bmIComTotal").text().replace("&#8377;", "").trim();
	let bmIInsTotal= $("#bmIInsTotal").text().replace("&#8377;", "").trim();
	let bmIComInsTotal= $("#bmIComInsTotal").text().replace("&#8377;", "").trim();
	let bmISuspence= $("#bmISuspence").val().trim();
	let iCteComm= $("#iCteComm").text().replace("&#8377;", "").trim();
	let iCteIns= $("#iCteIns").text().replace("&#8377;", "").trim();
	let iCteCommInsTotal= $("#iCteCommInsTotal").text().replace("&#8377;", "").trim();
	let iEteComm= $("#iEteComm").text().replace("&#8377;", "").trim();
	let iEteIns= $("#iEteIns").text().replace("&#8377;", "").trim();
	let iEteCommInsTotal= $("#iEteCommInsTotal").text().replace("&#8377;", "").trim();
	let cteIComm= $("#cteIComm").text().replace("&#8377;", "").trim();
	let cteICommInsTotal= $("#cteICommInsTotal").text().replace("&#8377;", "").trim();
	let iCteComTotal= $("#iCteComTotal").text().replace("&#8377;", "").trim();
	let iCteInsTotal= $("#iCteInsTotal").text().replace("&#8377;", "").trim();
	let iCteComInsTotal= $("#iCteComInsTotal").text().replace("&#8377;", "").trim();
	let cteISuspence= $("#cteISuspence").val().trim();
	let customer1= $("#customer1").val().trim();
	let customer2= $("#customer2").val().trim();
	let customer3= $("#customer3").val().trim();
	let totalCustomerShare=customer1+customer2+customer3;
	let mrpPerAdult= $("#mrpPerAdult").val().trim();
	let mrpPerChild= $("#mrpPerChild").val().trim();
	let mrpPerAdultGst = mrpPerAdult + (mrpPerAdult * (gst / 100));
	let mrpPerChildGst = mrpPerChild + (mrpPerChild * (gst / 100));
	let cancellationPercentage1= $("#cancellationPercentage1").val().trim();
	let cancellationPercentage2= $("#cancellationPercentage2").val().trim();
	let cancellationPercentage3= $("#cancellationPercentage3").val().trim();
	let cancellationPercentage4= $("#cancellationPercentage4").val().trim();
	let cancellationPercentage5= $("#cancellationPercentage5").val().trim();
	
    // Validation
    if (netPriceAdult === "") {
        showError("netPriceAdult", "Please enter Base Price for per Adult.");
        return false;
    }

    if (netPriceChild === "") {
        showError("netPriceChild", "Please enter Base Price for per Child.");
        return false;
    }
    if (extraMatress === "") {
        showError("extraMatress", "Please enter Extra Matress.");
        return false;
    }

    if (companyMarkup === "") {
        showError("companyMarkup", "Please enter Company Markup.");
        return false;
    }

    if (couponAdjustment === "") {
        showError("couponAdjustment", "Please enter Default Coupon Adjustment.");
        return false;
    }
	if ($("#switchCheckGuestUser").is(":checked")) {

		// Check if any option is selected
		if (!$("#radioDefault1").is(":checked") && !$("#radioDefault2").is(":checked")) {
			showError("guestAmount", "Please select either Fixed Amount or Percentage.");
			return false;
		}

		// Fixed Amount validation
		if ($("#radioDefault1").is(":checked")) {
			

			if (guestAmount === "") {
				showError("guestAmount", "Please enter Fixed Amount.");
				return false;
			}
		}

		// Percentage validation
		if ($("#radioDefault2").is(":checked")) {
			

			if (guestPercentage === "") {
				showError("guestPercentage", "Please enter Percentage.");
				return false;
			}

			if (isNaN(guestPercentage) || Number(guestPercentage) < 0 || Number(guestPercentage) > 100) {
				showError("guestPercentage", "Percentage must be between 0 and 100.");
				return false;
			}
		}
	}
	if (travelConsultant === "") {
        showError("travelConsultant", "Please enter Travel Consultant.");
        return false;
    }
	for (let i = 1; i <= 5; i++) {
		let value = $(`#cancellationPercentage${i}`).val().trim();

		if (value === "") {
			showError(`cancellationPercentage${i}`, "Please enter Cancellation Percentage.");
			return false;
		}
	}
    

    // Save data
    payLoadData.pricing = {
		netPriceAdult,
		netPriceChild,
		extraMatress,
		companyMarkup,
		couponAdjustment,

		guestUser: $("#switchCheckGuestUser").is(":checked") ? 1 : 0,
		guestPricingType: $("#radioDefault1").is(":checked")
			? "fixed"
			: $("#radioDefault2").is(":checked")
				? "percentage"
				: "",

		guestAmount,
		guestPercentage,

		travelConsultant,

		cteComm,
		cteIns,
		cteCommInsTotal,

		eteComm,
		eteIns,
		eteCommInsTotal,

		steComm,
		steIns,
		steCommInsTotal,

		cTeFComm,
		cTeFIns,
		cTeFCommInsTotal,

		cteChainCommTotal,
		cteChainInsTotal,
		cteChainCommInsTotal,
		cteSuspence,

		teBmComm,
		teBmIns,
		teBmComInsTotal,

		bmTeComm,
		bmTeIns,
		bmTeCommInsTotal,

		bmTeChainCommTotal,
		bmTeChainInsTotal,
		bmTeChainCommInsTotal,
		bmSuspence,

		iBmComm,
		iBmIns,
		iBmCommInsTotal,

		bmIComm,
		bmICommInsTotal,
		bmIComTotal,
		bmIInsTotal,
		bmIComInsTotal,
		bmISuspence,

		iCteComm,
		iCteIns,
		iCteCommInsTotal,

		iEteComm,
		iEteIns,
		iEteCommInsTotal,

		cteIComm,
		cteICommInsTotal,

		iCteComTotal,
		iCteInsTotal,
		iCteComInsTotal,
		cteISuspence,

		customer1,
		customer2,
		customer3,
		totalCustomerShare,

		mrpPerAdult,
		mrpPerChild,
		mrpPerAdultGst,
		mrpPerChildGst,

		cancellationPercentage1,
		cancellationPercentage2,
		cancellationPercentage3,
		cancellationPercentage4,
		cancellationPercentage5
	};

    showSection("#package_form_policy");
});
//policy
$('#package_form_policy_nextBtn').on('click', function (e) {

    e.preventDefault();

    clearAllErrors();
    clearCouponRuleError();
    clearOtherPolicyError();

    let switchCoupon = $('#switchCoupon').is(':checked') ? 1 : 0;
    let switchCombine = $('#switchCombine').is(':checked') ? 1 : 0;
    let bookingPercentage = $('#bookingPercentage').val().trim();
    let bookingDay = $('#bookingDay').val().trim();

    let tableData = [];

    // Coupon Rule Validation
    if (!switchCoupon && !switchCombine) {
        showCouponRuleError("Please enable at least one coupon rule.");
        return;
    }

    // Booking Validation
    if (bookingPercentage === "") {
        showError("bookingPercentage", "Please enter Minimum Advance Payment.");
        return;
    }

    if (bookingDay === "") {
        showError("bookingDay", "Please enter Full Payment Before Travel.");
        return;
    }

    // Document Validation
    if (attachments.length === 0) {
        showOtherPolicyError("Please add at least one document.");
        return;
    }

    // Build document metadata
    attachments.forEach(function(item){

        tableData.push({
            id: item.id,
            title: item.title,
            fileName: item.file.name,
            type: item.file.name.split(".").pop().toUpperCase(),
            size: (item.file.size / (1024 * 1024)).toFixed(2) + " MB",
            uploadedOn: new Date().toLocaleDateString("en-GB")
        });

    });

    // Save in payload
    payLoadData.policy = {
        couponRule: {
            couponAllowed: switchCoupon,
            combineWithOffers: switchCombine
        },
        booking: {
            bookingPercentage,
            bookingDay
        },
        documents: tableData
    };

    // Create FormData
    let formData = new FormData();

    // Complete payload
    formData.append("payload", JSON.stringify(payLoadData));

    // Attach files
    attachments.forEach(function(item){

        formData.append("documents[]", item.file);
        formData.append("document_titles[]", item.title);
        formData.append("document_ids[]", item.id);

    });

    // Store globally if you want to submit later
    window.packageFormData = formData;

    console.log(payLoadData);
    console.log(formData);

    showSection("#package_form_picture");

});
//  submit form changed on 25 jan 2025 by sv
$("#update_form").on('click',function (e) {
	e.preventDefault();

	// Cover Image
	const coverImage = {
		name: $("#coverImageUrl").data("base64") || "",
		url: $("#coverImageUrl").val().trim()
	};

	// Gallery Images
	const gallery = galleryImages.map(img => ({
		name: img.src,   // Base64 for PHP
		url: img.url     // uploading/packages/filename.jpg
	}));

	// Videos
	let videos = [];

	$("#videoPreviewList .video-preview-item").each(function () {
		videos.push({
			url: $(this).find(".video-url").text().trim()
		});
	});

	// Media Payload
	payLoadData.media = {
		coverImage,
		gallery,
		videos
	};
	console.log(payLoadData);
	
	Swal.fire({
		title: "Creating Package...",
		text: "Please wait while we save your package.",
		allowOutsideClick: false,
		allowEscapeKey: false,
		didOpen: () => {
			Swal.showLoading();
		}
	});

	// $.ajax({
	// 	type: "POST",
	// 	url: "forms/create.php",
	// 	data: JSON.stringify(payLoadData),
	// 	contentType: "application/json",
	// 	dataType: "json",
	// 	headers: {
	// 		"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
	// 	},

	// 	success: function (res) {

	// 		Swal.close();

	// 		if (res.status === "success") {

	// 			Swal.fire({
	// 				icon: "success",
	// 				title: "Success!",
	// 				text: "Package created successfully.",//res.message || 
	// 				confirmButtonText: "OK"
	// 			}).then(() => {
	// 				window.location.href = "../packages/all_packages.php";
	// 			});

	// 		} else {

	// 			Swal.fire({
	// 				icon: "error",
	// 				title: "Failed!",
	// 				text: "Unable to create package."
	// 			});

	// 		}
	// 	},

	// 	error: function (xhr) {

	// 		Swal.close();

	// 		let message = "Something went wrong. Please try again.";

	// 		if (xhr.responseJSON && xhr.responseJSON.message) {
	// 			message = xhr.responseJSON.message;
	// 		}

	// 		Swal.fire({
	// 			icon: "error",
	// 			title: "Error",
	// 			text: message
	// 		});

	// 		console.error(xhr);
	// 	},
	// });
});

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
	var total_package_price_per_adult = $('#mrpPerAdult').val();
	var total_package_price_per_child = $('#mrpPerChild').val().trim() || '0';
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