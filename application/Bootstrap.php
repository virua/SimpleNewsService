<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
	  * ����������� ������ �� �������
	  */
    protected function _initAcl()
    {

        $acl = new Zend_Acl();

        // ������ ������� ��� �����
        $acl->addResource('index');
        $acl->addResource('error');
        $acl->addResource('auth');

        // ��� ������
        $acl->addResource('admin');

        // ������� create, update, delete � ��������� ������� admin
        $acl->addResource('create', 'index');
        $acl->addResource('update', 'index');
        $acl->addResource('delete', 'index');

        // ������� login, logout � ��������� ������� auth
        $acl->addResource('login', 'auth');
        $acl->addResource('logout', 'auth');

        // ���� "����" (��������������� ����������)
        $acl->addRole('guest');

        // ����������� ��������� ������ �� �����
        $acl->addRole('admin', 'guest');

        // ������ �������
        $acl->allow('guest', 'error');
        $acl->allow('guest', 'index', array('index', 'view'));
        $acl->allow('guest', 'auth', array('index', 'login', 'logout'));

        $acl->allow('admin', 'admin', array('index', 'create', 'update', 'delete'));

        // ��������� ��������� ����������
        $fc = Zend_Controller_Front::getInstance();

        // �������� ����� � ������ AccessCheck
        $fc->registerPlugin(new Application_Plugin_AccessCheck($acl, Zend_Auth::getInstance()));
    }
}


