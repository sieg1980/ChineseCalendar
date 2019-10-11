<?php

namespace Zimutech\ChineseCalendar;

require_once 'vsop87_data.php';
require_once 'support.php';

function CalcPeriodicTerm(array $coff, int $count, float $dt) : float
{
    $val = 0.0;

    for($i = 0; $i < $count; $i++)
        $val += ($coff[$i][0] * cos(($coff[$i][1] + $coff[$i][2] * $dt)));

    return $val;
}

function CalcSunEclipticLongitudeEC(float $dt) : float
{

    $L0 = CalcPeriodicTerm(Earth_L0, count(Earth_L0), $dt);
    $L1 = CalcPeriodicTerm(Earth_L1, count(Earth_L1), $dt);
    $L2 = CalcPeriodicTerm(Earth_L2, count(Earth_L2), $dt);
    $L3 = CalcPeriodicTerm(Earth_L3, count(Earth_L3), $dt);
    $L4 = CalcPeriodicTerm(Earth_L4, count(Earth_L4), $dt);
    $L5 = CalcPeriodicTerm(Earth_L5, count(Earth_L5), $dt);

    $L = ((((($L5 * $dt + $L4) * $dt + $L3) * $dt + $L2) * $dt + $L1) * $dt + $L0) / 100000000.0;

    /*地心黄经 = 日心黄经 + 180度*/
    return (Mod360Degree(Mod360Degree($L / RADIAN_PER_ANGLE) + 180.0));
}

function CalcSunEclipticLatitudeEC(float $dt) : float
{
    $B0 = CalcPeriodicTerm(Earth_B0, count(Earth_B0), $dt);
    $B1 = CalcPeriodicTerm(Earth_B1, count(Earth_B1), $dt);
    $B2 = CalcPeriodicTerm(Earth_B2, count(Earth_B2), $dt);
    $B3 = CalcPeriodicTerm(Earth_B3, count(Earth_B3), $dt);
    $B4 = CalcPeriodicTerm(Earth_B4, count(Earth_B4), $dt);

    $B = ((((($B4 * $dt) + $B3) * $dt + $B2) * $dt + $B1) * $dt + $B0) / 100000000.0;

    /*地心黄纬 = －日心黄纬*/
    return -($B / RADIAN_PER_ANGLE);
}

function CalcSunEarthRadius(float $dt) : float
{
    $R0 = CalcPeriodicTerm(Earth_R0, count(Earth_R0), $dt);
    $R1 = CalcPeriodicTerm(Earth_R1, count(Earth_R1), $dt);
    $R2 = CalcPeriodicTerm(Earth_R2, count(Earth_R2), $dt);
    $R3 = CalcPeriodicTerm(Earth_R3, count(Earth_R3), $dt);
    $R4 = CalcPeriodicTerm(Earth_R4, count(Earth_R4), $dt);

    $R = ((((($R4 * $dt) + $R3) * $dt + $R2) * $dt + $R1) * $dt + $R0) / 100000000.0;

    return $R;
}

function GetSunEclipticLongitudeEC(float $jde)
{
    $dt = ($jde - JD2000) / 365250.0; /*儒略千年数*/

    // 计算太阳的地心黄经
    $longitude = CalcSunEclipticLongitudeEC($dt);

    // 计算太阳的地心黄纬
    $latitude = CalcSunEclipticLatitudeEC($dt) * 3600.0;

    // 修正精度
    $longitude += AdjustSunEclipticLongitudeEC($dt, $longitude, $latitude);

    // 修正天体章动
    $longitude += CalcEarthLongitudeNutation($dt);

    // 修正光行差
    /*太阳地心黄经光行差修正项是: -20".4898/R*/
    $longitude -= (20.4898 / CalcSunEarthRadius($dt)) / 3600.0;

    return $longitude;
}

function AdjustSunEclipticLongitudeEC(float $dt, float $longitude, float $latitude) : float
{
    $T = $dt * 10; //T是儒略世纪数

    $dbLdash = $longitude - 1.397 * $T - 0.00031 * $T * $T;

    // 转换为弧度
    $dbLdash *= RADIAN_PER_ANGLE;

    return (-0.09033 + 0.03916 * (cos($dbLdash) + sin($dbLdash)) * tan($latitude * RADIAN_PER_ANGLE)) / 3600.0;
}