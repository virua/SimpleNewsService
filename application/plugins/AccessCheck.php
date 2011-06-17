<?php

/**
  * перевірка, чи має користувач доступ до поточної сторінки (ресурсу)
  */
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{
    private $_acl = null;
    private $_auth = null;

    public function __construct(Zend_Acl $acl, Zend_Auth $auth)
    {
        $this->_acl = $acl;
        $this->_auth = $auth;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        // отримуємо ім'я поточного ресурсу
        $resource = $request->getControllerName();

        // отримуємо ім'я екшена
        $action = $request->getActionName();

        // отримуємо роль користувача
        $identity = $this->_auth->getStorage()->read();

        // якщо роль порожня, то маємо справу з "гостем"
        $role = empty($identity->role) ? 'guest' : $identity->role;

        // якщо користувач не має доступу, перекидаємо його на авторизацію
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            $request->setControllerName('auth')->setActionName('index');
        }
    }
}


