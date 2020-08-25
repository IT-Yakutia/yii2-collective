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

    public function actionCreate()
    {
        $model = new Collective();
        if (!empty(Yii::$app->request->post('Collective'))) {
            $post = Yii::$app->request->post('Collective');
            $model->name = $post['name'];
            $model->position = $post['position'];
            $parent_id = $post['parentId'];

            if (empty($parent_id)) {
                $trees_list = $model->getTreesList();
                if (empty($trees_list)) {
                    $model->tree = 1;
                } else {
                    $max = (int)max($trees_list)['tree'] + 1;
                    $model->tree = $max;
                }
                $model->makeRoot();
            } else {
                $parent = Collective::findOne($parent_id);
                $model->appendTo($parent);
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!empty(Yii::$app->request->post('Collective'))) {

            $post  = Yii::$app->request->post('Collective');
            $model->name = $post['name'];
            $model->position = $post['position'];
            $parent_id = $post['parentId'];

            if ($model->save()) {
                if (empty($parent_id)) {
                    if (!$model->isRoot())
                        $model->makeRoot();
                } else {
                    if ($model->id != $parent_id) {
                        $parent = Collective::findOne($parent_id);
                        $model->appendTo($parent);
                    }
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->isRoot()) {
            // Получаю масимальную ветвь
            $max_tree = (int)max($model->getTreesList())['tree'];

            // Получаю саб ветки и создаю новые корневые, в которых переназначаю значения веток
            $leaves = $model::find()->leaves()->all();
            foreach ($leaves as $leave) {
                $max_tree++;
                $depth = 0;
                $leave->tree = $max_tree;
                $leave->depth = $depth;
                $leave->save();
                $this->rebaseLeaves($leave, $max_tree, $depth);
            }

            $model->depth = -1;
            $model->save();
            $model->deleteWithChildren();
        } else {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    private function rebaseLeaves($model, $tree, $depth)
    {
        $leaves = $model::find()->leaves()->all();
        if (!empty($leaves)) {
            foreach ($leaves as $leave) {
                $leave->tree = $tree;
                $leave->depth = $depth;
                $leave->save();
                $this->rebaseLeaves($leave, $tree, $depth++);
            }
        }
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
