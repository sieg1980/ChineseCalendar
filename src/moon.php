<?php

namespace Zimutech\ChineseCalendar;

function GetMoonEclipticLongitudeEC(float $dbJD) : float
{
    $Lp = $D = $M = $Mp = $F = $E = 0.0;
    $dt = ($dbJD - JD2000) / 36525.0; /*儒略世纪数*/

    GetMoonEclipticParameter($dt, $Lp, $D, $M, $Mp, $F, $E);

    /*计算月球地心黄经周期项*/
    $EI = CalcMoonECLongitudePeriodic($D, $M, $Mp, $F, $E);

    /*修正金星,木星以及地球扁率摄动*/
    $EI += CalcMoonLongitudePerturbation($dt, $Lp, $F);

    /*计算月球地心黄经*/
    $longitude = $Lp + $EI / 1000000.0;

    /*计算天体章动干扰*/
    $longitude += CalcEarthLongitudeNutation($dt / 10.0);

    $longitude = Mod360Degree($longitude); /*映射到0-360范围内*/

    return $longitude;
}

function GetMoonEclipticParameter($dt, &$Lp, &$D, &$M, &$Mp, &$F, &$E)
{
    $T = $dt;/*T是从J2000起算的儒略世纪数*/
    $T2 = $T * $T;
    $T3 = $T2 * $T;
    $T4 = $T3 * $T;

    /*月球平黄经*/
    $Lp = 218.3164591 + 481267.88134236 * $T - 0.0013268 * $T2 + $T3/538841.0 - $T4 / 65194000.0;
    $Lp = Mod360Degree($Lp);

    /*月日距角*/
    $D = 297.8502042 + 445267.1115168 * $T - 0.0016300 * $T2 + $T3 / 545868.0 - $T4 / 113065000.0;
    $D = Mod360Degree($D);

    /*太阳平近点角*/
    $M = 357.5291092 + 35999.0502909 * $T - 0.0001536 * $T2 + $T3 / 24490000.0;
    $M = Mod360Degree($M);

    /*月亮平近点角*/
    $Mp = 134.9634114 + 477198.8676313 * $T + 0.0089970 * $T2 + $T3 / 69699.0 - $T4 / 14712000.0;
    $Mp = Mod360Degree($Mp);

    /*月球经度参数(到升交点的平角距离)*/
    $F = 93.2720993 + 483202.0175273 * $T - 0.0034029 * $T2 - $T3 / 3526000.0 + $T4 / 863310000.0;
    $F = Mod360Degree($F);

    $E = 1 - 0.002516 * $T - 0.0000074 * $T2;
}

function CalcMoonECLongitudePeriodic(float $D, float $M, float $Mp, float $F, float $E) : float
{
    $EI = 0.0 ;

    for($i = 0; $i < count(Moon_longitude); $i++)
    {
        $sita = Moon_longitude[$i][0] * $D + Moon_longitude[$i][1] * $M + Moon_longitude[$i][2] * $Mp + Moon_longitude[$i][3] * $F;
        $sita = DegreeToRadian($sita);
        $EI += (Moon_longitude[$i][4] * sin($sita) * pow($E, abs(Moon_longitude[$i][1])));
    }

    return $EI;
}

function CalcMoonLongitudePerturbation(float $dt, float $Lp, float $F) : float
{
    $T = $dt; /*T是从J2000起算的儒略世纪数*/
    $A1 = 119.75 + 131.849 * $T;
    $A2 = 53.09 + 479264.290 * $T;

    $A1 = Mod360Degree($A1);
    $A2 = Mod360Degree($A2);

    $result = 3958.0 * sin(DegreeToRadian($A1));
    $result += (1962.0 * sin(DegreeToRadian($Lp - $F)));
    $result += (318.0 * sin(DegreeToRadian($A2)));

    return $result;
}