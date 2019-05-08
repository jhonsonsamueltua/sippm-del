<?php

use yii\helpers\Html;

?>

<div class="container">
<?php

    foreach($searchRes as $res){
        echo("
            <div><h2>" . Html::a($res['proj_title'], ['/project/view-project', 'proj_id' => $res['id']]) . "</h2></div>
            <div><p>" . $res['proj_description'] . "</p></div>
        ");
    }

?>
</div>
