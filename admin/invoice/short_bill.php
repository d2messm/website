<?php

require('fpdf181/fpdf.php');

class PDF extends FPDF {

    function __construct($orientation = 'p', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);
    }

    function fancyTable($products) {
        $this->SetFillColor(255, 255, 255);
        //$this->SetLineWidth(.3);
        $this->SetFont('', '');

        for ($i = 0; $i < sizeof($products); $i++) {
            $singleProduct = $products[$i];
            $this->Cell(3, 6, ($i + 1), "", 0, 'L', true);
            $this->Cell(($GLOBALS['itemWidth'] - 3), 6, $singleProduct->product_name, "", 0, 'L', true);
            $this->Cell($GLOBALS['othersWidth'], 6, round((float) $singleProduct->product_quantity, $GLOBALS['decimalValue']), "", 0, 'C', true);
            if ($GLOBALS['is_rate'] == "true")
                $this->Cell($GLOBALS['othersWidth'], 6, round((float) $singleProduct->unit_rate, $GLOBALS['decimalValue']), "", 0, 'L', true);
            if ($GLOBALS['is_discount'] == "true")
                $this->Cell($GLOBALS['othersWidth'], 6, round((float) $singleProduct->discount, $GLOBALS['decimalValue']), "", 0, 'L', true);


            $this->Cell($GLOBALS['totalAmountWidth'], 6, number_format((float) $singleProduct->total_product_amount, $GLOBALS['decimalValue']), "", 1, 'R', true);
            $this->Cell(5, 5, '', 0, 0, "L");
            $this->Cell(35, 5, '', 0, 0, "L");
            if ($GLOBALS['is_gst']) {
                $gst = (int) $singleProduct->cgst + (int) $singleProduct->sgst + (int) $singleProduct->igst;
                $taxableAmount = (int) $singleProduct->cost_without_tax;
                if ($gst != 0)
                    $this->Cell(25, 5, '[GST: ' . round($taxableAmount / $gst, $GLOBALS['decimalValue']) . ' @ ' . round($gst, $GLOBALS['decimalValue']) . '%]', 0, 0, "L");
                else
                    $this->Cell(25, 5, '[GST: 0 @ 0%]', 0, 0, "L");
            }
            $this->Cell(0, 5, '', 0, 1, "R");
        }
    }

}

// get details
$decimalValue = 2;  //upto two decimal point

$adminCompanyName = isset($_POST['company_name']) ? $_POST['company_name'] : "Bulwark Software Research pvt. ltd.";
$adminCompanyGSTIN = isset($_POST['company_gstin']) ? strtoupper($_POST['company_gstin']) : "22AAAAA0000A1Z5";
$adminCompanyState = isset($_POST['company_state']) ? $_POST['company_state'] : "UP";
$adminCompanyPan = isset($_POST['company_pan']) ? $_POST['company_pan'] : "7294V937JSK493";

$invoiceDate = $_POST['invoice_date'];
$invoiceNo = $_POST['invoice_no'];

$customerName = $_POST['customer_name'];
$customerAddress = $_POST['customer_address'];
$shippingAddArr = explode(", ", $customerAddress);
$shippingAdd1 = $shippingAddArr[0];
$shippingAdd2 = (sizeof($shippingAddArr) > 1) ? $shippingAddArr[1] : '';
$shippingAdd3 = '';
for ($i = 2; $i < sizeof($shippingAddArr); $i++) {
    $shippingAdd3 .= $shippingAddArr[$i];
}

$customerGSTIN = isset($_POST['customer_gstin']) ? strtoupper($_POST['customer_gstin']) : "";
$dueDate = $_POST['due_date'];

$products = json_decode($_POST['products']);
$productLength = sizeof($products);

$totalAmount_without_tax = $_POST['total_amount_without_tax'];
$totalTax = $_POST['total_tax'];
$otherCharges = isset($_POST['other_charges']) ? $_POST['other_charges'] : 0;
$invoiceTotal = $_POST['invoice_total'];
$paidAmount = isset($_POST['paid_amount']) ? $_POST['paid_amount'] : 0;
$dueAmount = $_POST['due_amount'];
$is_gst = $_POST['is_gst'];
$is_cess = $_POST['is_cess'];
$is_discount = $_POST['is_discount'];
$is_tax_value = $_POST['is_tax_value'];
$is_rate = $_POST['is_rate'];

$instate = $_POST['instate'];
$outstate = $_POST['outstate'];

$otherChargesDesc = isset($_POST['other_charges_desc']) ? $_POST['other_charges_desc'] : '';
$comment = isset($_POST['comment']) ? $_POST['comment'] : "*$*Thank You Visit Again *$*";

// get detail end
//calculate headers
//header count other than SNo, and Item and Total
// SNo + Item = 30% of the width

$headerCount = 0;

//for quantity
$headerCount++;

if ($is_rate == "true")
    $headerCount++;
if ($is_discount == "true")
    $headerCount++;


//width of this bill is 80 x (230 + (11 * height of product))  mm
$pageWidth = 78; //80 -2margin

$itemWidth = $pageWidth * 0.35;
$totalAmountWidth = $pageWidth * 0.20;
$remainingWidth = $pageWidth * 0.45;

$othersWidth = $remainingWidth / $headerCount;


// end calculating headers





$pageHeight = 230;
for ($i = 1; $i <= $productLength; $i++) {
    $pageHeight += 11;
}
$pdf = new PDF('p', 'mm', array(80, $pageHeight));
// for every addition of product the height will increase 10 mm.
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetMargins(1, 1);
//row1
$pdf->Cell(0, 7, $adminCompanyName, 0, 1, "C");
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'State: ' . $adminCompanyState, 0, 1, "C");

$pdf->Cell(0, 6, 'GSTIN: ' . $adminCompanyGSTIN, 0, 1, "C");
//$pdf->Cell(0, 6, ' Tel:0120-234543', 0, 1, "C");
//$pdf->Cell(0, 6, 'Email: complaint@bsrnetwork.com', 0, 1, "C");
//$pdf->Cell(0, 6, 'WebSite: bsrnewtwork.in', 0, 1, "C");

$pdf->Cell(0, 6, '', 0, 1, "C");
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, 'Invoice NO: ' . $invoiceNo, 0, 1, "C");
$pdf->SetFont('Arial', '', 10);
$dateObj = date_create($invoiceDate);
$pdf->Cell(0, 6, 'Date/Time: ' . date_format($dateObj, "d M Y") . ' @ ' . date_format($dateObj, "g:i A") , 0, 1, "C");

$pdf->SetFont('Arial', '', 10);

$pdf->Cell(0, 6, '', 'B', 1, "C");
$pdf->Cell($itemWidth, 6, 'Item Name', 'B', 0, "L");
$pdf->Cell($othersWidth, 6, 'Qty', 'B', 0, "L");
if ($is_rate == "true")
    $pdf->Cell($othersWidth, 6, 'Rate', 'B', 0, "L");
if ($is_discount == "true")
    $pdf->Cell($othersWidth, 6, 'Discount', 'B', 0, "L");
$pdf->Cell($totalAmountWidth, 6, 'Total', 'B', 1, "R");

$pdf->SetFont('Arial', '', 8);
$pdf->fancyTable($products);

$pdf->Cell(0, 6, '', '', 1, "C");
$pdf->Cell($pageWidth, 6, '', 'T', 0, "L");
$pdf->Ln(1);
$pdf->Cell($pageWidth * 0.60, 6, 'Total Amount: ' . number_format((float) $totalAmount_without_tax, $decimalValue), '', 1, "R");


$pdf->Cell($pageWidth * 0.60, 6, 'Total Tax: ' . number_format((float) $totalTax, $decimalValue), '', 1, "R");


if ($otherCharges != 0)
    $pdf->Cell($pageWidth * 0.60, 6, 'Other Charge* :     ' . $otherCharges, '', 1, "R");

$pdf->SetFont('Arial', '', 12);
$pdf->Cell($pageWidth / 5, 6, '', '', 0, "R");
$pdf->Cell($pageWidth / 2, 6, 'Bill Amount: ' . number_format((float) $invoiceTotal, $decimalValue), 'TB', 1, "R");

$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(30, 6, 'Your Saving: 00:00', '', 0, "L");
//$pdf->Cell(30, 6, '', '', 0, "L");
//$pdf->Cell(40, 6, 'Payment Detail', '', 1, "R");
//$pdf->SetFont('Arial', '', 10);
//$pdf->Cell(40, 6, 'Your total Discount: ', '', 0, "L");
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(30, 6, 'Cash: 00.00', '', 1, "R");
//$pdf->Cell(40, 6, '', '', 0, "R");
//$pdf->Cell(30, 6, 'Card: 00.00', '', 1, "R");
//$pdf->Cell(70, 6, 'Bill Disc / Offer: ', '1', 1, "L");

$pdf->Cell(0, 6, '', '', 1, "C");
$pdf->Cell(0, 6, '', '', 1, "C");

//$pdf->SetFont('Arial', '', 10);
//$pdf->Cell(0, 6, 'Return Policy*', 'T', 1, "C");
//
//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(0, 5, 'Goods Sold can be exchange within 10 days.', '', 1, "C");
//$pdf->Cell(0, 5, 'Only sealed Original Packing will exchange.', '', 1, "C");
//$pdf->Cell(0, 5, 'Any exchange must be accopanained with original bill.', '', 1, "C");

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, $otherChargesDesc, 'T', 1, "C");
//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(0, 5, 'SHOP ONLINE', '', 1, "C");
//$pdf->Cell(0, 4, 'www.dfdfdf.in', '', 1, "C");

$pdf->Cell(0, 4, '', '', 1, "C");

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "*$*Thank You Visit Again *$*", 'TB', 1, "C");
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(0, 5, 'Write Your Feedback to Us.', '', 1, "C");
//$pdf->Cell(0, 4, 'care@bsrnetworkhelpline.com', '', 1, "C");







$pdf->Output();
?>
