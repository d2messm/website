<?php

class ProductService {

    public function getAllProduct($data) {
        $isWeb = Helper::Sanitize($data['isweb']);

        $productController = new ProductController();
        echo $productController->getAllProduct($isWeb);
        exit;
    }
    
    public function getAllTopProduct($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $limit = Helper::Sanitize($data['limit']);
        
        $productController = new ProductController();
        echo $productController->getAllTopProduct($isWeb,$limit);
        exit;
    }
    
    

    public function getAllProductInCategory($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $categoryId = Helper::Sanitize($data['category_id']);
        
        $productController = new ProductController();
        echo $productController->getAllProductInCategory($categoryId, $isWeb);
        exit;
    }

    public function getSpecificProduct($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $productId = Helper::Sanitize($data['product_id']);
        
        $productController = new ProductController();
        echo $productController->getSpecificProduct($productId, $isWeb);
        exit;
    }
    
    public function deleteSpecificProduct($data) {
        $adminId = Helper::Sanitize($data['admin_id']);
        $isWeb = Helper::Sanitize($data['isweb']);
        $productId = Helper::Sanitize($data['product_id']);
        $productController = new ProductController();
        echo $productController->deleteSpecificProduct($productId,$adminId, $isWeb);
        exit;
    }

    
    public function addProduct($data, $files = '') {

        //to avoid undefined index error, first get that index if that exist else an empty string
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $productName = Helper::Sanitize(Helper::getIndex($data, 'product_name'));
        $productMake = Helper::Sanitize(Helper::getIndex($data, 'product_make'));
        $categoryId = Helper::Sanitize(Helper::getIndex($data, 'category_id'));
        $barcode = Helper::Sanitize(Helper::getIndex($data, 'barcode'));
        $hsn = Helper::Sanitize(Helper::getIndex($data, 'hsn'));
        $purchasePrice = Helper::Sanitize(Helper::getIndex($data, 'purchase_price'));
        $sellingPrice = Helper::Sanitize(Helper::getIndex($data, 'selling_price'));
        $displayPrice = Helper::Sanitize(Helper::getIndex($data, 'display_price'));
        $unitOfMeasurement = Helper::Sanitize(Helper::getIndex($data, 'unit_of_measurement'));
        $discount = Helper::Sanitize(Helper::getIndex($data, 'discount'));
        $productDescription = Helper::Sanitize(Helper::getIndex($data, 'product_description'));
        $features = Helper::Sanitize(Helper::getIndex($data, 'features'));
        $featurDescription = Helper::Sanitize(Helper::getIndex($data, 'feature_description'));
        $adminId = Helper::Sanitize(Helper::getIndex($data, 'admin_id'));

        $productImageURL = '';
        if ($files != '') {
            for ($i = 0; $i <Constant::$MAX_NO_OF_IMAGE_TO_BE_UPDATED; $i++) {
                if (isset($files['product_image_' . ($i + 1)])) {

                    $valid = Helper::validateProductImages($files['product_image_' . ($i + 1)]);

                    if ($valid == '') {
                        if (strlen($productImageURL) != 0)
                            $productImageURL .= Constant::$PRODUCT_IMG_URL_SEPERATOR;
                        $productImageURL .= Helper::uploadFile($files['product_image_' . ($i + 1)], Constant::$PRODUCT_IMG_DIR);
                    } else {
                        echo Helper::getStandardData(0, 'Product Image ' . ($i + 1) . " " . $valid, 1);
                        exit;
                    }
                }
            }
        }
        $productController = new ProductController();
        echo $productController->addProduct($isWeb, $productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, $sellingPrice, $displayPrice, $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId);
        exit;
    }
    
    
    
    public function updateProduct($data, $files = '') {

        //to avoid undefined index error, first get that index if that exist else an empty string
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));

        $productId = Helper::Sanitize(Helper::getIndex($data, 'product_id'));
        $productName = Helper::Sanitize(Helper::getIndex($data, 'product_name'));
        $productMake = Helper::Sanitize(Helper::getIndex($data, 'product_make'));
        $categoryId = Helper::Sanitize(Helper::getIndex($data, 'category_id'));
        $barcode = Helper::Sanitize(Helper::getIndex($data, 'barcode'));
        $hsn = Helper::Sanitize(Helper::getIndex($data, 'hsn'));
        $purchasePrice = Helper::Sanitize(Helper::getIndex($data, 'purchase_price'));
        $sellingPrice = Helper::Sanitize(Helper::getIndex($data, 'selling_price'));
        $displayPrice = Helper::Sanitize(Helper::getIndex($data, 'display_price'));
        $unitOfMeasurement = Helper::Sanitize(Helper::getIndex($data, 'unit_of_measurement'));
        $discount = Helper::Sanitize(Helper::getIndex($data, 'discount'));
        $productDescription = Helper::Sanitize(Helper::getIndex($data, 'product_description'));
        $features = Helper::Sanitize(Helper::getIndex($data, 'features'));
        $featurDescription = Helper::Sanitize(Helper::getIndex($data, 'feature_description'));
        $adminId = Helper::Sanitize(Helper::getIndex($data, 'admin_id'));

        $productImageURL = '';
        
            for ($i = 0; $i < Constant::$MAX_NO_OF_IMAGE_TO_BE_UPDATED; $i++) {
                
                if (isset($files['product_image_' . ($i)])) {

                    $valid = Helper::validateProductImages($files['product_image_' . ($i)]);

                    if ($valid == '') {
                        if (strlen($productImageURL) != 0)
                            $productImageURL .= Constant::$PRODUCT_IMG_URL_SEPERATOR;
                        $productImageURL .= Helper::uploadFile($files['product_image_' . ($i)], Constant::$PRODUCT_IMG_DIR);
                    } else {
                        echo Helper::getStandardData(0, 'Product Image ' . ($i) . " " . $valid, 1);
                        exit;
                    }
                }
            }
        
        $productController = new ProductController();
        echo $productController->updateProduct($isWeb,$productId, $productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, $sellingPrice, $displayPrice, $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId);
        exit;
    }


    /* ------Category------ */

    public function getAllProductCategory($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));
        $forMenu = Helper::Sanitize(Helper::getIndex($data, 'for_menu'));

        $productController = new ProductController();
        echo $productController->getAllProductCategory($isWeb, $forMenu);
        exit;
    }

    public function getAllCategory($data) {
        $isWeb = Helper::Sanitize(Helper::getIndex($data, 'isweb'));

        $productController = new ProductController();
        echo $productController->getAllCategory($isWeb);
        exit;
    }

    public function addProductCategory($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $parentId = Helper::Sanitize($data['parent_id']);
        $categoryName = Helper::Sanitize($data['category_name']);
        $addedby = Helper::Sanitize($data['admin_id']);

        $productController = new ProductController();
        echo $productController->addProductCategory($parentId, $categoryName, $addedby, $isWeb);
        exit;
    }

    public function getSubCategory($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $parentId = Helper::Sanitize($data['parent_id']);

        $productController = new ProductController();
        echo $productController->getSubCategory($parentId, $isWeb);
        exit;
    }

    public function getAllStock($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);
        $productController = new ProductController();
        echo $productController->getAllStock($isWeb, $adminId);
        exit;
    }

    public function getSpecificStock($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);
        $stockId = Helper::Sanitize($data['stock_id']);
        $productController = new ProductController();
        echo $productController->getSpecificStock($isWeb, $adminId, $stockId);
        exit;
    }

    public function updateStock($data) {
        $isWeb = Helper::Sanitize($data['isweb']);
        $adminId = Helper::Sanitize($data['admin_id']);
        $stockId = Helper::Sanitize($data['stock_id']);
        $minQty = Helper::Sanitize($data['min_qty']);
        $maxQty = Helper::Sanitize($data['max_qty']);
        $notify = Helper::Sanitize($data['notify']);
        $productController = new ProductController();
        echo $productController->updateStock($isWeb, $adminId, $stockId, $minQty, $maxQty, $notify);
        exit;
    }

    public function removeProductCategory($data) {
        $catgoryId = intval($data['category_id']);
        $productController = new ProductController();
        echo $productController->removeProductCategory($catgoryId);
        exit;
    }

}
