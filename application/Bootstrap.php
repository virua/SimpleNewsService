<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
	  * налаштовуЇмо доступ до ресурс≥в
	  */
    protected function _initAcl()
    {

        $acl = new Zend_Acl();

        // додаЇмо ресурси дл€ сайту
        $acl->addResource('index');
        $acl->addResource('error');
        $acl->addResource('auth');

        // дл€ адм≥нки
        $acl->addResource('admin');

        // ресурси create, update, delete Ї нащадками ресурсу admin
        $acl->addResource('create', 'index');
        $acl->addResource('update', 'index');
        $acl->addResource('delete', 'index');

        // ресурси login, logout Ї нащадками ресурсу auth
        $acl->addResource('login', 'auth');
        $acl->addResource('logout', 'auth');

        // роль "г≥сть" (неавторизований користувач)
        $acl->addRole('guest');

        // адм≥н≥стратор успадковуЇ доступ в≥д гост€
        $acl->addRole('admin', 'guest');

        // надаЇмо дозволи
        $acl->allow('guest', 'error');
        $acl->allow('guest', 'index', array('index', 'view'));
        $acl->allow('guest', 'auth', array('index', 'login', 'logout'));

        $acl->allow('admin', 'admin', array('index', 'create', 'update', 'delete'));

        // екземпл€р головного контролера
        $fc = Zend_Controller_Front::getInstance();

        // реЇструЇмо плаг≥н з назвою AccessCheck
        $fc->registerPlugin(new Application_Plugin_AccessCheck($acl, Zend_Auth::getInstance()));
    }
}


