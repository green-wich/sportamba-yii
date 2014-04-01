<?php

class AdminModule extends CWebModule
{
    public $layout = 'main';
    
    public $assets = null;
    
    
   public function init()
    {
        // publish our assets folder
        $this->assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets'));

        $this->setImport(
            array(
                $this->getId() . '.models.*',
                $this->getId() . '.components.*',
                $this->getId() . '.components.widgets.*',
                $this->getId() . '.models.*'
            ));

        Yii::app()->language = 'ru';
        
        Yii::app()->setComponents(
            array(
                'errorHandler' => array(
                    'errorAction' => '/' . $this->getId() . '/default/error',
                ),
                'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                            'admin' => 'admin',
                            'admin/<controller:\w+>' => 'admin/<controller>',
                            'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
                        ),
                        'showScriptName' => false,
		),
                'user' => array(
                    'class' => 'AdminWebUser',
                    'allowAutoLogin' => true,
                    'stateKeyPrefix' => $this->getId() . 'user',
                    'loginUrl' => array('/' . $this->getId() . '/default/login'),
                    'returnUrl' => array('/' . $this->getId() . '/default/index'),
                ),
                'authManager' => array(
                    'class' => 'CDbAuthManager',
                    'defaultRoles' => array('authenticated', 'guest'),
                    'itemTable' => 'admin_auth_item',
                    'assignmentTable' => 'admin_auth_assignment',
                    'itemChildTable' => 'admin_auth_item_child',
                ),
            ));
    }

    public function beforeControllerAction($controller, $action)
    {
            if(parent::beforeControllerAction($controller, $action))
            {
                    // this method is called before any module controller action is performed
                    // you may place customized code here
                    return true;
            }
            else
                    return false;
    }
    
    public $menuConfig = 'admin.config.mainMenu';
        
        private $_mainMenu = null;
        private $_sectionMenu = null;

        /** Returns menu items at first level */
        public function getMainMenu()
        {
            if ($this->_mainMenu == null)
                $this->buildMenus();
            return $this->_mainMenu;
        }

        /** Returns menu items at second level */
        public function getSectionMenu()
        {
            if ($this->_mainMenu == null)
                $this->buildMenus();
            return $this->_sectionMenu;
        }

        protected function isItemActive($item, $route)
        {
            if (isset($item['activateOn'])) {
                foreach ($item['activateOn'] as $config) {
                    if (preg_match($config['route'], $route) > 0) {
                        $res = true;
                        if (!empty($config['params'])) {
                            foreach ($config['params'] as $name => $value) {
                                if (!isset($_GET[$name]) || $_GET[$name] != $value) {
                                    $res = false;
                                    break;
                                }
                            }
                        }
                        if ($res) return $res;
                    }
                }
            }
            if (isset($item['url']) && is_array($item['url']) && !strcasecmp(trim($item['url'][0], '/'), $route)) {
                if (count($item['url']) > 1) {
                    foreach (array_splice($item['url'], 1) as $name => $value) {
                        if (!isset($_GET[$name]) || $_GET[$name] != $value)
                            return false;
                    }
                }
                return true;
            }
            return false;
        }

        /**
         * Creates menu item by configuration.
         * @param $config
         * @return array|bool Menu item or false if access denied for current user
         */
        private function menuItemByConfig($config)
        {
            $route = Yii::app()->getController()->getRoute();
            $isActive = $this->isItemActive($config, $route);
            return array(
                'label' => $config['label'],
                'url' => $config['url'],
                'active' => $isActive,
            );
        }

        /**
         * Build main menu(first and second levels) as specified in $menuConfig
         * @throws CException
         */
        private function buildMenus()
        {
            $main = array();
            $section = false;
            if (!empty($this->menuConfig)) {
                if (is_string($this->menuConfig)) { // load php file with configuration
                    $file = Yii::getPathOfAlias($this->menuConfig);
                    $this->menuConfig = require($file . '.php');
                }
                foreach ($this->menuConfig as $groupConfig) {
                    if (isset($groupConfig['plain']) && $groupConfig['plain']) {
                        foreach ($groupConfig['items'] as $itemConfig) {
                            $item = $this->menuItemByConfig($itemConfig);
                            if ($item !== false)
                                $main[] = $item;
                        }
                    } else {
                        $current = array();
                        $active = false;
                        foreach ($groupConfig['items'] as $itemConfig) {
                            $item = $this->menuItemByConfig($itemConfig);
                            if ($item !== false) {
                                $current[] = $item;
                                if ($item['active']) $active = true;
                            }
                        }
                        if (count($current) > 0) {
                            $main[] = array(
                                'label' => $groupConfig['label'],
                                'url' => $current[0]['url'],
                                'active' => $active
                            );
                            if ($active) $section = $current;
                        }
                    }
                }
                $this->_mainMenu = $main;
                $this->_sectionMenu = $section;

            } else {
                throw new CException('Main menu is empty.');
            }
        }
}
