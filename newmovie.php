<?php
    require_once("templates/header.php");
    require_once("globals.php");

    //  Verify user already authenticated
    require_once("dao/userDAO.php");
    require_once("models/User.php");

    $user = new User();
    $userDAO = new UserDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(true);

?>
<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Add movie</h1>
        <p class="page-description">Add your review and share it with the world</p>
        <form action="<?= $BASE_URL ?>movieprocess.php" id="add-movie-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter your movie title">
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="runtime">Runtime:</label>
                <input type="text" class="form-control-file" name="length" id="length" placeholder="Enter the movie runtime">
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category" class="form-control">
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Animation">Animation</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Crime">Crime</option>
                    <option value="Drama">Drama</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Horror">Horror</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Romance">Romance</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Thriller">Thriller</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trailer">Trailer:</label>
                <input type="text" class="form-control-file" name="trailer" id="trailer" placeholder="Enter the link trailer">
            </div>
            <div class="form-group">
                <label for="descriptiom">Description:</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descript the movie..."></textarea>
            </div>
            <input type="submit" class="btn card-btn" value="Add movie">
        </form>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>