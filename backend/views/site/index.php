<?php

/* @var $this yii\web\View */
use yiister\gentelella\widgets\Panel;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?php
        Panel::begin(
            [
                'header' => 'Beranda',
                'icon' => 'dashboard',
            ]
        )
    ?>
        <div class="row">
            <div class="col-xs-12 col-md-4" data-toggle="tooltip" data-placement="top" title="Lihat Semua Proyek">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/all-project']) ?>">
                    <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'file-o',
                            'header' => 'Proyek',
                            'text' => 'Semua proyek mahasiswa',
                            'number' => '&nbsp;'.$projectCount,
                        ]
                    )
                    ?>
                </a>
            </div>
            <div class="col-xs-12 col-md-4">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/konten1']) ?>">
                    <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'users',
                            'header' => 'Mahasiswa',
                            'text' => "Mahasiswa yang terdaftar",
                            'number' => '&nbsp;'.'1807',
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
                            'number' => '&nbsp;'.'150',
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
                            'header' => 'Grafik Proyek',
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
                            'text' => 'Jumlah Proyek Tiap Tahun'
                        ],
                        'xAxis' => [
                            'categories' => [
                                '2019',
                                '2018',
                                '2017',
                                '2016',

                            ]
                        ],
                        'yAxis' => [
                            'title' => [
                                'text' => 'Jumlah Proyek'
                            ]
                        ],
                        'series' => [
                            ['name' => 'Jumlah Proyek', 'data' => [1, 6, 4, 10]],
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
                
                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0" >
                    <thead>
                    <tr> 
                        <th>#</th>
                        <th>Proyek</th>
                        <th>Unduh</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach ($modelTop as $data) {?>
                            
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $data->proj_title ?></td>
                                <td><?= $data->proj_downloaded ?></td>
                            </tr>

                        <?php
                                $i++;
                            }
                        ?>
                    </tbody>
                </table>

                <?php Panel::end() ?>
            </div>
        </div>
    <?php Panel::end() ?>

    
</div>
