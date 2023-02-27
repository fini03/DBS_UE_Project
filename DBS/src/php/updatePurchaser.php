 <?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

$purchaser_id = $first_name = $last_name = $email_address = '';
$success = '';
$help = false;

if(isset($_POST['purchaser_id'])){
    $purchaser_id = $_POST['purchaser_id'];
    $help = true;
}
if(isset($_POST['first_name'])){
    $first_name = $_POST['first_name'];
    $help = true;
}
if(isset($_POST['last_name'])){
    $last_name = $_POST['last_name'];
    $help = true;
}
if(isset($_POST['email_address'])){
    $email_address = $_POST['email_address'];
    $help = true;
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

            input[type="text"],
            select {
                width: 50%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            input[type="number"] {
                width: 50%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .button {
                display: inline-block;
                border-radius: 12px;
                background-color: #8f6edf;
                border: none;
                color: #ffffff;
                text-align: center;
                font-size: 20px;
                padding: 20px;
                width: 240px;
                transition: all 0.5s;
                cursor: pointer;
                margin: 10px;
            }

            .button span {
                cursor: pointer;
                display: inline-block;
                position: relative;
                transition: 0.5s;
            }

            .button span:after {
                content: "\00bb";
                position: absolute;
                opacity: 0;
                top: 0;
                right: -20px;
                transition: 0.5s;
            }

            .button:hover span {
                padding-right: 25px;
            }

            .button:hover span:after {
                opacity: 1;
                right: 0;
            }

            form {
                text-align: center;
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
                margin: 0 10em;
            }
        </style>
    </head>

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
        <body>
            <?php
if(!($database->emptyString($purchaser_id))) {
    $database->updatePurchaser($purchaser_id, $first_name, $last_name, $email_address, $success);
    $purchaser_array = $database->searchPurchaser($purchaser_id);
    if($success && !empty($purchaser_array)){ ?>
            <div class="container">
                <div class="row">
                    <h4>Purchaser successfully updated!</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email address</th>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($purchaser_array as $purchaser) : ?>
                            <tr>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <td>
                                                <a href="Purchaser.php?purchaser_id=<?php echo $purchaser['PURCHASER_ID'] ?>">
                                                    <?php echo $purchaser['PURCHASER_ID'];?>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="col"><?php echo $purchaser['FIRST_NAME']; ?></div>
                                            </td>
                                            <td>
                                                <div class="col"><?php echo $purchaser['LAST_NAME']; ?></div>
                                            </td>
                                            <td>
                                                <div class="col"><?php echo $purchaser['EMAIL_ADDRESS']; ?></div>
                                            </td>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } else { ?>
            <div class="container">
                <div class="row">
                    <t style="color: red;"><?php echo "Error can't update Purchaser with ID: '{$purchaser_id}'!"; ?></t>
                </div>
            </div>
            <?php
        }
} else if($help) { ?>
            <div class="container">
                <div class="row">
                    <t style="color: red;"><?php echo "Error can't update Purchaser with ID: '{$purchaser_id}'!"; ?></t>
                </div>
            </div>
            <?php

} ?>

            <section>
                <div class="container">
                    <div class="row">
                        <h2>Update Purchaser Form</h2>
                    </div>
                    <form method="post" action="updatePurchaser.php">
                        <div>
                            <label for="new_id">ID<sup style="color: red;">*</sup></label>
                        </div>
                        <br />
                        <div><input id="new_id" name="purchaser_id" type="text" maxlength="100" placeholder="Your ID..." /></div>
                        <br />
                        <div>
                            <label for="new_frist_name">First Name<sup style="color: red;">*</sup></label>
                        </div>
                        <br />
                        <div><input id="new_frist_name" name="first_name" type="text" maxlength="100" placeholder="Your first name..." /></div>
                        <br />

                        <div>
                            <label for="new_last_name">Last Name<sup style="color: red;">*</sup></label>
                        </div>
                        <br />
                        <div><input id="new_last_name" name="last_name" type="text" maxlength="100" placeholder="Your last name..." /></div>
                        <br />

                        <div>
                            <label for="new_email_address">Email address<sup style="color: red;">*</sup></label>
                        </div>
                        <br />
                        <div><input id="new_email_address" name="email_address" type="text" maxlength="100" placeholder="Your email address..." /></div>
                        <br />
                        <p><sup style="color: red;">*</sup>MUSTFILL</p>

                        <div>
                            <button class="button"><span>Update Purchaser</span></button>
                        </div>
                    </form>
                </div>
            </section>
            <br />
            <footer class="footer">
                <p>Copyright &copy; DBS 2022</p>
            </footer>
        </body>
    </section>
</html>
