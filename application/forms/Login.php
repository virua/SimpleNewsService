<?php

/**
  * форма для авторизації
  */
class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName("loginform");
        $this->setMethod('post');

        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Логін:',
            'size'      => 32,
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Пароль:',
            'size'      => 32,
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Увійти',
        ));
    }

}