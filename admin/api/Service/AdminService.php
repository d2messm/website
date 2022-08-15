<?php
class AdminService{
    public function addProductCategory($data){
        $parentCatId = Helper::Sanitize($data['parent_category_id']);
        $categoryName = Helper::Sanitize($data['category_name']);
        $adminId = Helper::Sanitize($data['admin_id']);
        
        $adminController = new AdminController();
    }
    public function removeProductCategory(){
        //add a nw category to category table
    }
    public function updateProductCategory(){
        //add a nw category to category table
    }
    public function generateBill(){
        //add a nw category to category table
    }
    public function addClient(){
        //add a nw category to category table
    }
}
?>

