<?php  

session_start();

function get_all_users($con)
{
   $sql  = "SELECT * FROM user";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	$users = $stmt->fetchAll();
   } else {
      $users = 0;
   }

   return $users;
}

function get_user($con, $id)
{
   $sql  = "SELECT * FROM user WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $user = $stmt->fetch();
   } else {
      $user = 0;
   }

   return $user;
}

function checkUserStatus($con) {
   // Check if the user is logged in
   if (isset($_SESSION['user_id'])) {

      // Retrieve user information from the database
      $user_id = $_SESSION['user_id'];

      $sql = "SELECT user_type FROM user WHERE id = $user_id";
      $stmt = $con->prepare($sql);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
         // User found
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         $user_type = $row['user_type'];

         // Return numerical values based on user type
         switch ($user_type) {
            case 0:
               return 0; // Logged-in user
            case 1:
               return 1; // Admin user
            default:
               return -1; // Unknown user type (handle as needed)
         }
      } else {
         // User not found in the database
         return -1; // Unknown user type (handle as needed)
      }
   } else {
      // User is not logged in
      return 2; // Visitor
      echo "Something aint right";
   }
}