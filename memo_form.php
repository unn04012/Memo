<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Memo form</title>
    <link rel="stylesheet" href="memo.css">
  </head>
  <body>
    <div class="memo-box">
      <h1>쪽지 보내기</h1>
      <ul class = "memo">
        <li><a href="./memo.php?kind=recv">받은쪽지</a></li>
        <li><a href="./memo.php?kind=send">보낸쪽지</a></li>
        <li><a href="./memo_form.php">쪽지쓰기</a></li>
      </ul>
      <form class="" action="./memo_form_update.php" onsubmit = "return fmemoform_submit(this);" method="post" autocomplete = "off">
        <div class="">
          <table>
            <tbody>
              <th>받는 회원 아이디</th>
              <td>
                <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>"
                id="me_recv_mb_id" required class = "frm_input_required" size ="47" ><br>
                <span>여러 회원에게 보낼때는 콤마(,)로 구분하세요</span>
              </td>
              <tr>
                <th>내용</th>
                <td> <textarea name="mem_memo" rows="10" cols="50" required></textarea> </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="win_btn">
          <input type="submit"  class = "button"name="" value="보내기">
          <button type="button" class = "button" onclick = "window.close();">창닫기</button>
        </div>
      </form>
    </div>
  </body>
</html>
