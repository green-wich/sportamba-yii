<?php

class BSideMenu extends CWidget
{
    /**
     * @var array
     * examle:
     * [{
     *   'label':'Group label'
     *   'items':[{
     *          label:label,
     *          icon:icon,
     *          url:url|array(route,params)
     *          active:route_regexp|boolean
     *   },..]
     * },..]
     */
    public $items;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $current_route = '/' . $this->controller->module->id . '/' . $this->controller->id . '/' . $this->controller->action->id;

        echo '<ul class="nav nav-list">';
        foreach ($this->items as $group) {
            echo '<li class="nav-header">', $group['label'], '</li>';
            foreach ($group['items'] as $item) {
                if (is_string($item['active']))
                    $active = (preg_match($item['active'], $current_route) > 0);
                else
                    $active = $item['active'];

                echo
                '<li', ($active ? ' class="active"' : ''), '>',
                CHtml::link('<i class="' . $item['icon'] . ($active ? ' icon-white' : '') . '"></i> ' . $item['label'], $item['url']),
                '</li>';
            }
        }
        echo '</ul>';
    }

}
