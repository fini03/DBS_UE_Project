<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

if (isset($_GET['item_id'])) {
  $item_id = $_GET['item_id'];
}
if (isset($_GET['price'])) {
  $price = $_GET['price'];
}
if (isset($_GET['max_uploadsize'])) {
  $max_size = $_GET['max_size'];
}
if (isset($_GET['upload_date'])) {
  $upload_date = $_GET['upload_date'];
}
if (isset($_GET['creator_id'])) {
  $creator_id = $_GET['creator_id'];
}
if (isset($_GET['employee_id'])) {
  $employee_id = $_GET['employee_id'];
}
$item_array = $database->selectItem();
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
                    <a href="ItemList.php" class="active">Item</a>
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
            <h2>Item List</h2>

            <p>Click on the ID to see the item-info.</p>
            <p>Click on the following icon to check the buys-list.</p>
            <section>
                <td>
                    <a href="BuysList.php" class="fa fa-shopping-cart" style="font-size: 50px; color: #551a8b; text-decoration: none;"></a>
                </td>
            </section>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Price</th>
                    <th>Max uploadsize</th>
                    <th>Upload date</th>
                    <th>CreatorID</th>
                </tr>

                <?php foreach ($item_array as $item): ?>
                <tr>
                    <div class="container">
                        <div class="row">
                            <td>
                                <div class="col">
                                    <a style="color: #5f2fd1;" href="Item.php?item_id=<?php echo $item['ITEM_ID'] ?>">
                                        <?php echo $item['ITEM_ID']; ?>
                                    </a>
                                </div>
                            </td>

                            <td>
                                <div class="col">
                                    <?php echo $item['PRICE']; ?>
                                </div>
                            </td>

                            <td>
                                <div class="col"><?php echo $item['MAX_UPLOADSIZE']; ?></div>
                            </td>

                            <td>
                                <div class="col">
                                    <?php echo $item['UPLOAD_DATE']; ?>
                                </div>
                            </td>

                            <td>
                                <div class="col">
                                    <a style="color: #5f2fd1;" href="Creator.php?purchaser_id=<?php echo $item['CREATOR_ID'] ?>">
                                        <?php echo $item['CREATOR_ID']; ?>
                                    </a>
                                </div>
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
