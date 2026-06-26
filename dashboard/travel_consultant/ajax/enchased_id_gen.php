<?php

    // ENCHASED ID GENERATION
    function generateUniqueId()
    {
        // PREFIX
        $prefix = "WD";

        // CURRENT YEAR
        $year = date("Y");

        // GENERATE RANDOM HEX STRING
        // 6 bytes = 12 hex characters
        $uniquePart = strtoupper(
            bin2hex(random_bytes(6))
        );

        // FINAL ID
        // Example: WD2026A1B2C3D4
        return $prefix .
            $year .
            substr($uniquePart, 0, 8);
    }

?>