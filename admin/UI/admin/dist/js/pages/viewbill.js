var invoiceData = {};
var invoiceDataToAppend = {};

// variable used to print bill
var invoiceNo = 0;
var customerId = 0;
var sellingId = 0;
var inState = 0;
var outState = 0;
var companyName = '';   //admin company name
var companyState = '';
var companyGSTIN = '';
var companyPan = '';


$(document).ready(function () {
    var invoiceData = '';
    var data = {};
    data.admin_id = aid;
    data.sname = 'InvoiceService';
    data.fname = 'getAllInvoiceDetail';
    data.isweb = '1';
    data.tval = '1';
    makeAJAX('../../api/index.php', data, handleInvoice);
});
function handleInvoice(json) {
    $.each(json, function (i, invoice) {
        if (invoice.customer_name == null || invoice.customer_phone == '') {
            invoice.customer_name = "--";
        }
        if (invoice.customer_phone == null || invoice.customer_phone == '') {
            invoice.customer_phone = "--";
        }
        if (invoice.customer_email == null || invoice.customer_email == '') {
            invoice.customer_email = "--";
        }
//        invoice.invoice_no = ('B000') + invoice.invoice_no;
        invoiceDataToAppend += '<tr id=' + invoice.invoice_no + '>'
                + '<td>' + (i + 1) + '</td>'
                + '<td>' + invoice.customer_name + '</td>'
                + '<td>' + invoice.customer_phone + '</td>'
                + '<td>' + invoice.customer_email + '</td>'
                + '<td>' + invoice.invoice_date + '</td>'
                + '<td>' + ('B000') + invoice.invoice_no + '</td>'
                + '<td>₹ ' + invoice.invoice_total + '</td>'
                + '<td>₹ ' + invoice.paid_amount + '</td>'
                + '<td>₹ ' + invoice.due_amount + '</td>'
                + '<td><i data-toggle="modal" data-target="#printBillModal" onclick="getInvoiceData(' + invoice.invoice_no + ')" value ="' + invoice.invoice_no + '"  id="printBill" class="fa fa-print" style="cursor:pointer;"></i></td>'
                + '</tr>';

    });
    $('#view_bill_tbody').append(invoiceDataToAppend);
    $('#invoice_table').DataTable({
        responsive: true
    });
}


function getInvoiceData(invoice) {
    
    this.invoiceNo = invoice;
    console.log("invoice no " + this.invoiceNo);
    var data = {};
    data.admin_id = aid;
    data.invoice_no = this.invoiceNo;
    data.sname = 'InvoiceService';
    data.fname = 'getParticularInvoiceDetail';
    data.isweb = '1';
    data.tval = '1';
    makeAJAX('../../api/index.php', data, formatInvoiceDate);

}

function formatInvoiceDate(response) {
    console.log('Recieved Invoice Information ' + JSON.stringify(response));
    data = response[0];

    invoiceData.customer_name = data['customer_name'];
    
    console.log('Customer Name ' + invoiceData.customer_name);
    
    invoiceData.customer_address = data['customer_address'];
    invoiceData.customer_email = data['customer_email'];
    invoiceData.invoice_date = data['invoice_date'];
    invoiceData.due_date = data['due_date'];

    invoiceData.items = data['item'];    //array
    var customerCompany = data['c_companyFullDetail'];
    var adminCompanyAndReg = data["admin_companyFullDetail"];

    var adminCompany = adminCompanyAndReg['company_detail'];
    var adminCompanyReg = adminCompanyAndReg["company_registration_detail"];

    companyName = adminCompany['company_name'];
    companyState = adminCompany['company_state'];
    companyGSTIN = adminCompanyReg['gstin'];
    companyPan = adminCompanyReg['pan_no'];

    var customerCompanyAndReg = data["c_companyFullDetail"];
    var customerCompanyReg = customerCompanyAndReg['company_registration_detail'];
    invoiceData.customer_gstin = customerCompanyReg['gstin'];

    invoiceData.total_amount_without_tax = data['total_amount_without_tax'];
    invoiceData.total_tax = data['total_tax'];
    invoiceData.invoice_total = data['invoice_total'];
    invoiceData.paid_amount = data['paid_amount'];
    invoiceData.other_charges = data['other_charges'];
    invoiceData.other_charges_desc = data["other_charges_description"];
    invoiceData.due_amount = data['due_amount'];

    invoiceData.comment = '*$*Thank You Visit Again *$*';
}


$('#view_bill_long_bill_btn').click(function () {
    if (! jQuery.isEmptyObject(invoiceData))
        printBill("A4");
    else
        console.log('Failed to get Billing information');
});
$('#view_bill_short_bill_btn').click(function () {
    if (! jQuery.isEmptyObject(invoiceData) )
        printBill("A2");
    else
        console.log('Failed to get Billing information');
    
});


function printBill(billFormat) {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("hidden", "true");
    if (billFormat === "A4")
        form.setAttribute("action", "../../invoice/long_bill.php");
    else if (billFormat === "A2")
        form.setAttribute("action", "../../invoice/short_bill.php");
    form.setAttribute("target", "view");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "is_gst");
    hiddenField.setAttribute("value", $('#is_gst').prop('checked'));
    form.appendChild(hiddenField);


    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "is_cess");
    hiddenField.setAttribute("value", $('#is_cess').prop('checked'));
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "is_discount");
    hiddenField.setAttribute("value", $('#is_discount').prop('checked'));
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "is_tax_value");
    hiddenField.setAttribute("value", $('#is_tax_value').prop('checked'));
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "is_rate");
    hiddenField.setAttribute("value", $('#is_rate').prop('checked'));
    form.appendChild(hiddenField);


    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "invoice_no");
    hiddenField.setAttribute("value", "B000" + invoiceNo);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "selling_id");
    hiddenField.setAttribute("value", sellingId);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_id");
    hiddenField.setAttribute("value", customerId);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "total_amount_without_tax");
    hiddenField.setAttribute("value", invoiceData.total_amount_without_tax);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "total_tax");
    hiddenField.setAttribute("value", invoiceData.total_tax);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "invoice_total");
    hiddenField.setAttribute("value", invoiceData.invoice_total);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "paid_amount");
    hiddenField.setAttribute("value", invoiceData.paid_amount);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "other_charges");
    hiddenField.setAttribute("value", invoiceData.other_charges);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "other_charges_desc");
    hiddenField.setAttribute("value", invoiceData.other_charges_desc);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "due_amount");
    hiddenField.setAttribute("value", invoiceData.due_amount);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "invoice_date");
    hiddenField.setAttribute("value", invoiceData.invoice_date);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "due_date");
    hiddenField.setAttribute("value", invoiceData.due_date);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_address");
    hiddenField.setAttribute("value", invoiceData.customer_address);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_gstin");
    hiddenField.setAttribute("value", invoiceData.customer_gstin);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_name");
    hiddenField.setAttribute("value", invoiceData.customer_name);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_email");
    hiddenField.setAttribute("value", invoiceData.customer_email);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("textarea");
    hiddenField.setAttribute("name", "comment");
    hiddenField.setAttribute("value", invoiceData.comment);
    form.appendChild(hiddenField);

    var products = [];
    for (var i = 0; i < invoiceData.items.length; i++) {
        var productArr = invoiceData.items[i];
        if (productArr.cgst != 0 || productArr.sgst != 0) {
            inState = '1';
        }
        if (productArr.igst != 0) {
            outState = '1';
        }
        products.push({
            "hsn": productArr.hsn,
            "cess": productArr.cess,
            "cgst": productArr.cgst,
            "igst": productArr.igst,
            "sgst": productArr.sgst,
            "cost_without_tax": productArr.cost_without_tax,
            "discount": productArr.discount,
            "product_id": productArr.product_id,
            "product_name": productArr.product_name,
            "product_quantity": productArr.product_quantity,
            "total_product_amount": productArr.total_product_amount,
            "unit_of_measurement": productArr.unit_of_measurement,
            "unit_rate": productArr.unit_rate
        });
    }
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "products");
    hiddenField.setAttribute("value", JSON.stringify(products));
    form.appendChild(hiddenField);
    document.body.appendChild(form);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "instate");
    hiddenField.setAttribute("value", inState);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "outstate");
    hiddenField.setAttribute("value", outState);
    form.appendChild(hiddenField);


    if (billFormat === "A4")
        window.open('invoice/long_bill.php', 'view');
    else if (billFormat === "A2")
        window.open('invoice/short_bill.php', 'view');

//    form.setAttribute("target", "view");
    form.submit();
//    var win = window.open('invoice/index.php', '_blank');
    window.focus();
}
