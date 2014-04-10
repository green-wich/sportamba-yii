<?php

class UserController extends Controller
{    
    const JSON_RESPONSE_ROOT_PLURAL='users';
    const JSON_RESPONSE_ROOT_SINGLE='user';
    
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('login', 'endpoint', 'status'),
                'users'=>array('*'),
            ),
            array('deny',
                'users'=>array('?'),
            ),
        );
    }
    
    public function actionList(){
        $myFriends = Connection::model()->getMyFriends();
        $search = array();
        foreach ($myFriends as $friend){
            $search[] = $friend->user_id_2;
        }
        $criteria = new CDbCriteria();
        $criteria->condition = "id!=1 && id!=".Yii::app()->user->id;
        $criteria->addNotInCondition('id', $search);
        $users = User::model()->findAll($criteria);
        
        $console = array();
        foreach ($users as $user){
            $console[] = $this->createRow($user);
        }
        $result = array(self::JSON_RESPONSE_ROOT_PLURAL => $console);
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    public function actionCurrent(){
        $user = User::getCurrentUser();
        $result = array(self::JSON_RESPONSE_ROOT_SINGLE => $this->createRow($user));
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    public function actionGet($id){
        $user = User::model()->findByPk($id);
        if($id == 1 || empty($user)){
            $this->sendResponse(302, "User not found.");
        }
        $result = array(self::JSON_RESPONSE_ROOT_SINGLE => $this->createRow($user));
        $this->sendResponse(200, CJSON::encode($result));
    }
    
    public function actionNews(){
        $news = User::getCurrentUser()->login[0]->user->news;
        rsort($news);
        $console = array();
        foreach ($news as $new){
            $row['id'] = $new->id;
            $row['news'] = $new->text;
            $row['date'] = $new->created_at;
            $console[] = $row;
        }
        $result = array('news' => $console);
        $this->sendResponse(200, CJSON::encode($result));
    }

    public function actionLogout(){
        if(Yii::app()->hybridAuth->getConnectedProviders()){
            Yii::app()->hybridAuth->logoutAllProviders();
        }
        Yii::app()->user->logout();
        $this->homeRedirect();
    }
 
    public function actionEndpoint(){
        Yii::app()->hybridAuth->endPoint();
    }
    
    public function actionLogin($provider){
        
        $guest = Yii::app()->user->isGuest;
        
        if(!$guest && Yii::app()->user->provider == $provider)
            $this->homeRedirect();
        
        if(!$provider || !Yii::app()->hybridAuth->isAllowedProvider($provider))
            $this->sendResponse(401, 'Error: Provider not found');
        if(Yii::app()->hybridAuth->isAdapterUserConnected($provider)){
            
            $socialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
            $sessionData = Yii::app()->hybridAuth->getSessionData();
            
            if(isset($socialUser) && isset($sessionData)){
                $login = Login::model()->findByAuthUser($provider, $socialUser->identifier);
                if(empty($login)){ 
                    
                    if($guest){
                        $user = new User();
                        $user->role = 'user';
                        $user->save();
                    }
                    $login = new Login();
                    $login->user_id = $guest ? $user->id : Yii::app()->user->id;
                    $login->username = $socialUser->identifier;
                    $login->password = md5($socialUser->identifier);
                    $login->session_data = $sessionData;
                    $login->provider = $provider;
                    $login->save();
                    
                    $userProfile = new UserProfile();
                    $userProfile->login_id = $login->id;
                    $userProfile->profileUrl = $socialUser->profileURL;
                    $userProfile->photoUrl = $socialUser->photoURL;
                    $userProfile->displayName = $socialUser->displayName;
                    $userProfile->firstName = $socialUser->firstName;
                    $userProfile->lastName = $socialUser->lastName;
                    $userProfile->gender = $socialUser->gender;
                    if($provider == 'Facebook'){
                        $userProfile->region = $socialUser->region;
                        $userProfile->email = $socialUser->email;
                    }
                    
                    if(!$userProfile->save()){
                       $login = false;
                    }
                }elseif(!$guest){
                    $old_user_id = $login->user_id;
                    $current_id = Yii::app()->user->id;
                    if($old_user_id != $current_id){
                        $login->user_id = Yii::app()->user->id;
                        $login->save();
                        UserMatch::model()->updateAll(array('user_id'=>$current_id),'user_id="'.$old_user_id.'"');
                        UserNews::model()->updateAll(array('user_id'=>$current_id),'user_id="'.$old_user_id.'"');
                        Connection::model()->updateAll(array('user_id_1'=>$current_id),'user_id_1="'.$old_user_id.'"');
                        User::model()->deleteByPk($old_user_id);
                    }
                }
 
                if($login && $guest){
                    $identity = new UserIdentity($login->username, $login->password);
                    $identity->authenticate();
                    if ($identity->errorCode === UserIdentity::ERROR_NONE) {
                        Yii::app()->user->login($identity);
                        $this->homeRedirect();
                    }
                }else{
                    $this->homeRedirect();
                }
            }
        }else{
            $this->sendResponse(401, 'Error: User not connected');
        }
    }
    
    public function actionStatus(){
        if(!Yii::app()->user->isGuest){
            $this->sendResponse(200, TRUE);
        }else{
            $this->sendResponse(200, FALSE);
        }
        Yii::app()->end();
    }
    
    private function homeRedirect(){
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/", true, 301);
        Yii::app()->end();
    }
    
    private function createRow($params){
         $row['id'] = $params->id;
         $row['name'] = $params->login[0]->getFullname();
         $row['photoUrl'] = $params->login[0]->profile->photoUrl;
         return $row;
    }
    
}
