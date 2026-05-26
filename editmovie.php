<?php
    require_once("templates/header.php");
    require_once("globals.php");

    //  Verify user already authenticated
    require_once("dao/userDAO.php");
    require_once("models/User.php");
    require_once("dao/movieDAO.php");

    $user = new User();
    $userDAO = new UserDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(true);

    $movieDAO = new MovieDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

    if(empty($id)){

        $message->setMessage("Movie not found!", "error", "index.php");

    } else {

        $movie = $movieDAO->findById($id);

        // Verify if movie exist
        if(!$movie){

            $message->setMessage("Movie not found!", "error", "index.php");

        }
    }

    if($movie->image === ""){
        $movie->image = "movie_cover.jpg";
    }

?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $movie->title ?></h1>
                <p class="page-description">Update the movie information in the form below:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movieprocess.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $movie->id ?>">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter your movie title" value="<?= $movie->title ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <label for="runtime">Runtime:</label>
                        <input type="text" class="form-control-file" name="length" id="length" placeholder="Enter the movie runtime" value="<?= $movie->length ?>">
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="Action" <?= $movie->category === "Action" ? "selected" : ""?>>Action</option>
                            <option value="Adventure" <?= $movie->category === "Adventure" ? "selected" : ""?>>Adventure</option>
                            <option value="Animation" <?= $movie->category === "Animation" ? "selected" : ""?>>Animation</option>
                            <option value="Comedy" <?= $movie->category === "Comedy" ? "selected" : ""?>>Comedy</option>
                            <option value="Crime" <?= $movie->category === "Crime" ? "selected" : ""?>>Crime</option>
                            <option value="Drama" <?= $movie->category === "Drama" ? "selected" : ""?>>Drama</option>
                            <option value="Fantasy" <?= $movie->category === "Fantasy" ? "selected" : ""?>>Fantasy</option>
                            <option value="Horror" <?= $movie->category === "Horror" ? "selected" : ""?>>Horror</option>
                            <option value="Mystery" <?= $movie->category === "Mystery" ? "selected" : ""?>>Mystery</option>
                            <option value="Romance" <?= $movie->category === "Romance" ? "selected" : ""?>>Romance</option>
                            <option value="Sci-Fi" <?= $movie->category === "Sci-Fi" ? "selected" : ""?>>Sci-Fi</option>
                            <option value="Thriller" <?= $movie->category === "Thriller" ? "selected" : ""?>>Thriller</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trailer">Trailer:</label>
                        <input type="text" class="form-control-file" name="trailer" id="trailer" placeholder="Enter the link trailer" value="<?= $movie->trailer ?>">
                    </div>
                    <div class="form-group">
                        <label for="descriptiom">Description:</label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descript the movie..."> <?= $movie->description ?></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Edit movie">
                </form>
            </div>
            <div class="col-md-3">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>')"></div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?> 