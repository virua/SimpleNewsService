<?php

class AdminController extends Zend_Controller_Action
{

    /**
	  * список новин
	  */
    public function indexAction()
    {

        $this->view->title = 'Список новин - Адмінка';
        $this->view->headTitle($this->view->title);

        $news = new Application_Model_DbTable_Posts();

        // розбиття на сторінки
		$curPage = (int)$this->getRequest()->getParam('page', 1);
		$perPage = 5; // кількість новин на одній сторінці
		$this->view->paginator = $news->getPaginatorRows($curPage, $perPage);

    }

    /**
	  * створення новини
	  */
    public function createAction()
    {
        $this->view->title = 'Створити новину - Адмінка';
        $this->view->headTitle($this->view->title);

        $form = new Application_Form_Post();
        $form->submit->setLabel('Створити');

        // отримуємо масив категорій для select'а
        $categories = new Application_Model_DbTable_Categories();
        $catsArr = $categories->getCategories();
        // і заповнюємо ним цей елемент форми
        $form->getElement('category_id')->setMultiOptions( $catsArr );

	    $this->view->form = $form;

	    // перевіряємо, чи форму надіслано
	    if ($this->getRequest()->isPost()) {

	        // масив даних з форми
	        $formData = $this->getRequest()->getPost();

	        if ($form->isValid($formData)) {

	            $title = $formData['title'];
	            $text = $formData['text'];
	            $category_id = (int)$formData['category_id'];

				// додаємо новину в базу
				$posts = new Application_Model_DbTable_Posts();
	            $posts->addPost($title, $text, $category_id);

	            // редірект на головну сторінку адмінки
	            $this->_helper->redirector('index', 'admin');

	        } else {
	            $form->populate($formData);
	        }

	 	}
    }

    /**
	  * редагування новини
	  */
    public function updateAction()
    {
        $this->view->title = 'Редагування новини - Адмінка';
        $this->view->headTitle($this->view->title);

        $form = new Application_Form_Post();
        $form->submit->setLabel('Редагувати');

        // отримуємо масив категорій для select'а
        $categories = new Application_Model_DbTable_Categories();
        $catsArr = $categories->getCategories();
        // і заповнюємо ним цей елемент форми
        $form->getElement('category_id')->setMultiOptions($catsArr);

	    $this->view->form = $form;

	    // перевіряємо, чи форму надіслано
	    if ($this->getRequest()->isPost()) {

	        // масив даних з форми
	        $formData = $this->getRequest()->getPost();

	        if ($form->isValid($formData)) {

	            $id = (int)$formData['id'];
	            $title = $formData['title'];
	            $text = $formData['text'];
	            $category_id = (int)$formData['category_id'];

				if ($id > 0) {
					// редагуємо (оновлюємо існуючу) новину в базі
					$posts = new Application_Model_DbTable_Posts();
		            $posts->updatePost($id, $title, $text, $category_id);

		            $this->view->message = 'Новина оновлена успішно';
	            }

	        } else {
	            $form->populate($formData);
	        }

	    }else{

		    $id = (int)$this->_getParam('id', 0);

		    if ($id > 0) {
			    // отримуємо новину з ідентифікатором рівним $id
			    // для заповнення форми
			    $posts = new Application_Model_DbTable_Posts();
			    $formData = $posts->getPost($id);
			    $form->populate($formData);
		    }

	    }
    }

    /**
	  * видалення новини
	  */
    public function deleteAction()
    {
    	$this->view->title = 'Видалення новини - Адмінка';
        $this->view->headTitle($this->view->title);

	    // перевіряємо, чи форму надіслано
	    if ($this->getRequest()->isPost()) {

	        // перевіряємо, чи підтверджене видалення
	        $del = $this->getRequest()->getPost('delete');
	        if (isset($del)) {
	            $id = (int)$this->getRequest()->getPost('id');
	            if ($id > 0) {
		            // видаляємо новину з ідентифікатором $id
					$posts = new Application_Model_DbTable_Posts();
		            $posts->deletePost($id);
	            }
	        }

	        $this->_helper->redirector('index', 'admin');

	    } else {
	        // виводимо форму для підтвердження видалення
	        // новини з ідентифікатором $id
	        $id = $this->_getParam('id', 0);
	        $posts = new Application_Model_DbTable_Posts();
	        $this->view->post = $posts->getPost($id);
	    }
    }


}