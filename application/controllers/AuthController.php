<?php

class AuthController extends Zend_Controller_Action
{

    public function indexAction()
    {
        // редірект на сторінку авторизації
        $this->_helper->redirector('login');
    }

    /**
	  * сторінка авторизації
	  */
	public function loginAction()
	{
        $this->view->title = 'Вхід в адмінку';
	    $this->view->headTitle($this->view->title);

	    // перевіряємо, чи користувач авторизований
	    if (Zend_Auth::getInstance()->hasIdentity()) {
	        // робимо редірект на головну сторінку
	        $this->_helper->redirector('index', 'index');
	    }

	    // створюємо форму для авторизації
	    $form = new Application_Form_Login();
	    $this->view->loginForm = $form;

	    // дані відіслано через Post-запит,
	    // користувач намагається увійти
	    if ($this->getRequest()->isPost()) {
	        // масив даних з форми
	        $formData = $this->getRequest()->getPost();

	        // перевіряємо, чи форма заповнена вірно
	        if ($form->isValid($formData)) {
	            // створюємо адаптер з'єднання з БД
	            $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

	            $authAdapter->setTableName('users')
	                ->setIdentityColumn('username')
	                ->setCredentialColumn('password')
            		->setCredentialTreatment('MD5(?)');

	            // підставляємо логін і пароль з форми
	            $authAdapter->setIdentity( $formData['username'] )
	                		->setCredential( $formData['password'] );

	            // отримуємо екземпляр Zend_Auth
	            $auth = Zend_Auth::getInstance();

	            // спроба авторизувати користувача
	            $result = $auth->authenticate($authAdapter);

	            // перевіряємо, як пройшла авторизація
	            if ($result->isValid()) {
	                // дістаємо дані про користувача
	                $identity = $authAdapter->getResultRowObject();

	                // отримуємо доступ до глобального сховища даних
	                $authStorage = $auth->getStorage();

	                // заносимо дані про користувача в це сховище
	                $authStorage->write($identity);

	                // робимо редірект
	                $this->_helper->redirector('index', 'index');
	            } else {
	                $this->view->errMessage = 'Невірне ім\'я користувача або невірний пароль';
	            }
	        }
	    }
	}

    /**
	  * сторінка для виходу із системи
	  */
	public function logoutAction()
	{
	    // знищуємо інформацію про авторизацію користувача
	    Zend_Auth::getInstance()->clearIdentity();

	    // і перенаправляємо його на головну
	    $this->_helper->redirector('index', 'index');
	}


}





