<?php

/* @var $this yii\web\View */
use yiister\gentelella\widgets\Panel;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?php
        Panel::begin(
            [
                'header' => 'Dashboard',
                'icon' => 'dashboard',
            ]
        )
    ?>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/konten1']) ?>">
                    <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'users',
                            'header' => 'Mahasiswa',
                            'text' => "Mahasiswa yang terdaftar",
                            'number' => '1807',
                        ]
                    )
                    ?>
                </a>
            </div>
            <div class="col-xs-12 col-md-4">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/konten2']) ?>">
                    <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'user',
                            'header' => 'Pengajar',
                            'text' => 'Dosen dan asisten akademik yang terdaftar',
                            'number' => '150',
                        ]
                    )
                    ?>
                </a>
            </div>
            <div class="col-xs-12 col-md-4">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/konten3']) ?>">
                    <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'list-alt',
                            'header' => 'Proyek',
                            'text' => 'Semua proyek mahasiswa',
                            'number' => '120',
                        ]
                    )
                    ?>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-7">
                <?php
                    Panel::begin(
                        [
                            'header' => 'Grafik Pengunjung',
                            'icon' => 'bar-chart',
                        ]
                    )
                ?>
                <?=
                    \dosamigos\highcharts\HighCharts::widget([
                    'clientOptions' => [
                        'chart' => [
                            'type' => 'bar'
                        ],
                        'title' => [
                            'text' => 'Grafik Pengunjung Tahun 20..'
                        ],
                        'xAxis' => [
                            'categories' => [
                                'Januari',
                                'Februari',
                                'Maret', 
                                '....',

                            ]
                        ],
                        'yAxis' => [
                            'title' => [
                                'text' => 'Pengunjung'
                            ]
                        ],
                        'series' => [
                            ['name' => 'Mahasiswa', 'data' => [1, 6, 4, 10]],
                            ['name' => 'Pengajar', 'data' => [5, 7, 3,10]]
                        ]
                    ]
                    ]);
                ?>
                <?php Panel::end() ?>
            </div>
            <div class="col-xs-12 col-md-5">
                <?php
                    Panel::begin(
                        [
                            'header' => 'Top 10 Proyek Mahasiswa',
                            'icon' => 'star',
                        ]
                    )
                ?>

                <?php Panel::end() ?>
            </div>
        </div>
    <?php Panel::end() ?>

    
</div>
