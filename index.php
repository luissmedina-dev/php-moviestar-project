<?php
    require_once("templates/header.php");
    require_once("globals.php");
    require_once("dao/movieDAO.php");

    // Movies DAO
    $movieDAO = new MovieDAO($conn , $BASE_URL);

    $latestMovies = $movieDAO->getLatesMovies();
    $actionMovies = $movieDAO->getMoviesByCategory("Action");
    $adventureMovies = $movieDAO->getMoviesByCategory("Adveture");

?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">New movies</h2>
    <p class="section-description">Check out reviews for the latest movies added to MovieStar</p>
    <div class="movies-container">
        <?php foreach ($latestMovies as $movie):?>
            <?php require("templates/moviecard.php"); ?>
        <?php endforeach; ?>
        <?php if(count($latestMovies) === 0): ?>
                <p class="empty-list">No movies have been added yet.</p>
        <?php endif ?>
    </div>
    <h2 class="section-title">Action</h2>
    <p class="section-description">Check out the best action movies</p>
    <div class="movies-container"></div>
        <?php foreach ($actionMovies as $movie):?>
            <?php require("templates/moviecard.php"); ?>
        <?php endforeach; ?>
        <?php if(count($actionMovies) === 0): ?>
                <p class="empty-list">No action movies have been added yet.</p>
        <?php endif ?>
    <h2 class="section-title">Adventure</h2>
    <p class="section-description">Check out the best adventure movies</p>
    <div class="movies-container"></div>
        <?php foreach ($adventureMovies as $movie):?>
            <?php require("templates/moviecard.php"); ?>
        <?php endforeach; ?>
        <?php if(count($adventureMovies) === 0): ?>
            <p class="empty-list">No adventure movies have been added yet.</p>
        <?php endif ?>
</div>

<?php
    require_once("templates/footer.php");
?>