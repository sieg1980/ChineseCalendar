<?php

namespace Zimutech\ChineseCalendar;

require_once 'calendar_const.php';
require_once 'calendar_func.php';
require_once 'vsop87_data.php';
require_once 'elp2000_data.php';
require_once 'nutation.php';
require_once 'td_utc.php';
require_once 'sun.php';
require_once 'moon.php';
require_once 'holiday.php';

class ChineseCalender
{
    private $year;
    private $solarTermsJD;
    private $newMoonJD;
    private $chnMonthInfo;

    public function setYear(int $year)
    {
        $this->year = $year;
        $this->newMoonJD = [];
        $this->chnMonthInfo = [];
        $this->monthInfo = [];

        $this->CalculateProcData();

        if($this->BuildAllChnMonthInfo() === false) {
            return false;
        }

        $this->CalcLeapChnMonth();
        $this->BuildAllMonthInfo();

        return $this->export();
    }

    public function export() : array
    {
        global $holiday;

        $data = [];

        for($m = 0; $m < 12; $m++)
        {
            $mi = $this->monthInfo[$m];
            $weekCount = [
                '0' => 0,
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0
            ];

            for($n = 0; $n < $mi['days']; $n++)
            {
                $di = $mi['dayInfo'][$n];
                $weekCount[$di['week']]++;

                $data[$m][$n] = [
                    'dayNo' => $di['dayNo'],
                    'weekNo' => $di['week'],
                    'mmonthNo' => $di['mmonthNo'],
                    'mmonthName' => $di['leap'] ? '闰' . nameOfChnMonth[$di['mmonthNo'] - 1] . '月' : nameOfChnMonth[$di['mmonthNo'] - 1] . '月',
                    'mdayNo' => $di['mdayNo'],
                    'mdayName' => nameOfChnDay[$di['mdayNo']],
                    'st' => $di['st'] === '' ? null : $di['st'],
                    'holiday' => []
                ];

                if(isset($holiday['western']['fixed'][$m + 1][$n + 1]))
                    $data[$m][$n]['holiday'][] = $holiday['western']['fixed'][$m + 1][$n + 1];

                if(isset($holiday['chinese'][$di['mmonthNo']][$di['mdayNo'] + 1]))
                    $data[$m][$n]['holiday'][] = $holiday['chinese'][$di['mmonthNo']][$di['mdayNo'] + 1];

                if(isset($holiday['western']['ordered'][$m + 1][$weekCount[$di['week']]][$di['week']]))
                    $data[$m][$n]['holiday'][] = $holiday['western']['ordered'][$m + 1][$weekCount[$di['week']]][$di['week']];

                if(empty($data[$m][$n]['holiday'])) {
                    $data[$m][$n]['holiday'] = null;
                } else {
                    $data[$m][$n]['holiday'] = implode('\n', $data[$m][$n]['holiday']);
                }
            }
        }

        return $data;
    }

    private function CalculateProcData()
    {
        //计算从上一年冬至开始到今天冬至全部25个节气
        $this->GetAllSolarTermsJD($this->year - 1, 冬至);

        $lastDongZhi = JDLocalTimetoTD($this->solarTermsJD[0]);

        //求与冬至最近的一个朔日
        $tmpShuo = CalculateMoonShuoJD($lastDongZhi);
        $tmpShuo = JDTDtoLocalTime($tmpShuo);

        if($tmpShuo > $this->solarTermsJD[0])
            $tmpShuo -= 29.53;

        $this->GetNewMoonJDs($tmpShuo);
    }

    private function BuildAllChnMonthInfo()
    {
        //一年最多可13个农历月
        $info = [];

        //采用夏历建寅，冬至所在月份为农历11月
        $yuejian = 11;

        for($i = 0; $i < (NEW_MOON_CALC_COUNT - 1); $i++)
        {
            $info['mmonth'] = $i;
            $info['mname'] = ($yuejian <= 12) ? $yuejian : $yuejian - 12;
            $info['shuoJD'] = $this->newMoonJD[$i];
            $info['nextJD'] = $this->newMoonJD[$i + 1];
            $info['mdays'] = intval($info['nextJD'] + 0.5) - intval($info['shuoJD'] + 0.5);
            $info['leap'] = false;

            $this->chnMonthInfo[] = $info;

            $yuejian++;
        }

        return (count($this->chnMonthInfo) === (NEW_MOON_CALC_COUNT - 1));
    }

    private function CalcLeapChnMonth()
    {
        //第13月的月末没有超过冬至，说明今年需要闰一个月
        if(intval($this->newMoonJD[13] + 0.5) <= intval($this->solarTermsJD[24] + 0.5)) {

            $i = 1;

            //找到第一个没有中气的月
            while($i < (NEW_MOON_CALC_COUNT - 1))
            {
                if(intval($this->newMoonJD[$i + 1] + 0.5) <= intval($this->solarTermsJD[2 * $i] + 0.5))
                    break;
                $i++;
            }

            // 找到闰月，对后面的农历月调整月名
            if($i < (NEW_MOON_CALC_COUNT - 1)) {
                $this->chnMonthInfo[$i]['leap'] = true;

                while($i < (NEW_MOON_CALC_COUNT - 1))
                {
                    $this->chnMonthInfo[$i++]['mname']--;
                }
            }
        }
    }

    private function BuildAllMonthInfo() : bool
    {
        for($i = 0; $i < MONTHES_FOR_YEAR; $i++)
        {
            if($this->BuildMonthInfo($i + 1) === false) {
                return false;
            }
        }

        return true;
    }

    private function BuildMonthInfo(int $month) : bool
    {
        $info = [];
        $info['month'] = $month;
        $info['first_week'] = ZellerWeek($this->year, $info['month'], 1);
        $info['days'] = GetDaysOfMonth($this->year, $info['month']);

        if($this->BuildMonthAllDaysInfo($info)) {
            $this->monthInfo[] = $info;

            return true;
        }

        return false;
    }

    private function BuildMonthAllDaysInfo(array &$mi) : bool
    {
        $info = [];
        $mi['dayInfo'] = [];

        for($j = 0; $j < $mi['days']; $j++)
        {
            $today = CalculateJulianDay($this->year, $mi['month'], $j + 1, 0, 0, 1);

            $info['dayNo'] = $j + 1;
            $info['week'] = ($mi['first_week'] + $j) % DAYS_FOR_WEEK;
            $cm = $this->FindChnMonthInfo($today);
            $info['mmonth'] = $cm['mmonth'];
            $info['mmonthNo'] = $cm['mname'];
            $info['mdayNo'] = intval($today + 0.5) - intval($cm['shuoJD'] + 0.5);
            $info['st'] = $this->GetSolarTermsName($today);
            $info['leap'] = $cm['leap'];

            $mi['dayInfo'][] = $info;
        }

        return count($mi['dayInfo']) === $mi['days'];
    }

    private function GetSolarTermsName(float $today) : string
    {
        $i = 0;

        while($i < SOLAR_TERMS_CALC_COUNT)
        {
            if(intval($this->solarTermsJD[$i] + 0.5) == intval($today + 0.5)) {
                return nameOfJieQi[($i + 18) % SOLAR_TERMS_COUNT];
            }
            $i++;
        }

        return '';
    }

    private function FindChnMonthInfo(float $todayJD) : array
    {
        $this_day = intval($todayJD + 0.5);

        $k = 0;
        while($k < count($this->chnMonthInfo))
        {
            $last_day = intval($this->chnMonthInfo[$k]['shuoJD'] + 0.5);
            $next_day = intval($this->chnMonthInfo[$k]['nextJD'] + 0.5);

            if(($this_day >= $last_day) && ($this_day < $next_day))
            {
                return $this->chnMonthInfo[$k];
            }
            $k++;
        }

        // 异常出现时，总是返回第一个月信息
        return $this->chnMonthInfo[0];
    }

    private function GetAllSolarTermsJD(int $year, int $start)
    {
        //从某一年的某个节气开始，连续计算25个节气，返回各节气的儒略日，本地时间
        $i = 0;
        $st = $start;

        while($i < 25)
        {
            $jd = CalculateSolarTerms($year, $st * 15);
            $this->solarTermsJD[$i++] = JDTDtoLocalTime($jd);

            if($st === 冬至) {
                $year++;
            }

            $st = ($st + 1) % SOLAR_TERMS_COUNT;
        }
    }

    private function GetNewMoonJDs(float $jd)
    {
        $tdjd = JDLocalTimetoTD($jd);

        for($i = 0; $i < NEW_MOON_CALC_COUNT; $i++)
        {
            $shuoJD = CalculateMoonShuoJD($tdjd);
            $shuoJD = JDTDtoLocalTime($shuoJD);
            $this->newMoonJD[$i] = $shuoJD;

            $tdjd += 29.5; /*转到下一个最接近朔日的时间*/
        }
    }
}

