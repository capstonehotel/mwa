<?php
// $connection = new mysqli('localhost', 'root', '', 'hmsystemdb');
require_once("../../includes/initialize.php");
require_once("../../includes/config.php");

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$code = $_GET['code'];

if ($action === 'confirm_delete') {
    $sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE = '$code'";
    $sql2 = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE = '$code'";

    if (mysqli_query($connection, $sql) && mysqli_query($connection, $sql2)) {
        echo 'Executed PHP Code';
        echo '<script>
            Swal.fire({
                title: "Deleted!",
                text: "The reservation has been deleted.",
                icon: "success"
            }).then(() => {
                window.location.href = "index.php?confirm=true&code=' . $code . '";
            });
            </script>';
    } else {
        
        echo '<script>
            Swal.fire({
                title: "Error!",
                text: "Error on deleting the reservation.",
                icon: "error"
            }).then(() => {
                window.location.href = "index.php";
            });
            </script>';
    }
}
?>
