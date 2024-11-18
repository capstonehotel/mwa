<?php 
require_once("../../includes/initialize.php");

// Validate action parameter
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
    case 'add':
        doInsert();
        break;
    
    case 'edit':
        doEdit();
        break;
    
    case 'delete':
        doDelete();
        break;

    default:
        // Handle default case if needed
        break;
}

function doInsert() {
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and validate inputs
        $name = filter_input(INPUT_POST, 'ACCOMODATION', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'ACCOMDESC', FILTER_SANITIZE_STRING);

        if (empty($name) || empty($desc)) {
            message("All fields required!", "error");
            redirect("index.php?view=add");
        } else {
            $accomodation = new Accomodation();
            $accomodation->ACCOMODATION = $name;
            $accomodation->ACCOMDESC = $desc;

            // Create accommodation
            if ($accomodation->create()) {
                message("New [" . htmlspecialchars($name) . "] created successfully!", "success");
                redirect('index.php');
            } else {
                message("Failed to create accommodation!", "error");
                redirect("index.php?view=add");
            }
        }
    }
}

function doEdit() {
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and validate inputs
        $name = filter_input(INPUT_POST, 'ACCOMODATION', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'ACCOMDESC', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'ACCOMID', FILTER_VALIDATE_INT);

        if (empty($name) || empty($desc) || !$id) {
            message("All fields required!", "error");
            redirect("index.php?view=edit&id=" . $id);
        } else {
            $accomodation = new Accomodation();
            $accomodation->ACCOMODATION = $name;
            $accomodation->ACCOMDESC = $desc;

            // Update accommodation
            if ($accomodation->update($id)) {
                message("Accommodation [" . htmlspecialchars($name) . "] updated successfully!", "success");
                redirect('index.php');
            } else {
                message("Failed to update accommodation!", "error");
                redirect("index.php?view=edit&id=" . $id);
            }
        }
    }
}

function doDelete() {
    // Sanitize and validate the input
    $ids = filter_input(INPUT_POST, 'selector', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    
    if (!empty($ids)) {
        foreach ($ids as $id) {
            $accomodation = new Accomodation();
            if ($accomodation->delete(filter_var($id, FILTER_VALIDATE_INT))) {
                message("Accommodation deleted successfully!", "info");
            }
        }
    } else {
        message("No accommodation selected for deletion!", "error");
    }

    redirect('index.php');
}
?>