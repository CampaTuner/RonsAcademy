<?php
include("../common/db.php");
session_start();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['register'])) {
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_FILES['avatar']) || !isset($_POST['terms'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: /websites/RonsAcademy/?register=true"); // Redirect back
        exit();
    }

    $username = test_input($_POST['username']);
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $avatar = $_FILES['avatar'];

    $avatarName = uniqid() . "_" . basename($avatar['name']);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $avatarName;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $_SESSION['error'] = "Email already exists! Please use a different email.";
        header("location: /websites/RonsAcademy/?register=true");
        exit();
    } else {
        // if email not exists then only upload images
        if (!move_uploaded_file($avatar["tmp_name"], $targetFile)) {
            $_SESSION['error'] = "Failed to upload profile picture!";
            header("Location: /websites/RonsAcademy/?register=true"); // Redirect back
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO `users` (username, email, password, avatar, isAdmin) VALUES (?,?,?,?,?)");
        $isAdmin = 0;
        $stmt->bind_param("ssssi", $username, $email, $hashedPassword, $avatarName, $isAdmin);

        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success'] = "Registration Successfull! You can now login.";
            header("location: /websites/RonsAcademy/?login=true");
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("location: /websites/RonsAcademy/?register=true");
        }
    }

    $stmt->close();
    $conn->close();
} else if (isset($_POST['login'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: /websites/RonsAcademy/?login=true"); // Redirect back
        exit();
    }

    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, avatar, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $avatar, $hashedPassword);
        $stmt->fetch();

        // ✅ Verify hashed password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['avatar'] = $avatar;  // ✅ Store avatar in session
            $_SESSION['success'] = "Login successful!";
            header("Location: /websites/RonsAcademy/"); // Redirect to home
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password!";
        }
    } else {
        $_SESSION['error'] = "Email not found!";
    }

    header("Location: /websites/RonsAcademy/?login=true");
    exit();

    $conn->close();
} else if (isset($_GET['logout'])) {
    session_unset();
    header("location: /websites/RonsAcademy/?login=true");
} else if (isset($_POST['adminlogin'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: /websites/RonsAcademy/?adminlogin=true"); // Redirect back
        exit();
    }

    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, avatar, password, isAdmin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $avatar, $hashedPassword, $isAdmin);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            if ($isAdmin) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['avatar'] = $avatar;
                $_SESSION['isUserAdmin'] = true;
                $_SESSION['success'] = "Admin Login Successful!";

                header("Location: /websites/RonsAcademy/");
                exit();
            } else {
                $_SESSION['error'] = "You are not an admin!";
            }
        } else {
            $_SESSION['error'] = "Incorrect password!";
        }
    } else {
        $_SESSION['error'] = "Email not found!";
    }

    header("Location: /websites/RonsAcademy/?adminlogin=true");
    exit();

    $stmt->close();
    $conn->close();
} else if (isset($_POST['createCourse'])) {
    if (empty($_POST['title']) || empty($_POST['description']) || empty($_FILES['thumbnail']['name'])) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: /websites/RonsAcademy/?create=true");
        exit();
    }

    $title = ($_POST['title']);
    $description = ($_POST['description']);
    $thumbnail = $_FILES['thumbnail'];


    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxFileSize = 2 * 1024 * 1024;

    if (!in_array($thumbnail["type"], $allowedTypes)) {
        $_SESSION['error'] = "Invalid file type! Only JPG, PNG, GIF, and WEBP allowed.";
        header("Location: /websites/RonsAcademy/?create=true");
        exit();
    }

    if ($thumbnail["size"] > $maxFileSize) {
        $_SESSION['error'] = "File size too large! Max 2MB allowed.";
        header("Location: /websites/RonsAcademy/?create=true");
        exit();
    }

    $thumbnailName = uniqid() . "_" . basename($thumbnail['name']);
    $targetDir = "courses/";
    $targetFile = $targetDir . $thumbnailName;

    if (!move_uploaded_file($thumbnail["tmp_name"], $targetFile)) {
        $_SESSION['error'] = "Failed to upload thumbnail!";
        header("Location: /websites/RonsAcademy/?create=true");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO `courses` (title, description, thumbnail) VALUES (?,?,?)");
    $stmt->bind_param("sss", $title, $description, $thumbnailName);

    if ($stmt->execute()) {
        $_SESSION['success'] = "New Course Uploaded Successfully!";
        header("location: /websites/RonsAcademy/");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("location: /websites/RonsAcademy/?create=true");
        exit();
    }
} // Handle account updates
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        $_SESSION['error'] = "Unauthorized access!";
        header("Location: /websites/RonsAcademy/?login=true");
        exit();
    }

    switch ($_POST['action']) {
        case 'update_username':
            $newUsername = test_input($_POST['new_username']);
            if (empty($newUsername)) {
                $_SESSION['error'] = "Username cannot be empty!";
            } else {
                $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt->bind_param("si", $newUsername, $userId);
                if ($stmt->execute()) {
                    $_SESSION['username'] = $newUsername;
                    $_SESSION['success'] = "Username updated successfully!";
                } else {
                    $_SESSION['error'] = "Failed to update username!";
                }
            }
            break;

        case 'update_email':
            $newEmail = test_input($_POST['new_email']);
            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format!";
            } else {
                // Check for duplicate email
                $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $checkStmt->bind_param("si", $newEmail, $userId);
                $checkStmt->execute();
                $checkStmt->store_result();
                if ($checkStmt->num_rows > 0) {
                    $_SESSION['error'] = "Email already in use!";
                } else {
                    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
                    $stmt->bind_param("si", $newEmail, $userId);
                    if ($stmt->execute()) {
                        $_SESSION['success'] = "Email updated successfully!";
                    } else {
                        $_SESSION['error'] = "Failed to update email!";
                    }
                }
            }
            break;

        case 'update_password':
            $currentPassword = test_input($_POST['current_password']);
            $newPassword = test_input($_POST['new_password']);

            if (empty($currentPassword) || empty($newPassword)) {
                $_SESSION['error'] = "Both current and new password are required!";
                break;
            }

            $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

        case 'update_password':
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];

            $getStmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
            $getStmt->bind_param("i", $userId);
            $getStmt->execute();
            $getStmt->bind_result($hashedPassword);
            $getStmt->fetch();
            $getStmt->close();

            if (!password_verify($currentPassword, $hashedPassword)) {
                $_SESSION['error'] = "Current password is incorrect!";
            } else {
                $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $updateStmt->bind_param("si", $newHashed, $userId);
                if ($updateStmt->execute()) {
                    $_SESSION['success'] = "Password updated successfully!";
                } else {
                    $_SESSION['error'] = "Failed to update password!";
                }
                $updateStmt->close();
            }
            header("Location: ../?account=true");
            exit();


        case 'delete_account':
            if (isset($stmt)) $stmt->close();
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            if ($stmt->execute()) {
                session_destroy();
                header("Location: /websites/RonsAcademy/?register=true");
                exit();
            } else {
                $_SESSION['error'] = "Failed to delete account!";
                header("Location: ../?account=true");
                exit();
            }
            break;
    }

    header("Location: ../?account=true");
    exit();
}
