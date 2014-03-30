<?php
/**
 * CActive form with helpers to use bootstrap horizontal form
 */

class BHorizontalForm extends CActiveForm
{
    public function init()
    {
        if (isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] .= ' form-horizontal';
        } else {
            $this->htmlOptions['class'] = 'form-horizontal';
        }
        parent::init();
    }


    public function beginControlGroup($model, $attribute)
    {
        return '<div class="control-group' . ($model->hasErrors($attribute) ? ' error' : '') . '">' .
            $this->label($model, $attribute, array('class' => 'control-label')) .
            '<div class="controls">';
    }

    public function endControlGroup()
    {
        return '</div></div>';
    }

    public function controlGroup($model, $attribute, $controlsHtml)
    {
        return
            $this->beginControlGroup($model, $attribute) . $controlsHtml .
            $this->endControlGroup();
    }

    public function textAreaControlGroup($model, $attribute, $htmlOptions = array())
    {
        return $this->controlGroup($model, $attribute, $this->textArea($model, $attribute, $htmlOptions));
    }

    public function checkBoxControlGroup($model, $attribute, $htmlOptions = array())
    {
        return $this->controlGroup($model, $attribute, $this->checkBox($model, $attribute, $htmlOptions));
    }

    public function passwordControlGroup($model, $attribute, $htmlOptions = array())
    {
        return $this->controlGroup($model, $attribute, $this->passwordField($model, $attribute, $htmlOptions));
    }

    public function textFieldControlGroup($model, $attribute, $htmlOptions = array())
    {
        return $this->controlGroup($model, $attribute, $this->textField($model, $attribute, $htmlOptions));
    }

    public function listBoxControlGroup($model, $attribute, $data, $htmlOptions = array())
    {
        return $this->controlGroup($model, $attribute, $this->listBox($model, $attribute, $data, $htmlOptions));
    }

    public function dropDownListControlGroup($model, $attribute, $data, $htmlOptions = array())
    {
        return $this->controlGroup($model, $attribute, $this->dropDownList($model, $attribute, $data, $htmlOptions));
    }

    public function checkBoxListControlGroup($model, $attribute, $data, $htmlOptions = array())
    {
        $htmlOptions['separator'] = '';
        $htmlOptions['template'] = '<span class="checkbox">{input} {label}</span>';

        $html = '<div style="padding-top:5px; padding-left:15px;">' . $this->checkBoxList($model, $attribute, $data, $htmlOptions) . '</div>';
        return $this->controlGroup($model, $attribute, $html);
    }

    public function fileFieldControlGroup($model, $attribute, $htmlOptions = array())
    {
        return $this->controlGroup($model, $attribute, $this->fileField($model, $attribute, $htmlOptions));
    }

    public function radioButtonListControlGroup($model, $attribute, $data, $htmlOptions = array())
    {
        $htmlOptions['separator'] = '';
        $htmlOptions['template'] = '<span class="radio">{input} {label}</span>';

        $html = '<div style="padding-top:5px; padding-left:15px;">' . $this->radioButtonList($model, $attribute, $data, $htmlOptions) . '</div>';
        return $this->controlGroup($model, $attribute, $html);
    }

    public function beginFieldset($legend)
    {
        return '<fieldset><legend>' . $legend . '</legend>';
    }

    public function endFieldset()
    {
        return '</fieldset>';
    }

}
