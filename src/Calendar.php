<?php

namespace Zimutech\ChineseCalendar;

require_once 'ChineseCalendar.php';
require_once 'support.php';

class Calendar
{
    static public function make(int $year) : string
    {
        $cc = new ChineseCalender();
        $data = [];

        // 生成前后三年的年历
        $last = $cc->setYear($year - 1);
        $current = $cc->setYear($year);
        $next = $cc->setYear($year + 1);

        for($m = 0; $m < 12; $m++)
        {
            // 根据当月的第一天是星期几来确认前面需要补几天
            $before = $current[$m][0]['weekNo'];

            // 根据前面需要补的天数和当月的总天数来确认后面需要补的天数
            $after = 42 - $before - getDaysOfMonth($year, $m + 1);

            if($m !== 0) {
                // 上个月属于本年
                $totalDays = getDaysOfMonth($year, $m);
                for($n = $totalDays - $before; $n < $totalDays; $n++)
                {
                    $today = $current[$m - 1][$n];
                    $data[$m][] = [
                        'weekday' => $today['weekNo'],
                        'day' => $today['dayNo'],
                        'lunarMonth' => $today['mmonthName'],
                        'lunarDay' => $today['mdayName'],
                        'holiday' => $today['holiday'],
                        'jieQi' => $today['st'],
                        'grey' => true
                    ];
                }
            } else {
                for($n = 31 - $before; $n < 31; $n++)
                {
                    $today = $last[11][$n];
                    $data[$m][] = [
                        'weekday' => $today['weekNo'],
                        'day' => $today['dayNo'],
                        'lunarMonth' => $today['mmonthName'],
                        'lunarDay' => $today['mdayName'],
                        'holiday' => $today['holiday'],
                        'jieQi' => $today['st'],
                        'grey' => true
                    ];
                }
            }

            for($n = 0; $n < getDaysOfMonth($year, $m + 1); $n++)
            {
                $today = $current[$m][$n];
                $data[$m][] = [
                    'weekday' => $today['weekNo'],
                    'day' => $today['dayNo'],
                    'lunarMonth' => $today['mmonthName'],
                    'lunarDay' => $today['mdayName'],
                    'holiday' => $today['holiday'],
                    'jieQi' => $today['st']
                ];
            }

            if($m !== 11) {
                for($n = 0; $n < $after; $n++)
                {
                    $today = $current[$m + 1][$n];
                    $data[$m][] = [
                        'weekday' => $today['weekNo'],
                        'day' => $today['dayNo'],
                        'lunarMonth' => $today['mmonthName'],
                        'lunarDay' => $today['mdayName'],
                        'holiday' => $today['holiday'],
                        'jieQi' => $today['st'],
                        'grey' => true
                    ];
                }
            } else {
                for($n = 0; $n < $after; $n++)
                {
                    $today = $next[0][$n];
                    $data[$m][] = [
                        'weekday' => $today['weekNo'],
                        'day' => $today['dayNo'],
                        'lunarMonth' => $today['mmonthName'],
                        'lunarDay' => $today['mdayName'],
                        'holiday' => $today['holiday'],
                        'jieQi' => $today['st'],
                        'grey' => true
                    ];
                }
            }
        }

        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $json = str_replace('\\\\n', '\\n', $json);

        return 'var calendar = ' . $json;
    }
}