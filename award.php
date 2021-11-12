<?php
  include "iouse.php";

  /* 設定時間遮罩 */
  $now = strtotime('now'); // strtotime("2022/1/18 00:00:00");
  $open = array();
  if( $now>strtotime("2021/11/17 00:00:00") ) $open[] = 11;
  if( $now>strtotime("2021/12/17 00:00:00") ) $open[] = 12;
  if( $now>strtotime("2022/1/17 00:00:00") ) $open[] = 1;
  if( $now>strtotime("2022/2/17 00:00:00") ) $open[] = 2;
  if( $now>strtotime("2022/3/17 00:00:00") ) $open[] = 3;
  if( $now>strtotime("2022/4/17 00:00:00") ) $open[] = 4;
  if( $now>strtotime("2022/5/17 00:00:00") ) $open[] = 5;
  $mask = count($open);

  /* init string */
  $win_1 = [ 11 => "<table>", 12 => "<table>", 1=> "<table>",
              2 => "<table>", 3 => "<table>",  4 => "<table>", 5=> "<table>" ];
  $win_2 = [ 11 => "<table>", 12 => "<table>", 1=> "<table>",
              2 => "<table>", 3 => "<table>",  4 => "<table>", 5=> "<table>" ];

  /* 每個月的抽獎結果 */
  foreach( $open as $m ) {
    $res = $conn->query("SELECT ticket_ser, winner_name FROM winner where w_M=".$m." and w_type=1 limit 10");
    if( $res->num_rows<=0 ) { // 可能不是月份，do nothing
      //echo "no data!<br>";
    } else {
      while( $row=$res->fetch_assoc() ) {
        $str_arr = str_split($row["ticket_ser"],4);
        $win_1[$m] .= "<tr><td>".$row['winner_name']."</td><td>".$str_arr[0]." ".$str_arr[1]." ".$str_arr[2]."</td></tr>";
      }
    }

    $res = $conn->query("SELECT ticket_ser, winner_name FROM winner where w_M=".$m." and w_type=2 limit 20");
    if( $res->num_rows<=0 ) ; // 可能不是月份，do nothing
    else {
      while( $row=$res->fetch_assoc() ) {
        $str_arr = str_split($row["ticket_ser"],4);
        $win_2[$m] .= "<tr><td>".$row['winner_name']."</td><td>".$str_arr[0]." ".$str_arr[1]." ".$str_arr[2]."</td></tr>";
      }
    }
  }

  /* close string */
  foreach( $win_1 as $m => $v ) {
    $win_1[$m] .= "</table>";
    $win_2[$m] .= "</table>";
  }

  /* 5/20 年度大抽獎 */

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=428" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>得獎名單－五倍勝利金耀眼</title>
    <link href="./style.css" rel="stylesheet" />
  </head>
  <body>
    <div class="wrapper">
      <?php include "header.html"; ?>
      <div class="main">
        <img src="./img/awardKv.jpg" class="tFull" alt="" />
        <div class="awardCon">
          <div class="block">
            <div class="title">
              <span>2021/11/15 中獎名單</span><?php if($mask<1) : ?><b>尚未開獎</b><?php endif; ?>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww"><div class="a1">
              <h2>生活好物×10名</h2><?php echo $win_1[11]; ?>
              <h2>勝利星村文創好物×20名</h2><?php echo $win_2[11]; ?>
            </div></div>
          </div>
          <div class="block">
            <div class="title">
              <span>2021/12/15 中獎名單</span><?php if($mask<2) : ?><b>尚未開獎</b><?php endif; ?>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww"><div class="a1">
              <h2>生活好物×10名</h2><?php echo $win_1[12]; ?>
              <h2>勝利星村文創好物×20名</h2><?php echo $win_2[12]; ?>
            </div></div>
          </div>
          <div class="block">
            <div class="title">
              <span>2022/01/15 中獎名單</span><?php if($mask<3) : ?><b>尚未開獎</b><?php endif; ?>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww"><div class="a1">
              <h2>生活好物×10名</h2><?php echo $win_1[1]; ?>
              <h2>勝利星村文創好物×20名</h2><?php echo $win_2[1]; ?>
            </div></div>
          </div>
          <div class="block">
            <div class="title">
              <span>2022/02/15 中獎名單</span><?php if($mask<4) : ?><b>尚未開獎</b><?php endif; ?>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww"><div class="a1">
              <h2>生活好物×10名</h2><?php echo $win_1[2]; ?>
              <h2>勝利星村文創好物×20名</h2><?php echo $win_2[2]; ?>
            </div></div>
          </div>
          <div class="block">
            <div class="title">
              <span>2022/03/15 中獎名單</span><?php if($mask<5) : ?><b>尚未開獎</b><?php endif; ?>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww"><div class="a1">
              <h2>生活好物×10名</h2><?php echo $win_1[3]; ?>
              <h2>勝利星村文創好物×20名</h2><?php echo $win_2[3]; ?>
            </div></div>
          </div>
          <div class="block">
            <div class="title">
              <span>2022/04/15 中獎名單</span><?php if($mask<6) : ?><b>尚未開獎</b><?php endif; ?>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww"><div class="a1">
              <h2>生活好物×10名</h2><?php echo $win_1[4]; ?>
              <h2>勝利星村文創好物×20名</h2><?php echo $win_2[4]; ?>
            </div></div>
          </div>
          <div class="block">
            <div class="title">
              <span>2022/05/15 中獎名單</span><?php if($mask<7) : ?><b>尚未開獎</b><?php endif; ?>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww"><div class="a1">
              <h2>生活好物×10名</h2><?php echo $win_1[5]; ?>
              <h2>勝利星村文創好物×20名</h2><?php echo $win_2[5]; ?>
            </div></div>
          </div>
        </div>
        <img src="./img/text4.jpg" class="text4" alt="" />
        <div class="awardCon">
          <div class="block">
            <div class="title">
              <span>中獎名單</span> <b>尚未開獎</b>
              <img
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAALABIDASIAAhEBAxEB/8QAFwABAQEBAAAAAAAAAAAAAAAACAAECv/EACQQAAEEAwACAQUBAAAAAAAAAAUDBAYHAQIICRYAChITFBcV/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AFzb9n9s/Tk9rzW7rSmlxdoeIHsy3XkosSVSsi/nFs8tWvNHumq5N09XzqnpvrphBmMSSwLjFmRgYzj+iAKfgRKpLP2X5Buh/PXfb/xfeICYFYlyWMbCnXcXf7YceFA8wctnbLmAwVVXUIa2Bl0kHwhIKgsHlF1HWhIA3XjlMgJxLpJ2FWjV1d3bXczqS24ZH7DrSw4+Qi01hUpHolAEjAFEcoPR5BkvjOu+m+ucKILp5TdM3SaDxmu3dt0F0xf4teXOf+TOKabr7nar4/V8VPR9rO5C0Dbkn5GSzKSoJODMlk8iPPy0kkhhxqm2YIPThZ+qOCjxYEbs0CCRo9oCHrHn3+aVrXtc/wBnvWa+gQeJwn3Kbz3BmZy31UAPBezS4vgWhgrJz36H+qfJYQRw+Ku3brCSf5fsxfEN8vgf/9k="
              />
            </div>
            <div class="awww">
              <div class="a1">
                <h2>五倍勝利金牌獎×1名</h2>
                <table>
                  <!--tr>
                    <td>林O逸</td>
                    <td>ABCD 1234 Q567</td>
                  </tr-->
                </table>
                <h2>勝利銀牌獎×2名</h2>
                <table>
                  <!--tr>
                    <td>林O逸</td>
                    <td>ABCD 1234 Q567</td>
                  </tr-->
                </table>
                <h2>勝利銅牌獎×3名</h2>
                <table>
                  <!--tr>
                    <td>林O逸</td>
                    <td>ABCD 1234 Q567</td>
                  </tr-->
                </table>
              </div>
            </div>
          </div>
        </div>
        <img src="./img/text5.jpg" class="text4" alt="" />
      </div>
      <footer><img src="./img/footer.jpg" alt="" /></footer>
    </div>
    <script src="./app.js"></script>
  </body>
</html>
