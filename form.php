<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=428" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>登錄序號－五倍勝利金耀眼</title>
    <link href="./style.css" rel="stylesheet" />

    <?php
      if( "POST"!==$_SERVER['REQUEST_METHOD'] ) ;
      else {
        $js_str = "<script>alert('";

        if( empty($_POST["uname"]) || empty($_POST["uid"]) || empty($_POST["email"])
         || empty($_POST["phone"]) || empty($_POST["address"]) )        
          $js_str .= "您的個人資料輸入不完整，無法登錄序號。請重新輸入。";
        else {
          $js_str .= $_POST["uname"].'您好：\n\n';
          
          include "iouse.php";
          foreach( $_POST["serial"] as $str ) {
            if( empty($str) ) continue;

            $js_str .= "序號：".$str;

            if( strlen($str)<12 ) {
              $js_str .= ' 不是合法的序號，請檢查輸入資料是否正確。\n';
              continue;
            }

            $res = $conn->query("SELECT idx, exchanged FROM ticket where tick_serial='".$str."'");
            if( $res->num_rows!=1 ) 
              $js_str .= ' 不是合法的序號，請檢查輸入資料是否正確。\n';
            else {
              $row = $res->fetch_assoc();
              if( $row["exchanged"]==1 ) {
                $js_str .= ' 已被登錄，無法再次登錄。\n';
              } else {
                $idx = $row['idx'];
                $res = $conn->query("UPDATE ticket SET exchanged=1,
                  exc_time=CURRENT_TIMESTAMP, name='".$_POST["uname"]."',
                  phone='".$_POST["phone"]."', gov_id='".$_POST["uid"]."',
                  email='".$_POST["email"]."', addr='".$_POST["address"]."' WHERE idx=$idx");
                $js_str .= ' 已完成登錄，祝您中獎。\n';
              }
            }
          }
        }

        echo $js_str . "');</script>";
      }
    ?>

  </head>
  <body>
    <div class="wrapper">
      <?php include "header.html"; ?>
      <div class="main">
        <img src="./img/formKv.jpg" class="tFull" alt="" />

        <form action="" method="post">
          <table class="form form1">
            <tr>
              <td>*</td>
              <td>抽獎券序號 1</td>
            </tr>
            <tr>
              <td></td>
              <td><input type="text" maxlength="12" name="serial[]" /></td>
            </tr>
            <tr>
              <td></td>
              <td>抽獎券序號 2</td>
            </tr>
            <tr>
              <td></td>
              <td><input type="text" maxlength="12" name="serial[]" /></td>
            </tr>
            <tr>
              <td></td>
              <td>抽獎券序號 3</td>
            </tr>
            <tr>
              <td></td>
              <td><input type="text" maxlength="12" name="serial[]" /></td>
            </tr>
          </table>
          <a href="#" class="addForm">新增序號欄位</a>
          <img src="./img/text6.jpg" class="text6 tFull" alt="" />
          <table class="form">
            <tr>
              <td>*</td>
              <td>姓名</td>
            </tr>
            <tr>
              <td></td>
              <td><input name="uname" maxlength="10"/></td>
            </tr>
            <tr>
              <td>*</td>
              <td>身分證字號</td>
            </tr>
            <tr>
              <td></td>
              <td><input name="uid" maxlength="10"/></td>
            </tr>
            <tr>
              <td>*</td>
              <td>電子信箱</td>
            </tr>
            <tr>
              <td></td>
              <td><input type="email" name="email" /></td>
            </tr>
            <tr>
              <td>*</td>
              <td>手機號碼</td>
            </tr>
            <tr>
              <td></td>
              <td><input type="tel" name="phone" maxlength="10"/></td>
            </tr>
            <tr>
              <td>*</td>
              <td>寄送地址</td>
            </tr>
            <tr>
              <td></td>
              <td><input name="address" /></td>
            </tr>
          </table>
          <input class="sendBtn" type="submit" value="送出完成登入">
        </form>
        <img src="./img/text7.jpg" class="text7" alt="" />
      </div>
      <footer><img src="./img/footer.jpg" alt="" /></footer>
    </div>
    <script src="./app.js"></script>
  </body>
</html>
