<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'SIPPM Del';
?>
<div class="site-index">

    <div class="body-content">
        <h2>Terpopuler</h2>
        <?php
        foreach($model as $data){?>
            <?= Html::a($data->proj_title, ['project/view-project', 'proj_id' => $data->proj_id]) ?>
            <?= $data->proj_description ?>
        <?php
            }
        ?>

        <h2>Menang Kompetisi</h2>
           <?= Html::a('Sistem Informasi Parna Ulos', ['site/proyek']) ?>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>

           <?= Html::a('Sistem Informasi Apul Ulos', ['site/proyek']) ?>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>


            <?= Html::a('Sistem Informasi Batikta', ['site/proyek']) ?>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>

      <h2>Sering Digunakan</h2>
           <?= Html::a('Sistem Informasi Parna Ulos', ['site/proyek']) ?>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>

           <?= Html::a('Sistem Informasi Apul Ulos', ['site/proyek']) ?>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>


            <?= Html::a('Sistem Informasi Batikta', ['site/proyek']) ?>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                
            </div>
</div>

