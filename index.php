<?php
require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Regression\LeastSquares;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['tinggi_badan'])) {
        $myArr = [
            'code' => '400',
            'status' => 'BAD_REQUEST',
            'errors' => [
                'tinggi_badan' => ['must be not null']
            ],
        ];
        $myJSON = json_encode($myArr);
        echo $myJSON;
        die;
    }

    if ($_POST['tinggi_badan'] < 100) {
        $myArr = [
            'code' => '400',
            'status' => 'BAD_REQUEST',
            'errors' => [
                'aplikasi ini tidak cocok digunakan untuk anak usia balita'
            ],
        ];
        $myJSON = json_encode($myArr);
        echo $myJSON;
        die;
    }

    $samples = [
        [189], [195], [155], [191], [172], [185],
        [157], [185], [190], [168], [153], [180],
        [177], [192], [165], [154], [187], [169],
        [199], [184], [181], [188], [180], [173],
        [153], [174], [166], [162], [157], [190],
    ];
    $targets = [
        87, 81, 51, 79, 67, 81,
        56, 76, 83, 59, 51, 75,
        61, 90, 57, 54, 70, 54,
        99, 76, 78, 80, 73, 82,
        78, 65, 61, 58, 52, 80,
    ];

    $regression = new LeastSquares();
    $regression->train(
        $samples,
        $targets
    );
    $coba = $_POST['tinggi_badan'];
    $result = $regression->predict([$coba]);

    $myArr = [
        'code' => 200,
        'status' => 'Ok',
        'data' => [
            'berat_badan' => "$result"
        ]
    ];
    $myJSON = json_encode($myArr);
    echo $myJSON;
    die;
} else {
    $myArr = [
        'code' => '400',
        'status' => 'Unauthorized',
        'errors' => ['wrong method'],
    ];
    $myJSON = json_encode($myArr);
    echo $myJSON;
    die;
}
