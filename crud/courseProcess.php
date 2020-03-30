<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

$mysqli = new mysqli('localhost','root','','social') or die(mysqli_error($mysqli));
$name ='';
$course_name='';
$course_id = '';
$semester= '';
$upate = false;
$id=0;

if(isset($_POST['save'])){
  $course_name = $_POST['course_name'];
  $course_id = $_POST['course_id'];

  $_SESSION['message'] = "Record has been saved";
  $_SESSION['msg_type']="success";
  $mysqli->query("INSERT into courses (course_name, course_id) VALUES ('$course_name','$course_id')") or
  die($mysqli->error);
  $_SESSION['message'] = "Record has been saved!";
  $_SESSION['msg_type']="success";

  header("location: courses.php");
}

if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $mysqli->query("DELETE from courses where id=$id")or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted";
  $_SESSION['msg_type']="danger";

  header("location: courses.php");
}

if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM courses WHERE id=$id")or die($mysqli->error());
  if(count($result)==1){
    $row = $result->fetch_array();
    $course_name=$row['course_name'];
    $course_id = $row['course_id'];
  }
}

if(isset($_POST['update'])){
  $id = $_POST['id'];
  $course_name = $_POST['course_name'];
  $course_id = $_POST['course_id'];

  $mysqli->query("UPDATE courses SET course_name='$course_name', course_id='$course_id'") or
  die($mysqli->error);

  $_SESSION['message']="Record has been updated";
  $_SESSION['msg_type']="warning";

  header('location: courses.php');
}
 ?>
