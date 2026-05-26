<?php
    // COUPON CODE GENERATION
    function generateUniqueCoupon()
    {
        $prefix = "LOY";

        $year = date("Y");

        // 6 BYTES = 12 HEX CHARACTERS
        $uniquePart =
            strtoupper(
                bin2hex(random_bytes(6))
            );

        // FINAL CODE
        return $prefix .
            $year .
            substr($uniquePart, 0, 8);

        // OUTPUT EXAMPLE:
        // LOY2026F6ADC33C
    }
?>