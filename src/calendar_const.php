<?php

namespace Zimutech\ChineseCalendar;

const MONTHES_FOR_YEAR = 12;
const DAYS_FOR_WEEK = 7;


const SOLAR_TERMS_COUNT = 24;

const JD2000 = 2451545.0;
// 圆周率
const PI = 3.1415926535897932384626433832795;

// 一度代表的弧度
const RADIAN_PER_ANGLE = PI / 180.0;

// 节气定义
const 春分 = 0;
const 清明 = 1;
const 谷雨 = 2;
const 立夏 = 3;
const 小满 = 4;
const 芒种 = 5;
const 夏至 = 6;
const 小暑 = 7;
const 大暑 = 8;
const 立秋 = 9;
const 处暑 = 10;
const 白露 = 11;
const 秋分 = 12;
const 寒露 = 13;
const 霜降 = 14;
const 立冬 = 15;
const 小雪 = 16;
const 大雪 = 17;
const 冬至 = 18;
const 小寒 = 19;
const 大寒 = 20;
const 立春 = 21;
const 雨水 = 22;
const 惊蛰 = 23;

const DAYS_OF_MONTH = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

const SOLAR_TERMS_CALC_COUNT = 25;
const NEW_MOON_CALC_COUNT = 15;

const nameOfWeek = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
const nameOfStems = ["甲", "乙", "丙", "丁", "戊", "己", "庚", "辛", "壬", "癸"];
const nameOfBranches = ["子", "丑", "寅", "卯", "辰", "巳", "午", "未", "申", "酉", "戌", "亥"];
const nameOfShengXiao = ["鼠", "牛", "虎", "兔", "龙", "蛇", "马", "羊", "猴", "鸡", "狗", "猪"];
const nameOfChnDay = ["初一", "初二", "初三", "初四", "初五", "初六", "初七", "初八", "初九", "初十", "十一", "十二", "十三", "十四", "十五", "十六", "十七", "十八", "十九", "二十", "廿一", "廿二", "廿三", "廿四", "廿五", "廿六", "廿七", "廿八", "廿九", "三十"];
const nameOfChnMonth = ["正", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "腊"];
const nameOfJieQi = ["春分", "清明", "谷雨", "立夏", "小满", "芒种", "夏至", "小暑", "大暑", "立秋", "处暑", "白露", "秋分", "寒露", "霜降", "立冬", "小雪", "大雪", "冬至", "小寒", "大寒", "立春", "雨水", "惊蛰" ];