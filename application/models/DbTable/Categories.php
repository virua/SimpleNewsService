<?php

class Application_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{
    // вказуємо таблицю, в якій зберігаються категорії
    protected $_name = 'categories';

    /**
	  * повертає масив категорій, де
	  *    ключ - цілочисельний ідентифікатор категорії
	  *    значення - назва категорії
	  */
    public function getCategories(){
    	$select = $this->select('id', 'name')->order('name ASC');
		$rows = $this->fetchAll($select)->toArray();

		// генеруємо масив категорій
    	$categories = array();

        foreach ($rows as $row) {
            $categories[$row['id']] = $row['name'];
        }

		return $categories;    }

    /**
	  * отримуємо назву категорії по її ідентифікатору
	  * повертає рядок
	  */
    public function getCategoryNameById($id){
        $id = (int)$id;

        $select = $this->select('name')->where('id = ?', $id);
        $row = $this->fetchRow($select);

		return $row['name'];
    }

}