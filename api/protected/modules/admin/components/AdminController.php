<?php
/**
 * AdminController is the customized base controller class.
 * All controller classes for this module should extend from this base class.
 */
class AdminController extends CController
{
    public $layout = 'base';
    
    public $menu = array();

    public function appendPageTitle($part)
    {
        $this->pageTitle = $part . ' | ' . $this->pageTitle;
    }

    public function init()
    {
        parent::init();
        $this->pageTitle = 'Панель управления «' . Yii::app()->name . '»';
    }
    
    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
}