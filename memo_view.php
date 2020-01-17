<?php
include("./dbconn.php");

$u_id = $_SESSION['ss_u_id'];
$kind = $_GET['kind'] ? $_GET['kind'] : 'recv';

if(!$u_id){
  echo "<script> alert('회원만 이용하실 수 있습니다.'); window.close(); </script>";
  exit;
}

$me_id = $_REQUEST['me_id'];
$me_read_datetime = date('Y-m-d H:i:s', time());

if($kind == 'recv'){
  $kind_str = "보낸";
  $kind_date = "받은";

  $sql = "UPDATE memo
            SET me_read_datetime = '$me_read_datetime'
            WHERE me_id = '$me_id'
            AND me_recv_mb_id = '$u_id'
            AND me_read_datetime = '0000-00-00 00:00:00' ";
  $result = mysqli_query($conn, $sql);
}else if($kind == 'send'){
  $kind_str = "받는";
  $kind_date = "보낸";
}else{
  echo "<script> alert('변수 kind 값이 없습니다.'); window.close(); </sciprt>";
  exit;
}

$sql = "SELECT * FROM memo
          WHERE me_id = '$me_id'
          AND me_{$kind}_mb_id = '$u_id'";
$result = mysqli_query($conn, $sql);
$memo = mysqli_fetch_assoc($result);

mysqli_close($conn);
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Memo View</title>
     <link rel="stylesheet" href="memo.css">
     <style media="screen">
     a{
       color : white;
       text-decoration : none;
     }
     a:hover{
       color : yellow;
       transition : 0.4s;
     }
     </style>
   </head>
   <body>
    <div class="memo-box">
      <h1>쪽지 보기</h1>
      <ul class = "memo">
        <li><a href="./memo.php?kind=recv">받은쪽지</a></li>
        <li><a href="./memo.php?kind=send">받은쪽지</a></li>
        <li><a href="./memo_form.php">쪽지쓰기</a></li>
      </ul>
      <article class="">
        <header>
          <h1>쪽지 내용</h1>
        </header>
        <table>
          <colgroup>
            <col width="20%">
            <col span="*">
            <col span="20%">
            <col span="*">
          </colgroup>
          <tr>
            <th><?php $kind_str ?>사람</th>
            <td><strong><?php echo $memo['me_send_mb_id'] ?></strong> </td>
            <th><?php $kind_date ?>시간</th>
            <td><strong><?php echo $memo['me_send_datetime'] ?></strong> </td>
          </tr>
          <tr>
            <td colspan = "4"><?php echo nl2br($memo['me_MEMO']) ?></td>
          </tr>
        </table>
      </article>
      <div class="win_btn">
        <?php if($kind == 'recv'){ ?>
          <a href="./memo_form.php?me_recv_mb_id=<?php echo $memo['me_send_mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>">답장</a>
        <?php } ?>
        <a href="./memo.php?kind=<?php echo $kind ?>">목록보기</a>
        <button type="button" onclick = "window.close();" name="button">창닫기</button>
      </div>
    </div>
   </body>
 </html>
