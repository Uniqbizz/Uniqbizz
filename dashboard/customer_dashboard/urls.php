<?php

    // AUTO DETECT LOCAL / LIVE

    $protocol =
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        ? "https://"
        : "http://";

    $domain =
        $_SERVER['HTTP_HOST'];


    // LOCALHOST
    if(
        strpos($domain, 'localhost') !== false
    ){

        $project_folder =
            "/uniqbizz-main";
    }
    else{

        // LIVE SERVER
        $project_folder = "";
    }


    // FINAL URLS
    $home_url =
        $protocol .
        $domain .
        $project_folder . "/";

    $base_url =
        $home_url .
        "dashboard/";

    $base_url_cust =
        $home_url .
        "dashboard/customer_dashboard/";

?>