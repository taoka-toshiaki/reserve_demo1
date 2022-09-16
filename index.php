<?php
ini_set("display_errors",0);
/**
 * @param array $holiday
 * @return string $str
 */
function fn_header($holiday = [])
{
    $str = "";
    $date = new DateTime();
    for ($i = 0; $i < 7; $i++) {
        !$i ? "" : $date->modify('+1 day');
        $w = $date->format("w");
        $tabindex = $i*7;
        $ho = (function ($days, $holiday = []) {
            return (array_search($days, $holiday) !== false) ? "holiday" : "";
        })($date->format("Y-m-d"), $holiday);
        $str .= "
        <th tabindex=$tabindex>
            <span class='header_no week_no_$w $ho'>" . $date->format("Y-m-d") . "</span>
        </th>";
    }
    return $str;
}
/**
 * @param int $h_min
 * @param int $h_max
 * @param int $m_interval
 * @param array $cnt
 * @param array $reserve
 * @param array $holiday
 * @return string $str
 */
function fn_time($h_min, $h_max, $m_interval,$cnt=[],$holiday = [], $reserve = [])
{
    $str= [];
    for ($h = $h_min; $h <= $h_max; $h++) {
        for ($m = 0; $m < 60; $m = $m + $m_interval) {
            print("<tr>\n");
            $date = new DateTime();
            for ($i = 0; $i < 7; $i++) {
                $cnt[$i]=!$cnt[$i]?(((($h_max - $h_min)+1)*(60/$m_interval))*($i))+7:(++$cnt[$i]);
                !$i ? "" : $date->modify('+1 day');
                $w = $date->format("w");
                $ho = (function ($days, $holiday = []) {
                    return (array_search($days, $holiday) !== false) ? "holiday" : "";
                })($date->format("Y-m-d"), $holiday);
                $time = sprintf("%02d:%02d",$h, $m);
                if ($ho) {
                    print("
                        <td class='' tabindex={$cnt[$i]}>
                            <span class='header_no week_no_$w $ho'>" . $time . "</span>
                        </td>");
                } else {
                    $r = (function ($days, $reserve = []) {
                        return (array_search($days, $reserve) !== false) ? "reserve" : "";
                    })($date->format("Y-m-d") . "_" . $time, $reserve);
                    if (!$r) {
                        print("
                            <td class='date_" . $date->format("Y-m-d") . "_{$time}' tabindex={$cnt[$i]} data-date='" . $date->format("Y-m-d") . "_{$time}'>
                                <a class='time_{$m}_" . $date->format("Y-m-d") . "_{$time}' data-sortno={$cnt[$i]}  href='#?data=" . $date->format("Y-m-d") . "_{$time}'><span class='header_no week_no_{$w} {$h}'>{$time}</span></a>
                            </td>");
                    } else {
                        print("
                            <td class='' tabindex={$cnt[$i]}>
                                <span class='header_no week_no_$w $r'>" . $time . "</span>
                            </td>");
                    }
                }
            }
            $date = null;
            print("</tr>\n");
        }
    }
    return "";
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>予約-時刻表(デモ版)</title>
    <style>
        table,tr,td{
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-1">予約-時刻表<br></h1>
                <h5>{予約：時刻をクリックするか、<br>
                    左クリック選択状態で複数選択可能です<br>
                    （日付またぎは禁止しています）}</h5>
                <h5>{ダブルクリックすると予約画面に遷移します。<br>
                    ※DEMO版ですので予約登録画面は御座いません}</h5>
            </div>
        </div>
    </div>
    <div class="container-fluid  text-center">
        <div class="row">
            <div class="col-12">
                <table class="shadow-lg table table-hover table-bordered">
                    <thead>
                        <tr>
                            <?= fn_header() ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?=fn_time(10, 20, 10,[],["2022-09-18","2022-09-23"],["2022-09-19_10:40","2022-09-19_10:50"]) ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <script src="./assets/js/main.js?<?=time()?>"></script>
</body>
</html>
