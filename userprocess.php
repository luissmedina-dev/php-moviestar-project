<?php 
    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/userDAO.php");

    $message = new Message($BASE_URL);

    $userDAO = new userDAO($conn, $BASE_URL);

    // Rescue the form type
    $type = filter_input(INPUT_POST, "type");

    // Update user 
    if ($type === "update"){

        // Rescue user data
        $userData = $userDAO->verifyToken();

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

        // Upload image
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){
            
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Image type verefication
            if(in_array($image["type"], $imageTypes)){

                //Check jpg
                if(in_array($image["type"], $jpgArray)){

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                // Png image
                } else {

                    $imageFile = imagecreatefrompng($image["tmp_name"]);

                }

                $imageName = $user->imageGenerateName();

                imagejpeg($imageFile, "./img/users/". $imageName, 100);

                $userData->image = $imageName;

            } else {
                $message->setMessage("Invalid image type", "error", "back");
            }

        }

        $userDAO->update($userData);
        
    // Update password
    } elseif ($type === "changepassword"){

        // Recive post data
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        // Rescue user data
        $userData = $userDAO->verifyToken();
        $id = $userData->id;

        if ($password == $confirmpassword){

            // Create new user object
            $user = new User();

            $finalPassoword = $user->generatePassoword($password);

            $user->password = $finalPassoword;
            $user->id = $id;

            $userDAO->changePassword($user);

        } else {
            $message->setMessage("Password are not equal!", "error", "back");
        }

    } else {
        $message->setMessage("Invalid credentials!", "error", "index.php");
    }