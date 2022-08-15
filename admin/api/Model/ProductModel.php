<?php

class ProductModel extends Database {

    public function getAllProduct() {
        $sql = "SELECT * FROM `product` ORDER BY `product_name` ASC;";
        return parent::executeQuery($sql);
    }

    public function getAllCategory() {
        $sql = "SELECT * FROM `category` ORDER BY `category_name` ASC;";
        return parent::executeQuery($sql);
    }
    
    public function getAllTopProduct($limit) {
        $sql = "SELECT * FROM `product` ORDER BY `timestamp` desc limit $limit";
        return parent::executeQuery($sql);
    }

    public function getAllProductInCategory($categoryId) {
        $sql = "SELECT * FROM `product` WHERE `category_id`='$categoryId' ORDER BY `product_name` ASC;";
        return parent::executeQuery($sql);
    }

    public function getSpecificProduct($productId) {
        $sql = "SELECT * FROM `product` WHERE `product_id`='$productId';";
        return parent::executeQuery($sql);
    }
    
    public function deleteSpecificProduct($productId) {
        $sql = "DELETE FROM `product` WHERE `product_id`='$productId';";
        return parent::executeQuery($sql);
    }

    public function getAllStock($isWeb, $adminId) {
        $sql = "SELECT * FROM `stock` ORDER BY `timestamp` DESC";
        return parent::executeQuery($sql);
    }

    public function getSpecificStock($isWeb, $adminId, $stockId) {
        $sql = "SELECT * FROM `stock`WHERE `stock_id`='$stockId' ORDER BY `timestamp` DESC";
        return parent::executeQuery($sql);
    }

    public function updateStock($stockId, $minQty, $maxQty, $notify) {
        $sql = "UPDATE `stock` SET `min_quantity`='$minQty',`max_quantity`='$maxQty',`notify`='$notify' WHERE `stock_id`='$stockId'";
        return parent::executeQuery($sql);
    }

    public function addProduct($productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, $sellingPrice, $displayPrice,
            $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId) {
        $sql = "INSERT INTO "
                . "`product`"
                . "(`product_name`, `product_make`, `category_id`, `barcode`, `hsn`, `purchase_price`, `selling_price`, `display_price`, "
                . " `unit_of_measurement`, `discount`, `product_description`,`product_image_url`, `features`, `feature_description`, `addedby`)"
                . "VALUES"
                . "('$productName', '$productMake', '$categoryId', '$barcode', '$hsn', '$purchasePrice','$sellingPrice', '$displayPrice', '$unitOfMeasurement',"
                . "'$discount','$productDescription','$productImageURL','$features', '$featurDescription', '$adminId')";

        return parent::executeQuery($sql);
    }

    public function addProductAssoc($product) {
        return parent::insertAssoc($product, 'product');
    }

    public function checkIfProductExist($productName, $productMake, $categoryId) {
        $sql = "SELECT * FROM `product` WHERE `product_name`='$productName' AND `product_make`='$productMake' AND `category_id`='$categoryId'";
        return parent::executeQuery($sql);
    }
    public function getImageUrl($product_id){
        $sql = "SELECT `product_image_url` FROM `product` where `product_id`='$product_id';";
        return parent::executeQuery($sql);
    }
    public function updateProduct($productId ,$productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, 
            $sellingPrice, $displayPrice, $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId) {
        $sql = "UPDATE "
                . "`product`"
                . "  SET `product_name`='$productName',  `product_make`='$productMake',"
                . "  `category_id`='$categoryId',  `barcode`='$barcode',  `hsn`='$hsn', "
                . "  `purchase_price`='$purchasePrice', `display_price`='$displayPrice', "
                . "  `selling_price`='$sellingPrice',  `unit_of_measurement`='$unitOfMeasurement', "
                . "  `discount`='$discount',  `product_description`='$productDescription', "
                . "  `features`='$features', `feature_description`='$featurDescription', "
                . "  `product_image_url`='$productImageURL',  `addedby`='$adminId' WHERE `product_id`='$productId';";
        return parent::executeQuery($sql);
    }

    public function updateProductTaxDetail($productId, $cgst, $sgst, $igst, $cess) {
        $sql = "UPDATE `product` "
                . "SET `cgst`='$cgst', `sgst`='$sgst', `igst`='$igst', `cess`='$cess'"
                . " WHERE `product_id`='$productId'";
        return parent::executeQuery($sql);
    }

    public function deleteProduct($productId) {
        $sql = "DELETE FROM product WHERE product_id='$productId';";
        return parent::executeQuery($sql);
    }

    /* -----Category----- */

    public function getSubCategory($parentId) {
        $sql = "SELECT category_id, category_name FROM category WHERE parent_id='$parentId' and status=1 ORDER BY `category_name` ASC;";
        return parent::executeQuery($sql);
    }

    public function getAllProductCategory() {
        $sql = "SELECT * FROM `category` where status=1 ORDER BY `category_name` ASC";
        return parent::executeQuery($sql);
    }

    public function addProductCategory($parentId, $categoryName, $addedby) {
        $sql = "INSERT INTO "
                . "`category` "
                . "(`category_id`, `parent_id`, `category_name`, `addedby`, `timestamp`)"
                . " VALUES"
                . "(NULL, '$parentId', '$categoryName', '$addedby', now());";
        return parent::executeQuery($sql);
    }

    public function searchCategoryByName($categoryName) {
        $sql = "SELECT * FROM `category` WHERE `category_name`='$categoryName' and status=1 LIMIT 1";
        return parent::executeQuery($sql);
    }

    public function getCategoryInfo($categoryId) {
        $sql = "SELECT * FROM `category` WHERE `category_id`='$categoryId' and status=1 LIMIT 1";
        return parent::executeQuery($sql);
    }

    public function lastInsertId() {
        return parent::lastInsertedId();
    }

    public function doesProductExist($productName, $brandName, $category_id) {
        $sql = "SELECT `product_id` FROM `product` WHERE `product_name`='$productName' AND `product_make`='$brandName' AND `category_id`='$category_id' LIMIT 1";
        return parent::executeQuery($sql);
    }

    public function addUpdateStock($productId, $quantity) {
        $sql = "INSERT INTO `stock` (`product_id`,`quantity`) VALUES ('$productId','$quantity') ON DUPLICATE KEY UPDATE `quantity`=(`quantity`+'$quantity')";
        return parent::executeQuery($sql);
    }

    public function removeProductCategory($catgoryId) {
        $sql = "UPDATE `category` SET `status`=0 WHERE `category_id`='$catgoryId' or `parent_id`='$catgoryId';";
        return parent::executeQuery($sql);
    }

}
