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

class BackController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['collective']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'uploadImg' => [
                'class' => UploadAction::class,
                'url' => '/images/uploads/collective',
                'path' => '@frontend/web/images/uploads/collective/',
                'maxSize' => 10485760
            ],
            'sorting' => [
                'class' => Sorting::class,
                'query' => Collective::find(),
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CollectiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Url::remember();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionCreate()
    // {
    //     $model = new Collective();

    //     $post = Yii::$app->request->post();
    //     $load = $model->load($post);

    //     if ($load && $model->save()) {
    //         Yii::$app->session->setFlash('success', 'Запись успешно создана!');
    //         return $this->redirect(Url::previous());
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate()
    {
        $model = new Collective();

        if (!empty(Yii::$app->request->post('Collective'))) {
            $post            = Yii::$app->request->post('Collective');
            $model->name     = $post['name'];
            $model->position = $post['position'];
            $parent_id       = $post['parentId'];

            if (empty($parent_id))
                $model->makeRoot();
            else {
                $parent = Collective::findOne($parent_id);
                $model->appendTo($parent);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     $post = Yii::$app->request->post();
    //     $load = $model->load($post);

    //     if ($load && $model->save()) {
    //         Yii::$app->session->setFlash('success', 'Запись успешно изменена!');
    //         return $this->redirect(Url::previous());
    //     }

    //     return $this->render('update', [
    //         'model' => $model
    //     ]);
    // }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!empty(Yii::$app->request->post('Collective'))) {
            $post            = Yii::$app->request->post('Collective');

            $model->name     = $post['name'];
            $model->position = $post['position'];
            $parent_id       = $post['parentId'];

            if ($model->save()) {
                if (empty($parent_id)) {
                    if (!$model->isRoot())
                        $model->makeRoot();
                } else { // move node to other root 
                    if ($model->id != $parent_id) {
                        $parent = Collective::findOne($parent_id);
                        $model->appendTo($parent);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // public function actionDelete($id)
    // {
    //     $modelDelete = $this->findModel($id)->delete();
    //     if (false !== $modelDelete) {
    //         Yii::$app->session->setFlash('success', 'Запись успешно удалена!');
    //     }

    //     return $this->redirect(Url::previous());
    // }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->isRoot())
            $model->deleteWithChildren();
        else
            $model->delete();

        return $this->redirect(['index']);
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
