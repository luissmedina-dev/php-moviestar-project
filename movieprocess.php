<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Movie.php");
    require_once("models/Message.php");
    require_once("dao/userDAO.php");
    require_once("dao/movieDAO.php");

    $message = new Message($BASE_URL);
    $userDAO = new UserDAO($conn, $BASE_URL);
    $movieDAO = new MovieDAO($conn, $BASE_URL);

    // Rescue the form type
    $type = filter_input(INPUT_POST, "type");

    // Rescue user data
    $userData = $userDAO->verifyToken();

    if($type === "create"){

        // Recive inputs data
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        // Data verification 
        if(!empty($title) && !empty($description) && !empty($category)){

            $movie->title = $title;
            $movie->description = $description;
            $movie->trailer = $trailer;
            $movie->category = $category;
            $movie->length = $length;
            $movie->user_id = $userData->id;

            // Movie image upload
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png", "image/webp"];
                $jpgArray = ["image/jpeg", "image/jpg"];

                // Check image type
                if(in_array($image["type"], $imageTypes)){

                    // Check image jpg type
                    if(in_array($image["type"], $jpgArray)){
                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    } elseif($image["type"] == "image/webp"){
                        $imageFile = imagecreatefromwebp($image["tmp_name"]);
                    }
                    else {
                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }
                    
                    // Generate image name
                    $imageName = $movie->imageGenerateName();

                    imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                    $movie->image = $imageName;

                } else {
                    $message->setMessage("Invalid image type", "error", "back");
                }
            }
 
            $movieDAO->create($movie);

        } else {
            $message->setMessage("Please fill in all required fields: title, description, and category.", "error", "back");
        }

    
    } else if ($type === "delete") {

        // Recive form data
        $id = filter_input(INPUT_POST, "id");

        $movie = $movieDAO->findById($id);

        if($movie){

            // Check if the movie belongs to the user
            if ($movie->user_id === $userData->id) {

                $movieDAO->destroy($movie->id);

            } else {
                $message->setMessage("Invalid data provided!", "error", "index.php");
            }

        } else {
            $message->setMessage("Invalid data provided!", "error", "index.php");
        }

    } elseif($type === "update") {

        // Recive inputs data
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");
        $id = filter_input(INPUT_POST, "id");

        $movieData = $movieDAO->findById($id);

        // Verify if found movie
        if($movieData){

            if ($movieData->user_id === $userData->id) {

                // Data verification 
                if(!empty($title) && !empty($description) && !empty($category)) {

                    // Edit movie
                    $movieData->title = $title;
                    $movieData->description = $description;
                    $movieData->trailer = $trailer;
                    $movieData->category = $category;
                    $movieData->length = $length;

                    // Movie image upload
                    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){

                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/jpg", "image/png", "image/webp"];
                    $jpgArray = ["image/jpeg", "image/jpg"];

                    // Check image type
                    if(in_array($image["type"], $imageTypes)){

                        // Check image jpg type
                        if(in_array($image["type"], $jpgArray)){
                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } elseif($image["type"] == "image/webp"){
                            $imageFile = imagecreatefromwebp($image["tmp_name"]);
                        }
                        else {
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }
                        
                        // Generate image name
                        $movie = new Movie();

                        $imageName = $movie->imageGenerateName();

                        imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                        $movie->image = $imageName;

                    } else {
                        $message->setMessage("Invalid image type", "error", "back");
                    }
                }

                $movieDAO->update($movieData);

                } else {
                    $message->setMessage("Please fill in all required fields: title, description, and category.", "error", "back"); 
                }
                
            } else {
                $message->setMessage("Invalid data provided!", "error", "index.php");
            }

        } else {
            $message->setMessage("Invalid data provided!", "error", "index.php");
        }


    } else {

        $message->setMessage("Invalid data provided!", "error", "index.php");
    }