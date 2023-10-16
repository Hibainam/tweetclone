<?php
include '../core/init.php';
include '../core/welcome.php';
require_once '../core/classes/validation/Validator.php';
use validation\Validator;

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // Check if any of the input fields are empty
    if (empty($email) || empty($password) || empty($name) || empty($username)) {
        // Handle the case where any of the fields are empty
        $_SESSION['errors_signup'] = ['All fields are required'];
        header('location: ../index.php');
        exit();
    }

    // Sanitize input data
    $email = User::checkInput($email);
    $password = User::checkInput($password);
    $name = User::checkInput($name);
    $username = User::checkInput($username);

    // Validate input data
    $v = new Validator;
    $v->rules('name', $name, ['required', 'string', 'max:20']);
    $v->rules('username', $username, ['required', 'string', 'max:20']);
    $v->rules('email', $email, ['required', 'email']);
    $v->rules('password', $password, ['required', 'string', 'min:5']);
    $errors = $v->errors;

    if (empty($errors)) {
        // Further checks and registration logic
        $username = str_replace(' ', '', $username);

        if (User::checkEmail($email) === true) {
            $_SESSION['errors_signup'] = ['This email is already in use'];
        } elseif (User::checkUserName($username) === true) {
            $_SESSION['errors_signup'] = ['This username is already in use'];
        } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
            $_SESSION['errors_signup'] = ['Only characters and numbers are allowed in the username'];
        } else {
            // Call the User::register method to add the user to the database
            $user_id = User::register($email, $password, $name, $username);

            // Set user information in the session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;

            // Redirect to the welcome page
            header('location: ../welcome.php');
            exit();
        }
    } else {
        // Handle validation errors
        $_SESSION['errors_signup'] = $errors;
    }

    // Redirect back to the signup page with errors
    header('location: ../index.php');
    exit();
} else {
    // Redirect if the signup form was not submitted
    header('location: ../index.php');
    exit();
}
?>
