<?php

class ExcelController
{

    public function ValidateFile($target_file, $target_dir, $uploadOk, $imageFileType, $file)
    {
        //this file might contain updated data, just override previous file
        /*if (file_exists($target_file)) {
            $headerrow = $this->readHeader($target_file);
            return Helper::getStandardData(1, "", 1, $headerrow);
            $uploadOk = 0;
        }*/
        // Check file size
        if ($file["size"] > 1048576) {//1mb =>bytes
            return Helper::getStandardData(0, "Sorry, your file is too large.", 1);
            $uploadOk = 0;
        }
        // Allow certain file formats
        $supportedformats = Constant::$EXCEL_ARRAY;
        if (!in_array($imageFileType, $supportedformats)) {
            return Helper::getStandardData(0, "Sorry, file format is not allowed.", 1);
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return Helper::getStandardData(0, "Sorry, your file was not uploaded.", 1);
        } else {
            ini_set('upload_max_filesize', '1M');
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $headerrow = $this->readHeader($target_file);
                return Helper::getStandardData(1, "", 1, $headerrow);
            } else {
//                ini_get('upload_max_filesize'). ini_get('post_max_size')
                return Helper::getStandardData(0, "Sorry, there was an error uploading your file.", 1);
            }
        }
    }

    public function readHeader($target_file)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
        /** PHPExcel_IOFactory */
        $inputFileName = $target_file;
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $row = $objPHPExcel->getActiveSheet()->getRowIterator(1)->current();
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);
        $headerrow = array();
        foreach ($cellIterator as $cell) {
            $headerrow[$cellIterator->key()] = $cell->getValue();
        }
        return $headerrow;
    }

    public function readExcel($inputFileName)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }


    public function UploadExcelRecords($dataPost)
    {
        $filename = './tempuploads/' . Helper::Sanitize($dataPost['filename']);
        $adminId = $dataPost['admin_id'];
        $data = $dataPost['data'];
        $excelController = new ExcelController();
        $exceldata = $excelController->readExcel($filename);
        //don't read the first header record .Index is 1 for first
        $productModel = new ProductModel();
        $productNameColumn = $data[0]["value"];
        if ($productNameColumn == '0') {
            return Helper::getStandardData(0, "Product Name is Compulsory", 1);
        }
        $productMakeColumn = $data[1]["value"];
        if ($productMakeColumn == '0') {
            $GLOBALS['productMake'] = '';
        }
        $categoryNameColumn = $data[2]["value"];
        if ($categoryNameColumn == '0') {
            return Helper::getStandardData(0, "Category of Product is Required", 1);
        }
        $unitOfMeasurementColumn = $data[3]["value"];
        if ($unitOfMeasurementColumn == '0') {
            $GLOBALS['unitOfMeasurement'] = '';
        }
        $barcodeColumn = $data[4]["value"];
        if ($barcodeColumn == '0') {
            $GLOBALS['barcode'] = '';
        }
        $purchasePriceColumn = $data[5]["value"];
        if ($purchasePriceColumn == '0') {
            $GLOBALS['purchasePrice'] = 0;
        }
        $sellingPriceColumn = $data[6]["value"];
        if ($sellingPriceColumn == '0') {
            $GLOBALS['sellingPrice'] = 0;
        }
        $discountColumn = $data[7]["value"];
        if ($discountColumn == '0') {
            $GLOBALS['discount'] = 0;
        }
        $productDescriptionColumn = $data[8]["value"];
        if ($productDescriptionColumn == '0') {
            return Helper::getStandardData(0, "Please Provide Product Description", 1);
        }
        $hsnColumn = $data[9]["value"];
        if ($hsnColumn == '0') {
            $GLOBALS['hsn'] = 0;
        }

        $categoryCounter = 0;
        $productCounter = 0;
        for ($i = 2; $i <= count($exceldata); $i++) {
            //add the product category
            if ($categoryNameColumn != NULL) {
                $parentId = 0;
                $GLOBALS['categoryName'] = $exceldata[$i][$categoryNameColumn];
                if (strlen(trim($GLOBALS['categoryName'])) != 0) {
                    $resultSet = $productModel->addProductCategory($parentId, $GLOBALS['categoryName'], $adminId);
                    if (!$resultSet) {
                        $rs = $productModel->searchCategoryByName($GLOBALS['categoryName']);
                        if ($rs) {
                            $row = mysqli_fetch_assoc($rs);
                            $category_id = $row['category_id'];
                        }
                    } else {
                        $category_id = $productModel->lastInsertId();
                        $categoryCounter++;
                    }
                }
            } else {
                $category_id = NULL;
            }
            $productName = $exceldata[$i][$productNameColumn];
            if ($productMakeColumn != '0')
                $GLOBALS['productMake'] = $exceldata[$i][$productMakeColumn];
            if ($categoryNameColumn != '0')
                $GLOBALS['categoryName'] = $exceldata[$i][$categoryNameColumn];
            if ($unitOfMeasurementColumn != '0')
                $GLOBALS['unitOfMeasurement'] = $exceldata[$i][$unitOfMeasurementColumn];
            if ($barcodeColumn != '0')
                $GLOBALS['barcode'] = $exceldata[$i][$barcodeColumn];
            if ($purchasePriceColumn != '0')
                $GLOBALS['purchasePrice'] = $exceldata[$i][$purchasePriceColumn];
            if ($sellingPriceColumn != '0')
                $GLOBALS['sellingPrice'] = $exceldata[$i][$sellingPriceColumn];
            if ($discountColumn != '0')
                $GLOBALS['discount'] = $exceldata[$i][$discountColumn];
            if ($productDescriptionColumn != '0') {
                $GLOBALS['productDescription'] = $exceldata[$i][$productDescriptionColumn];
            }
            if ($hsnColumn != '0')
                $GLOBALS['hsn'] = $exceldata[$i][$hsnColumn];
            $productImageURL = '';
            $categoryId = $category_id;
            $features = '';
            $feature_description = '';
            $displayPrice = 0;

            $resultSet = $productModel->doesProductExist($productName, $GLOBALS['productMake'], $category_id);
            if ($resultSet) {
                if (mysqli_num_rows($resultSet) == 0 && strlen(trim($productName)) != 0) {
                    $resultSetProduct = $productModel->addProduct($productName, $GLOBALS['productMake'], $categoryId, $GLOBALS['barcode'], $GLOBALS['hsn'], $GLOBALS['purchasePrice'], $GLOBALS['sellingPrice'], $displayPrice,
                        $GLOBALS['unitOfMeasurement'], $GLOBALS['discount'], $GLOBALS['productDescription'], $productImageURL, $features, $feature_description, $adminId);
//                    if (!$resultSetProduct)
//                        return Helper::getStandardData(0, Helper::queryFailedMessage(), 1);continue use
                    $product_id = $productModel->lastInsertId();
                    $productCounter++;
                } else {
                    $row = mysqli_fetch_assoc($resultSet);
                    $product_id = $row['product_id'];
                }
            } else {
//                return Helper::getStandardData(0, "Product Could not be added", 1);
            }

        }
        if (file_exists($filename)) {
            unlink($filename);
        }
        $msg = $categoryCounter . " categories added, " . $productCounter . " products added " . " out of " . (count($exceldata) - 1) . " Records!";
        $data = array("msg" => $msg);
        return Helper::getStandardData(1, '', 1, $data);
    }
}
