<?php

namespace Zimutech\ChineseCalendar;

// 计算太阳黄经周期项
const Earth_L0 = [
    [ 175347046.0 ,   0.0000000 ,   000000.0000000 ] ,
    [   3341656.0 ,   4.6692568 ,     6283.0758500 ] ,
    [     34894.0 ,   4.6261000 ,    12566.1517000 ] ,
    [      3497.0 ,   2.7441000 ,     5753.3849000 ] ,
    [      3418.0 ,   2.8289000 ,        3.5231000 ] ,
    [      3136.0 ,   3.6277000 ,    77713.7715000 ] ,
    [      2676.0 ,   4.4181000 ,     7860.4194000 ] ,
    [      2343.0 ,   6.1352000 ,     3930.2097000 ] ,
    [      1324.0 ,   0.7425000 ,    11506.7698000 ] ,
    [      1273.0 ,   2.0371000 ,      529.6910000 ] ,
    [      1799.0 ,   1.1096000 ,     1577.3435000 ] ,
    [       990.0 ,   5.2330000 ,     5884.9270000 ] ,
    [       902.0 ,   2.0450000 ,       26.2980000 ] ,
    [       857.0 ,   3.5080000 ,      398.1490000 ] ,
    [       780.0 ,   1.1790000 ,     5223.6940000 ] ,
    [       753.0 ,   2.5330000 ,     5507.5530000 ] ,
    [       505.0 ,   4.5830000 ,    18849.2280000 ] ,
    [       492.0 ,   4.2050000 ,      775.5230000 ] ,
    [       357.0 ,   2.9200000 ,   000000.0670000 ] ,
    [       317.0 ,   5.8490000 ,    11790.6290000 ] ,
    [       284.0 ,   1.8990000 ,      796.2980000 ] ,
    [       271.0 ,   0.3150000 ,    10977.0790000 ] ,
    [       243.0 ,   0.3450000 ,     5486.7780000 ] ,
    [       206.0 ,   4.8060000 ,     2544.3140000 ] ,
    [       205.0 ,   1.8690000 ,     5573.1430000 ] ,
    [       202.0 ,   2.4580000 ,     6069.7770000 ] ,
    [       156.0 ,   0.8330000 ,      213.2990000 ] ,
    [       132.0 ,   3.4110000 ,     2942.4630000 ] ,
    [       126.0 ,   1.0830000 ,       20.7750000 ] ,
    [       119.0 ,   0.6450000 ,   000000.9800000 ] ,
    [       107.0 ,   0.6360000 ,     4694.0030000 ] ,
    [       102.0 ,   0.9760000 ,    15720.8390000 ] ,
    [       102.0 ,   4.2670000 ,        7.1140000 ] ,
    [        99.0 ,   6.2100000 ,     2146.1700000 ] ,
    [        98.0 ,   0.6800000 ,      155.4200000 ] ,
    [        86.0 ,   5.9800000 ,   161000.6900000 ] ,
    [        85.0 ,   1.3000000 ,     6275.9600000 ] ,
    [        85.0 ,   3.6700000 ,    71430.7000000 ] ,
    [        80.0 ,   1.8100000 ,    17260.1500000 ] ,
    [        79.0 ,   3.0400000 ,    12036.4600000 ] ,
    [        75.0 ,   1.7600000 ,     5088.6300000 ] ,
    [        74.0 ,   3.5000000 ,     3154.6900000 ] ,
    [        74.0 ,   4.6800000 ,      801.8200000 ] ,
    [        70.0 ,   0.8300000 ,     9437.7600000 ] ,
    [        62.0 ,   3.9800000 ,     8827.3900000 ] ,
    [        61.0 ,   1.8200000 ,     7084.9000000 ] ,
    [        57.0 ,   2.7800000 ,     6286.6000000 ] ,
    [        56.0 ,   4.3900000 ,    14143.5000000 ] ,
    [        56.0 ,   3.4700000 ,     6279.5500000 ] ,
    [        52.0 ,   0.1900000 ,    12139.5500000 ] ,
    [        52.0 ,   1.3300000 ,     1748.0200000 ] ,
    [        51.0 ,   0.2800000 ,     5856.4800000 ] ,
    [        49.0 ,   0.4900000 ,     1194.4500000 ] ,
    [        41.0 ,   5.3700000 ,     8429.2400000 ] ,
    [        41.0 ,   2.4000000 ,    19651.0500000 ] ,
    [        39.0 ,   6.1700000 ,    10447.3900000 ] ,
    [        37.0 ,   6.0400000 ,    10213.2900000 ] ,
    [        37.0 ,   2.5700000 ,     1059.3800000 ] ,
    [        36.0 ,   1.7100000 ,     2352.8700000 ] ,
    [        36.0 ,   1.7800000 ,     6812.7700000 ] ,
    [        33.0 ,   0.5900000 ,    17789.8500000 ] ,
    [        30.0 ,   0.4400000 ,    83996.8500000 ] ,
    [        30.0 ,   2.7400000 ,     1349.8700000 ] ,
    [        25.0 ,   3.1600000 ,     4690.4800000 ]
];

const Earth_L1 = [
    [ 628331966747.0 , 0.000000 ,   00000.0000000 ] ,
    [       206059.0 , 2.678235 ,    6283.0758500 ] ,
    [         4303.0 , 2.635100 ,   12566.1517000 ] ,
    [          425.0 , 1.590000 ,       3.5230000 ] ,
    [          119.0 , 5.796000 ,      26.2980000 ] ,
    [          109.0 , 2.966000 ,    1577.3440000 ] ,
    [           93.0 , 2.590000 ,   18849.2300000 ] ,
    [           72.0 , 1.140000 ,     529.6900000 ] ,
    [           68.0 , 1.870000 ,     398.1500000 ] ,
    [           67.0 , 4.410000 ,    5507.5500000 ] ,
    [           59.0 , 2.890000 ,    5223.6900000 ] ,
    [           56.0 , 2.170000 ,     155.4200000 ] ,
    [           45.0 , 0.400000 ,     796.3000000 ] ,
    [           36.0 , 0.470000 ,     775.5200000 ] ,
    [           29.0 , 2.650000 ,       7.1100000 ] ,
    [           21.0 , 5.340000 ,   00000.9800000 ] ,
    [           19.0 , 1.850000 ,    5486.7800000 ] ,
    [           19.0 , 4.970000 ,     213.3000000 ] ,
    [           17.0 , 2.990000 ,    6275.9600000 ] ,
    [           16.0 , 0.030000 ,    2544.3100000 ] ,
    [           16.0 , 1.430000 ,    2146.1700000 ] ,
    [           15.0 , 1.210000 ,   10977.0800000 ] ,
    [           12.0 , 2.830000 ,    1748.0200000 ] ,
    [           12.0 , 3.260000 ,    5088.6300000 ] ,
    [           12.0 , 5.270000 ,    1194.4500000 ] ,
    [           12.0 , 2.080000 ,    4694.0000000 ] ,
    [           11.0 , 0.770000 ,     553.5700000 ] ,
    [           10.0 , 1.300000 ,    6286.6000000 ] ,
    [           10.0 , 4.240000 ,    1349.8700000 ] ,
    [            9.0 , 2.700000 ,     242.7300000 ] ,
    [            9.0 , 5.640000 ,     951.7200000 ] ,
    [            8.0 , 5.300000 ,    2352.8700000 ] ,
    [            6.0 , 2.650000 ,    9437.7600000 ] ,
    [            6.0 , 4.670000 ,    4690.4800000 ]
];

const Earth_L2 = [
    [ 52919.0 ,   0.0000 ,   00000.0000 ] ,
    [ 8720.0  ,   1.0721 ,   6283.0758  ] ,
    [   309.0 ,   0.8670 ,   12566.1520 ] ,
    [    27.0 ,   0.0500 ,       3.5200 ] ,
    [    16.0 ,   5.1900 ,      26.3000 ] ,
    [    16.0 ,   3.6800 ,     155.4200 ] ,
    [    10.0 ,   0.7600 ,   18849.2300 ] ,
    [     9.0 ,   2.0600 ,   77713.7700 ] ,
    [     7.0 ,   0.8300 ,     775.5200 ] ,
    [     5.0 ,   4.6600 ,    1577.3400 ] ,
    [     4.0 ,   1.0300 ,       7.1100 ] ,
    [     4.0 ,   3.4400 ,    5573.1400 ] ,
    [     3.0 ,   5.1400 ,     796.3000 ] ,
    [     3.0 ,   6.0500 ,    5507.5500 ] ,
    [     3.0 ,   1.1900 ,     242.7300 ] ,
    [     3.0 ,   6.1200 ,     529.6900 ] ,
    [     3.0 ,   0.3100 ,     398.1500 ] ,
    [     3.0 ,   2.2800 ,     553.5700 ] ,
    [     2.0 ,   4.3800 ,    5223.6900 ] ,
    [     2.0 ,   3.7500 ,   00000.9800 ]
];

const Earth_L3 = [
    [ 289.0 ,   5.844 , 6283.076  ] ,
    [ 35.0  ,   0.000 , 00000.000 ] ,
    [ 17.0  ,   5.490 , 12566.150 ] ,
    [   3.0 ,   5.200 ,   155.420 ] ,
    [   1.0 ,   4.720 ,     3.520 ] ,
    [   1.0 ,   5.300 , 18849.230 ] ,
    [   1.0 ,   5.970 ,   242.730 ]
];

const Earth_L4 = [
    [ 114.0 , 3.142 , 00000.00 ] ,
    [   8.0 , 4.130 ,  6283.08 ] ,
    [   1.0 , 3.840 , 12566.15 ]
];

const Earth_L5 = [
    [ 1.0 , 3.14 , 0.0 ]
];


// 计算太阳黄纬周期项
const Earth_B0 = [
    [ 280.0 , 3.199 , 84334.662] ,
    [ 102.0 , 5.422 , 5507.553 ] ,
    [ 80.0  , 3.880 , 5223.690 ] ,
    [ 44.0  , 3.700 , 2352.870 ] ,
    [ 32.0  , 4.000 , 1577.340 ]
];

const Earth_B1 = [
    [ 9.0 , 3.90 , 5507.55 ] ,
    [ 6.0 , 1.73 , 5223.69 ]
];

const Earth_B2 = [
    [ 22378.0 , 3.38509 , 10213.28555 ] ,
    [   282.0 , 0.00000 , 00000.00000 ] ,
    [   173.0 , 5.25600 , 20426.57100 ] ,
    [    27.0 , 3.87000 , 30639.86000 ]
];

const Earth_B3 = [
    [ 647.0 , 4.992 , 10213.286 ] ,
    [ 20.0  , 3.140 , 00000.000 ] ,
    [   6.0 , 0.770 , 20426.570 ] ,
    [   3.0 , 5.440 , 30639.860 ]
];

const Earth_B4 = [
    [ 14.0 , 0.32 , 10213.29 ]
];


// 计算日地经距离周期项
const Earth_R0 = [
    [ 100013989   , 0         ,    0           ],
    [ 1670700     , 3.0984635 ,    6283.0758500],
    [ 13956       , 3.05525   ,   12566.15170  ],
    [ 3084        , 5.1985    ,   77713.7715   ],
    [ 1628        , 1.1739    ,   5753.3849    ],
    [ 1576        , 2.8469    ,   7860.4194    ],
    [ 925         , 5.453     ,   11506.770    ],
    [ 542         , 4.564     ,   3930.210     ],
    [ 472         , 3.661     ,   5884.927     ],
    [ 346         , 0.964     ,   5507.553     ],
    [ 329         , 5.900     ,   5223.694     ],
    [ 307         , 0.299     ,   5573.143     ],
    [ 243         , 4.273     ,   11790.629    ],
    [ 212         , 5.847     ,   1577.344     ],
    [ 186         , 5.022     ,   10977.079    ],
    [ 175         , 3.012     ,   18849.228    ],
    [ 110         , 5.055     ,   5486.778     ],
    [ 98          , 0.89      ,   6069.78      ],
    [ 86          , 5.69      ,   15720.84     ],
    [ 86          , 1.27      ,   161000.69    ],
    [ 65          , 0.27      ,   17260.15     ],
    [ 63          , 0.92      ,   529.69       ],
    [ 57          , 2.01      ,   83996.85     ],
    [ 56          , 5.24      ,   71430.70     ],
    [ 49          , 3.25      ,   2544.31      ],
    [ 47          , 2.58      ,   775.52       ],
    [ 45          , 5.54      ,   9437.76      ],
    [ 43          , 6.01      ,   6275.96      ],
    [ 39          , 5.36      ,   4694.00      ],
    [ 38          , 2.39      ,   8827.39      ],
    [ 37          , 0.83      ,   19651.05     ],
    [ 37          , 4.90      ,   12139.55     ],
    [ 36          , 1.67      ,   12036.46     ],
    [ 35          , 1.84      ,   2942.46      ],
    [ 33          , 0.24      ,   7084.90      ],
    [ 32          , 0.18      ,   5088.63      ],
    [ 32          , 1.78      ,   398.15       ],
    [ 28          , 1.21      ,   6286.60      ],
    [ 28          , 1.90      ,   6279.55      ],
    [ 26          , 4.59      ,   10447.39     ]
];

const Earth_R1 = [
    [ 103019 , 1.107490 , 6283.075850 ],
    [ 1721   , 1.0644   , 12566.1517  ],
    [ 702    , 3.142    , 0           ],
    [ 32     , 1.02     , 18849.23    ],
    [ 31     , 2.84     , 5507.55     ],
    [ 25     , 1.32     , 5223.69     ],
    [ 18     , 1.42     , 1577.34     ],
    [ 10     , 5.91     , 10977.08    ],
    [ 9      , 1.42     , 6275.96     ],
    [ 9      , 0.27     , 5486.78     ]
];

const Earth_R2 = [
    [ 4359 , 5.7846 , 6283.0758 ],
    [ 124  , 5.579  , 12566.152 ],
    [ 12   , 3.14   , 0         ],
    [ 9    , 3.63   , 77713.77  ],
    [ 6    , 1.87   , 5573.14   ],
    [ 3    , 5.47   , 18849.23  ]
];

const Earth_R3 = [
    [ 145 , 4.273 , 6283.076 ],
    [   7 , 3.92 ,  12566.15 ]
];

const Earth_R4 = [
    [ 4 , 2.56 , 6283.08 ]
];