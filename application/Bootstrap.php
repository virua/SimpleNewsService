<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
      * налаштовуємо доступ до ресурсів
      */
    protected function _initAcl()
    {

        $acl = new Zend_Acl();

        // додаємо ресурси для сайту
        $acl->addResource('index');
        $acl->addResource('error');
        $acl->addResource('auth');

        // для адмінки
        $acl->addResource('admin');

        // ресурси create, update, delete є нащадками ресурсу admin
        $acl->addResource('create', 'index');
        $acl->addResource('update', 'index');
        $acl->addResource('delete', 'index');

        // ресурси login, logout є нащадками ресурсу auth
        $acl->addResource('login', 'auth');
        $acl->addResource('logout', 'auth');

        // роль "гість" (неавторизований користувач)
        $acl->addRole('guest');

        // адміністратор успадковує доступ від гостя
        $acl->addRole('admin', 'guest');

        // надаємо дозволи
        $acl->allow('guest', 'error');
        $acl->allow('guest', 'index', array('index', 'view'));
        $acl->allow('guest', 'auth', array('index', 'login', 'logout'));

        $acl->allow('admin', 'admin', array('index', 'create', 'update', 'delete'));

        // екземпляр головного контролера
        $fc = Zend_Controller_Front::getInstance();

        // реєструємо плагін з назвою AccessCheck
        $fc->registerPlugin(new Application_Plugin_AccessCheck($acl, Zend_Auth::getInstance()));
    }
}


