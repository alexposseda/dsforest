<?php
    
    namespace backend\controllers;
    
    use common\models\Category;
    use common\models\Offer;
    use common\models\Product;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\HttpException;
    use yii\web\NotFoundHttpException;
    
    class CatalogController extends Controller{
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ]
            ];
        }
        
        public function actionIndex(){
            return $this->render('index');
        }
        
        #region category
        public function actionViewCategory($id){
            
            return $this->render('view', [
                'model' => $this->findModel('category', 'id', $id),
                'file'  => 'category'
            ]);
        }
        
        
        public function actionCreateCategory(){
            $model = new Category();
    
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkLangs()){
                $model->save();
                
                Yii::$app->session->set('fl', ['success' => 'Категория успешно создана']);
                $this->redirect(['catalog/view-category', 'id' => $model->id]);
            }
            
            return $this->render('create', [
                'model' => $model,
                'file'  => 'category'
            ]);
        }
        
        public function actionUpdateCategory($id){
            $model = $this->findModel('category', 'id', $id);
    
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkLangs()){
                $model->save();
        
                Yii::$app->session->set('fl', ['success' => 'Категория успешно обновлена']);
                return $this->redirect(['catalog/view-category', 'id' => $model->id]);
            }
            
            return $this->render('update', [
                'model' => $model,
                'file' => 'category'
            ]);
        }
        
        public function actionDeleteCategory($id){
            $model = $this->findModel('category', 'id', $id);
            if($model->delete()){
                Yii::$app->session->set('fl', ['success' => 'Категория успешно удалена']);
                return $this->redirect(['catalog/index']);
            }
    
            Yii::$app->session->set('fl', ['error' => 'Ошибка удаления....']);
            return $this->redirect(['catalog/view-category', 'id' => $id]);
            
        }
        #endregion
        #region offer
        public function actionViewOffer($id){
            return $this->render('offer');
        }
        
        public function actionCreateOffer($categoryId){
            
            return $this->render('offer');
        }
        
        public function actionUpdateOffer($id){
            
            return $this->render('offer');
        }
        
        public function actionDeleteOffer($id){
        }
        #endregion
        #region product
        
        public function actionViewProduct($id){
            return $this->render('product');
        }
        
        public function actionCreateProduct($offerId){
            return $this->render('product');
        }
        
        public function actionUpdateProduct($id){
            return $this->render('product');
        }
        
        public function actionDeleteProduct($id){
        }
        
        #endregion
        
        public function beforeAction($action){
            $messages = Yii::$app->session->get('fl');
            if(!empty($messages)){
                foreach($messages as $key => $val){
                    Yii::$app->session->addFlash($key, $val);
                }
                Yii::$app->session->remove('fl');
            }
            
            return parent::beforeAction($action);
        }
        
        /**
         * @param string $modelName
         * @param string $attribute
         * @param string $value
         *
         * @return Category | Offer | Product
         * @throws NotFoundHttpException
         */
        public function findModel($modelName, $attribute, $value){
            $modelName = '\common\models\\'.ucfirst($modelName);
            $model     = (new $modelName())->findOne([$attribute => $value]);
            if(is_null($model)){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            
            return $model;
        }
    }