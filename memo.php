<?php
include("./dbconn.php");

$u_id = $_SESSION['ss_u_id'];   // 로그인중인 회원 아이디
$kind = $_GET['kind'] ? $_GET['kind'] : 'recv';   // 삼항 연산자

if($kind == 'recv'){
  $unkind = 'send';
  $kind_title = '받은';
}else if($kind == 'send'){
  $unkind = 'recv';
  $kind_title = '보낸';
}else{
  echo "<script> alert(''.$kind .'값을 넘겨주세요');</script>";
  echo "<script> location.replace('./login_form.php');</script>";
  exit;
}

$sql = " SELECT COUNT(*) AS cnt FROM memo WHERE me_{$kind}_mb_id = '{$u_id}'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_count = $row['cnt'];

$page_rows = 5;
$page = $_GET['page'];

$total_page = ceil($total_count / $page_rows); // 전체 페이지 계산
if($page<1) { $page = 1;} // 페이지가 없으면 첫 페이지(1페이지)
$from_record = ($page - 1) * $page_rows;  // 시작 열을 구함

$list = array();

$sql = "SELECT a.*, b.u_id, b.u_name, b.u_email
          FROM memo a
          LEFT JOIN users b ON (a.me_{$unkind}_mb_id = b.u_id)
          WHERE a.me_{$kind}_mb_id = '{$u_id}'
          ORDER BY a.me_id DESC LIMIT $from_record, {$page_rows}";
$result = mysqli_query($conn, $sql);
for($i = 0; $row = mysqli_fetch_assoc($result); $i++){
  $list[$i] = $row;

  $mb_id = $row["me_{$unkind}_mb_id"];

  if($row['me_read_datetime'] == '0000-00-00 00:00:00')
      $read_datetime = '아직 읽지 않음';
  else
      $read_datetime = $row['me_read_datetime'];

  $send_datetime = $row['me_send_datetime'];

  $list[$i]['send_datetime'] = $send_datetime;
  $list[$i]['read_datetime'] = $read_datetime;
  $list[$i]['view_href'] = './memo_view.php?me_id='.$row['me_id'].'&amp;kind='.$kind;   // 쪽지 읽기 링크
  $list[$i]['del_href'] = './memo_delete.php?me_id='.$row['me_id'].'&amp;kind='.$kind;  // 쪽지 삭제 링크
}

$str = '';  // 시작 열을 시작
if ($page > 1){
  $str .= '<a href="./memo.php?kind='.$kind.'&amp;page=1" class="pg_page pg_start">처음</a>';
}
$start_page = (( (int)( ($page -1) / $page_rows ) )* $page_rows) + 1;
$end_page = $start_page + $page_rows -1;

if($end_page >= $total_page) $end_page = $total_page;

if($start_page > 1) $str .= '<a href = "./memo.php?kind='.$kind.'&amp;page=1'.($start_page-1).'" class="pg_page pg_recv">이전</a>';

if($total_page > 1){
  for($k=$start_page; $k<=$end_page; $k++){
    if($page!=$k)
      $str .= '<a href = "./memo.php?kind='.$kind.'&amp;page='.$k.'" class="pg_page">'.$k.'</a>';
  }
}

if($total_page > $end_page) $str .= '<a href = "./memo.php?kind='.$kind.'&amp;page='.($end_page+1).'" class="pg_next">다음</a>';

if($page < $total_page){
  $str .= '<a href = "./memo.php?kind='.$kind.'&amp;page='.$total_page.'" class="pg_end">맨끝</a>';
}

if($str)
  $write_page = "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
else
  $write_page = "";

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="kr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Memo</title>
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
      <h1>내 쪽지함</h1>
      <ul class="memo">
        <li><a href="./memo.php?kind=recv">받은쪽지</a></li>
        <li><a href="./memo.php?kind=send">보낸쪽지</a></li>
        <li><a href="./memo_form.php">쪽지쓰기</a></li>
      </ul>

      <table>
        <caption>전체 <?php echo $kind_title ?> 쪽지 <?php echo $total_count ?>통</caption>
        <thead>
          <tr>
            <th><?php echo ($kind == "recv") ? "보낸사람" : "받는사람"?></th>
            <th>보낸시간</th>
            <th>읽은시간</th>
            <th>관리</th>
          </tr>
        </thead>
        <tbody>
          <?php for($i=0; $i<count($list); $i++){ ?>
          <tr>
            <td><?php echo $list[$i]['u_id'] ?></td>
            <td><?php echo $list[$i]['send_datetime'] ?></td>
            <td><a href="<?php echo $list[$i]['view_href'] ?>"><?php echo $list[$i]['read_datetime'] ?></a> </td>
            <td><a href="<?php $list[$i]['view_href'] ?> onclick = "del(this.href); return false;"">삭제</a></td>
          </tr>
          <?php } ?>
          <?php if($i == 0) { echo '<tr><td colspan="4"> 자료가 없습니다.</td></tr>';} ?>
        </tbody>
      </table>
      <div class="button">
        <button type="button" onclick = "window.close();" name="button">창닫기</button>
      </div>
    </div>
     <p><?php echo $write_page; ?></p> <!-- 페이징 -->

  </body>
</html>
