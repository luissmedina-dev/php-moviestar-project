<?php 
    require_once("templates/header.php");
    require_once("globals.php");

    //  Verify user already authenticated
    require_once("models/Movie.php");
    require_once("dao/movieDAO.php");

    // Movie id
    $id = filter_input(INPUT_GET, "id");

    $movie; 

    $movieDAO = new MovieDAO($conn, $BASE_URL);

    if(empty($id)){

        $message->setMessage("Movie not found!", "error", "index.php");

    } else {

        $movie = $movieDAO->findById($id);

        // Verify if movie exist
        if(!$movie){

            $message->setMessage("Movie not found!", "error", "index.php");

        }
    }

    // Check if the movie belongs to the user
    $userOwnsMovie = false; 

    if(!empty($userData)){

        if($userData->id === $movie->user_id){
            $userOwnsMovie = true;
        }

    }

    // Rescue movie reviews

?>