<?php

class DatabaseHelper
{
    const username = '';
    const password = '';
    const con_string = 'oracle19.cs.univie.ac.at:1521/orclcdb';

    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = @oci_connect(
                    DatabaseHelper::username,
                    DatabaseHelper::password,
                    DatabaseHelper::con_string
            );
            if (!$this->conn) {
                die("DB error: Connection can't be established!");
            }
        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    public function __destruct()
    {
        // clean up
        @oci_close($this->conn);
    }

    public function emptyString($string)
    {
        return ($string === null || trim($string) === '');
    }

    public function selectCreator()
    {
        $sql = "SELECT * FROM Purchaser INNER JOIN Creator USING (purchaser_id) ORDER BY purchaser_id";
        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);
        @oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        @oci_free_statement($statement);

        return $res;
    }

    public function selectPurchaser()
    {
        $sql = "SELECT * FROM Purchaser ORDER BY purchaser_id";
        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);
        @oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        @oci_free_statement($statement);

        return $res;
    }

    public function searchPurchaser($purchaser_id)
    {
        $sql = "SELECT * FROM Purchaser FULL OUTER JOIN Creator USING (purchaser_id) WHERE purchaser_id = $purchaser_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $res;
    }

    public function selectEmployee()
    {
        $sql = "SELECT * FROM Employee ORDER BY employee_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $res;
    }

    public function searchEmployee($employee_id)
    {
        $sql = "SELECT * FROM employee WHERE employee_id = $employee_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }
    public function searchSupervisor($employee_id)
    {
        $sql = "SELECT s.* FROM Employee e INNER JOIN Employee s ON e.supervisor_id LIKE s.employee_id AND e.employee_id = $employee_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }

    public function selectItems($employee_id)
    {
        $sql = "SELECT * FROM Item WHERE employee_id = $employee_id ORDER BY item_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }

    public function insertIntoEmployee($first_name, $last_name, $email_address, $phone_number, $supervisor_id, &$success)
    {
        $sql = "INSERT INTO Employee (first_name, last_name, email_address, phone_number, supervisor_id) VALUES ('{$first_name}', '{$last_name}', '{$email_address}', '{$phone_number}', '{$supervisor_id}')";
        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);

        $sql2 = "SELECT * FROM Employee WHERE email_address = '$email_address'";
        $statement = oci_parse($this->conn, $sql2);

        oci_execute($statement);
        oci_fetch_all($statement, $output, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        oci_free_statement($statement);
        return $output;
    }

    public function deleteEmployee($employee_id, &$success)
    {
        $sql = "DELETE FROM Employee WHERE (employee_id = :employee_id)";
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':employee_id', $employee_id);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
    }

    public function updateEmployee($employee_id, $first_name, $last_name, $email_address, $phone_number, $supervisor_id, &$success)
    {
        $help = false;
        if (!$this->emptyString($first_name)) {
            $sql = "UPDATE Employee SET first_name = :first_name WHERE (employee_id = :employee_id)";
            $statement = oci_parse($this->conn, $sql);
            oci_bind_by_name($statement, ':first_name', $first_name);
            oci_bind_by_name($statement, ':employee_id', $employee_id);
            oci_execute($statement);
            $help = true;
        }
        if (!$this->emptyString($last_name)) {
            $sql2 = "UPDATE Employee SET last_name = :last_name WHERE (employee_id = :employee_id)";
            $statement = oci_parse($this->conn, $sql2);
            oci_bind_by_name($statement, ':last_name', $last_name);
            oci_bind_by_name($statement, ':employee_id', $employee_id);
            oci_execute($statement);
            $help = true;
        }
        if (!$this->emptyString($email_address)) {
            $sql3 = "UPDATE Employee SET email_address = :email_address WHERE (employee_id = :employee_id)";
            $statement = oci_parse($this->conn, $sql3);
            oci_bind_by_name($statement, ':email_address', $email_address);
            oci_bind_by_name($statement, ':employee_id', $employee_id);
            oci_execute($statement);
            $help = true;
        }
        if (!$this->emptyString($phone_number)) {
            $sql4 = "UPDATE Employee SET phone_number = :phone_number WHERE (employee_id = :employee_id)";
            $statement = oci_parse($this->conn, $sql4);
            oci_bind_by_name($statement, ':phone_number', $phone_number);
            oci_bind_by_name($statement, ':employee_id', $employee_id);
            oci_execute($statement);
            $help = true;
        }
        if (!$this->emptyString($supervisor_id)) {
            $sql7 = "UPDATE Employee SET supervisor_id = :supervisor_id WHERE (employee_id = :employee_id)";
            $statement = oci_parse($this->conn, $sql7);
            oci_bind_by_name($statement, ':supervisor_id', $supervisor_id);
            oci_bind_by_name($statement, ':employee_id', $employee_id);
            oci_execute($statement);
            $help = true;
        }
        if ($help) {
            $success = oci_execute($statement) && oci_commit($this->conn);
            oci_close($this->conn);
        }
    }

    public function adSearchEmployee($employee_id, $first_name, $last_name, $email_address, $phone_number, $supervisor_id, &$success)
    {
        $sql = "SELECT * FROM Employee WHERE (employee_id = :employee_id)
              OR upper(first_name) = upper (:first_name)
              OR upper(last_name) = upper (:last_name)
              OR upper(email_address) = upper (:email_address)
              OR upper(phone_number) = upper (:phone_number)
              OR upper(supervisor_id) = upper (:supervisor_id)";
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':employee_id', $employee_id);
        oci_bind_by_name($statement, ':first_name', $first_name);
        oci_bind_by_name($statement, ':last_name', $last_name);
        oci_bind_by_name($statement, ':email_address', $email_address);
        oci_bind_by_name($statement, ':phone_number', $phone_number);
        oci_bind_by_name($statement, ':supervisor_id', $supervisor_id);

        $success = oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $res;
    }

    public function selectItem()
    {
        $sql = "SELECT * FROM Item ORDER BY item_id";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $res;
    }

    public function searchItem($item_id)
    {
        $sql = "SELECT * FROM Item WHERE item_id = $item_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }

    public function searchCreatorItem($item_id)
    {
        $sql = "SELECT s.* FROM Item e INNER JOIN Creator s ON e.creator_id = s.purchaser_id AND e.item_id = $item_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }

    public function searchPhotoItem($item_id)
    {
        $sql = "SELECT s.* FROM Item e INNER JOIN Photo s ON e.item_id = s.photo_id AND e.item_id = $item_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }

    public function searchArtItem($item_id)
    {
        $sql = "SELECT s.* FROM Item e INNER JOIN Art s ON e.item_id = s.art_id AND e.item_id = $item_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }

    public function selectEmployeeItem($item_id)
    {
        $sql = "SELECT employee_id, first_name, last_name, email_address, phone_number, supervisor_id FROM Item NATURAL RIGHT OUTER JOIN Employee WHERE item_id = $item_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }

    public function selectBoughtItem($item_id)
    {
        $sql = "SELECT s.* FROM Item e INNER JOIN Buys s ON e.item_id = s.buys_id AND e.item_id = $item_id";
        $statement = oci_parse($this->conn, $sql);

        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $result;
    }
    public function selectBuys()
    {
        $sql = "SELECT * FROM Buys ORDER BY buys_id";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);
        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $res;
    }


    public function insertIntoPurchaser($first_name, $last_name, $email_address, &$success)
    {
        $sql = "INSERT INTO Purchaser (first_name, last_name, email_address) VALUES ('{$first_name}', '{$last_name}', '{$email_address}')";
        $statement = oci_parse($this->conn, $sql);
        $success = oci_execute($statement) && oci_commit($this->conn);

        $sql2 = "SELECT * FROM Purchaser WHERE email_address = '$email_address'";
        $statement = oci_parse($this->conn, $sql2);

        oci_execute($statement);
        oci_fetch_all($statement, $output, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $output;
    }

    public function deletePurchaser($purchaser_id, &$success)
    {
        $sql = "DELETE FROM Purchaser WHERE (purchaser_id = :purchaser_id)";
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':purchaser_id', $purchaser_id);
        $success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
    }

    public function updatePurchaser($purchaser_id, $first_name, $last_name, $email_address, &$success)
    {
        $help = false;
        if (!$this->emptyString($first_name)) {
            $sql = "UPDATE Purchaser SET first_name = :first_name WHERE (purchaser_id = :purchaser_id)";
            $statement = oci_parse($this->conn, $sql);
            oci_bind_by_name($statement, ':first_name', $first_name);
            oci_bind_by_name($statement, ':purchaser_id', $purchaser_id);
            oci_execute($statement);
            $help = true;
        }
        if (!$this->emptyString($last_name)) {
            $sql2 = "UPDATE Purchaser SET last_name = :last_name WHERE (purchaser_id = :purchaser_id)";
            $statement = oci_parse($this->conn, $sql2);
            oci_bind_by_name($statement, ':last_name', $last_name);
            oci_bind_by_name($statement, ':purchaser_id', $purchaser_id);
            oci_execute($statement);
            $help = true;
        }
        if (!$this->emptyString($email_address)) {
            $sql3 = "UPDATE Purchaser SET email_address = :email_address WHERE (purchaser_id = :purchaser_id)";
            $statement = oci_parse($this->conn, $sql3);
            oci_bind_by_name($statement, ':email_address', $email_address);
            oci_bind_by_name($statement, ':purchaser_id', $purchaser_id);
            oci_execute($statement);
            $help = true;
        }
        if ($help) {
            $success = oci_execute($statement) && oci_commit($this->conn);
            oci_close($this->conn);
        }
    }
    public function adSearchPurchaser($purchaser_id, $first_name, $last_name, $email_address, &$success)
    {
        $sql = "SELECT * FROM Purchaser WHERE (purchaser_id = :purchaser_id)
              OR upper(first_name) = upper (:first_name)
              OR upper(last_name) = upper (:last_name)
              OR upper(email_address) = upper (:email_address)";
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':purchaser_id', $purchaser_id);
        oci_bind_by_name($statement, ':first_name', $first_name);
        oci_bind_by_name($statement, ':last_name', $last_name);
        oci_bind_by_name($statement, ':email_address', $email_address);

        $success = oci_execute($statement);

        oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);

        return $res;
    }

    public function creator_stats($purchaser_id)
    {
        $procCount = $procSales = '';

        $sql = "BEGIN CreatorStats(:purchaser_id, :procCount, :procSales); END;";
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':purchaser_id', $purchaser_id, 100);
        oci_bind_by_name($statement, ':procCount', $procCount, 100);
        oci_bind_by_name($statement, ':procSales', $procSales, 100);
        oci_execute($statement);
        oci_commit($this->conn);

        $result = array($procCount, $procSales);

        oci_free_statement($statement);

        return $result;
    }
}
