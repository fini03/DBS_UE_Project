<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

if (isset($_GET['buys_id'])) {
  $purchase_id = $_GET['buys_id'];
}
if (isset($_GET['purchaser_id'])) {
  $user_id = $_GET['purchaser_id'];
}
if (isset($_GET['item_id'])) {
  $item_id = $_GET['item_id'];
}
if (isset($_GET['payment_method'])) {
  $payment_method = $_GET['payment_method'];
}
if (isset($_GET['license'])) {
  $license = $_GET['license'];
}
if (isset($_GET['purchase_date'])) {
  $purchase_date = $_GET['purchase_date'];
}
$purchase_array = $database->selectBuys();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body,
    html {
      height: 100%;
      margin: 0;
    }

    .bgimg {
      background-image: url('img/customer.jpg');
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
      border-bottom: 3px solid #5160D5;
      color: #fff;
    }

    .topnav a.active {
      border-bottom: 3px solid #93A6F5;
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
      background-color: #8F6EDF;
      color: #fff;
    }

    td {
      padding: 8px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    tr:hover {
      background-color: #9F83E4;
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
      background-color: #8F6EDF;
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
      <hr>
      <p>univie 2022</p>
    </div>
  </div>
  <section>
    <h2>Buys List</h2>

    <p>Click on the purchaserID to see the purchaser-info and on the itemID for the item-info.</p>

    <table>
      <tr>
        <th>ID</th>
        <th>PurchaserID</th>
        <th>ItemID</th>
        <th>Payment method</th>
        <th>License</th>
        <th>Purchase date</th>
      </tr>

      <?php foreach ($purchase_array as $p): ?>
        <tr>
          <div class="container">
            <div class="row">
              <td>
                <div class="col"><?php echo $p['BUYS_ID']; ?>
              </td>
            </div>
            <td>
              <div class="col"><a style="color: #5F2FD1"
                  href="Purchaser.php?purchaser_id=<?php echo $p['PURCHASER_ID'] ?>">
                  <?php echo $p['PURCHASER_ID']; ?>
                </a>
            </td>
          </div>
          <td>
            <div class="col"><a style="color: #5F2FD1" href="Item.php?item_id=<?php echo $p['ITEM_ID'] ?>">
                <?php echo $p['ITEM_ID']; ?>
              </a>
          </td>
          </div>
          <td>
            <div class="col">
              <?php echo $p['PAYMENT_METHOD']; ?>
          </td>
          </div>
          <td>
            <div class="col"><?php echo $p['LICENSE']; ?>
          </td>
          </div>
          <td>
            <div class="col">
              <?php echo $p['PURCHASE_DATE']; ?>
          </td>
          </div>
          </div>
          </div>
        </tr>
        <?php endforeach; ?>
    </table>
  </section>
  <!-- Footer -->
  <footer class="footer">
    <p>Copyright &copy; DBS 2022</p>
  </footer>

</body>

</html>