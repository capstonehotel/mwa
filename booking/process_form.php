<?php


// Include initialization script (database connection, etc.)
require_once("../includes/initialize.php"); 

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Initialize an array to hold errors
$errors = [];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate each input
    // 1. First Name
    if (empty($_POST['name'])) {
        $errors[] = "First Name is required.";
    } else {
        $name = sanitize_input($_POST['name']);
        if (!preg_match("/^[A-Za-z]{1,16}$/", $name)) {
            $errors[] = "First Name should contain only letters and up to 16 characters.";
        }
    }

    // 2. Last Name
    if (empty($_POST['last'])) {
        $errors[] = "Last Name is required.";
    } else {
        $last = sanitize_input($_POST['last']);
        if (!preg_match("/^[A-Za-z]{1,16}$/", $last)) {
            $errors[] = "Last Name should contain only letters and up to 16 characters.";
        }
    }

    // 3. Gender
    if (empty($_POST['gender'])) {
        $errors[] = "Gender is required.";
    } else {
        $gender = sanitize_input($_POST['gender']);
        $allowed_genders = ['Male', 'Female', 'Other'];
        if (!in_array($gender, $allowed_genders)) {
            $errors[] = "Invalid gender selected.";
        }
    }

    // 4. Date of Birth
    if (empty($_POST['dbirth'])) {
        $errors[] = "Date of Birth is required.";
    } else {
        $dbirth = sanitize_input($_POST['dbirth']);
        $dob = DateTime::createFromFormat('Y-m-d', $dbirth);
        if (!$dob) {
            $errors[] = "Invalid Date of Birth format.";
        } else {
            $today = new DateTime();
            $age = $today->diff($dob)->y;
            if ($age < 18) {
                $errors[] = "You must be at least 18 years old.";
            }
        }
    }

    // 5. Phone
    if (empty($_POST['phone'])) {
        $errors[] = "Phone number is required.";
    } else {
        $phone = sanitize_input($_POST['phone']);
        if (!preg_match("/^09\d{9}$/", $phone)) {
            $errors[] = "Phone number must start with '09' followed by 9 digits.";
        }
    }

    // 6. City
    if (!empty($_POST['city'])) {
        $city = sanitize_input($_POST['city']);
        if (!preg_match("/^[A-Za-z\s]{1,50}$/", $city)) {
            $errors[] = "City should contain only letters and spaces.";
        }
    } else {
        $city = NULL; // Optional field
    }

    // 7. Address
    if (empty($_POST['address'])) {
        $errors[] = "Address is required.";
    } else {
        $address = sanitize_input($_POST['address']);
        // Additional address validation can be added here
    }

    // 8. Zip Code
    if (empty($_POST['zip'])) {
        $errors[] = "Zip Code is required.";
    } else {
        $zip = sanitize_input($_POST['zip']);
        if (!preg_match("/^\d{4}$/", $zip)) {
            $errors[] = "Zip Code must be exactly 4 digits.";
        }
    }

    // 9. Nationality
    if (!empty($_POST['nationality'])) {
        $nationality = sanitize_input($_POST['nationality']);
        if (!preg_match("/^[A-Za-z\s]{1,17}$/", $nationality)) {
            $errors[] = "Nationality should contain only letters and spaces.";
        }
    } else {
        $nationality = NULL; // Optional field
    }

    // 10. Company
    if (empty($_POST['company'])) {
        $errors[] = "Company is required.";
    } else {
        $company = sanitize_input($_POST['company']);
        // Additional company validation can be added here
    }

    // 11. Company Address
    if (empty($_POST['caddress'])) {
        $errors[] = "Company Address is required.";
    } else {
        $caddress = sanitize_input($_POST['caddress']);
        // Additional company address validation can be added here
    }

    // 12. Email
    if (empty($_POST['username'])) {
        $errors[] = "Email is required.";
    } else {
        $email = sanitize_input($_POST['username']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
    }

    // 13. Password
    if (empty($_POST['pass'])) {
        $errors[] = "Password is required.";
    } else {
        $password = $_POST['pass']; // Passwords should not be sanitized to allow special characters
        // Validate password strength
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/", $password)) {
            $errors[] = "Password must be at least 6 characters long and include letters, numbers, and special characters.";
        }
    }

    // 14. Terms and Conditions
    if (empty($_POST['condition'])) {
        $errors[] = "You must agree to the Terms and Conditions.";
    }

    // If there are no errors, proceed to process the data
    if (empty($errors)) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Example: Insert data into the database using prepared statements to prevent SQL injection
        try {
            // Assuming you have a PDO instance named $pdo
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, gender, dob, phone, city, address, zip, nationality, company, company_address, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $name,
                $last,
                $gender,
                $dbirth,
                $phone,
                $city,
                $address,
                $zip,
                $nationality,
                $company,
                $caddress,
                $email,
                $hashed_password
            ]);

            // Success message or redirection
            $_SESSION['success'] = "Registration successful!";
            header("Location: success_page.php");
            exit();

        } catch (PDOException $e) {
            // Handle database errors
            $errors[] = "Database error: " . $e->getMessage();
        }
    }

    // If there are errors, store them in the session and redirect back to the form
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: booking_form.php"); // Replace with your form page
        exit();
    }
} else {
    // If the form was not submitted via POST, redirect to the form
    header("Location: booking_form.php"); // Replace with your form page
    exit();
}
?>
