<?php

namespace ityakutia\collective\controllers;

use ityakutia\collective\models\Collective;
use ityakutia\collective\models\CollectiveSearch;
use uraankhayayaal\materializecomponents\imgcropper\actions\UploadAction;
use uraankhayayaal\sortable\actions\Sorting;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FrontController extends Controller
{
    public function actionIndex()
    {
        $view = Yii::$app->params['custom_view_for_modules']['collective_front']['index'] ?? 'index';

        $searchModel = new CollectiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();

        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $view = Yii::$app->params['custom_view_for_modules']['collective_front']['view'] ?? 'view';

        $model = $this->findModel($id);

        return $this->render($view, [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        $model = Collective::findOne($id);
        if (null === $model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
