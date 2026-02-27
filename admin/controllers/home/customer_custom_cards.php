<div class="row">
    <!-- Customer Types -->
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-2">
        <div class="row">
            
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card rounded-4">
                    <div class="bg-primary-subtle rounded-top-4 p-3 pb-2 ">
                        <h5 class="text-primary-emphasis fw-bolder">Regular Customer</h5>
                        <h6 class="text-primary-emphasis">Free</h6>
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Count</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalRegularCustomer FROM `ca_customer` WHERE customer_type = 'Free' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalRegularCustomer = $row['totalRegularCustomer'];
                                            echo '<p class="text-end text-black">'.$totalRegularCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="fw-bolder text-black">Amount</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="text-black text-end">Free</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Complimentary</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalRegularCompCustomer FROM `ca_customer` WHERE customer_type = 'Free' AND comp_chek = '1' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalRegularCompCustomer = $row['totalRegularCompCustomer'];
                                            echo '<p class="text-end text-black">'.$totalRegularCompCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card rounded-4">
                    <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                        <h5 class="text-primary-emphasis fw-bolder">Premium Customer</h5>
                        <h6 class="text-primary-emphasis">Rs: 30,000</h6>
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Count</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCustomer FROM `ca_customer` WHERE customer_type = 'Premium' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumCustomer = $row['totalPremiumCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="fw-bolder text-black">Amount</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                            <?php
                                $Amt = 0;
                                $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium' AND status = '1'";
                                $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                $sqlTotalAmt->execute();
                                $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                if (($sqlTotalAmt->rowCount() > 0)) {
                                    foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                        $totalAmt = $value['paid_amount'];

                                        if ($totalAmt == 'null') {
                                            $totalAmt = 0;
                                        } else {
                                            $totalAmt;
                                        }

                                        $Amt = $Amt + $totalAmt;
                                    }
                                }
                                $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                echo '<p class="text-black text-end">'.$Amt.'</p>';
                            ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Complimentary</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium' AND comp_chek = '1' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumCompCustomer = $row['totalPremiumCompCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumCompCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card rounded-4">
                    <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                        <h5 class="text-primary-emphasis fw-bolder">Premium Plus Customer</h5>
                        <h6 class="text-primary-emphasis">Rs: 35,000</h6>
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Count</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumPlusCustomer FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumPlusCustomer = $row['totalPremiumPlusCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumPlusCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="fw-bolder text-black">Amount</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                            <?php
                                $Amt = 0;
                                $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND status = '1'";
                                $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                $sqlTotalAmt->execute();
                                $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                if (($sqlTotalAmt->rowCount() > 0)) {
                                    foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                        $totalAmt = $value['paid_amount'];

                                        if ($totalAmt == 'null') {
                                            $totalAmt = 0;
                                        } else {
                                            $totalAmt;
                                        }

                                        $Amt = $Amt + $totalAmt;
                                    }
                                }
                                $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                echo '<p class="text-black text-end">'.$Amt.'</p>';
                            ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Complimentary</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium Plus' AND comp_chek = '1' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumCompCustomer = $row['totalPremiumCompCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumCompCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card rounded-4">
                    <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                        <h5 class="text-primary-emphasis fw-bolder">Premium Select</h5>
                        <h6 class="text-primary-emphasis">Rs: 35,000</h6>
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Count</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumSelectCustomer = $row['totalPremiumSelectCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumSelectCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="fw-bolder text-black">Amount</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <?php
                                    $Amt = 0;
                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium Select' AND status = '1'";
                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                    $sqlTotalAmt->execute();
                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                            $totalAmt = $value['paid_amount'];

                                            if ($totalAmt == 'null') {
                                                $totalAmt = 0;
                                            } else {
                                                $totalAmt;
                                            }

                                            $Amt = $Amt + $totalAmt;
                                        }
                                    }
                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                ?>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Complimentary</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select' AND comp_chek = '1' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumSelectCompCustomer = $row['totalPremiumSelectCompCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumSelectCompCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card rounded-4">
                    <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                        <h5 class="text-primary-emphasis fw-bolder">Premium Select Lite</h5>
                        <h6 class="text-primary-emphasis">Rs: 21,000</h6>
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Count</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectLiteCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select Lite' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumSelectLiteCustomer = $row['totalPremiumSelectLiteCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumSelectLiteCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="fw-bolder text-black">Amount</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <?php
                                    $Amt = 0;
                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Premium Select Lite' AND status = '1'";
                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                    $sqlTotalAmt->execute();
                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                            $totalAmt = $value['paid_amount'];

                                            if ($totalAmt == 'null') {
                                                $totalAmt = 0;
                                            } else {
                                                $totalAmt;
                                            }

                                            $Amt = $Amt + $totalAmt;
                                        }
                                    }
                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                ?>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Complimentary</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalPremiumSelectLiteCompCustomer FROM `ca_customer` WHERE customer_type = 'Premium Select Lite' AND comp_chek = '1' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalPremiumSelectLiteCompCustomer = $row['totalPremiumSelectLiteCompCustomer'];
                                            echo '<p class="text-end text-black">'.$totalPremiumSelectLiteCompCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card rounded-4">
                    <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                        <h5 class="text-primary-emphasis fw-bolder">Neo Select</h5>
                        <h6 class="text-primary-emphasis">Rs: 11,000</h6>
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Count</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalNeoSelectCustomer = $row['totalNeoSelectCustomer'];
                                            echo '<p class="text-end text-black">'.$totalNeoSelectCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="fw-bolder text-black">Amount</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <?php
                                    $Amt = 0;
                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Neo Select' AND status = '1'";
                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                    $sqlTotalAmt->execute();
                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                            $totalAmt = $value['paid_amount'];

                                            if ($totalAmt == 'null') {
                                                $totalAmt = 0;
                                            } else {
                                                $totalAmt;
                                            }

                                            $Amt = $Amt + $totalAmt;
                                        }
                                    }
                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                ?>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Complimentary</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectCompCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select' AND comp_chek = '1' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalNeoSelectCompCustomer = $row['totalNeoSelectCompCustomer'];
                                            echo '<p class="text-end text-black">'.$totalNeoSelectCompCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card rounded-4">
                    <div class="bg-primary-subtle rounded-top-4 p-3 pb-2">
                        <h5 class="text-primary-emphasis fw-bolder">Neo Select Ultra</h5>
                        <h6 class="text-primary-emphasis">Rs: 11,000</h6>
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Count</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectUltraCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select Ultra' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalNeoSelectUltraCustomer = $row['totalNeoSelectUltraCustomer'];
                                            echo '<p class="text-end text-black">'.$totalNeoSelectUltraCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                <p class="fw-bolder text-black">Amount</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <?php
                                    $Amt = 0;
                                    $sqlCaAmt = "SELECT paid_amount FROM `ca_customer` WHERE customer_type = 'Neo Select Ultra' AND status = '1'";
                                    $sqlTotalAmt = $conn->prepare($sqlCaAmt);
                                    $sqlTotalAmt->execute();
                                    $sqlTotalAmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if (($sqlTotalAmt->rowCount() > 0)) {
                                        foreach ($sqlTotalAmt->fetchAll() as $key => $value) {
                                            $totalAmt = $value['paid_amount'];

                                            if ($totalAmt == 'null') {
                                                $totalAmt = 0;
                                            } else {
                                                $totalAmt;
                                            }

                                            $Amt = $Amt + $totalAmt;
                                        }
                                    }
                                    $Amt = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $Amt);
                                    echo '<p class="text-black text-end">'.$Amt.'</p>';
                                ?>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-8">
                                <p class="fw-bolder text-black">Complimentary</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-4">
                                <?php
                                    $stmt = $conn->prepare("SELECT COUNT(id) as totalNeoSelectUltraCompCustomer FROM `ca_customer` WHERE customer_type = 'Neo Select Ultra' AND comp_chek = '1' AND status = '1' ");
                                    $stmt->execute();
                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                    if ($stmt->rowCount() > 0) {
                                        foreach (($stmt->fetchAll()) as $key => $row) {
                                            $totalNeoSelectUltraCompCustomer = $row['totalNeoSelectUltraCompCustomer'];
                                            echo '<p class="text-end text-black">'.$totalNeoSelectUltraCompCustomer.'</p>';
                                        }
                                    } else {
                                        echo '<p class="text-end text-black">0</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'all_cu_emp_te_chart.php' ?>
</div> 