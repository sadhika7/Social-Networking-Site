<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- Javascript -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  	<script src="assets/js/bootstrap.js"></script>

  	<!-- CSS -->
  	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/adminStyle.css">
      <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php
    require_once('process.php');
    require_once('../database/database.php');
    require_once('../database/session.php');
    $mysqli = Database::dbConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ?>

     <div class="top_bar">
   		<div class="logo">
   			<a href="index.php">
   					<i class="fa fa-book fa-lg"></i>
   					Learn
   				</a>
   		</div>

   		<nav>

   			<a href="admin.php">Students
   				<i class="fa fa-users fa-lg"></i>
   			</a>
        <a href="courses.php">Courses
        	<i class="fa fa-book fa-lg"></i>
        </a>
   			<a href="#"> Settings
   				<i class="fa fa-cog fa-lg"></i>
   			</a>
   			<a href="../includes/handlers/logout.php">
          Log out
   				<i class="fa fa-sign-out fa-lg"></i>
   			</a>
   		</nav>

      <!-- Masthead -->
      <header class="masthead text-gray text-center">
       <div class="overlay"></div>
       <div class="container">
       </div>
       </div>

       <?php
       if(isset($_SESSION['message'])){?>
       <div class="alert alert-<?=$_SESSION['msg_type']?>">
         <?php
         echo $_SESSION['message'];
         unset($_SESSION['message']);
          ?>
       </div>
       <?php
     }
        ?>

        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                <h2>Manage <b>Students</b></h2>
              </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Semester</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <?php
                    $query = "SELECT * from students where id=?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute[$_GET["id"]];
                    if($stmt){
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['semester']; ?></td>
                      <td>
                      <a data-toggle="modal"
                        class="btn btn-info" href="admin.php?edit= <?php echo $row['id']; ?>">Edit</a>
                       <a href="process.php?delete=<?php echo $row['id']; ?>"
                         class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                  <?php }
                }else{
                    $_SESSION["message"]="Student not found!";
                } ?>
                </table>
            </div>
        </div>

        <div class="container">
        <div class="row justify-content-center">
          <form class="" action="process.php" method="post">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
        						<div class="form-group">
        							<label>Name</label>
        							<input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
        						</div>
        						<div class="form-group">
        							<label>Semester</label>
        							<input type="text" name="semester"class="form-control" value="<?php echo $semester; ?>"
                      required>
        						</div>
        					<div class="form-group">
                    <?php
                    if($update == true):
                      ?>
                    <button type="submit" class="btn btn-info" name="update">Update</button>
                  <?php
                  else:
                  ?>
        						<button type="submit" class="btn btn-info" name="save">Save</button>
                  <?php endif; ?>
        					</div>
        				</form>
        			</div>
            </div>
  </body>
</html>
