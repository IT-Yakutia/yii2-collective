<?php

use yii\helpers\Url;

?>
    <div class="col-12 col-md-6 col-lg-4 mb-3">
        <a href="<?= Url::toRoute(['/collective/front/view', 'id' => $model->id]); ?>">
            <div class="card">
                <img class="card-img-top mw-100" src="<?= $model->photo; ?>" alt="<?= $model->name; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $model->post; ?></h5>
                    <p class="card-text"><?= $model->name; ?></p>
                </div>
            </div>
        </a>
    </div>

