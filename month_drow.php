<?php

  include "iouse.php";

  $drow_m = date('m');
  $from = date( 'Y-m-14 23:00:00', strtotime( $drow_m=='11' ? "-2 month" : "last Month" ) );
  $to = date('Y-m-14 23:00:00');

  $res = $conn->query("SELECT * FROM ticket where exchanged=1 and exc_time>='$from' and exc_time<'$to'");
  
  $num = $res->num_rows;
  echo "From: ".$from."   To: ".$to."<br>Month: ".$drow_m."   Total: ".$num." tickets.<br>";
  if( $num<=0 ) {  
    echo "no data!<br>";
  } else {
    // 準備候選名單
    echo "From: ".$from."<br>To: ".$to."<br> Total: ".$num." tickets.<br>";
    while( $row=$res->fetch_assoc() ) {
      $pool[] = [
        'idx' => $row['idx'],
        'tk' => $row['tick_serial'],
        'name' => $row['name'],
        'ph' => $row['phone'],
        'id' => $row['gov_id'],
        'email' => $row['email'],
        'addr' => $row['addr'],
        'time' => $row['exc_time']
      ];
    }
    $num--; // 因為要從零開始

    // 抽三十個
    $win_list = array();
    $win_phone = array();
    $wid = 0;
    $sql_cmd = "INSERT INTO winner (w_M, w_type, ticket_id, ticket_ser, winner_name) VALUES ";
    while( !empty($pool) && $wid<30 ) {
      do {
        $drow_id = rand(0, $num);
        echo "drow: ".$drow_id."   ";
      } while( empty($pool[$drow_id]) );

      if( in_array( $pool[$drow_id]['ph'], $win_phone) ) echo "drop: (".$pool[$drow_id]['idx'].") ".$pool[$drow_id]['ph']."<br>"; // 重複中獎，不算
      else {
        echo "win: (".$pool[$drow_id]['idx'].") ".$pool[$drow_id]['ph']."<br>";
        $winner[$wid]['w_M'] = $drow_m;
        $winner[$wid]['w_type'] = $wid<10 ? 1 : 2; // 前10/後20
        $winner[$wid]['idx'] = $pool[$drow_id]['idx'];
        $winner[$wid]['tk'] = $pool[$drow_id]['tk'];
        $winner[$wid]['name'] = $pool[$drow_id]['name'];
        $winner[$wid]['ph'] = $pool[$drow_id]['ph'];
        $winner[$wid]['id'] = $pool[$drow_id]['id'];
        $winner[$wid]['email'] = $pool[$drow_id]['email'];
        $winner[$wid]['addr'] = $pool[$drow_id]['addr'];
        $winner[$wid]['time'] = $pool[$drow_id]['time'];

        // 製作打馬賽克的名字：某Ｏ某
        $w_mark = mb_substr($pool[$drow_id]['name'], 0, 1, "UTF-8")."Ｏ";
        if( strlen($pool[$drow_id]['name'])>=9 )
          $w_mark .= mb_substr($pool[$drow_id]['name'], -1, 1, "UTF-8");
        $sql_cmd .= "(".$drow_m.",".$winner[$wid]['w_type'].",".$winner[$wid]['idx'].",'".$winner[$wid]['tk']."','".$w_mark."'),";

        $wid++;
        $win_phone[] = $pool[$drow_id]['ph'];
      }
      unset($pool[$drow_id]); // 將這一組資料丟掉（已中獎或著不符資格）
    }  
  }

  $sql_cmd = substr($sql_cmd, 0, -1);
  $res = $conn->query($sql_cmd);
  echo "Insert ".( $res ? "success" : "false" )." !<br>";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=428" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>抽獎囉－五倍勝利金耀眼</title>
    <style>table, td {
      border: 1px solid black;
      border-collapse: collapse;
      padding: 10px;
    }</style>
  </head>
  <body>

  <table>
    <tr>
      <td>月份</td><td>獎項</td>
      <td>流水號</td><td>序號</td>
      <td>姓名</td><td>身分證號</td>
      <td>email</td><td>地址</td>
      <td>電話</td><td>登錄時間</td>
    </tr>
    <?php foreach($winner as $w) : ?><tr>
      <td><?php echo $w['w_M']; ?></td><td><?php echo ( $w['w_type']==1 ? "生活" : "文創" ); ?></td>
      <td><?php echo $w['idx']; ?></td><td><?php echo $w['tk']; ?></td>
      <td><?php echo $w['name']; ?></td><td><?php echo $w['id']; ?></td>
      <td><?php echo $w['email']; ?></td><td><?php echo $w['addr']; ?></td>
      <td><?php echo $w['ph']; ?></td><td><?php echo $w['time']; ?></td>
    </tr><?php endforeach; ?>
  </table>
  </body>
</html>
