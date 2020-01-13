<?php
include("./dbconn.php");
 ?>

<!DOCTYPE html>
<html>
<head>
  <title>LOGIN FORM</title>
  <link rel="stylesheet" href="message.css">
  <script src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>
  <style media="screen">
  caption{
    text-align : left;
    color : white;
  }
  table{
    width : 125%;
    transform : translateX(-10%);
  }
  </style>
</head>
<body>
  <?php if(!isset($_SESSION['ss_u_id'])) { ?>
    <form class="" action="./login_check.php" method="post">
      <div class="login-box">
        <h1>Login</h1>
        <form action="">
          <div class="textbox">
            <i class="fas fa-user"></i>
            <input type="text" placeholder = "Username" name = "u_id">
          </div>
          <div class="textbox">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder = "Password" name = "u_password">
          </div>
          <input class = "btn" type="submit" value = "Sign in">
        </form>
      </div>
    </form>
  <?php } else {?>
    <?php
    $u_id = $_SESSION['ss_u_id'];
    $sql = "SELECT COUNT(*) AS 'cnt' FROM users";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_count = $row['cnt'];

    $page_rows = 10;
    $page = $_GET['page'];

    $total_page = ceil($total_count / $page_rows);
    if($page<1){$page = 1;}
    $from_record = ($page -1) * $page_rows;

    $list = array();

    $sql = "SELECT * FROM users ORDER BY u_datetime desc LIMIT {$from_record}, {$page_rows}";
    $result = mysqli_query($conn, $sql);
    for($i = 0; $row = mysqli_fetch_assoc($result); $i++){
      $list[$i] = $row;
      $list_num - $total_count - ($page - 1) * $page_rows;
      $list[$i]['num'] = $list_num - $i;
    }

    $str = '';
    if($page > 1){
      $str .= '<a href = "./login_form.php?page = 1" class = "pg_page pg_start">처음</a>';
    }

    $start_page = ( ( (int)( ($page -1) / $page_rows ) ) * $page_rows) + 1;
    $end_page = $start_page + $page_rows -1;

    if($end_page >= $total_page) $end_page = $total_page;

    if($start_page > 1)
      $str .= '<a href = "./login_form.php?page ='.($start_page-1).'" class = "pg_page pg_prev">이전</a>';

    if($total_page > 1){
      for($k = $start_page; $k<$end_page; $k++){
        if($page != $k)
          $str .= '<a href = "./login_form.php?page ='.$k.'" class = "pg_page">'.$k.'</a>';
        else
          $str .= '<strong class = "pg_current">'.$k.'</strong>';
      }
    }

    if($total_page > $end_page) $str .= '<a href = "./login_form.php?page ='.($end_page+1).'" class = "pg_page pg_next">다음</a>';

    if($page < $total_page){
      $str .= '<a href = "./login_form.php?page ='.$total_page.'" class = "pg_page pg_end">맨끝</a>';
    }

    if($str)
      $write_page = "<nav class=\"pg_wrap\"><span class = \"pg\">{$str}</span></nav>";
    else {
      $write_page = "";
    }
    mysqli_close($conn);
     ?>
     <div class="message-box">
       <h1>Member List</h1>
       <div class="button">
         <a href="./memo.php" onclick = "win_memo(this.href); reutrn false;" >쪽지함</a>
         <a href="logout.php">로그아웃</a>
       </div>
       <table>
         <caption>Total <?php echo number_format($total_count) ?>명 <?php echo $page ?>페이지</caption>
         <thead>
           <tr>
             <th>번호</th>
             <th>아이디</th>
             <th>이름</th>
             <th>이메일</th>
             <th>성별</th>
             <th>직업</th>
             <th>관심언어</th>
             <th>가입일</th>
             <th>쪽지보내기</th>
           </tr>
         </thead>
         <tbody>
           <?php
           for($i = 0; $i<count($list); $i++){
           ?>
           <tr>
             <td><?php echo $list[$i]['u_no'] ?></td>
             <td><?php echo $list[$i]['u_id'] ?></td>
             <td><?php echo $list[$i]['u_name'] ?></td>
             <td><?php echo $list[$i]['u_email'] ?></td>
             <td><?php echo $list[$i]['u_gender'] ?></td>
             <td><?php echo $list[$i]['u_job'] ?></td>
             <td><?php echo $list[$i]['u_language'] ?></td>
             <td><?php echo $list[$i]['u_datetime'] ?></td>
             <td><a href = "./memo_form.php?me_recv_mb_id=<<?php echo $list[$i]['u_id'] ?>"
               class ="td_btn" onclick = "win_memo(this.href); return false;">쪽지보내기</a></td>
           </tr>
         <?php } ?>
         <?php if(count($list) == 0){echo '<tr><td colspan = "9"> 등록된 회원이 없습니다.<td><tr>';} ?>
         </tbody>
       </table>
       <p><?php echo $wiite_page; ?></p>
     </div>
     <script type="text/javascript">
       var win_memo = function(href){
         var new_win = window.open(href, 'win_memo','left = 100, top = 100, width = 620, height = 500, scrollbars = 1');
         new_win.focus();
       }
     </script>
   <?php } ?>
</body>
</html>
