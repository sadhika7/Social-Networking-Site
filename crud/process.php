<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once("../database/database.php");
require_once("../database/session.php");

$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$upate = false;

if(isset($_POST['save'])){

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type']="success";
  $query = "INSERT into students (name,semester) VALUES (?,?)";
  //execute $query
  $stmt = $mysqli->prepare($query);
  $stmt-> execute([$_POST["name"], $_POST["semester"]]);

  if ($stmt){
    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type']="success";
  }
  else{
    $_SESSION["message"]="ERROR! Could not add student";
  }

  header("location: admin.php");
}

if(isset($_GET["delete"]) && isset($_GET["id"]) && $_GET["id"] !== ""){

		$query = "DELETE FROM students WHERE id=?";
		$stmt = $mysqli -> prepare($query);
		$stmt-> execute([$_GET["id"]]);

		if ($stmt) {

			$_SESSION["message"] = "Student has been successfully deleted.";
		}
		else {
			$_SESSION["message"] = "Student could not be deleted.";
		}
	}
	else {
		$_SESSION["message"] = "Student could not be found!";
	}


if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $update = true;

  $query = "SELECT * FROM students WHERE id=?";
  $stmt = $mysqli -> prepare($query);
  $stmt-> execute($id);

  if ($query->rowCount() > 0){
    $row = $stmt -> fetch_assoc();
    $name = $row['name'];
    $semester = $row['semester'];
  }
  }

  // if(isset($_GET['edit'])){
  //   $id = $_GET['edit'];
  //   $update = true;
  //   $result = $mysqli->query("SELECT * FROM courses WHERE id=$id")or die($mysqli->error());
  //   if(count($result)==1){
  //     $row = $result->fetch_array();
  //     $course_name=$row['course_name'];
  //     $course_id = $row['course_id'];
  //   }
  // }

if(isset($_POST['update'])){
  $query = "UPDATE students SET name=?, semester=? WHERE id=?";
  $stmt = $mysqli -> prepare($query);
	$stmt -> execute([$_POST["name"],$_POST["semester"],$_POST["id"]]);

  $_SESSION["message"] = "$_POST[name] has been changed";
  $_SESSION['message']="Record has been updated";
  $_SESSION['msg_type']="warning";

  // header('location: admin.php');

  if($stmt) {
			$_SESSION["message"] = $_POST["name"]." has been changed.";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["name"];
		}

}

$stmt=null;
Database::dbDisconnect();
?>
