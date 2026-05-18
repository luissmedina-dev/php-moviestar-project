<?php 

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/userDAO.php");

    $message = new Message($BASE_URL);

    $userDao = new userDAO($conn, $BASE_URL);

    // Rescue the form type
    $type = filter_input(INPUT_POST, "type");

    // Update user 
    if ($type === "update"){

        // Rescue user data
        $userData = $userDao->verifyToken();

        // Recive post data
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        // Create new user object
        $user = new User();

        // Fill user data
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;

        $userDao->update($userData);
        
    // Update password
    } elseif ($type === "changepassword"){

    } else {
        $message->setMessage("Invalid credentials!", "error", "index.php");
    }