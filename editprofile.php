<?php
    require_once("templates/header.php");
    require_once("globals.php");
    require_once("dao/userDAO.php");
    require_once("models/User.php");

    $user = new User();
    $userDAO = new UserDAO($conn, $BASE_URL);

    $userData = $userDAO->verifyToken(true);

    $fullName = $user->getFullName($userData);

    if($userData->image == ""){
        $userData->image = "user.png";
    }
?>
<div id="main-container" class="container-fluid edit-profile-page">
    <div class="col-md-12">
        <form action="<?= $BASE_URL ?>userprocess.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-4">
                    <h1><?=  $fullName; ?></h1>
                    <p class="page-description">Update your profile information: </p>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?= $userData->name ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your lastname" value="<?= $userData->lastname ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Enter your email" value="<?= $userData->email ?>">
                    </div>
                    <input type="submit" class="btn card-btn" value="Update">
                </div>
                <div class="col-md-4">
                    <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <div class="form-group">
                        <label for="image">Picture:</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio:</label>
                        <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="About you"><?= $userData->bio ?></textarea>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" id="change-password-container">
            <div class="col-md-4">
                <h2>Change password:</h2>
                <p class="page-description">Enter new password and confirm</p>
                <form action="<?= $BASE_URL ?>userprocess.php" method="post">
                    <input type="hidden" name="type" value="changepassword">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirm password:</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm your new password">
                    </div>
                    <input type="submit" class="btn card-btn" value="Update password">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>