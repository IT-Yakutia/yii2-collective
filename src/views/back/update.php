<?php

$this->title = 'Редактирование: ' . $model->name;
?>
<div class="collective-update">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>
</div>
