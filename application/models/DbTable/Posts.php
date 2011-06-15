<?php

class Application_Model_DbTable_Posts extends Zend_Db_Table_Abstract
{
    // вказуємо таблицю, в якій зберігаються новини
    protected $_name = 'posts';

    /**
	  * отримуємо новину по ідентифікатору
	  * повертає масив
	  */
    public function getPost($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);

        if (!$row) {
            throw new Exception("Не вдається знайти новину з ID = $id");
        }

        return $row->toArray();
    }

    /**
	  * отримуємо новини порціями
	  * параметри:
	  *    pageNumber - цілочисельний номер поточної сторінки,
	  *    perPage - кількість записів на одній сторінці
	  */
	public function getPaginatorRows($pageNumber=1, $perPage=5)
	{
		$paginator = new Zend_Paginator(
			new Zend_Paginator_Adapter_DbSelect(
				$this->select()->order('id DESC')
			)
		);

		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage($perPage);

		return $paginator;
	}

    /**
	  * додаємо новину - робимо запис в базу
	  */
    public function addPost($title, $text, $category_id)
    {
        $data = array(
            'title' => $title,
            'text' => $text,
            'date' => new Zend_Db_Expr('NOW()'), // поточна дата
            'category_id' => $category_id,
        );
        $this->insert($data);
    }

    /**
	  * редагуємо новину з ідентифікатором $id
	  */
    public function updatePost($id, $title, $text, $category_id)
    {
        $id = (int)$id;

        $data = array(
            'title' => $title,
            'text' => $text,
            'category_id' => $category_id,
        );
        $this->update($data, 'id = ' . $id);
    }

    /**
	  * видаляємо новину з ідентифікатором $id
	  */
    public function deletePost($id)
    {
        $this->delete('id = ' . (int)$id);
    }
}