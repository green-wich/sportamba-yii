<?php

class UserController extends Controller
{
//    public function actionCreate(){
//       // $user = $this->getInputAsJson();
//        $userInput = $_REQUEST;
//        $username = $userInput['username'];
//        
//        $user = User::model()->findByAttributes(['username' => $username]);
//        
//        if($user){
//            return $user->login();
//        }else{
//            $model = new User;
//            $model->username = $username;
//            $model->password = $userInput['password'];
//            $model->status = 1;
//            if($model->save()){
//                return $model->login ();
//            }
//            else 
//                return false;
//        }
//    }
    
    public function actionGet($id){
        $user = User::model()->findByPk($id);
        echo '{"user": ' . CJSON::encode($user) . '}';
        Yii::app()->end();
    }
    
    public function actionLogout()
    {
        Yii::app()->user->logout();
    }
    
    public $defaultAction='authenticate';
    public $debugMode=true;
 
    // important! all providers will access this action, is the route of 'base_url' in config
    public function actionEndpoint(){
        Yii::app()->hybridAuth->endPoint();
    }
 // Twitter Facebook
    public function actionCreate(){
        
      //  $provider = $_REQUEST['provider'];
        
        $provider = 'Facebook';
        
        if(!Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider))
            $this->redirect(Yii::app()->homeUrl);
 
        if($this->debugMode)
            Yii::app()->hybridAuth->showError=true;
 
        if(Yii::app()->hybridAuth->isAdapterUserConnected($provider)){
            $socialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
            if(isset($socialUser)){
                // find user from db model with social user info
                $user = Users::model()->findBySocial($provider, $socialUser->identifier);
                if(empty($user)){ 
                    // if not exist register new user with social user info.
                    // 'identifier, profileUrl, photoUrl, displayName, firstName, lastName, gender, email, region, provider'
                    $model = new Users();
                    $model->provider = $provider;
                    $model->identifier = $socialUser->identifier;
                    $model->profileUrl = $socialUser->profileURL;
                    $model->photoUrl = $socialUser->photoURL;
                    $model->displayName = $socialUser->displayName;
                    $model->firstName = $socialUser->firstName;
                    $model->lastName = $socialUser->lastName;
                    $model->gender = $socialUser->gender;
                    $model->password = md5($socialUser->identifier);
                    $model->role = 'user';
                    if($provider == 'Facebook'){
                        $model->region = $socialUser->region;
                        $model->email = $socialUser->email;
                    }
                    if($model->save()){
                       $user=$model; 
                    }else{
                       $user=false;
                    }
                }
 
                if($user){
                    $identity = new UserIdentity($user->firstName, $user->password);
                    $identity->authenticate('social');
                    switch ($identity->errorCode) {
//                      ...... 
                      case UserIdentity::ERROR_NONE:
                           Yii::app()->user->login($identity);
                           $this->redirect(Yii::app()->user->returnUrl);
                           break;
//                      ...... 
                    }
                }
            }
        }
        $this->redirect(Yii::app()->homeUrl);
    }
    
    public function actionList(){
        
      //  $provider = $_REQUEST['provider'];
        
        $provider = 'Facebook';
        
        if(!Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider))
            $this->redirect(Yii::app()->homeUrl);
 
        if($this->debugMode)
            Yii::app()->hybridAuth->showError=true;
 
        if(Yii::app()->hybridAuth->isAdapterUserConnected($provider)){
            $socialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
            if(isset($socialUser)){
                // find user from db model with social user info
                $user = Users::model()->findBySocial($provider, $socialUser->identifier);
                if(empty($user)){ 
                    // if not exist register new user with social user info.
                    // 'identifier, profileUrl, photoUrl, displayName, firstName, lastName, gender, email, region, provider'
                    $model = new Users();
                    $model->provider = $provider;
                    $model->identifier = $socialUser->identifier;
                    $model->profileUrl = $socialUser->profileURL;
                    $model->photoUrl = $socialUser->photoURL;
                    $model->displayName = $socialUser->displayName;
                    $model->firstName = $socialUser->firstName;
                    $model->lastName = $socialUser->lastName;
                    $model->gender = $socialUser->gender;
                    $model->password = md5($socialUser->identifier);
                    $model->role = 'user';
                    if($provider == 'Facebook'){
                        $model->region = $socialUser->region;
                        $model->email = $socialUser->email;
                    }
                    if($model->save()){
                       $user=$model; 
                    }else{
                       $user=false;
                    }
                }
 
                if($user){
                    $identity = new UserIdentity($user->firstName, $user->password);
                    $identity->authenticate('social');
                    switch ($identity->errorCode) {
//                      ...... 
                      case UserIdentity::ERROR_NONE:
                           Yii::app()->user->login($identity);
                           $this->redirect(Yii::app()->user->returnUrl);
                           break;
//                      ...... 
                    }
                }
            }
        }
        $this->redirect(Yii::app()->homeUrl);
    }
    
}

