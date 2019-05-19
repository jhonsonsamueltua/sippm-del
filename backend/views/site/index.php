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
                            'icon' => 'cubes',
                            'header' => 'Proyek',
                            'text' => 'Semua proyek mahasiswa',
                            'number' => '&nbsp;'.$projectCount,
                        ]
                    )
                    ?>
                </a>
            </div>
            <div class="col-xs-12 col-md-4" data-toggle="tooltip" data-placement="top" title="Lihat Proyek Menang Kompetisi">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/all-project', 'type' => 'winComp']) ?>">
                    <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'trophy',
                            'header' => 'Menang Kompetisi',
                            'text' => "Proyek menang kompetisi",
                            'number' => '&nbsp;'.$projectWinCompetitionCount,
                        ]
                    )
                    ?>
                </a>
            </div>
            <div class="col-xs-12 col-md-4" data-toggle="tooltip" data-placement="top" title="Lihat Proyek Per Sub Kategori">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/category-project']) ?>">
                    <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'list-alt',
                            'header' => 'Sub Kategori',
                            'text' => 'Sub Kategori Proyek',
                            'number' => '&nbsp;'.$subCategoryCount,
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
                <?php
                    $tahun = array();
                    $jumlah = array();
                    foreach ($modelGrafik as $key => $value) {
                        array_push($tahun, $value["asg_year"]);
                        array_push($jumlah, (int)$value["count(sp.proj_id)"]);
                    }
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
                            'categories' => $tahun
                        ],
                        'yAxis' => [
                            'title' => [
                                'text' => 'Jumlah Proyek'
                            ]
                        ],
                        'series' => [
                            ['name' => 'Tahun', 'data' => $jumlah],
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
