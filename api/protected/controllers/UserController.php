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
        $news = User::getCurrentUser()->news;
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
        
        if(!Yii::app()->user->isGuest){
            $this->homeRedirect();
        }
        if(!$provider || !Yii::app()->hybridAuth->isAllowedProvider($provider))
            $this->sendResponse(401, 'Error: Provider not found');
  
        if(Yii::app()->hybridAuth->isAdapterUserConnected($provider)){
            $socialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
            $sessionData = Yii::app()->hybridAuth->getSessionData();
            
            if(isset($socialUser) && isset($sessionData)){
                $user = User::model()->findByAuthUser($provider, $socialUser->identifier);
                if(empty($user)){ 
                    $user = new User();
                    $user->username = $socialUser->identifier;
                    $user->password = md5($socialUser->identifier);
                    $user->session_data = $sessionData;
                    $user->provider = $provider;
                    $user->role = 'user';
                    $user->save();
                    
                    $userProfile = new UserProfile();
                    $userProfile->user_id = $user->id;
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
                       $user = false;
                    }
                }
 
                if($user){
                    $identity = new UserIdentity($user->username, $user->password);
                    $identity->authenticate();
                    if ($identity->errorCode === UserIdentity::ERROR_NONE) {
                        Yii::app()->user->login($identity);
                        $this->homeRedirect();
                    }
                }else{
                    $this->sendResponse(401, 'Error: User not find');
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
         $row['name'] = $params->getFullname();
         $row['photoUrl'] = $params->profile->photoUrl;
         return $row;
    }
    
}
