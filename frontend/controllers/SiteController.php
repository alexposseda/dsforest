<?php
    namespace frontend\controllers;

    use common\models\Category;
    use common\models\Offer;
    use Yii;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;

    /**
     * Site controller
     */
    class SiteController extends Controller{

        /**
         * @inheritdoc
         */
        public function actions(){
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction'
                ]
            ];
        }

        /**
         * Displays homepage.
         *
         * @return mixed
         */
        public function actionIndex(){
            $categories = Category::find()->all();
            $availableCategories = [];
    
            if(!empty($categories)){
                foreach($categories as $category){
                    if($category->translation){
                        $availableCategories[] = $category;
                    }
                }
            }
            
            return $this->render('index', ['categories' => $availableCategories]);
        }

        public function actionCatalog($categoryId = null){
            $allCategories = Category::find()->all();
            if(!is_null($categoryId)){
                $currentCategory = $this->findModel('category', 'id', $categoryId);
            }else{
                $currentCategory = $allCategories[0];
            }
            
            return $this->render('catalog', ['categories' => $allCategories, 'currentCategory' => $currentCategory]);
        }

        public function actionOffer($id){
            $model = $this->findModel('offer', 'id', $id);
            if(!$model->translation){
                throw new NotFoundHttpException(Yii::t('error', 'The requested page does not exist'));
            }
            return $this->render('offer', ['offer' => $model]);
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
