<?php
/**
 * AdminController is the customized base controller class.
 * All controller classes for this module should extend from this base class.
 */
class AdminController extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to 'application.views.layouts.column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'base';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();


    /**
     * Appends part to current page title
     * @param $part string Part to be added
     */
    public function appendPageTitle($part)
    {
        $this->pageTitle = $part . ' | ' . $this->pageTitle;
    }

    /**
     * Generates sidebar tree based on config and sets default page title.
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->pageTitle = 'Панель управления «' . Yii::app()->name . '»';
    }

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
                'users' => array('@'),
//                  'roles' => array('admin'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
}