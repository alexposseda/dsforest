<?php
    
    namespace backend\controllers;
    
    use backend\models\OfferGallery;
    use backend\models\UploadCover;
    use common\models\Category;
    use common\models\Offer;
    use common\models\Product;
    use Yii;
    use yii\alexposseda\fileManager\actions\UploadAction;
    use yii\filters\AccessControl;
    use yii\web\Controller;
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
        
        public function actions(){
            return [
                'category-upload'    => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'categories',
                    'sessionEnable' => true,
                    'uploadModel'   => new UploadCover([
                                                           'validationRules' => [
                                                               'extensions' => 'jpg, png',
                                                               'maxSize'    => 1024 * 500
                                                           ]
                                                       ])
                ],
                'category-remove'    => [
                    'class' => '\yii\alexposseda\fileManager\actions\RemoveAction',
                ],
                'offer-upload'       => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'offers',
                    'sessionEnable' => true,
                    'uploadModel'   => new OfferGallery([
                                                            'validationRules' => [
                                                                'extensions' => 'jpg, png',
                                                                'maxSize'    => 1024 * 1024 * 2
                                                            ]
                                                        ])
                ],
                'offer-remove'       => [
                    'class' => '\yii\alexposseda\fileManager\actions\RemoveAction',
                ],
                'offer-upload-cover' => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'offers',
                    'sessionEnable' => true,
                    'uploadModel'   => new UploadCover([
                                                           'validationRules' => [
                                                               'extensions' => 'jpg, png',
                                                               'maxSize'    => 1024 * 500
                                                           ]
                                                       ])
                ],
                'offer-remove-cover' => [
                    'class' => '\yii\alexposseda\fileManager\actions\RemoveAction',
                ],
                'product-upload'     => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'products',
                    'sessionEnable' => true,
                    'uploadModel'   => new UploadCover([
                                                           'validationRules' => [
                                                               'extensions' => 'jpg, png',
                                                               'maxSize'    => 1024 * 500
                                                           ]
                                                       ])
                ],
                'product-remove'     => [
                    'class' => '\yii\alexposseda\fileManager\actions\RemoveAction',
                ]
            ];
        }
        
        public function actionIndex(){
            return $this->render('index', [
                'models' => Category::find()
                                    ->all()
            ]);
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
                
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Category successfully created')]);
                $this->redirect([
                                    'catalog/view-category',
                                    'id' => $model->id
                                ]);
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
                
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Category successfully updated')]);
                
                return $this->redirect([
                                           'catalog/view-category',
                                           'id' => $model->id
                                       ]);
            }
            
            return $this->render('update', [
                'model' => $model,
                'file'  => 'category'
            ]);
        }
        
        public function actionDeleteCategory($id){
            $model = $this->findModel('category', 'id', $id);
            if($model->delete()){
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Category successfully deleted')]);
                
                return $this->redirect(['catalog/index']);
            }
            
            Yii::$app->session->set('fl', ['error' => Yii::t('error', 'Failed to delete')]);
            
            return $this->redirect([
                                       'catalog/view-category',
                                       'id' => $id
                                   ]);
        }
        #endregion
        #region offer
        public function actionViewOffer($id){
            $model = $this->findModel('offer', 'id', $id);
            $model->setBaseModel($model->category);
            
            return $this->render('view', [
                'model' => $model,
                'file'  => 'offer'
            ]);
        }
        
        public function actionCreateOffer($categoryId){
            $category = $this->findModel('category', 'id', $categoryId);
            $model    = new Offer(['categoryId' => $category->id]);
            $model->setBaseModel($category);
            
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkLangs()){
                $model->save();
                
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Offer successfully created')]);
                $this->redirect([
                                    'catalog/view-offer',
                                    'id' => $model->id
                                ]);
            }
            
            return $this->render('create', [
                'model' => $model,
                'file'  => 'offer'
            ]);
        }
        
        public function actionUpdateOffer($id){
            $model = $this->findModel('offer', 'id', $id);
            $model->setBaseModel($model->category);
            
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkLangs()){
                $model->save();
                
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Offer successfully updated')]);
                $this->redirect([
                                    'catalog/view-offer',
                                    'id' => $model->id
                                ]);
            }
            
            return $this->render('update', [
                'model' => $model,
                'file'  => 'offer'
            ]);
        }
        
        public function actionDeleteOffer($id){
            $model      = $this->findModel('offer', 'id', $id);
            $categoryId = $model->categoryId;
            if($model->delete()){
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Offer successfully deleted')]);
                
                return $this->redirect([
                                           'catalog/view-category',
                                           'id' => $categoryId
                                       ]);
            }
            
            Yii::$app->session->set('fl', ['error' => Yii::t('error', 'Failed to delete')]);
            
            return $this->redirect([
                                       'catalog/view-offer',
                                       'id' => $id
                                   ]);
        }
        #endregion
        #region product
        
        public function actionViewProduct($id){
            $model = $this->findModel('product', 'id', $id);
            $model->setBaseModel($model->offer);
            return $this->render('view', ['model' => $model, 'file' => 'product']);
        }
        
        public function actionCreateProduct($offerId){
            $offer = $this->findModel('offer', 'id', $offerId);
            $model    = new Product(['offerId' => $offer->id]);
            $model->setBaseModel($offer);
    
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkLangs()){
                $model->save();
        
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Product successfully created')]);
                $this->redirect([
                                    'catalog/view-product',
                                    'id' => $model->id
                                ]);
            }
    
            return $this->render('create', [
                'model' => $model,
                'file'  => 'product'
            ]);
        }
        
        public function actionUpdateProduct($id){
            $model = $this->findModel('product', 'id', $id);
            $model->setBaseModel($model->offer);
    
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkLangs()){
                $model->save();
        
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Product successfully updated')]);
                $this->redirect([
                                    'catalog/view-product',
                                    'id' => $model->id
                                ]);
            }
    
            return $this->render('update', [
                'model' => $model,
                'file'  => 'product'
            ]);
        }
        
        public function actionDeleteProduct($id){
            $model      = $this->findModel('product', 'id', $id);
            $offerId = $model->categoryId;
            if($model->delete()){
                Yii::$app->session->set('fl', ['success' => Yii::t('success', 'Product successfully deleted')]);
        
                return $this->redirect([
                                           'catalog/view-offer',
                                           'id' => $offerId
                                       ]);
            }
    
            Yii::$app->session->set('fl', ['error' => Yii::t('error', 'Failed to delete')]);
    
            return $this->redirect([
                                       'catalog/view-product',
                                       'id' => $id
                                   ]);
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
                throw new NotFoundHttpException(Yii::t('error', 'The requested page does not exist'));
            }
            
            return $model;
        }
    }