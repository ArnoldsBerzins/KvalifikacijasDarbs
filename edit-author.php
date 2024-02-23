<?php  
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
	if (!isset($_GET['id'])) {
        header("Location: admin.php");
        exit;
	}

	$id = $_GET['id'];
	include_once "db_conn.php";

	include_once "php/func-author.php";
    $author = get_author($conn, $id);
    
    if ($author == 0) {
        header("Location: admin.php");
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autora rediģēšana</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <!-- -->
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Administrators</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Veikals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-book.php">Pievienot Grāmatu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-category.php">Pievienot Kategoriju</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-author.php">Pievienot Autoru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Iziet</a>
                    </li>
                </div>
            </div>
        </nav>
        <form action="php/edit-author.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%;">

     	<h1 class="text-center pb-5 display-4 fs-3">Rediģēt autoru</h1>
     	<?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>
     	<div class="mb-3">
		    <label class="form-label">
		           	Autora vārds
		           </label>

		     <input type="text" 
		            value="<?=$author['id'] ?>" 
		            hidden
		            name="author_id">


		    <input type="text" 
		           class="form-control"
		           value="<?=$author['name'] ?>" 
		           name="author_name">
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            Atjaunot</button>
     </form>
	</div>
</body>
</html>

<?php } else {
  header("Location: login.php");
  exit;
} ?>
    </div>