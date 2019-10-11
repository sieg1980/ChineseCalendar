<?php

namespace Zimutech\ChineseCalendar;

function Mod360Degree(float $degrees) : float
{
    $dbValue = $degrees;

    while($dbValue < 0.0)
        $dbValue += 360.0;

    while($dbValue > 360.0)
        $dbValue -= 360.0;

    return $dbValue;
}

function DegreeToRadian(float $degree) : float
{
    return $degree * PI / 180.0;
}

function CalculateJulianDay(int $year, int $month, int $day, int $hour, int $minute, float $second) : float
{
    $a = intval((14 - $month) / 12);
    $y = $year + 4800 - $a;
    $m = $month + 12 * $a - 3;

    $jdn = $day + intval((153 * $m + 2) / 5) + 365 * $y + intval($y / 4);

    if(IsGregorianDays($year, $month, $day)) {
        $jdn = $jdn - intval($y / 100) + intval($y / 400) - 32045.5;
    } else {
        $jdn -= 32083.5;
    }

    $result = $jdn + $hour / 24.0 + $minute / 1440.0 + $second / 86400.0;

    return $result;
}

function IsGregorianDays(int $year, int $month, int $day) : bool
{
    if($year < 1582)
        return false;

    if($year === 1582)
    {
        if( ($month < 10) || (($month === 10) && ($day < 15)) )
            return false;
    }

    return true;
}

function JDTDtoLocalTime(float $tdJD) : float
{
    $tmp = JDTDtoUTC($tdJD);

    return JDUTCToLocalTime($tmp);
}

function JDTDtoUTC(float $tdJD) : float
{
    $jd2K = $tdJD - JD2000;
    $tian = TdUtcDeltatT2($jd2K);
    $tdJD -= $tian;

    return $tdJD;
}

function JDUTCToLocalTime(float $utcJD) : float
{
    $seconds = -timezone_offset_get(new \DateTimeZone(ini_get('date.timezone')), new \DateTime());
    return $utcJD - floatval($seconds) / 86400.0;
}

function JDLocalTimetoTD(float $localJD) : float
{
    $tmp = JDLocalTimetoUTC($localJD);
    return JDUTCtoTD($tmp);
}

function JDLocalTimetoUTC(float $localJD) : float
{
    $seconds = -timezone_offset_get(new \DateTimeZone(ini_get('date.timezone')), new \DateTime());
    return $localJD + floatval($seconds) / 86400.0;
}

function JDUTCtoTD(float $utcJD) : float
{
    $jd2K = $utcJD - JD2000;
    $tian = TdUtcDeltatT2($jd2K);
    $utcJD += $tian;

    return $utcJD;
}

function ZellerWeek(int $year, int $month, int $day) : int
{
    $m = $month;
    $d = $day;

    if($month <= 2) {
        $year--;
        $m = $month + 12;
    }

    $y = $year % 100;
    $c = ($year - $y) / 100;

    $w = ($y + intval($y / 4) + intval($c / 4) - 2 * $c + intval(13 * ($m + 1) / 5) + $d - 1) % 7;

    if($w < 0) {
        $w += 7;
    }

    return $w;
}

function getDaysOfMonth(int $year, int $month) : int
{
    if($month < 1 || $month > 12) {
        return 0;
    }

    $days = DAYS_OF_MONTH[$month - 1];

    if($month === 2 && isLeapYear($year)) {
        $days++;
    }

    return $days;
}

function isLeapYear(int $year) : bool
{
    return (($year % 4 === 0) && ($year % 100 !== 0)) || ($year % 400 === 0);
}