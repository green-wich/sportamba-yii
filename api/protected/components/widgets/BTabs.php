<?php
/**
 * Widget to decorate content as bootstrap tabs.
 */
class BTabs extends CWidget
{
    private static $_counter = 0;

    public function init()
    {
        parent::init();

    }

    protected $_currentTab = null;
    protected $_output = array();

    public function beginTab($label, $id = null)
    {
        if ($this->_currentTab !== null) {
            throw new CException('Close current tab before open new one.');
        }
        if (!isset($id)) $id = '_yw_tab_' . self::$_counter++;
        $this->_currentTab = array(
            'id' => $id,
            'label' => $label,
        );
        ob_start();
    }

    public function endTab()
    {
        if ($this->_currentTab === null) {
            throw new CException('Before close tab you must open it.');
        }
        $this->_currentTab['content'] = ob_get_clean();
        if ($this->_dropDown !== null) {
            $this->_dropDown['items'][] = $this->_currentTab;
        } else {
            $this->_currentTab['type'] = 'tab';
            $this->_output[] = $this->_currentTab;
        }
        $this->_currentTab = null;
    }

    protected $_dropDown = null;

    public function beginDropDown($label)
    {
        if ($this->_dropDown !== null) {
            throw new CException('Close current DropDown before open new one.');
        }
        $this->_dropDown = array(
            'type' => 'dropDown',
            'label' => $label,
            'items' => array(),
        );
    }

    public function endDropDown()
    {
        if ($this->_dropDown === null) {
            throw new CException('Before close DropDown you need to open it.');
        }
        $this->_output[] = $this->_dropDown;
        $this->_dropDown = null;
    }

    public function run()
    {
        parent::run();
        // render tabs
        echo '<ul class="nav nav-tabs">';
        $firstTab = true;
        foreach ($this->_output as $item) {
            if ($item['type'] == 'tab') {
                echo ($firstTab) ? '<li class="active">' : '<li>';
                echo CHtml::link($item['label'], '#' . $item['id'], array('data-toggle' => 'tab'));
                echo '</li>';
                if ($firstTab) $firstTab = false;
            } elseif ($item['type'] = 'dropDown') {
                echo '<li class="dropdown">';
                echo CHtml::link($item['label'] . '     <b class="caret"></b>', '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));

                echo '<ul class="dropdown-menu">';
                foreach ($item['items'] as $tab) {
                    if ($firstTab) {
                        echo '<li>', CHtml::link($tab['label'], '#' . $tab['id'], array('data-toggle' => 'tab', 'class' => 'active')), '</li>';
                        $firstTab = false;
                    } else {
                        echo '<li>', CHtml::link($tab['label'], '#' . $tab['id'], array('data-toggle' => 'tab')), '</li>';
                    }
                }

                echo '</ul>';
                echo '</li>';
            }

        }

        echo '</ul>';
        //render content
        echo '<div class="tab-content">';
        $firstTab = true;
        foreach ($this->_output as $item) {
            if ($item['type'] == 'tab') {
                echo ($firstTab) ? '<div class="tab-pane fade in active' : '<div class="tab-pane fade';
                echo '" id="', $item['id'], '">';
                echo $item['content'];
                echo '</div>';
                if ($firstTab) $firstTab = false;
            } elseif ($item['type'] = 'dropDown') {
                foreach ($item['items'] as $tab) {
                    echo ($firstTab) ? '<div class="tab-pane fade in active' : '<div class="tab-pane fade';

                    if ($firstTab) $firstTab = false;

                    echo '" id="', $tab['id'], '">';
                    echo $tab['content'];
                    echo '</div>';
                }
            }

        }
        echo '</div>';
    }

}
