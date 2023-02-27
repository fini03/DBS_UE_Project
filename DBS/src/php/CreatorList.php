<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

if (isset($_GET['purchaser_id'])) {
    $purchaser_id = $_GET['purchaser_id'];
}
if(isset($_GET['first_name'])){
    $first_name = $_GET['first_name'];
}
if(isset($_GET['last_name'])){
    $last_name = $_GET['last_name'];
}
if(isset($_GET['email_address'])){
    $email_address = $_GET['email_address'];
}
if(isset($_GET['content'])){
    $status = $_GET['content'];
}
if(isset($_GET['username'])){
    $nickname = $_GET['username'];
}
if(isset($_GET['start_date'])){
    $last_upload = $_GET['start_date'];
}
$creator_array = $database->selectCreator();
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
                    <a href="CreatorList.php" class="active">Creator</a>
                    <a href="EmployeeList.php">Employee</a>
                    <a href="ItemList.php">Item</a>
                    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </nav>
            <div class="middle">
                <h1>DATENBANKENSYSTEME</h1>
                <hr>
                <p>univie 2022</p>
            </div>
        </div>
        <section>
            <h2>Creator List</h2>

            <p>Click on the ID to see the creator-info.</p>
            <br />
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Username</th>
                    <th>Content</th>
                    <th>Start Date</th>
                </tr>

                <?php foreach ($creator_array as $creator) : ?>
                  <tr>
                      <div class="container">
                          <div class="row">
                              <td>
                                  <div class="col">
                                      <a style="color: #5f2fd1;" href="Creator.php?purchaser_id=<?php echo $creator['PURCHASER_ID'] ?>"><?php echo $creator['PURCHASER_ID'];?></a>
                                  </div>
                              </td>
                              <td>
                                  <div class="col"><?php echo $creator['FIRST_NAME'];?></div>
                              </td>
                              <td>
                                  <div class="col"><?php echo $creator['LAST_NAME']; ?></div>
                              </td>
                              <td>
                                  <div class="col"><?php echo $creator['EMAIL_ADDRESS']; ?></div>
                              </td>
                              <td>
                                  <div class="col"><?php echo $creator['USERNAME']; ?></div>
                              </td>
                              <td>
                                  <div class="col"><?php echo $creator['CONTENT']; ?></div>
                              </td>
                              <td>
                                  <div class="col"><?php echo $creator['START_DATE'];?></div>
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

