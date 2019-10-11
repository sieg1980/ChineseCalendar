<?php

namespace Zimutech\ChineseCalendar;

function CalculateSolarTerms(int $year, int $angle) : float
{
    $jd1 = GetInitialEstimateSolarTerms($year, $angle);

    do {
        $jd0 = $jd1;
        $stDegree = GetSunEclipticLongitudeEC($jd0);

        /*
            对黄经0度迭代逼近时，由于角度360度圆周性，估算黄经值可能在(345,360]和[0,15)两个区间，
            如果值落入前一个区间，需要进行修正
        */

        $stDegree = (($angle === 0) && ($stDegree > 345.0)) ? $stDegree - 360.0 : $stDegree;
        $stDegreep = (GetSunEclipticLongitudeEC($jd0 + 0.000005) - GetSunEclipticLongitudeEC($jd0 - 0.000005)) / 0.00001;

        $jd1 = $jd0 - ($stDegree - $angle) / $stDegreep;

    } while(abs($jd1 - $jd0) > 0.0000001);

    return $jd1;
}

function GetInitialEstimateSolarTerms(int $year, int $angle) : float
{
    $solarTermMonth = intval(ceil(floatval(($angle + 90.0) / 30.0)));
    $solarTermMonth = $solarTermMonth > 12 ? $solarTermMonth - 12 : $solarTermMonth;

    // 每月第一个节气发生日期基本都4-9日之间，第二个节气的发生日期都在16－24日之间
    if(($angle % 15 === 0) && ($angle % 30 !== 0)) {
        return CalculateJulianDay($year, $solarTermMonth, 6, 12, 0, 0.00);
    } else {
        return CalculateJulianDay($year, $solarTermMonth, 20, 12, 0, 0.00);
    }
}

function CalculateMoonShuoJD(float $tdJD) : float
{
    $JD1 = $tdJD;
    do {
        $JD0 = $JD1;

        $moonLongitude = GetMoonEclipticLongitudeEC($JD0);
        $sunLongitude = GetSunEclipticLongitudeEC($JD0);

        if(($moonLongitude > 330.0) && ($sunLongitude < 30.0)) {
            $sunLongitude = 360.0 + $sunLongitude;
        }

        if(($sunLongitude > 330.0) && ($moonLongitude < 30.0)) {
            $moonLongitude = 60.0 + $moonLongitude;
        }

        $stDegree = $moonLongitude - $sunLongitude;

        if($stDegree >= 360.0)
            $stDegree -= 360.0;

        if($stDegree < -360.0)
            $stDegree += 360.0;

        $stDegreep = (GetMoonEclipticLongitudeEC($JD0 + 0.000005) - GetSunEclipticLongitudeEC($JD0 + 0.000005) - GetMoonEclipticLongitudeEC($JD0 - 0.000005) + GetSunEclipticLongitudeEC($JD0 - 0.000005)) / 0.00001;

        $JD1 = $JD0 - $stDegree / $stDegreep;
    } while((abs($JD1 - $JD0) > 0.00000001));

    return $JD1;
}