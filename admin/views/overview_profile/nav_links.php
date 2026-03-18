<nav role="navigation">
    <ul class="nav nav-underline " role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#overview">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#activities">Activities</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#teams">Team</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#payout">Payout</a>
        </li>
        <?php 
            if($DBtable == 'ca_customer'){
        ?>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#Coupon">Coupons</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#t_c">Terms And Conditions</a>
        </li>
        <?php 
            } 
        ?>
        <?php if ($DBtable == 'sub_franchisee' || $DBtable == 'institution') { ?>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#s_p">Upgrade History</a>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#editLogs">Edit History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#transferLogs">Transfer History</a>
        </li>

    </ul>
</nav>