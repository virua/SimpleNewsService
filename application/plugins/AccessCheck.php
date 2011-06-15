<?php
/**
  * ��������, �� �� ���������� ������ �� ������� ������� (�������)
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
        // �������� ��'� ��������� �������
        $resource = $request->getControllerName();

        // �������� ��'� ������
        $action = $request->getActionName();

        // �������� ���� �����������
        $identity = $this->_auth->getStorage()->read();

        // ���� ���� �������, �� ���� ������ � "������"
        $role = empty($identity->role) ? 'guest' : $identity->role;

        // ���� ���������� �� �� �������, ���������� ���� �� �����������
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            $request->setControllerName('auth')->setActionName('index');
        }
    }
}


