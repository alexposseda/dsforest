<?php
    namespace backend\controllers;
    
    use backend\models\PasswordResetRequestForm;
    use backend\models\ResetPasswordForm;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;
    use common\models\LoginForm;
    
    /**
     * Site controller
     */
    class SiteController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => [
                                'login',
                                'error',
                                'reset-password',
                                'request-password-reset'
                            ],
                            'allow'   => true,
                        ],
                        [
                            'actions' => [
                                'logout',
                            ],
                            'allow'   => true,
                            'roles'   => ['@'],
                        ],
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ];
        }
        
        /**
         * @inheritdoc
         */
        public function actions(){
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ],
            ];
        }
        /**
         * Login action.
         *
         * @return string
         */
        public function actionLogin(){
            if(!Yii::$app->user->isGuest){
                return $this->goHome();
            }
            
            $model = new LoginForm();
            if($model->load(Yii::$app->request->post()) && $model->login()){
                return $this->goBack();
            }else{
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }
        
        /**
         * Requests password reset.
         *
         * @return mixed
         */
        public function actionRequestPasswordReset(){
            $model = new PasswordResetRequestForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->sendEmail()){
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));
                    
                    return $this->goHome();
                }else{
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
                }
            }
            
            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }
        
        /**
         * Resets password.
         *
         * @param string $token
         *
         * @return mixed
         * @throws BadRequestHttpException
         */
        public function actionResetPassword($token){
            try{
                $model = new ResetPasswordForm($token);
            }catch(InvalidParamException $e){
                throw new BadRequestHttpException($e->getMessage());
            }
            
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()){
                Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved.'));
                
                return $this->goHome();
            }
            
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }
        
        /**
         * Logout action.
         *
         * @return string
         */
        public function actionLogout(){
            Yii::$app->user->logout();
            
            return $this->goHome();
        }
    }