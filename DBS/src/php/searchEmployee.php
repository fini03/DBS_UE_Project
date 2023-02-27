<?php

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

$employee_id = $first_name = $last_name = $email_address = $phone_number = $supervisor_id = null;
$success = '';

if (isset($_POST['employee_id'])) {
  $employee_id = $_POST['employee_id'];
}
if (isset($_POST['first_name'])) {
  $first_name = $_POST['first_name'];
}
if (isset($_POST['last_name'])) {
  $last_name = $_POST['last_name'];
}
if (isset($_POST['email_address'])) {
  $email_address = $_POST['email_address'];
}
if (isset($_POST['phone_number'])) {
  $phone_number = $_POST['phone_number'];
}
if (isset($_POST['supervisor_id'])) {
  $supervisor_id = $_POST['supervisor_id'];
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

    function deleteRow(r) {
      if (!confirm("Are you sure you want to delete?")) return;

      let formData = new FormData();
      formData.append("employee_id", r.dataset.employeeId);
      fetch("deleteEmployee.php", {
        body: formData,
        method: "POST",
      }).then((result) => {
        console.log(result);
        if (!result.ok) return;
        var d = r.parentNode.parentNode;
        d.parentNode.removeChild(d);
      });
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
    <?php
    if (!($database->emptyString($employee_id)) || !($database->emptyString($first_name)) || !($database->emptyString($last_name)) || !($database->emptyString($email_address)) || !($database->emptyString($phone_number)) || !($database->emptyString($supervisor_id))) {
      $employee_array = $database->adSearchEmployee($employee_id, $first_name, $last_name, $email_address, $phone_number, $supervisor_id, $success);
      if ($success && !empty($employee_array)) { ?>
        <div class="container">
          <div class="row">
            <h4>Employee Search Result:</h4>
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
                        <th>Phone number</th>
                        <th>SupervisorID</th>
                        <th>Delete</th>
                      </div>
                    </div>
                  </div>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($employee_array as $employee): ?>
                  <tr>
                    <div class="container">
                      <div class="row">
                        <div class="col">
                          <td>
                            <a href="Employee.php?employee_id=<?php echo $employee['EMPLOYEE_ID'] ?>">
                              <?php echo $employee['EMPLOYEE_ID']; ?>
                            </a>
                          </td>
                        </div>
                        <td>
                          <div class="col">
                            <?php echo $employee['FIRST_NAME']; ?>
                          </div>
                        </td>
                        <td>
                          <div class="col"><?php echo $employee['LAST_NAME']; ?></div>
                        </td>
                        <td>
                          <div class="col">
                            <?php echo $employee['EMAIL_ADDRESS']; ?>
                          </div>
                        </td>
                        <td>
                          <div class="col"><?php echo $employee['PHONE_NUMBER']; ?></div>
                        </td>
                        <td>
                          <div class="col">
                            <a href="Employee.php?employee_id=<?php echo $employee['SUPERVISOR_ID'] ?>">
                              <?php echo $employee['SUPERVISOR_ID']; ?>
                            </a>
                          </div>
                        </td>
                        <td><button onclick="deleteRow(this)" class="fa fa-trash"
                            data-employee-id="<?php echo $employee['EMPLOYEE_ID'] ?>"
                            style="font-size: 17px; color: #ff1a1a; text-decoration: none;"></button></td>
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
            <t style="color: red;">
              <?php echo "Employee not found!"; ?>
            </t>
          </div>
        </div>
        <?php
      }
    } ?>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <h2>Search Employee Form</h2>
      </div>
      <form method="post" action="searchEmployee.php">
        <div><label for="new_id">ID</label></div>
        <br />
        <div><input id="new_id" name="employee_id" type="text" maxlength="100" placeholder="Your ID..." /></div>
        <br />
        <div><label for="new_frist_name">First Name</label></div>
        <br />
        <div><input id="new_frist_name" name="first_name" type="text" maxlength="100"
            placeholder="Your first name..." /></div>
        <br />

        <div><label for="new_last_name">Last Name</label></div>
        <br />
        <div><input id="new_last_name" name="last_name" type="text" maxlength="100" placeholder="Your last name..." />
        </div>
        <br />

        <div><label for="new_email_address">Email address</label></div>
        <br />
        <div><input id="new_email_address" name="email_address" type="text" maxlength="100"
            placeholder="Your email address..." /></div>
        <br />

        <div><label for="new_phone_number">Phone number</label></div>
        <br />
        <div><input id="new_phone_number" name="phone_number" type="text" maxlength="100"
            placeholder="Your phone number" /></div>
        <br />

        <div><label for="new_supervisor_id">SupervisorID</label></div>
        <br />
        <div><input id="new_supervisor_id" name="supervisor_id" type="number" placeholder="Number" /></div>
        <br />

        <div>
          <button class="button"><span>Search Employee</span></button>
        </div>
      </form>
    </div>
  </section>
  <br />
  <footer class="footer">
    <p>Copyright &copy; DBS 2022</p>
  </footer>
</body>

</html>