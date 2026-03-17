<?php
    //convert long number to short number with 2 decimal points and currency indication
    function formatIndianCurrency($num) {
        $num = str_replace(',', '', $num);
        if ($num >= 10000000) {
            return number_format($num / 10000000, 2) . ' Cr';
        } elseif ($num >= 100000) {
            return number_format($num / 100000, 2) . ' L';
        } elseif ($num >= 1000) {
            return number_format($num / 1000, 2) . ' K';
        } else {
            return $num;
        }
    }
?>