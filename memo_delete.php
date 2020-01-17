<?php
include("./dbconn.php");

$u_id = $_SESSION['ss_u_id'];
$kind = $_GET['kind'] ? $_GET['kind'] : 'recv';

if(!$u_id){
  echo "<script> alert('회원만 이용하실 수 있습니다.'); window.close(); </script>";
  exit;
}

$me_id = $_GET['me_id'];

$sql = "DELETE FROM memo
          WHERE me_id = {$me_id}
          AND (me_recv_mb_id = '$u_id' OR me_send_mb_id = '$u_id')";
$result = mysqli_query($conn, $sql);

if($result){
  $url = './memo.php?kind='.$kind;
  echo "<script> alert('쪽지 삭제가 완료 되었습니다.');</script>";
  echo "<script>location.replace('$url');</script>";
  exit;
}else{
  echo "삭제 실패 : " .mysqli_error($conn);
  mysqli_close($conn);
}
 ?>
