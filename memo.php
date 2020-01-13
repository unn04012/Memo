<?php
<!DOCTYPE html>
<html lang="kr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Memo</title>
    <style media="screen">
      body{
        margin : 0;
        padding : 0;
        font-family : sans-serif;
        background : url(bg.jpg) no-repeat center;
        height : 100vh;
        color : white;
      }
      .memo-box{
        text-align : center;
        position : absolute;
        left : 50%;
        width : 75%;
        transform : translateX(-50%);
        background : rgba(0,0,0,0.6);
      }
      .memo{
        border : 3px solid  #d8215f;
        padding : 10px;
      }
      ul{
        font-size : 0;
        margin-bottom : 20px;
      }
      ul li{
        display : inline-block;
        width : 33.33%;
        font-size : 14px;
        vertical-align: middle;
      }

      table{
        width : 100%;
        margin : auto;
        border-collapse : collapse;
      }
      caption{
        text-align : left;
        font-size : 12px;
      }
      th,td{
        padding : 10px 20px;
        min-height : 40px;
        font-size : 14px;
        border : 3px solid #d8215f;
      }
      th{
        background : #2a2828;
      }
    </style>
  </head>
  <body>
    <div class="memo-box">
      <h1>내 쪽지함</h1>
      <ul class="memo">
        <li>받은쪽지</li>
        <li>보낸쪽지</li>
        <li>쪽지쓰기</li>
      </ul>

      <table>
        <caption>전체 받은 쪽지 0통</caption>
        <thead>
          <tr>
            <th>보낸사람</th>
            <th>보낸시간</th>
            <th>읽은시간</th>
            <th>관리</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan = "4">자료가 없습니다</td>
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>

?>
