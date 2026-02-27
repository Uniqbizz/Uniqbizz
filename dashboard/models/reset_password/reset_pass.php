<?php
    //get profile col data (img link) to display in header
    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    function getNameById($conn, $table, $column, $id)
    {
        $stmt = $conn->prepare("SELECT {$column} FROM {$table} WHERE id = ? AND status = '1'");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result[$column];
        }
        return '';
    }

    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $key => $value) {
            $profile_pic = $value['profile_pic'];

            // Default values
            $middle = '';
            $bank_passbook='';
            if ($userType == '25' || $userType == '24') {

                // Handle name split safely
                $nameParts = explode(' ', trim($value['name']));
                $fname = $nameParts[0] ?? '';
                $lname = end($nameParts) ?? '';
                // Extract middle names (excluding first and last)
                
                if (count($nameParts) > 2) {
                    $middle = implode(' ', array_slice($nameParts, 1, -1));
                }
            } else {
                // Common for userType 10, 11, and others
                $fname = $value['firstname'];
                $lname = $value['lastname'];
            }
        }
    }
?>