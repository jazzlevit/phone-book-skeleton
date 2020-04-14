<?php

namespace frontend\controllers;

use Faker\Provider\en_US\Person;
use Faker\Provider\en_US\PhoneNumber;
use frontend\models\Contact;
use frontend\models\Phone;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ContactController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'push' => ['post'],
                    'clear-table' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $title = 'Contact Book';

        $dataProvider = new ActiveDataProvider([
            'query' => Contact::find()->with('phones'),
        ]);

        return $this->render('index', [
            'title' => $title,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Contact::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Contact model.
     */
    public function actionCreate()
    {
        $model = new Contact();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Please add phone numbers');
            return $this->redirect(['contact/update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Contact model.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['contact/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Contact::findOne($id);

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    /**
     * For testing purpose
     * @return \yii\web\Response
     */
    public function actionPush()
    {
        for($i = 0; $i < 30; $i++) {

            $model = new Contact();
            $model->setAttributes([
                'first_name' => Person::firstNameMale(),
                'last_name' => Person::firstNameMale(),
            ]);
            $model->save(false);

            $max = rand(10, 20);
            for($n = 0; $n < $max; $n++) {
                $ph = new PhoneNumber(new \Faker\Generator());
                $phone = new Phone();
                $phone->setAttributes([
                    'contact_id' => $model->id,
                    'phone' => $ph->e164PhoneNumber(),
                ]);
                $phone->save(false);
            }
        }

        return $this->redirect(['contact/index']);
    }

    /**
     * For testing purpose
     *
     * @return \yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionClearTable()
    {
        Yii::$app->db->createCommand()->truncateTable(Phone::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Contact::tableName())->execute();

        return $this->redirect(['contact/index']);
    }

    //
    //
    //

    public function actionPhoneList($id)
    {
        $model = $this->findModel($id);

        return $this->renderAjax('_phone_list', ['model' => $model]);
    }

    /**
     * @param $id Contact::id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddPhone($id)
    {
        $contact = $this->findModel($id);

        $model = new Phone();
        $model->contact_id = $contact->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->actionPhoneList($id);
        }

        return $this->renderAjax('_phone_form', ['model' => $model]);
    }

    /**
     * @param $id Phone::id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdatePhone($id)
    {
        $model = $this->findPhoneModel($id);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->actionPhoneList($model->contact_id);
        }

        return $this->renderAjax('_phone_form', ['model' => $model]);
    }

    /**
     * @param $id Contact::id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeletePhone($id)
    {
        $model = $this->findPhoneModel($id);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $model->delete();

        return $this->actionPhoneList($model->contact_id);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Phone|null
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPhoneModel($id)
    {
        $model = Phone::findOne($id);

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
