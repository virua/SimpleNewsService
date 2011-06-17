<?php

class Zend_View_Helper_CategoryName
{
    public function categoryName($id)
    {
        $categories = new Application_Model_DbTable_Categories();
        echo $categories->getCategoryNameById($id);
    }
}
