<?php
require 'BuyerDB.php';
?>

<?php
class User {
    public function authenticate($username, $password) {
        global $conn;
        $sql = "SELECT * FROM buyer WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) {
                mysqli_close($conn);
                return true;
            } else {
                mysqli_close($conn);
                return false;
            }
        } else {
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_close($stmt);
    }
}
?>
