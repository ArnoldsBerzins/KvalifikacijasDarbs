<?php 

include_once "db_conn.php";

include_once "php/func-book.php";
$books = get_all_books($conn);

include_once "php/func-author.php";
$authors = get_all_author($conn);

include_once "php/func-category.php";
$categories = get_all_categories($conn);

include_once "php/func-user.php";
// Checks the user status (0 for logged in, 1 for administrator and 2 for visitor)
$userStatus = checkUserStatus($conn);

//If user is not logged in, move to login.php
if ($userStatus == 2) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zvaigzne un Ābece</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- -->

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Zvaigzne un Ābece</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <?php if ($userStatus == 0) { ?> <!-- User is logged in, but not admin -->
                        <li class="nav-item">
                            <a class="nav-link .float-right" href="logout.php">Iziet</a>
                        </li>
                    <?php } else if ($userStatus == 1) { ?> <!-- User is logged in, and admin -->
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Administratora panelis</a>
                            <a class="nav-link" href="logout.php">Iziet</a>
                        </li>
                    <?php } ?>
                    </li>
                </div>
            </div>
        </nav>
            <form action="search.php" method="get" style="width: 100%; max-width: 30rem">
       	        <div class="input-group my-5">
                    <input type="text" 
                            class="form-control"
                            name="key" 
                            placeholder="Meklēt Grāmatu..."
                            aria-label="Meklēt Grāmatu..." 
                            aria-describedby="basic-addon2">

                    <button class="input-group-text btn btn-primary" id="basic-addon2">
                            <img src="img/search.png" width="20">
                    </button>
                </div>
            </form>
            <div class="d-flex pt-3">
                <?php if ($books == 0){ ?>
                    <div class="alert alert-warning text-center p-5" role="alert">Datubāzē nav grāmatu.</div>
                <?php }else{ ?>
                <div class="pdf-list d-flex flex-wrap">
                    <?php foreach ($books as $book) { ?>
                    <div class="card m-1">
                        <img src="uploads/cover/<?=$book['cover']?>"
                            class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?=$book['title']?>
                            </h5>
                            <p class="card-text">
                                <i><b>Autors:
                                    <?php foreach($authors as $author){ 
                                        if ($author['id'] == $book['author_id']) {
                                            echo $author['name'];
                                            break;
                                        }
                                    ?>

                                    <?php } ?>
                                <br></b></i>
                                <?=$book['description']?>
                                <br><i><b>Kategorija:
                                    <?php foreach($categories as $category){ 
                                        if ($category['id'] == $book['category_id']) {
                                            echo $category['name'];
                                            break;
                                        }
                                    ?>

                                    <?php } ?>
                                <br></b></i>
                            </p>
                            <a href="uploads/files/<?=$book['file']?>"
                                class="btn btn-success align-bottom">Atvērt</a>

                            <a href="uploads/files/<?=$book['file']?>"
                            class="btn btn-primary align-bottom"
                            download="<?=$book['title']?>">Lejupielādēt</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="category float-right">
                <div class="list-group">
                    <?php if ($categories == 0){
                        // Nekas nenotiek
                    }else{ ?>
                    <a href="#"
                    class="list-group-item list-group-item-action active">Kategorija</a>
                    <?php foreach ($categories as $category ) {?>
                    
                    <a href="category.php?id=<?=$category['id']?>"
                        class="list-group-item list-group-item-action">
                        <?=$category['name']?></a>
                    <?php } } ?>
                </div>
                <div class="list-group mt-5">
                    <?php if ($authors == 0){
                        // Neko nedara
                    }else{ ?>
                    <a href="#"
                    class="list-group-item list-group-item-action active">Autors</a>
                    <?php foreach ($authors as $author ) {?>
                    
                    <a href="author.php?id=<?=$author['id']?>"
                        class="list-group-item list-group-item-action">
                        <?=$author['name']?></a>
                    <?php } } ?>
                </div>
            </div>
		</div>
	</div>
</body>
</html>