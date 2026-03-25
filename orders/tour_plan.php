<?php
    $data4 = $conn->prepare("SELECT * FROM package_trip_days WHERE package_id = $id");
    $data4->execute();
    $data4->setFetchMode(PDO::FETCH_ASSOC);

    if ($data4->rowCount() > 0) {
        foreach (($data4->fetchAll()) as $key_3 => $day) {
            $decription = $day['day_details'];
            $decription_1 = explode(".", $decription);
            $decription_2 = implode(".<br>", $decription_1);
            echo '<div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseOne"
                            aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseOne">
                            Day ' . ++$key_3 . ' - ' . $day['title'] . '
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne"
                        class="accordion-collapse collapse show"
                        aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            <ul class="listing">
                                <li class="list">
                                    ' . $decription_2 . '
                                </li>
                            </ul>
                            <hr style="border-top: 1px solid #4b5051" />
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-12 d-flex">
                                    <h6>Meal:&nbsp;</h6>
                                    <p>' . $day['meal_plan'] . '</p>
                                </div>
                                <div class="col-md-6 col-sm-12 col-12 d-flex">
                                    <h6>Transport:&nbsp;</h6>
                                    <p>' . $day['day_tansport'] . '</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    }
?>