<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

if(isset($_GET['item_id'])){
    $item_id = $_GET['item_id'];
    $item_array = $database->searchItem($item_id);
    $creator_array = $database->searchCreatorItem($item_id);
    $photo_array = $database->searchPhotoItem($item_id);
    $art_array = $database->searchArtItem($item_id);
    $employee_array = $database->selectEmployeeItem($item_id);
    $buy_array = $database->selectBoughtItem($item_id);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <style>
            body,
            html {
                height: 100%;
                margin: 0;
            }

            .bgimg {
                background-image: url("img/customer.jpg");
                height: 100%;
                background-position: center;
                background-size: cover;
                position: relative;
                color: white;
                font-family: "Courier New", Courier, monospace;
                font-size: 25px;
            }

            .topleft {
                position: absolute;
                top: 0;
                left: 16px;
            }

            .bottomleft {
                position: absolute;
                bottom: 0;
                left: 16px;
            }

            .middle {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }

            .topnav {
                overflow: hidden;
                background-color: transparent;
                width: 100%;
                float: left;
            }

            .topnav a {
                float: left;
                width: 345px;
                display: block;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
                color: #fff;
            }

            .topnav a:hover {
                border-bottom: 3px solid #5160d5;
                color: #fff;
            }

            .topnav a.active {
                border-bottom: 3px solid #93a6f5;
                color: #fff;
            }

            .topnav .icon {
                display: none;
            }

            @media screen and (max-width: 600px) {
                .topnav a:not(:first-child) {
                    display: none;
                }
                .topnav a.icon {
                    float: right;
                    display: block;
                }
            }

            @media screen and (max-width: 600px) {
                .topnav.responsive {
                    position: relative;
                }
                .topnav.responsive .icon {
                    position: absolute;
                    right: 0;
                    top: 0;
                }
                .topnav.responsive a {
                    float: none;
                    display: block;
                    text-align: left;
                }
            }

            table {
                border-collapse: collapse;
                margin: 0 10em;
                width: 80%;
            }

            th {
                padding: 8px;
                text-align: center;
                background-color: #8f6edf;
                color: #fff;
            }

            td {
                padding: 8px;
                text-align: center;
                border-bottom: 1px solid #ddd;
            }

            tr:hover {
                background-color: #9f83e4;
            }

            hr {
                padding: 1px;
                background-color: #fff;
            }

            section {
                text-align: center;
            }

            footer {
                text-align: center;
                padding: 3px;
                background-color: #8f6edf;
                color: white;
            }
        </style>
    </head>

    <body>
        <script>
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }
        </script>

        <div class="bgimg">
            <nav>
                <div class="topnav" id="myTopnav">
                    <a href="index.php">Home</a>
                    <a href="PurchaserList.php">Purchaser</a>
                    <a href="CreatorList.php">Creator</a>
                    <a href="EmployeeList.php">Employee</a>
                    <a href="ItemList.php">Item</a>
                    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </nav>
            <div class="middle">
                <h1>DATENBANKENSYSTEME</h1>
                <hr />
                <p>univie 2022</p>
            </div>
        </div>

        <section>
            <h2>Item-info</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Price</th>
                    <th>Max uploadsize</th>
                    <th>Upload date</th>
                    <th>CreatorID</th>
                </tr>

                <?php foreach ($item_array as $item) : ?>
                <tr>
                    <div class="container">
                        <div class="row">
                            <td>
                                <div class="col"><?php echo $item['ITEM_ID'];?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $item['PRICE'];?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $item['MAX_UPLOADSIZE']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $item['UPLOAD_DATE']; ?></div>
                            </td>
                            <td>
                                <div class="col">
                                    <a style="color: #5f2fd1;" href="Creator.php?purchaser_id=<?php echo $item['CREATOR_ID'] ?>"><?php echo $item['CREATOR_ID'];?></a>
                                </div>
                            </td>
                        </div>
                    </div>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <section>
            <h2>Photo-info</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Photo dimension</th>
                    <th>Name</th>
                    <th>Camera model</th>
                </tr>

                <?php foreach ($photo_array as $photo) : ?>
                <tr>
                    <div class="container">
                        <div class="row">
                            <td>
                                <div class="col"><?php echo $photo['PHOTO_ID'];?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $photo['PHOTO_DIMENSION']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $photo['NAME']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $photo['CAMERA_MODEL']; ?></div>
                            </td>
                        </div>
                    </div>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <section>
            <h2>Art-info</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Art dimension</th>
                    <th>Name</th>
                    <th>Art type</th>
                </tr>

                <?php foreach ($art_array as $art) : ?>
                <tr>
                    <div class="container">
                        <div class="row">
                            <td>
                                <div class="col"><?php echo $art['ART_ID'];?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $art['ART_DIMENSION']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $art['NAME']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $art['ART_TYPE']; ?></div>
                            </td>
                        </div>
                    </div>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <section>
            <h2>Employee-info</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>SupervisorID</th>
                </tr>

                <?php foreach ($employee_array as $employee) : ?>
                <tr>
                    <div class="container">
                        <div class="row">
                            <td>
                                <div class="col">
                                    <a style="color: #5f2fd1;" href="Employee.php?employee_id=<?php echo $employee['EMPLOYEE_ID'] ?>"><?php echo $employee['EMPLOYEE_ID'];?></a>
                                </div>
                            </td>
                            <td>
                                <div class="col"><?php echo $employee['FIRST_NAME'];?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $employee['LAST_NAME']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $employee['EMAIL_ADDRESS']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $employee['PHONE_NUMBER']; ?></div>
                            </td>
                            <td>
                                <div class="col">
                                    <a style="color: #5f2fd1;" href="Employee.php?employee_id=<?php echo $employee['SUPERVISOR_ID'] ?>">
                                        <?php echo $employee['SUPERVISOR_ID']; ?>
                                    </a>
                                </div>
                            </td>
                        </div>
                    </div>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <section>
            <h2>Bought-info</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>PurchaserID</th>
                    <th>Payment method</th>
                    <th>license</th>
                    <th>Purchase date</th>
                </tr>

                <?php foreach ($buy_array as $p) : ?>
                <tr>
                    <div class="container">
                        <div class="row">
                            <td>
                                <div class="col"><?php echo $p['BUYS_ID'];?></div>
                            </td>
                            <td>
                                <div class="col">
                                    <a style="color: #5f2fd1;" href="Purchaser.php?purchaser_id=<?php echo $p['PURCHASER_ID'] ?>"><?php echo $p['PURCHASER_ID'];?></a>
                                </div>
                            </td>
                            <td>
                                <div class="col"><?php echo $p['PAYMENT_METHOD']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $p['LICENSE']; ?></div>
                            </td>
                            <td>
                                <div class="col"><?php echo $p['PURCHASE_DATE']; ?></div>
                            </td>
                        </div>
                    </div>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
        <footer class="footer">
            <p>Copyright &copy; DBS 2022</p>
        </footer>
    </body>
</html>
