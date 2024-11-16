<?php 
require_once("../../includes/initialize.php");

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
    case 'add':
        doInsert();
        break;

    case 'edit':
        doEdit();
        break;

    case 'editimage':
        editImg();
        break;

    case 'delete':
        doDelete();
        break;
}

function doInsert() {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        message("No Image Selected or upload error!", "error");
        redirect("index.php?view=add");
    }

    $file = $_FILES['image'];
    $image_size = getimagesize($file['tmp_name']);

    if ($image_size === FALSE) {
        message("That's not an image!", "error");
        redirect("index.php?view=add");
    }

    // Validate and sanitize other input fields
    $roomNum = filter_input(INPUT_POST, 'ROOMNUM', FILTER_SANITIZE_STRING);
    $roomName = filter_input(INPUT_POST, 'ROOM', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'PRICE', FILTER_VALIDATE_FLOAT);
    $accomId = filter_input(INPUT_POST, 'ACCOMID', FILTER_SANITIZE_STRING);
    $roomDesc = filter_input(INPUT_POST, 'ROOMDESC', FILTER_SANITIZE_STRING);
    $numPerson = filter_input(INPUT_POST, 'NUMPERSON', FILTER_VALIDATE_INT);

    if (empty($roomNum) || empty($roomName) || $price === false) {
        message("All fields required!", "error");
        redirect("index.php?view=add");
    }

    $room = new Room();

    if ($room->find_all_room($roomName) >= 1) {
        message("Room name already exists!", "error");
        redirect("index.php?view=add");
    }

    // Securely handle file upload
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid('room_', true) . '.' . $extension; // Unique file name
    $location = "rooms/" . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $location)) {
        $room->ROOMNUM = $roomNum;
        $room->ROOM = $roomName;
        $room->ACCOMID = $accomId;
        $room->ROOMDESC = $roomDesc;
        $room->NUMPERSON = $numPerson;
        $room->PRICE = $price;
        $room->ROOMIMAGE = $location;

        if ($room->create()) {
            message("New [" . $roomName . "] created successfully!", "success");
            redirect('index.php');
        }
    } else {
        message("Failed to upload image!", "error");
        redirect("index.php?view=add");
    }
}

function doEdit() {
    $room = new Room();

    $room->ROOMNUM = filter_input(INPUT_POST, 'ROOMNUM', FILTER_SANITIZE_STRING);
    $room->ROOM = filter_input(INPUT_POST, 'ROOM', FILTER_SANITIZE_STRING);
    $room->ACCOMID = filter_input(INPUT_POST, 'ACCOMID', FILTER_SANITIZE_STRING);
    $room->ROOMDESC = filter_input(INPUT_POST, 'ROOMDESC', FILTER_SANITIZE_STRING);
    $room->NUMPERSON = filter_input(INPUT_POST, 'NUMPERSON', FILTER_VALIDATE_INT);
    $room->PRICE = filter_input(INPUT_POST, 'PRICE', FILTER_VALIDATE_FLOAT);

    $room->update(filter_input(INPUT_POST, 'ROOMID', FILTER_VALIDATE_INT));
    message($_POST['ROOM'] . " Updated successfully!", "success");
    unset($_SESSION['id']);
    redirect('index.php');
}

function doDelete() {
    $ids = filter_input(INPUT_POST, 'selector', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($ids) {
        foreach ($ids as $id) {
            $rm = new Room();
            $rm->delete(filter_var($id, FILTER_VALIDATE_INT));
        }
        message("Rooms deleted successfully!", "info");
    } else {
        message("No rooms selected for deletion!", "error");
    }
    redirect('index.php');
}

function editImg() {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        message("No Image Selected or upload error!", "error");
        redirect("index.php?view=list");
    }

    $file = $_FILES['image'];
    $image_size = getimagesize($file['tmp_name']);

    if ($image_size === FALSE) {
        message("That's not an image!", "error");
        redirect("index.php?view=list");
    }

    $rm = new Room();
    $rm_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    
    // Securely handle file upload
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid('room_', true) . '.' . $extension; // Unique file name
    $location = "rooms/" . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $location)) {
        $rm->ROOMIMAGE = $location;
        $rm->update($rm_id);
        message("Room Image Updated successfully!", "success");
        unset($_SESSION['id']);
        redirect("index.php");
    } else {
        message("Failed to upload image!", "error");
        redirect("index.php?view=list");
    }
}

function _deleteImage($catId) {
    $deleted = false;

    $sql = "SELECT * FROM room WHERE roomNo ";
    
    if (is_array($catId)) {
        $sql .= " IN (" . implode(',', array_map('intval', $catId)) . ")";
    } else {
        $sql .= " = " . intval($catId);
    }

    $result = dbQuery($sql);
    
    if (dbNumRows($result)) {
        while ($row = dbFetchAssoc($result)) {
            extract($row);
            $deleted = @unlink($roomImage);
        }
    }
    
    return $deleted;
}
?>