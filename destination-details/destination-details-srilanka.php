<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="zxx" dir="lrt">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <head>
        <script>
            const setTheme = (theme) => {
                theme ??= localStorage.theme || "light";
                document.documentElement.dataset.theme = theme;
                localStorage.theme = theme;
            };
            setTheme();
        </script>
        <meta logo="assets/images/logo/logo.png">
        <meta white-logo="assets/images/logo/logo-white.png">
        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:type" content="website">
        <meta property="og:title" content="">
        <meta property="og:site_name" content="">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
        <meta property="og:description" content="">
        <meta name="twitter:title" content="">
        <meta name="twitter:description" content="">
        <meta name="twitter:image" content="">
        <meta name="twitter:card" content="summary">
        <!-- Google site verification -->
        <meta name="google-site-verification" content="...">
        <meta name="facebook-domain-verification" content="...">
        <meta name="csrf-token" content="...">
        <meta name="currency" content="">
        <!-- Title -->
        <title>Bizzmirth Holidays Private Ltd</title>
        <link rel="icon" type="image/x-icon" sizes="20x20" href="../assets/images/icon/fav.png">
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-5.3.0.min.css">
        <!-- Fonts & icon -->
        <link rel="stylesheet" type="text/css" href="../assets/css/remixicon.css">
        <!-- Plugin -->
        <link rel="stylesheet" type="text/css" href="../assets/css/plugin.css">
        <!-- Main CSS -->
        <link rel="stylesheet" type="text/css" href="../assets/css/main-style.css">
        <!-- RTL CSS::When Need RTL Uncomments File -->
        <!-- <link rel="stylesheet" type="text/css" href="../assets/css/rtl.css"> -->
        <style>
            .colNewlyAddedImg {
                display: flex;
                align-items: center;
                padding-left: 0px !important;
            }
            .newlyAddedImg{
                width: 100% !important;
                height: 85% !important;
            }
            .btn-secondary-sm-view {
                background-color: var(--secondary-color);
                border: 1px solid transparent;
                padding: 4px 8px;
                font-size: 12px;
                font-weight: 800;
                line-height: 1.3;
                border-radius: 8px;
                color: #fff;
                display: inline-block;
            }
            .btn-secondary-sm-view:hover {
                -webkit-transition: 0.3s;
                transition: 0.3s;
                background-color: transparent;
                border: 1px solid var(--secondary-color);
                color: var(--secondary-color);
            }
            .package-font-size {
                font-size: 12px;
                padding-bottom: 5px;
            }
            .borderEndStyle {
                border: 1px solid red !important;
                margin: -5px 5px 10px 0px !important;
            }
        </style>
    </head>
    <body>
        <?php include_once "header_blog.php" ?>
        <main>
            <!-- Breadcrumbs S t a r t -->
            <section class="breadcrumbs-area breadcrumb-bg">
                <div class="container">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.0s">Destination</h1>
                    <div class="breadcrumb-text">
                        <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.1s">
                            <ul class="breadcrumb listing">
                                <li class="breadcrumb-item single-list"><a href="../index.php" class="single">Home</a></li>
                                <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                        class="single active">Destination</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>
            <!--/ End-of Breadcrumbs-->

            <!-- Destination area S t a r t -->
            <section class="destination-details-section section-padding2">
                <div class="container">
                    <div class="row g-4">
                        <!-- Destination details banner -->
                        <div class="destination-details-banner o-hidden radius-12 p-0">
                            <div class="swiper destinationSwiper-active" style="height: 500px !important;">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="../assets/images/destination/SriLanka1.jpg" alt="SriLanka" style="height: 550px !important; object-fit: cover;">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="../assets/images/destination/SriLanka2.jpg" alt="SriLanka" style="height: 550px !important; object-fit: cover;">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="../assets/images/destination/SriLanka3.jpg" alt="SriLanka" style="height: 550px !important; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Destination details banner-->
                        <div class="col-xl-8 col-lg-7">
                            <!-- Details content -->
                            <div class="destination-details-content">
                                <h4 class="title">Island of Enchantment: Discovering Sri Lanka’s Hidden Gems</h4>
                                <p class="pera">
                                    Sri Lanka is a teardrop-shaped island nation located in the Indian Ocean. Colombo is the capital 
                                    of Sri Lanka. It is a business hub with a bustling mix of colonial elegance and contemporary 
                                    development. The Lotus Tower is a landmark in Colombo. It is a flowering-shaped tower, the tallest 
                                    in South Asia, painted pink. It is a symbol of tradition as well as modernity. Colombo’s Galle Face 
                                    Promenade is a popular seaside urban park ideal for evening strolls. Visitors can enjoy street food, 
                                    kite flying, and watching breathtaking sunsets. 
                                </p>
                                <p class="pera">
                                    A visit to the Pinnawala Elephant Orphanage offers a unique experience for tourists. This 
                                    conservation and captive breeding centre is home to wild Asian elephants and provides an opportunity 
                                    to observe these gentle giants up close.  
                                </p>
                                <p class="pera">
                                    Negombo Lagoon is made up of tiny rivers and is rich in flora, fauna. A perfect spot for tourists to 
                                    explore spots like the Morawala Beach, the Muthurajawela Marsh, which is a bird sanctuary, and the 
                                    stunning architecture of Angurukaramulla Temple, which pays reverence to Lord Buddha. The Dutch fort 
                                    built by the Portuguese in the 16th century stands as a historical reminder of Sri Lanka’s colonial 
                                    past.    
                                </p>
                                <p class="pera">
                                    Sigiriya Lion Rock is a massive ancient rock fortress that has its entrance carved in the shape of 
                                    an enormous Lion. Rising about 200 meters high, visitors must climb approximately 1,200 steps from 
                                    the Lion’s mouth to reach the summit. Along the way, one can enjoy breathtaking views of the 
                                    surrounding landscape. Sigiriya Rock is recognized as a UNESCO World Heritage Site in the country. 
                                    Other nearby attractions are the Dambulla caves, located centrally in Sri Lanka. These ancient 
                                    caves were constructed in the year 80BC.   
                                </p>
                                <p class="pera">
                                    Kandy, located in the heart of Sri Lanka, is a major pilgrimage centre in the country. It is home 
                                    to the famous Buddhist temple known as the Temple of the Tooth, which houses the sacred Tooth Relic 
                                    of the Buddha. Visitors can get a glimpse of the sacred Tooth relic of the Buddha and marvel at 
                                    the murals on the walls. In Kandy, you can visit the Royal Botanical garden, which is huge and 
                                    beautifully maintained with over 4000 species of plants, from all around the world. Lake Kandy, 
                                    often referred to as the Sea of Milk, is an artificial lake located in the heart of the hill city 
                                    of Kandy.    
                                </p>
                                <p class="pera">
                                    Pinnawala Elephant Orphanage is a popular tourist destination. It houses the largest herd of 
                                    Elephants in the world. It offers visitors a chance to feed and bathe the Elephants under the 
                                    supervision of a trained handler Ambuluwawa Tower is an iconic tourist destination.   
                                </p>
                                <p class="pera">
                                    Visitors can get to view the panoramic mountain views while going upwards. It is a multi-religious 
                                    centre and stands as a symbol of religious harmony. At its core stands a Buddhist temple, reflecting 
                                    the country's cultural and spiritual heritage. 
                                </p>
                                <p class="pera">
                                    Nuwara Eliya often referred to as “Little England” due to its cool climate and colonial-era 
                                    bungalows. It is the world’s largest tea-producing region, surrounded by vast tea-producing estates. 
                                    Besides its scenic beauty, Nuwara Eliya is has many breathtaking waterfalls, making it a must-visit 
                                    destination for nature lovers and travellers seeking tranquillity.   
                                </p>
                                <p class="pera">
                                    A journey through Sri Lanka offers travellers a vivid encounter with its colonial heritage, cultural 
                                    harmony, and heartfelt hospitality. It is an experience that lingers long after you've left its 
                                    shores. 
                                </p>
                            </div>
                            <!--/ details-content -->
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="row g-4 position-static top-0">
                                <div class="col-lg-12">
                                    <!-- info -->
                                    <div class="destination-details-info">
                                        <h4 class="title">Basic Information</h4>
                                        <div class="info-table">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th>Country</th>
                                                        <td>Sri Lanka</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Language</th>
                                                        <td>Sinhala. Tamil.</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Currency</th>
                                                        <td>Sri Lankan Rupee (LKR, Rs)</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Population</th>
                                                        <td>2.19 Crore</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Area</th>
                                                        <td>25,330 Square Miles</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Time to Travel</th>
                                                        <td>April to September and December to March</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Newly added packages top 5 -->
                                <div class="col-lg-12">
                                    <div class="destination-details-info">
                                        <h4 class="title ">Newly Added Packages</h4>
                                        <div class="row p-3 rounded-3" style="background-color: #eaebee; margin-left: 1px !important; margin-right: 1px !important; margin-bottom: 30px !important;">
                                            <?php 
                                                require '../connect.php';
                                                $stmt = $conn->prepare(" SELECT id, description, destination, location, name FROM package WHERE  status = '1'  ORDER BY id DESC LIMIT 5 ");
                                                $stmt->execute();
                                                $stmt->SetFetchMode(PDO::FETCH_ASSOC);
                                                if($stmt->rowCount()>0){
                                                    foreach (($stmt->fetchAll()) as $key => $row) {
                                                        // $name = $row['name'].''.$row['unique_code'];
                                                        // echo $srno.' '.$name.'</br>';
                                                        // get images
                                                        $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = '".$row['id']."' LIMIT 1" );
                                                        $data->execute();
                                                        $value = $data->fetch();
                                                        // echo $value['image'].'-id-'.$value['id'].'-package_id-'.$value['package_id'];
                                                        // tour package description limit words counts to show in list view
                                                        $description = $row['description'];
                                                        $maxLength = 65; //word limit
                                                        if (strlen($description) > $maxLength) {
                                                            $truncatedString = substr($description, 0, $maxLength) . '...';
                                                        } else {
                                                            $truncatedString = $description;
                                                        }
                                                        echo'
                                                            <div class="col-5 colNewlyAddedImg mb-2">
                                                                <img class="newlyAddedImg rounded-3" src="../'.$value['image'].'" alt="BizzMirth">
                                                            </div>
                                                            <div class="col-7 mb-2 pb-2 justify-content-center align-content-center">
                                                                <h6 class="fw-bolder text-center">'.$row['location'].'</h6>
                                                                <p class="package-font-size">'.$truncatedString.'</p>
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="#" class="btn-secondary-sm-view" onclick=\'viewPackage("' .$row['id']. '")\'>View Package</a>
                                                                </div>
                                                            </div>
                                                            <hr class="borderEndStyle">
                                                        ';
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Newly added packages top 5 -->
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <div class="row g-4">
                                <?php 
                                    require '../connect.php';
                                    $searchPac = "SriLanka";
                                    $user_id = 0;
                                    $ta_id = 0;
                                    // get TA id
                                    if ( $user_id ) {
                                        if (  $user_type == '2' ) {
                                            $ta_data = $conn->prepare("SELECT * FROM customer WHERE cust_id = '".$user_id."' " );
                                            $ta_data->execute();
                                            $ta = $ta_data->fetch();
                                            $ta_id = $ta['ta_reference'];
                                        } else if (  $user_type == '3' ) {
                                            $ta_id = $user_id;
                                        }
                                    }

                                    $stmt = $conn->prepare(" SELECT p.id, p.description, p.description, p.destination, p.location, p.name, t.total_package_price_per_adult, t.total_package_price_per_child, t.markup_total FROM package p, package_pricing t, category c WHERE p.id = t.package_id AND p.category_id = c.id AND p.status = '1' AND p.name LIKE '%$searchPac%' ORDER BY p.id DESC LIMIT 4 ");
                                    $stmt->execute();
                                    $stmt->SetFetchMode(PDO::FETCH_ASSOC);
                                    if($stmt->rowCount()>0){
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            // $name = $row['name'].''.$row['unique_code'];
                                            // echo $srno.' '.$name.'</br>';

                                            // get images
                                            $data = $conn->prepare("SELECT * FROM package_pictures WHERE package_id = '".$row['id']."' LIMIT 1" );
                                            $data->execute();
                                            $value = $data->fetch();
                                            // echo $value['image'].'-id-'.$value['id'].'-package_id-'.$value['package_id'];

                                            $adult_price = (int)$row['total_package_price_per_adult'];
                                            $markup_price = (int)$row['markup_total'];
                                            $total_base_price = $adult_price + $markup_price;

                                            if ( $ta_id ) {
                                                $ta_markup_data = $conn->prepare("SELECT * FROM package_markup_travelagent WHERE travelagent_id = '".$ta_id."' AND package_id = '".$row['id']."' AND status='1' LIMIT 1" );
                                                $ta_markup_data->execute();
                                                $ta_markup = $ta_markup_data->fetch();

                                                $total_price = $ta_markup['selling_price'] ?? $total_base_price;
                                            } else {
                                                $total_price = $total_base_price;
                                            }

                                            echo'
                                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                                    <div class="package-card">
                                                        <div class="package-img imgEffect4">
                                                            <a href="#" onclick=\'viewPackage("' .$row['id']. '")\'>
                                                                <img src="../'.$value['image'].'" alt="BizzMirth">
                                                            </a>
                                                        </div>
                                                        <div class="package-content">
                                                            <h4 class="area-name">
                                                                <a href="#" onclick=\'viewPackage("' .$row['id']. '")\'>'.$row['name'].'</a>
                                                            </h4>
                                                            <div class="location">
                                                                <i class="ri-map-pin-line"></i>
                                                                <div class="name">'.$row['destination'].'</div>
                                                            </div>
                                                            <div class="packages-person">
                                                                <div class="count">
                                                                    <i class="ri-time-line"></i>
                                                                    <p class="pera">'.$row['location'].'</p>
                                                                </div>
                                                            </div>
                                                            <div class="price-review">
                                                                <div class="d-flex gap-10">
                                                                    <p class="light-pera">From</p>
                                                                    <p class="pera"><span>&#8377</span>'.$total_price.'</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ End-of Destination -->
        </main>

        <!-- Footer S t a r t -->
            <?php include_once "footer_blog.php" ?>
        <!--/ End-of Footer -->

        <!-- Scroll Up  -->
        <div class="progressParent" id="back-top">
            <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
        <!-- Add an search-overlay element -->
        <div class="search-overlay"></div>
        <!-- jquery-->
        <script src="../assets/js/jquery-3.7.0.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap-5.3.0.min.js"></script>
        <!-- Plugin -->
        <script src="../assets/js/plugin.js"></script>
        <!-- Main js-->
        <script src="../assets/js/main.js"></script>
        <script type="../text/javascript" src="logout/logout.js"></script>
        <script>
            function viewPackage(id)
            { 
                window.location.href='../tour-details.php?pacId='+id;  
            }
        </script>
    </body>
</html>