<?php

class NewsBehavior extends CActiveRecordBehavior 
{
    public $type;
 
    public function afterSave($event){
        $news = new News();
        $news->text = $this->getText($this->type);
        $news->save();
        $myFriends = Connection::model()->getMyFriends();
        foreach ($myFriends as $friend){
            $UserNews = new UserNews();
            $UserNews->user_id = $friend->user_id_2;
            $UserNews->news_id = $news->id;
            $UserNews->save();
        }
    }
    
    public function getText($type){
        $text = '';
        switch ($type){
            case 1:
                $main_owner = $this->getOwner();
                $text .= $main_owner->user->login[0]->getFullName()." запланировал матч ";
                $text .= $main_owner->match->getCommands()." ".$main_owner->match->getDate().".";
                break;
            case 2:
                $main_owner = $this->getOwner();
                $text .= $main_owner->user1->login[0]->getFullName()." подписался на ".$main_owner->user2->getFullName().'.';
                break;
        }
        return $text;
    }
    
}
