<?php
    // package
    $stmt = $conn->prepare("SELECT * FROM package WHERE id = $id");
    $stmt->execute();
    $package = $stmt->fetch();
    $cat_id = $package['category_id'];
    $sub_cat_id = $package['sub_category_id'];
    $hotel_cat_id = $package['category_hotel_id'];
    $meal_cat_id = $package['category_meal_id'];
    $validity = $package['validity'] ?? 0;
    // itinery 
    $data2 = $conn->prepare("SELECT * FROM package_itinerary_details WHERE package_id = $id");
    $data2->execute();
    $itinery = $data2->fetch();
    // package_pricing 
    $data3 = $conn->prepare("SELECT * FROM package_pricing WHERE package_id = $id");
    $data3->execute();
    $amount = $data3->fetch();
    // category 
    $data5 = $conn->prepare("SELECT * FROM category WHERE id = $cat_id");
    $data5->execute();
    $category = $data5->fetch();
    // sub_cat 
    $data6 = $conn->prepare("SELECT * FROM subcategory WHERE id = $sub_cat_id");
    $data6->execute();
    $sub_cat = $data6->fetch();
    // cat hotel 
    $data7 = $conn->prepare("SELECT * FROM category_hotel WHERE id = $hotel_cat_id");
    $data7->execute();
    if ($data7->rowCount() > 0) {
        $hotel_cat = $data7->fetch();
    } else {
        $hotel_cat = "null";
    }
    // cat meal 
    $data8 = $conn->prepare("SELECT * FROM category_meal WHERE id = $meal_cat_id");
    $data8->execute();
    if ($data8->rowCount() > 0) {
        $meal_cat = $data8->fetch();
    } else {
        $meal_cat = "null";
    }
    // Fetch occupancy types for a given package_id
    $data9 = $conn->prepare("SELECT * FROM `package_to_category_occupancy` WHERE package_id = :id");
    $data9->bindParam(':id', $id, PDO::PARAM_INT);
    $data9->execute();
    $occu_type = $data9->rowCount() > 0 ? $data9->fetchAll(PDO::FETCH_ASSOC) : [];
    // Fetch all occupancy categories
    $data10 = $conn->prepare("SELECT id, name FROM `category_occupancy`");
    $data10->execute();
    $occu_type_id = $data10->rowCount() > 0 ? $data10->fetchAll(PDO::FETCH_ASSOC) : [];
    // Fetch vehicle types for a given package_id
    $data11 = $conn->prepare("SELECT * FROM `package_to_category_vehicle` WHERE package_id = :id");
    $data11->bindParam(':id', $id, PDO::PARAM_INT);
    $data11->execute();
    $vehicle_type = $data11->rowCount() > 0 ? $data11->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name
    // Fetch all vehicle categories
    $data12 = $conn->prepare("SELECT id, name FROM `category_vehicle`");
    $data12->execute();
    $vehicle_type_id = $data12->rowCount() > 0 ? $data12->fetchAll(PDO::FETCH_ASSOC) : []; // Corrected variable name
    //cancellation policy
    $data9 = $conn->prepare("SELECT * FROM cancel_policy WHERE package_id = $id");
    $data9->execute();
    if ($data9->rowCount() > 0) {
        $cancel_policy = $data9->fetch();
    } else {
        $cancel_policy['policy_1'] = 0;
        $cancel_policy['policy_2'] = 0;
        $cancel_policy['policy_3'] = 0;
    }
?>