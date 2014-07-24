<?php

namespace bariew\noticeModule\controllers;

use bariew\noticeModule\helpers\ClassCrawler;
use Yii;
use bariew\noticeModule\models\EmailConfig;
use bariew\noticeModule\models\EmailConfigSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\DetailView;

/**
 * EmailConfigController implements the CRUD actions for EmailConfig model.
 */
class EmailConfigController extends Controller
{
    /**
     * Lists all EmailConfig models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailConfigSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single EmailConfig model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EmailConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmailConfig;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EmailConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EmailConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Returns json event list for form DepDrop widget.
     */
    public function actionEvents()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ($post = Yii::$app->request->post('depdrop_parents'))
            ? array_flip(ClassCrawler::getEventNames($post[0]))
            : [];
        $output = [];
        foreach ($result as $id => $name) {
            $output[] = compact('id', 'name');
        }
        echo Json::encode(['output' => $output, 'selected' => '']);
    }

    public function actionModelVariables()
    {
        $model = new EmailConfig();
        $model->load(Yii::$app->request->post());
        echo DetailView::widget([
            'model'         => false,
            'attributes'    => $model->variables(),
        ]);
    }
    /**
     * Finds the EmailConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmailConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmailConfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
