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

    // Check the form type
    if($type === "register"){

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        // Check minimun data requeriments
        if($name && $lastname && $email && $password) {

            // Check if passwords are equal
            if($password === $confirmpassword){

                // Verify if email is already registered
                if($userDao->findByEmail($email) === false) {

                    $user = new User ();

                    // Create token and password
                    $usertoken = $user->generateToken();
                    $finalPassoword = $user->generatePassoword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassoword;
                    $user->token = $usertoken;

                    $auth = true;

                    $userDao->create($user, $auth);

                }else {
                    // User already exists error message
                    $message->setMessage("This email is already in use", "error", "back");
                }

            } else{

                // Passwords do not match error message
                $message->setMessage("Passwords do not match", "error", "back");

            }

        } else {

            // Send error message about data requeriments missing
            $message->setMessage("Please complete all required fields", "error", "back");

        }

    } else if($type === "login")

?>