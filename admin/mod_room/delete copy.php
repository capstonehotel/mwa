<?php
echo '<script src="../sweetalert.js"></script>';
// Check if 'id' is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tblreservation WHERE ROOMID = $id";

// Execute the DELETE statement
if ($connection->query($sql) === TRUE) {
    $sql1 = "DELETE FROM tblroom WHERE ROOMID = $id";
    if ($connection->query($sql1) === TRUE) {
    //   echo '<script>alert("Deleting successfully.");</script>';
    // echo '<script>window.location.href = "index.php";</script>';
    //  echo "<script>
    //                  swal({
    //                      title: 'Success!',
    //                      text: 'Deleting successfully.',
    //                      icon: 'success'
    //                  }).then(() => {
    //                      window.location.href = 'index.php';
    //                  });
    //                </script>";

    echo '<script>
    function confirmDelete() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this item!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // User clicked "Yes", proceed with deletion
                deleteRecord();
            } else {
                // User clicked "Cancel", do nothing
            }
        });
    }

    function deleteRecord() {
        // PHP script to delete the record
        window.location.href = "delete.php?id=' . $id . '"; // Replace with your PHP file handling deletion
    }
  </script>';

// Execute the DELETE statements only if confirmed
echo '<script>
    confirmDelete(); // Call the confirmation dialog
  </script>';


  

    
    }else{
      // echo '<script>alert("Deleting unsuccessful.");</script>';
      // echo '<script>window.location.href = "index.php";</script>';
      echo "<script>
                    swal({
                        title: 'Error!',
                        text: 'Deleting unsuccessful.',
                        icon: 'error'
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                  </script>";
    }
} else {
    // echo '<script>alert("Deleting unsuccessful.");</script>';
    // echo '<script>window.location.href = "index.php";</script>';
    echo "<script>
    swal({
        title: 'Error!',
        text: 'Deleting unsuccessful.',
        icon: 'error'
    }).then(() => {
        window.location.href = 'index.php';
    });
  </script>";
}

// Close the connection
$connection->close();
// <script>alert("An error occurred while preparing the DELETE statement.");</script>';
}
?>
