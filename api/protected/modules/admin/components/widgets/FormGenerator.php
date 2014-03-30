<?php
/**
 * Widget to render form by config in BHorizontalForm.
 */
class FormGenerator extends CWidget
{
    /**
     * @var BHorizontalForm
     */
    public $form;
    /**
     * @var CModel
     */
    public $model;
    /**
     * Suffix to separate different input  with same model, like: Model[suf1][field1] and Model[suf2][field1]
     * @var string
     */
    public $suffix;
    /**
     * @var array
     */
    public $config = array(
        array(
            'type' => 'widget',
            'class' => 'ClassName',
            'config' => array(),
        ),
        array(
            'type' => 'inputWigdet',
            'class' => 'ClassName',
            'attribute' => 'attribute',
            'config' => array(),
        ),
        array(
            'type' => 'simpleInput',
            'name' => 'textField',
            'attribute' => 'attribute',
            'options' => array(),
        ),
        array(
            'type' => 'listInput',
            'name' => 'textField',
            'attribute' => 'attribute',
            'data' => array(),
            'options' => array(),
        ),
    );

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
        $this->renderForm($this->config);
    }

    private function renderForm($config)
    {
        foreach ($config as $item) {
            switch ($item['type']) {
                case 'fieldset':
                    echo  $this->form->beginFieldset($item['legend']);
                    $this->renderForm($item['config']);
                    echo $this->form->endFieldset();
                    break;
                case 'widget':
                    Yii::app()->getController()->widget($item['class'], $item['config']);
                    break;

                case 'inputWidget':
                    $config = isset($item['config'])?$item['config']:array();
                    if (isset($this->suffix)) {
                        $attr = '[' . $this->suffix . ']' . $item['attribute'];
                    } else {
                        $attr = $item['attribute'];
                    }
                    $config['attribute'] = $attr;
                    $config['model'] = $this->model;
                    echo $this->form->beginControlGroup($this->model, $attr);
                    Yii::app()->getController()->widget($item['class'], $config);
                    echo $this->form->endControlGroup();
                    break;
                case 'simpleInput':
                    $method = $item['name'] . 'ControlGroup';
                    echo $this->form->$method($this->model, $item['attribute'], $item['options']);
                    break;
                case 'listInput':
                    $method = $item['name'] . 'ControlGroup';
                    echo $this->form->$method($this->model, $item['attribute'], $item['data'], $item['options']);
                    break;
                default:
                    throw new CException('Not implemented!!!');
            }
        }
    }

}
