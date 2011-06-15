<?php
/**
 * форма для редагування/створення новини
 */

class Application_Form_Post extends Zend_Form
{

    public function init()
    {
        $this->setName("newsform");
        $this->setMethod('post');

        // прихований елемент
        $this->addElement('hidden', 'id', array(
            'filters'    => array('Int'),
            'required'   => true,
            'decorators' => array('ViewHelper'),

        ));

        $this->addElement('text', 'title', array(
            'filters'    => array('StringTrim', 'StripTags'),
            'validators' => array(
                array('StringLength', false, array(0, 100)),
            ),
            'required'   => true,
            'label'      => 'Заголовок:',
        ));

        $this->addElement('textarea', 'text', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'      => 'Текст:',
        ));

        $this->addElement('select', 'category_id', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'      => 'Категорія:',
        ));

        $this->addElement('submit', 'submit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'submit',
            'class'    => 'submit-btn',
        ));
    }

}