<?php
include("./dbconn.php");

$u_id = trim($_POST['u_id']);
$u_password = trim($_POST['u_password']);

if(!$u_id || !$u_password){
  echo "<script> alert('회원 아이디나 비밀번호가 공백이면 안됩니다.');</script>";
  echo "<script> location.replace('./login_form.php');</script>";
  exit;
}

$sql = "SELECT * FROM users WHERE u_id = '$u_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


$sql = "SELECT PASSWORD('$u_password') AS pass";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$password = $row['pass'];

if(!$user['u_id'] ){
  echo "<script> alert('가입된 회원 아이디가 아니거나 비밀번호가 틀립니다.');</script>";
  echo "<script> location.replace('./login_form.php');</script>";
  exit;
}

$_SESSION['ss_u_id'] = $u_id;
mysqli_close($conn);

if(isset($_SESSION['ss_u_id'])){
  echo "<script> alert('로그인 되었습니다'); </script>";
  echo "<script>location.replace('./login_form.php');</script>";
}
 ?>
