<?php

class IndexController extends Zend_Controller_Action
{

    /**
	  * головна сторінка (виводимо список новин)
	  */
    public function indexAction()
    {
	    $this->view->title = 'Список новин';
	    $this->view->headTitle($this->view->title);

	    $news = new Application_Model_DbTable_Posts();

	    // розбиття на сторінки
		$curPage = (int)$this->getRequest()->getParam('page', 1);
		$perPage = 5; // кількість новин на одній сторінці
		$this->view->paginator = $news->getPaginatorRows($curPage, $perPage);

	    // форма для авторизації
	    $form = new Application_Form_Login();
	    $this->view->form = $form;
    }

    /**
	  * сторінка новини з ідентифікатором $id
	  */
    public function viewAction()
    {
    	$id = (int)$this->_getParam('id', 0);

    	if ($id==0) {
			// редірект на головну сторінку
	        $this->_helper->redirector('index', 'index');
    	}

	    $this->view->title = 'Сторінка новини №' . $id;
	    $this->view->headTitle($this->view->title);

	    $post = new Application_Model_DbTable_Posts();
        // отримуємо новину з ідентифікатором $id
	    $this->view->post = $post->getPost($id);

	    // форма для авторизації
	    $form = new Application_Form_Login();
	    $this->view->form = $form;
    }

}