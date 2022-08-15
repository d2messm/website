<?php

class ProductController {

    public function getAllProduct($isWeb) {
        $productModel = new ProductModel();
        $productRS = $productModel->getAllProduct();

        if (!$productRS)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);

        else if (mysqli_num_rows($productRS) == 0)
            return Helper::getStandardData(0, "There is no Product.", 1);
        else {
            $productArr = array();

            while (($row = mysqli_fetch_assoc($productRS)) != null) {
                $row['product_description'] = Helper::UnSanitize($row['product_description']);

                $categoryRs = $productModel->getCategoryInfo($row['category_id']);

                if (mysqli_num_rows($categoryRs) > 0) {
                    $row['category_name'] = mysqli_fetch_assoc($categoryRs)['category_name'];
                } else {
                    $row['category_name'] = 'Not Found';
                }

                $productArr[] = $row;
            }

            return Helper::getStandardData(1, "", 1, $productArr);
        }
    }

    public function getAllTopProduct($isWeb, $limit) {
        $error = '';
        if (strlen($limit) == 0) {
            $error .= 'Please Specify limit';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }


        $productModal = new ProductModel();

        $productRS = $productModal->getAllTopProduct($limit);

        if (!$productRS)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        if (mysqli_num_rows($productRS) == 0)
            return Helper::getStandardData(1, "There is no Product.", 1);
        else {
            $productArr = array();
            while (($row = mysqli_fetch_assoc($productRS)) != null) {
                $row['product_description'] = Helper::UnSanitize($row['product_description']);
                $productArr[] = $row;
            }
            return Helper::getStandardData(1, "", 1, $productArr);
        }
    }

    public function getAllProductInCategory($categoryId, $isWeb) {
        $error = '';
        if (strlen($categoryId) == 0) {
            $error .= 'Please Specify Category Id';
        }

        if (strlen($error) != 0) {
            Helper::sendData(0, $error, 1);
            exit;
        }


        $productModal = new ProductModel();
        $productRS = $productModal->getAllProductInCategory($categoryId);

        if (!$productRS)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        if (mysqli_num_rows($productRS) == 0)
            return Helper::getStandardData(1, "There is no Product.", 1);
        else {
            $productArr = array();
            while (($row = mysqli_fetch_assoc($productRS)) != null) {
                $row['product_description'] = Helper::UnSanitize($row['product_description']);
                $productArr[] = $row;
            }
            return Helper::getStandardData(1, "", 1, $productArr);
        }
    }

    public function getSpecificProduct($productId, $isWeb) {

        $error = '';
        if (strlen($productId) == 0) {
            $error .= 'Invalid Product Id';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $productModel = new ProductModel();
        $resultSet = $productModel->getSpecificProduct($productId);
        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        }
        if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(1, "Specified Product Not Found.", 1);
        } else {
            $row = mysqli_fetch_assoc($resultSet);

            $row['product_description'] = Helper::UnSanitize($row['product_description']);
            $categoryRs = $productModel->getCategoryInfo($row['category_id']);

            if (mysqli_num_rows($categoryRs) > 0) {
                $row['category_name'] = mysqli_fetch_assoc($categoryRs)['category_name'];
            } else {
                $row['category_name'] = 'Not Found';
            }

            return Helper::getStandardData(1, "", 1, $row);
        }
    }

    //to delete specific product
    public function deleteSpecificProduct($productId, $adminId, $isWeb) {
        $error = '';
        if (strlen($productId) == 0) {
            $error .= 'Invalid Product';
        }
        if (strlen($adminId) == 0) {
            $error .= 'Invalid admin';
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $productModel = new ProductModel();
        $resultSet = $productModel->deleteSpecificProduct($productId);
        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            return Helper::getStandardData(1, "delete Success", 1);
        }
    }

    public function addProduct($isWeb, $productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, $sellingPrice, $displayPrice, $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Unknown Admin ID ';
        }
        if (strlen($productName) == 0) {
            $error .= 'Please specify Product Name ';
        }
        if (strlen($categoryId) == 0) {
            $error .= 'Please Specify Category Id ';
        }
        if (strlen($productImageURL) == 1) {
            $error .= 'Please upload proper format of Image no ' . $productImageURL;
        }
        if (strlen($productDescription) == 0) {
            $error .= 'Please Add Description of Product ';
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }
        $productModel = new ProductModel();
        $productRS = $productModel->checkIfProductExist($productName, $productMake, $categoryId);

        if (mysqli_num_rows($productRS) > 0) {
            return Helper::getStandardData(0, "Product Already Exist in This Category", 1);
        }

        $resultSet = $productModel->addProduct($productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, $sellingPrice, $displayPrice, $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId);

        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else
            return Helper::getStandardData(1, "Sucessfully Added", 1, $productModel->lastInsertId());
    }

    public function updateProduct($isWeb, $productId, $productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, $sellingPrice, $displayPrice, $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId) {

        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Unknown Admin ID ';
        }
        if (strlen($productName) == 0) {
            $error .= 'Please specify Product Name ';
        }
        if (strlen($categoryId) == 0) {
            $error .= 'Please Specify Category Id ';
        }
        if (strlen($productId) == 0) {
            $error .= 'Product Id Invalid ';
        }
        if (strlen($productImageURL) == 1) {
            $error .= 'Please upload proper format of Image no ' . $productImageURL;
        }
        if (strlen($productDescription) == 0) {
            $error .= 'Please Add Description of Product ';
        }
        $productModel = new ProductModel();

        if (strlen($productImageURL) == 0) {
            $productImageRS = $productModel->getImageUrl($productId);
            $productImageRow = mysqli_fetch_assoc($productImageRS);
            $productImageURL = $productImageRow['product_image_url'];
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $resultSet = $productModel->updateProduct($productId, $productName, $productMake, $categoryId, $barcode, $hsn, $purchasePrice, $sellingPrice, $displayPrice, $unitOfMeasurement, $discount, $productDescription, $productImageURL, $features, $featurDescription, $adminId);

        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else
            return Helper::getStandardData(1, "Sucessfully Added", 1, $productModel->lastInsertId());
    }

    /* ----- Category ----- */

    public function getAllCategory($isWeb) {

        $productModel = new ProductModel();
        $resultSet = $productModel->getAllCategory();

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        } else {
            $categoryArr = array();

            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $categoryArr[] = $row;
            }

            return Helper::getStandardData(1, '', 1, $categoryArr);
        }
    }

    //for menu
    public function getAllProductCategory($isWeb, $forMenu) {
        $productModal = new ProductModel();
        $resultSet = $productModal->getAllProductCategory();

        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        if (mysqli_num_rows($resultSet) == 0)
            return Helper::getStandardData(1, "There is no Category.", 1);
        else {
            $categoryArr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $categoryArr[] = $row;
            }

            $formattedArr = array();

            $this->fillParent($categoryArr, $formattedArr);

            for ($i = 0; $i < count($formattedArr); $i++) {
                $this->searchForSubCategory($formattedArr[$i]['category_id'], $categoryArr, $formattedArr[$i]);
            }

            if ($forMenu != "1")
                return Helper::getStandardData(1, "", 1, $formattedArr);

            $serviceModel = new ServiceModel();

            $serviceRS = $serviceModel->getAllServiceName();

            $serviceArr = array();
            if (mysqli_num_rows($serviceRS) > 0) {

                while (($row = mysqli_fetch_assoc($serviceRS)) != null) {
                    $serviceArr[] = $row;
                }
            }

            return Helper::getStandardData(1, '', 1, array('product' => $formattedArr, 'service' => $serviceArr));
        }
    }

    private function searchForSubCategory($parentId, $categoryArr, &$formattedArrIndex) {
        $hasChild = 0;
        for ($index = 0; $index < count($categoryArr); $index++) {
            if ($categoryArr[$index]['parent_id'] == $parentId) {
                $hasChild = 1;
                $formattedArrIndex['child'][] = $categoryArr[$index];
            }
        }
        $formattedArrIndex['has_child'] = $hasChild;
    }

    private function fillParent($categoryArr, &$formattedArr) {
        $formatIndex = 0;
        for ($index = 0; $index < count($categoryArr); $index++) {
            if ($categoryArr[$index]['parent_id'] == '0') {
                $formattedArr[$formatIndex] = array();
                $formattedArr[$formatIndex] = $categoryArr[$index];
                $formatIndex++;
            }
        }
    }

    public function addProductCategory($parentId, $categoryName, $addedby, $isWeb) {
        $error = '';
        if (strlen($parentId) == 0) {
            $error .= 'Please Specify Parent Category Name';
        }

        if (strlen($categoryName) == 0) {
            $error .= 'Please Specify Category Name';
        }

        if (strlen($addedby) == 0) {
            $error .= 'Please Specify Admin';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }


        $productModal = new ProductModel();


        $categoryRS = $productModal->searchCategoryByName($categoryName);

        if (mysqli_num_rows($categoryRS) > 0) {
            return Helper::getStandardData(0, "Category Already Exist", 1);
        }

        $resultSet = $productModal->addProductCategory($parentId, $categoryName, $addedby);

        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else {
            return Helper::getStandardData(1, "Successfully Added", 1, $productModal->lastInsertId());
        }
    }

    public function getSubCategory($parentId, $isWeb) {
        $error = '';
        if (strlen($parentId) == 0) {
            $error .= 'Please Specify Parent Category Id';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $productModel = new ProductModel();
        $resultSet = $productModel->getSubCategory($parentId);
        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        if (mysqli_num_rows($resultSet) == 0)
            return Helper::getStandardData(1, "There is No Subcategory", 1);
        else {
            $subCatArr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $subCatArr[] = $row;
            }

            return Helper::getStandardData(1, '', 1, $subCatArr);
        }
    }

    public function getAllStock($isWeb, $adminId) {
        $error = '';
        if (strlen($adminId) === 0) {
            $error .= 'Invalid Admin Id';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $productModel = new ProductModel();
        $resultSet = $productModel->getAllStock($isWeb, $adminId);

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        }

        if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, "There is no stock Detail.", 1);
        } else {

            $stockarr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $productRS = $productModel->getSpecificProduct($row['product_id']);
                $row['product_name'] = mysqli_fetch_assoc($productRS)['product_name'];
                $stockarr[] = $row;
            }
            return Helper::getStandardData(1, "", 1, $stockarr);
        }
    }

    public function getSpecificStock($isWeb, $adminId, $stockId) {
        $error = '';
        if (strlen($adminId) === 0) {
            $error .= 'Invalid Admin Id';
        }
        if (strlen($stockId) === 0) {
            $error .= 'Invalid Stock Id';
        }
        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $productModel = new ProductModel();
        $resultSet = $productModel->getSpecificStock($isWeb, $adminId, $stockId);

        if (!$resultSet) {
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        }

        if (mysqli_num_rows($resultSet) == 0) {
            return Helper::getStandardData(0, "There is no stock Detail.", 1);
        } else {
            $stockarr = array();
            while (($row = mysqli_fetch_assoc($resultSet)) != null) {
                $productRS = $productModel->getSpecificProduct($row['product_id']);
                $row['product_name'] = mysqli_fetch_assoc($productRS)['product_name'];

                $stockarr[] = $row;
            }
            return Helper::getStandardData(1, "", 1, $stockarr);
        }
    }

    public function updateStock($isWeb, $adminId, $stockId, $minQty, $maxQty, $notify) {
        $error = '';
        if (strlen($adminId) == 0) {
            $error .= 'Unknown Admin Name';
        }

        if (strlen($stockId) == 0) {
            $error .= 'Invalid Stock id';
        }

        if (strlen($error) != 0) {
            return Helper::getStandardData(0, $error, 1);
        }

        $productModel = new ProductModel();
        $resultSet = $productModel->updateStock($stockId, $minQty, $maxQty, $notify);

        if (!$resultSet)
            return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);
        else
            return Helper::getStandardData(1, "Sucessfully Updated", 1);
    }

    public function removeProductCategory($catgoryId) {
        $productModel = new ProductModel();
        if ($productModel->removeProductCategory($catgoryId))
            return Helper::getStandardData(1, "Sucessfully Removed Catgory", 1);
        else
            return Helper::getStandardData(0, "Failed to update product", 1);
    }

}
