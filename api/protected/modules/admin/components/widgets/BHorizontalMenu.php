<?php

class BHorizontalMenu extends CWidget
{
    /**
     * @var array
     * examle:
     * 'items':[{
     *          label:label,
     *          url:url|array(route,params)
     *          active:route_regexp||boolean
     *   },..]
     */
    public $items;
    public $class = 'nav';
    public $style = "";

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $current_route = '/' . $this->controller->module->id . '/' . $this->controller->id . '/' . $this->controller->action->id;

        echo '<ul class="', $this->class, '" style="', $this->style, '">';
        foreach ($this->items as $item) {
            if (is_string($item['active']))
                $active = (preg_match($item['active'], $current_route) > 0);
            else
                $active = $item['active'];
            echo
            '<li', ($active ? ' class="active"' : ''), '>',
            CHtml::link($item['label'], $item['url']),
            '</li>';
        }
        echo '</ul>';
    }

}
