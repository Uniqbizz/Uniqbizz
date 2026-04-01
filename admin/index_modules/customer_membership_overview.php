<!-- Made table responsive 26-03-2026 -->
<!-- Membership overview  -->
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card rounded-4 shadow mb-3">
        <div class="card-body pt-2">
            <h3 class="text-dark pt-2">Membership Overview</h3>
            <hr>
            <div class="col-12 text-center">
                <div class="table-responsive">
                    <?php
                        // get custommer count base on membership selected 
                        $stmt = $conn->prepare("
                            SELECT 
                                COUNT(CASE WHEN customer_type = 'Free' THEN ca_customer_id END) AS free_customers,
                                COUNT(CASE WHEN customer_type = 'Premium' THEN ca_customer_id END) AS premium_customers,
                                COUNT(CASE WHEN customer_type = 'Premium plus' THEN ca_customer_id END) AS premium_plus_customers,
                                COUNT(CASE WHEN customer_type = 'Premium Select' THEN ca_customer_id END) AS premium_select_customers,
                                COUNT(CASE WHEN customer_type = 'Premium Select Lite' THEN ca_customer_id END) AS premium_select_lite_customers,
                                COUNT(CASE WHEN customer_type = 'neo select' THEN ca_customer_id END) AS neo_select_customers,
                                COUNT(CASE WHEN customer_type = 'neo select ultra' THEN ca_customer_id END) AS neo_select_ultra_customers
                            FROM ca_customer
                            WHERE user_type = '10' 
                            AND status = '1';
                        ");
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $free_customers = $row['free_customers'] ?? 0;
                        $premium_customers = $row['premium_customers'] ?? 0;
                        $premium_plus_customers = $row['premium_plus_customers'] ?? 0;
                        $premium_select_customers = $row['premium_select_customers'] ?? 0;
                        $premium_select_lite_customers = $row['premium_select_lite_customers'] ?? 0;
                        $neo_select_customers = $row['neo_select_customers'] ?? 0;
                        $neo_select_ultra_customers = $row['premium_select_lite_customers'] ?? 0;

                        // get custommer count base on membership selected and if complimentary
                        $stmt2 = $conn->prepare("
                            SELECT 
                                COUNT(CASE WHEN customer_type = 'Free' THEN ca_customer_id END) AS free_customers_comp,
                                COUNT(CASE WHEN customer_type = 'Premium' THEN ca_customer_id END) AS premium_customers_comp,
                                COUNT(CASE WHEN customer_type = 'Premium plus' THEN ca_customer_id END) AS premium_plus_customers_comp,
                                COUNT(CASE WHEN customer_type = 'Premium Select' THEN ca_customer_id END) AS premium_select_customers_comp,
                                COUNT(CASE WHEN customer_type = 'Premium Select Lite' THEN ca_customer_id END) AS premium_select_lite_customers_comp,
                                COUNT(CASE WHEN customer_type = 'neo select' THEN ca_customer_id END) AS neo_select_customers_comp,
                                COUNT(CASE WHEN customer_type = 'neo select ultra' THEN ca_customer_id END) AS neo_select_ultra_customers_comp
                            FROM ca_customer
                            WHERE user_type = '10' 
                            AND comp_chek = '1'
                            AND status = '1';
                        ");
                        $stmt2->execute();
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $free_customers_comp = $row2['free_customers_comp'] ?? 0;
                        $premium_customers_comp = $row2['premium_customers_comp'] ?? 0;
                        $premium_plus_customers_comp = $row2['premium_plus_customers_comp'] ?? 0;
                        $premium_select_customers_comp = $row2['premium_select_customers_comp'] ?? 0;
                        $premium_select_lite_customers_comp = $row2['premium_select_lite_customers_comp'] ?? 0;
                        $neo_select_customers_comp = $row2['neo_select_customers_comp'] ?? 0;
                        $neo_select_ultra_customers_comp = $row2['neo_select_ultra_customers_comp'] ?? 0;

                        // get custommer amount base on membership selected
                        $stmt3 = $conn->prepare("
                            SELECT 
                                SUM(CASE WHEN customer_type = 'Premium' THEN paid_amount END) AS premium_customers_amt,
                                SUM(CASE WHEN customer_type = 'Premium plus' THEN paid_amount END) AS premium_plus_customers_amt,
                                SUM(CASE WHEN customer_type = 'Premium Select' THEN paid_amount END) AS premium_select_customers_amt,
                                SUM(CASE WHEN customer_type = 'Premium Select Lite' THEN paid_amount END) AS premium_select_lite_customers_amt,
                                SUM(CASE WHEN customer_type = 'neo select' THEN paid_amount END) AS neo_select_customers_amt,
                                SUM(CASE WHEN customer_type = 'neo select ultra' THEN paid_amount END) AS neo_select_ultra_customers_amt
                            FROM ca_customer
                            WHERE user_type = '10' 
                            AND status = '1';
                        ");
                        $stmt3->execute();
                        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                        $premium_customers_amt = $row3['premium_customers_amt'] ?? 0;
                        $premium_plus_customers_amt = $row3['premium_plus_customers_amt'] ?? 0;
                        $premium_select_customers_amt = $row3['premium_select_customers_amt'] ?? 0;
                        $premium_select_lite_customers_amt = $row3['premium_select_lite_customers_amt'] ?? 0;
                        $neo_select_customers_amt = $row3['neo_select_customers_amt'] ?? 0;
                        $neo_select_ultra_customers_amt = $row3['neo_select_ultra_customers_amt'] ?? 0;
                    ?>
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="bg-dark-subtle fs-6">Type</th>
                                <th class="bg-dark-subtle">Value</th>
                                <th class="bg-dark-subtle text-end">Count</th>
                                <th class="bg-dark-subtle text-end">Complimentary</th>
                                <th class="bg-dark-subtle text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 align-content-center ps-2">Regular Customer</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6">&#8377; Free</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $free_customers; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $free_customers_comp; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-success fs-6 text-end">&#8377; Free</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 align-content-center ps-2">Premium Customer</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6">&#8377;30000</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_customers; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_customers_comp; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_customers_amt); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 align-content-center ps-2">Premium Plus Customer</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6">&#8377; 35,000</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_plus_customers; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_plus_customers_comp; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_plus_customers_amt); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 align-content-center ps-2">Premium Select</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6">&#8377; 35,000</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_select_customers; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_select_customers_comp; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_select_customers_amt); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 align-content-center ps-2">Premium Select Lite</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6">&#8377; 21,000</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_select_lite_customers; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $premium_select_lite_customers_comp; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($premium_select_lite_customers_amt); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 align-content-center ps-2">Neo Select</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6">&#8377; 11,000</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $neo_select_customers; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $neo_select_customers_comp; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($neo_select_customers_amt); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 align-content-center ps-2">Neo Select Ultra</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6">&#8377; 11,000</p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $neo_select_ultra_customers; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-dark fs-6 text-end"><?php echo $neo_select_ultra_customers_comp; ?></p>
                                </td>
                                <td class="py-2 align-content-center">
                                    <p class="text-success fs-6 text-end">&#8377; <?php echo formatIndianCurrency($neo_select_ultra_customers_amt); ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>