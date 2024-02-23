<?php  

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

	include "../db_conn.php";

	if (isset($_POST['category_name'])) {
		$name = $_POST['category_name'];

		if (empty($name)) {
			$em = "Nepieciešams ievadīt kategorijas nosaukumu!";
			header("Location: ../add-category.php?error=$em");
            exit;
		} else {
			$sql  = "INSERT INTO categories (name)
			         VALUES (?)";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name]);
		    if ($res) {
		     	$sm = "Kategorija pievienota!";
				header("Location: ../add-category.php?success=$sm");
	            exit;
		    } else {
		     	$em = "Kļūda!";
				header("Location: ../add-category.php?error=$em");
	            exit;
		    }
		}
	} else {
      header("Location: ../admin.php");
      exit;
	}

} else{
  header("Location: ../login.php");
  exit;
}