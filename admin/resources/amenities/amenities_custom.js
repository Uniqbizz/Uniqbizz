// edit hotel function
function editfuncHotel(id)
{
    window.location.href='../../views/amenities/edit_stay_types.php?vkvbvjfgfikix='+id;
};

// delete hotel function
function deletefuncHotel(id)
{
    var dataString = 'id='+ id;
    var r = confirm("You are about to delete a Stay Type.\nDo you want to delete the Stay Type?");

    if (r == true) {
            $.ajax({
            type: "POST",
            url: "../../models/amenities/hotels/delete_stay_types.php",
            data: dataString,
            cache: false,
                success:function(data){
                    if(data == 1){
                        alert("Delete Succesfully");
                        window.location.reload();
                    }else{
                        alert("Deletion Failed");
                    }
                }
            });
    };
}

// edit meals function
function editfuncMeal(id)
{
    window.location.href='../../views/amenities/edit_meals.php?vkvbvjfgfikix='+id;
};

// delete meals function
function deletefuncMeal(id)
{
    var dataString = 'id='+ id;
    var r = confirm("You are about to delete a Meal.\nDo you want to delete the Meal?");

    if (r == true) {
            $.ajax({
            type: "POST",
            url: "../../models/amenities/meals/delete_meals.php",
            data: dataString,
            cache: false,
                success:function(data){
                    if(data == 1){
                        alert("Delete Succesfully");
                        window.location.reload();
                    }else{
                        alert("Deletion Failed");
                    }
                }
            });
    };
}


// edit vehicle function
function editfuncVehicle(id)
    {
        window.location.href='../../views/amenities/edit_vehicle.php?vkvbvjfgfikix='+id;
    };

// delete vehicle function
function deletefuncVehicle(id)
{
    var dataString = 'id='+ id;
    var r = confirm("You are about to delete a Vehicle.\nDo you want to delete the Vehicle?");

    if (r == true) {
            $.ajax({
            type: "POST",
            url: "../../models/amenities/vehicles/delete_vehicle.php",
            data: dataString,
            cache: false,
                success:function(data){
                    if(data == 1){
                        alert("Delete Succesfully");
                        window.location.reload();
                    }else{
                        alert("Deletion Failed");
                    }
                }
            });
    };
}

// edit occupancy function
function editfuncOccupancy(id)
{
    window.location.href='../../views/amenities/edit_occupancy.php?vkvbvjfgfikix='+id;
};

// delete occupancy function
function deletefuncOccupancy(id)
{
    var dataString = 'id='+ id;
    var r = confirm("You are about to delete a Occupancy.\nDo you want to delete the Occupancy?");

    if (r == true) {
            $.ajax({
            type: "POST",
            url: "../../models/amenities/occupancy/delete_occupancy.php",
            data: dataString,
            cache: false,
                success:function(data){
                    if(data == 1){
                        alert("Delete Succesfully");
                        window.location.reload();
                    }else{
                        alert("Deletion Failed");
                    }
                }
            });
    };
}