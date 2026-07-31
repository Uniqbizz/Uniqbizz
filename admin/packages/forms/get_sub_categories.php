<?php

require '../../connect.php';

if (!empty($_POST['cat_id'])) {

    $selected = $_POST['selected'] ?? '';

    $stmt = $conn->prepare("
        SELECT *
        FROM subcategory
        WHERE category_id = :category_id
        AND status = 1
    ");

    $stmt->execute([
        ':category_id' => $_POST['cat_id']
    ]);

    $subCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($subCategories)) {

        echo '<option value="">--Select Sub Category--</option>';

        foreach ($subCategories as $value) {

            $isSelected = ($value['id'] == $selected) ? 'selected' : '';

            echo '<option value="' . $value['id'] . '" ' . $isSelected . '>'
                    . htmlspecialchars($value['sub_category_name']) .
                 '</option>';
        }

    } else {

        echo '<option value="">--No Sub Category Available--</option>';

    }
}
?>