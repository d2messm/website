/* global instate, outstate */

var itemoption = "";
var items = {};
var productsData = [];
var invoiceData = {};
var currenltyAddedProducts = 0;
var totalRemovedRows = [];
var stockAvailable = [];


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
    var data = {};
    data.isweb = 1;
    data.tval = 1;
    data.admin_id = aid;
    data.sname = 'ProductService';
    data.fname = 'getAllProduct';
    makeAJAX('../../api/index.php', data, manageItemsDetail);
    data.sname = 'CompanyService';
    data.fname = 'getCompanyBasicDetail';
    makeAJAX('../../api/index.php', data, manageCompanyDetails);
    data.sname = 'ProfileService';
    data.fname = 'getAllCustomerDetail';
    makeAJAX('../../api/index.php', data, manageCustomerDetail);
});
$("#add_product_btn_modal").click(function () {
    event.preventDefault();
    if ($('#product_name').val().trim().length < 2) {
        showModelNotification('Product Name required');
        $('#product_name').focus();
        return false;
    }

    if ($('#product_make').val().trim().length < 2) {
        showModelNotification('Product Make is required');
        $('#product_make').focus();
        return false;
    }
    if ($('#category_id').val().trim().length == 0) {
        showModelNotification('Category Name is required');
        $('#category_id').focus();
        return false;
    }
    if ($('#unit_of_measurement').val().trim().length < 1) {
        showModelNotification('Unit of measurement is required');
        $('#unit_of_measurement').focus();
        return false;
    }
    if ($('#add_product_btn').hasClass('disabled')) {
        return false;
    }
    $('#add_product_btn').addClass('disabled');

    var data = {};
    data.admin_id = aid;
    /*PRODUCT DETAIL*/
    data.product = {}
    data.product.product_name = $('#product_name').val().trim();
    data.product.product_make = $('#product_make').val().trim();
    data.product.category_id = $('#category_id').val().trim();
    data.product.unit_of_measurement = $('#unit_of_measurement').val().trim();
    data.product.barcode = $('#barcode').val().trim();
    data.product.cess = $('#cess').val().trim();
    data.product.inclusive_tax = $('#inclusive_tax').val().trim();
    data.product.purchase_price = $('#purchase_price').val().trim();
    data.product.product_image_url = null;
    data.product.selling_price = $('#selling_price').val().trim();
    data.product.discount = $('#discount').val().trim();
    data.product.product_description = $('#product_description').val().trim();
    /*STOCk DETAIL*/
    data.stock = {}
    data.stock.quantity = $('#product_stock').val();

    data.stock.unit_of_measurement = $('#unit_of_measurement').val().trim();

    data.stock.min_quantity = 1;
    data.stock.max_quantity = 100;
    data.stock.notify = 0;
    data.stock.addedby = aid;
    /*STOCK DETAILS END*/
    data.sname = 'StockService';
    data.fname = 'addProductAndStock';
    data.isweb = '1';
    data.tval = '1';
    data.remark = null;
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (dataReceived) {
           // console.log('addProductAndStock Resonse ' + dataReceived);
            $('#add_product_btn').removeClass('disabled');
            var decrypt = atob(dataReceived);
           // console.log(decrypt);
            var response = JSON.parse(decrypt);
            //alert('Akssh');
            if (response.status == 0) {
                handleErrorData(response);
            } else {
                swal('Done', 'New Product Added', 'success');
                var newProdId = response.data.product_id;
                var newOption = '<option value="' + newProdId + '">' + response.data.product_name + '</option>';
                itemoption += newOption;
                items.push(response.data);
                stockAvailable.push(data.stock.quantity);

                reloadProduct('items', newOption);
                $('#product_name').val('');
                $('#product_make').val('');
                $('#category_id').val('');
                $('#product_stock').val('');
                $('#unit_of_measurement').val('');
            }
        }, error: function (err) {
            //alert('erroe');
           // console.log('error function', +err);
            $('#add_product_btn').removeClass('disabled');
        }
    }).done(function () {
        //alert('done');
    }).fail(function () {
        swal('Done', 'OOPs! Failed to add Product', 'success');
        $('#add_product_btn').removeClass('disabled');

    });

});
function manageItemsDetail(data) {
    items = data;
    var itemRowtobeappended = '';
    itemRowtobeappended += '<tr id="tr_' + (currenltyAddedProducts) + '"><td id="sno_' + (currenltyAddedProducts) + '">' + (currenltyAddedProducts + 1) + '</td><td id="hsn_' + (currenltyAddedProducts) + '"><input type="text" id="hsn_txt_' + (currenltyAddedProducts) + '"></input></td><td><select onchange="getItemDetail(this,' + (currenltyAddedProducts) + ')" id="select_' + (currenltyAddedProducts) + '"><option value=0 readonly selected>Select an item</option>';
    for (var i = 0; i < data.length; i++) {
        var prod = {};
        prod.label = data[i].hsn;
        prod.index = i;
        prod.prodvalue = data[i].product_id;
        productsData.push(prod);
        stockAvailable[i] = data[i].available_stock;

        itemoption += '<option value="' + data[i].product_id + '">' + data[i].product_name + '</option>';
    }
    itemRowtobeappended += (itemoption + '</seclect></td>');
    var itemRowtobeappendedextra = '';
    itemRowtobeappendedextra += addDyanmicFields(itemRowtobeappended, currenltyAddedProducts);
    $('#items').append(itemRowtobeappendedextra);
    autocomplete(0);
}
function manageCompanyDetails(data) {
    data = data.company_detail;
    var companyDesc = data.company_name + "\n" + data.company_address + "\n" + data.company_state + "\n" + data.company_country;
    $('#companyDetails').val(companyDesc);
}

var selectedCustomerId = '';
function manageCustomerDetail(data) {
    var customerName = [];
    for (var i = 0; i < data.length; i++) {
        var customer = {};
        if (data[i].customer_phone !== '')
            var custPhone = data[i].customer_phone;
        else
            var custPhone = '';
        if (data[i].customer_address !== null && data[i].customer_address !== '')
            var custAddress = data[i].customer_address;
        if (custAddress.length > 10) {
            custAddress = custAddress.substr(0, 10);
        } else
            var custAddress = '';
        customer.label = data[i].customer_name + " (" + custPhone + ")" + " (" + custAddress + "...)";
        customer.index = i;
        customerName.push(customer);
    }
    $("#customer_name").autocomplete({
        source: customerName,
        select: function (event, ui) {
            event.preventDefault();
            selectedCustomerId = data[ui.item.index].customer_id;
            $('#customer_name').val(data[ui.item.index].customer_name);
            $('#customer_phone').val(data[ui.item.index].customer_phone);
            $('#customer_gstin').val(data[ui.item.index].customer_gstin);
            $('#customer_Add').val(data[ui.item.index].customer_address);
            $('#customer_email').val(data[ui.item.index].customer_email);
        }
    });
}
function getItemDetail(eventtarget, rowID) {
    for (var i = 0; i < items.length; i++) {
        if (items[i].product_id == $(eventtarget).val()) {
            filldefaultValues(items[i], rowID);
            break;
        }
    }
    setGrandTotal();
}
function addDyanmicFields(itemRowtobeappended, currenltyAddedProducts) {
//    itemRowtobeappended += '<td><input type="number" min="0" id="qty_' + currenltyAddedProducts + '" oninput="this.value=this.value.replace(/[^0-9]/g)" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"/></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="rate_' + currenltyAddedProducts + '" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="text" id="unit_' + currenltyAddedProducts + '" readonly/></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="discount_' + currenltyAddedProducts + '" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="checkbox" onchange="resetPricesRow(' + currenltyAddedProducts + ')" id="is_percent_dis_' + currenltyAddedProducts + '"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="cost_ex_tax_' + currenltyAddedProducts + '" readonly></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="cgst_' + currenltyAddedProducts + '" onkeyup="resetIGST(' + currenltyAddedProducts + ');resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="sgst_' + currenltyAddedProducts + '" onkeyup="resetIGST(' + currenltyAddedProducts + ');resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="igst_' + currenltyAddedProducts + '" onkeyup="resetSCGSTandCGST(' + currenltyAddedProducts + ');resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="cess_' + currenltyAddedProducts + '" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="total_' + currenltyAddedProducts + '"readonly></td><td onclick="removeCurrentRow(' + currenltyAddedProducts + ')"><i class="fa fa-remove"></i></td></tr>';
    //quantity can be in float
    itemRowtobeappended += '<td><input type="number" min="0" id="qty_' + currenltyAddedProducts + '" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"/></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="rate_' + currenltyAddedProducts + '" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="text" id="unit_' + currenltyAddedProducts + '" readonly/></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="discount_' + currenltyAddedProducts + '" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="checkbox" onchange="resetPricesRow(' + currenltyAddedProducts + ')" id="is_percent_dis_' + currenltyAddedProducts + '"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="cost_ex_tax_' + currenltyAddedProducts + '" readonly></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="cgst_' + currenltyAddedProducts + '" onkeyup="resetIGST(' + currenltyAddedProducts + ');resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="sgst_' + currenltyAddedProducts + '" onkeyup="resetIGST(' + currenltyAddedProducts + ');resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="igst_' + currenltyAddedProducts + '" onkeyup="resetSCGSTandCGST(' + currenltyAddedProducts + ');resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="cess_' + currenltyAddedProducts + '" onkeyup="resetPricesRow(' + currenltyAddedProducts + ')"></td><td><input type="number" min="0" oninput="this.value=this.value.replace(/[^0-9.]/g)" id="total_' + currenltyAddedProducts + '"readonly></td><td onclick="removeCurrentRow(' + currenltyAddedProducts + ')"><i class="fa fa-remove"></i></td></tr>';
    return itemRowtobeappended;
}
function insertNewItemRow() {
    currenltyAddedProducts++;
    var itemRowtobeappended = '';
    itemRowtobeappended += '<tr id="tr_' + (currenltyAddedProducts) + '"><td id="sno_' + (currenltyAddedProducts) + '">' + (currenltyAddedProducts + 1) + '</td><td id="hsn_' + (currenltyAddedProducts) + '"><input type="text" id="hsn_txt_' + (currenltyAddedProducts) + '"></input></td><td><select onchange="getItemDetail(this,' + (currenltyAddedProducts) + ')" id="select_' + (currenltyAddedProducts) + '"><option val=0 readonly selected>Select an item</option>';
    itemRowtobeappended += (itemoption + '</seclect></td>');
    var itemRowtobeappendedextra = addDyanmicFields(itemRowtobeappended, currenltyAddedProducts);
    $('#items').append(itemRowtobeappendedextra);
    autocomplete(currenltyAddedProducts);
}
function filldefaultValues(items, rowID) {
    $('#qty_' + rowID).val(1);
    $('#unit_' + rowID).val(items.unit_of_measurement);
    $('#rate_' + rowID).val(items.selling_price);
    $('#discount_' + rowID).val(items.discount);
    $('#total_' + rowID).val(Number(items.selling_price) - Number(items.discount));
    $('#cost_ex_tax_' + rowID).val((Number(items.selling_price) * 1) - Number(items.discount));
    $('#igst_' + rowID).val(items.igst);
    $('#cgst_' + rowID).val(items.cgst);
    $('#sgst_' + rowID).val(items.sgst);
    $('#cess_' + rowID).val(items.cess);
    $('#hsn_txt_' + rowID).val(items.hsn);
    setGrandTotal();
}

function resetIGST(rowID) {
    if ($('#cgst_' + rowID).val() > 0 || $('#sgst_' + rowID).val() > 0)
        $('#igst_' + rowID).val(0);
}
function resetSCGSTandCGST(rowID) {
    if ($('#igst_' + rowID).val() > 0)
    {
        $('#cgst_' + rowID).val(0);
        $('#sgst_' + rowID).val(0);
    }
}
function resetCESS(rowID) {
    $('#cess_' + rowID).val(0);
}

function resetPricesRow(row_id) {
    if ($('#select_' + row_id).val() == 0) {
        $('#qty_' + row_id).val(0);
        $('#rate_' + row_id).val(0);
        $('#discount_' + row_id).val(0);
        $('#cost_ex_tax_' + row_id).val(0);
        $('#cgst_' + row_id).val(0);
        $('#sgst_' + row_id).val(0);
        $('#igst_' + row_id).val(0);
        $('#total_' + row_id).val(0);
        return false;
    }

    setValidValue('#cgst_' + row_id);
    setValidValue('#sgst_' + row_id);
    setValidValue('#igst_' + row_id);
    setValidValue('#cess_' + row_id);

    if ($("#qty_" + row_id).val() == '') {
    } else if ($("#qty_" + row_id).val() < 0) {
        $("#qty_" + row_id).val(1);
    }

    var index = $('#select_' + row_id + ' option:selected').index();
    if (Number($("#qty_" + row_id).val()) > stockAvailable[index - 1])
    {
        swal('Stock of ' + $('#select_' + row_id + ' option:selected').text() + ' is ' + stockAvailable[index - 1] + ' only', 'Quantity cannot be more than available stock', 'error');
        $("#qty_" + row_id).val(stockAvailable[index - 1]);
        var quantity = stockAvailable[index - 1];
    } else
        var quantity = $("#qty_" + row_id).val();

    var rate = $("#rate_" + row_id).val();
    if ($('#is_percent_dis_' + row_id).is(':checked'))
        var dis = ($('#qty_' + row_id).val() * $('#rate_' + row_id).val()) * ($("#discount_" + row_id).val() / 100);
    else
        var dis = ($("#discount_" + row_id).val());


    if (dis > (rate * quantity)) {
        var dis = 0;
        $("#discount_" + row_id).val(0);
    }
    if ($('#cgst_' + row_id).val() > 0 || $('#sgst_' + row_id).val() > 0) {
        $('#igst_' + row_id).val(0);
    } else if ($('#igst_' + row_id).val() > 0) {
        $('#cgst_' + row_id).val(0);
        $('#sgst_' + row_id).val(0);
    }
    var cost_ex_tax_ = (Number(rate) * Number(quantity)) - Number(dis);
    $('#cost_ex_tax_' + row_id).val(cost_ex_tax_);
    var cgst = ($('#cgst_' + row_id).val() / 100) * cost_ex_tax_;
    var sgst = ($('#sgst_' + row_id).val() / 100) * cost_ex_tax_;
    var igst = ($('#igst_' + row_id).val() / 100) * cost_ex_tax_;
    var cess = ($('#cess_' + row_id).val() / 100) * cost_ex_tax_;
    var costTotal = cgst + cess + igst + sgst + cost_ex_tax_;
    var total = ($('#total_' + row_id).val(costTotal.toFixed(2)));
    setGrandTotal();
}

function setGrandTotal() {
    var gtotal = 0;
    for (var i = 0; i <= currenltyAddedProducts; i++) {
        if (totalRemovedRows.indexOf(i) == -1) {
            gtotal += Number($('#total_' + i).val());
        }
    }
    gtotal = gtotal - (($('#totaldiscount').val() / 100) * gtotal);
    gtotal += Number($('#other_charges').val());
    if ($('#roundoff').is(':checked')) {
        gtotal = Math.ceil(gtotal);
    }
    $('#paid_amount').val(gtotal);
    $('#refund_amount').val(0);
    $('#grandTotal').val(gtotal.toFixed(2));
}


function setValidValue(id) {
    if ($(id).val() === '') {

    } else if (Number($(id).val()) < 0) {
        $(id).val(0);
    } else if (Number($(id).val()) > 100) {
        $(id).val(100);
    }
}

$('#genrateInvoice').click(function () {
    if ($('#customer_name').val().trim() < 2)
    {
        $('#customer_name').focus();
        showNotification("Kindly enter Cutomer Name");
        return false;
    }
    if ($('#customer_gstin').val() != '') {
        //validate GSTIN
    }
    if ($('#customer_Add').val() != '') {
        //validate cutomer details
    }
    if ($('#customer_email').val().trim() != '') {
        if (!emailreg.test($('#customer_email').val().trim())) {
            showNotification('Customer email is not valid');
            $('#customer_email').focus();
            return false;
        }
    }
    if (!$('#checkbox').is(':checked')) {//mode of payment is cash
        var payment_method = 'CASH';
        if (Number($('#paid_amount').val()) < Number($('#grandTotal').val())) {
            $('#refund_amount').val(0);
        }
        var tranNoOrCashPayed = $('#paid_amount').val().trim();
    } else {
        var payment_method = 'CHEQUE/CARD/ONLINE';
        if ($('#transaction_no').val().trim().length < 3) {
            showNotification('Transaction number cannot be less than 3 digits');
            $('#transaction_no').focus();
            return false;
        }
        var tranNoOrCashPayed = $('#transaction_no').val().trim();
    }
    var data = {};
    data.payment_method = payment_method;
    data.tranNoOrCashPayed = tranNoOrCashPayed;
    data.admin_id = aid;
    data.isweb = 1;
    data.tval = 1;
    data.sname = 'InvoiceService';
    data.fname = 'generateInvoice';
    data.total_amount_without_tax = 0;
    data.total_tax = 0;
    data.customer_id = selectedCustomerId;
    data.customer_name = $('#customer_name').val().trim();
    data.customer_phone = $('#customer_phone').val().trim();
    data.customer_gstin = $('#customer_gstin').val().trim();
    data.customer_address = $('#customer_Add').val().trim();
    data.customer_email = $('#customer_email').val().trim();
    if (data.customer_phone != '') {
        if (!phnreg.test(data.customer_phone) || Number(data.customer_phone) == 0)
        {
            showNotification('Kindly Enter Phone number');
            $('#customer_phone').focus();
            return false;
        }
    }
    if (data.customer_gstin != '') {
        if (!gstinreg.test(data.customer_gstin))
        {
            showNotification('Kindly Enter Valid GSTIN');
            $('#customer_gstin').focus();
            return false;
        }
    }

    if (Number(currenltyAddedProducts) === 0 && $('#select_0 option:selected').val() == 0) {
        showNotification("Please Select some Products");
        return false;
    }

    data.invoice_date = new Date().toISOString().slice(0, 19).replace('T', ' ');//today date, must be change
    data.due_date = new Date().toISOString().slice(0, 19).replace('T', ' ');//today date, must be change

    data.items = [];
    for (var i = 0; i <= currenltyAddedProducts; i++) {
        if (totalRemovedRows.indexOf(i) !== 0) {
            var dataitem = {};
            dataitem.product_id = $('#select_' + i).val();
            dataitem.product_name = $('#select_' + i + ' option:selected').text();
            dataitem.product_quantity = $('#qty_' + i).val();
            dataitem.unit_rate = $('#rate_' + i).val();
            dataitem.unit_of_measurement = $('#unit_' + i).val();

            if ($('#is_percent_dis_' + i).is(':checked'))
                dataitem.discount = ($('#qty_' + i).val() * $('#rate_' + i).val()) / ($("#discount_" + i).val());
            else
                dataitem.discount = ($("#discount_" + i).val());

            dataitem.cost_without_tax = $('#cost_ex_tax_' + i).val();
            data.total_amount_without_tax = parseInt(data.total_amount_without_tax) + parseInt(dataitem.cost_without_tax);
            dataitem.cgst = $('#cgst_' + i).val();
            dataitem.sgst = $('#sgst_' + i).val();
            dataitem.igst = $('#igst_' + i).val();
            dataitem.cess = $('#cess_' + i).val();
            dataitem.total_product_amount = $('#total_' + i).val();
           // console.log(dataitem)
            data.total_tax = parseInt(data.total_tax) + parseInt(dataitem.total_product_amount) - parseInt(dataitem.cost_without_tax);
            data.items.push(dataitem);
        }
    }
    data.other_charges = $('#other_charges').val();
    data.other_charges_desc = $('#other_charges_desc').val().trim();
    data.granddiscount = $('#totaldiscount').val();
    data.invoice_total = $('#grandTotal').val();
    //THIS IS FOR THE PROVISION OF INSTALLMENT PAYMENT
    if (payment_method == 'CASH')
        data.paid_amount = tranNoOrCashPayed;
    else
        data.paid_amount = data.invoice_total;
    data.due_amount = Number(data.invoice_total) - Number(data.paid_amount);     // dummy data

   // console.log("Data to be send yeha pe hu " + JSON.stringify(data));

    invoiceData = data;
    makeAJAX("../../api/index.php", data, onSuccess);
});
function onSuccess(data) {
    //console.log('Received Invoice Data ' + JSON.stringify(data));
    invoiceNo = data.invoice_no;
    customerId = data.customer_id;
    sellingId = data.selling_id;
    //console.log("Before Company Name " + companyName);
    companyName = data.company_name;
    //console.log("After Company Name " + companyName);
    companyState = data.company_state;
    companyGSTIN = data.company_gstin;
    companyPan = data.company_pan;

    $('#invoice_modal').modal();
}

$('#long_bill_btn').click(function () {
    openBill("A4");
});
$('#short_bill_btn').click(function () {
    openBill("A2");
});



function openBill(billFormat) {
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
    hiddenField.setAttribute("value", $('#customer_Add').val().trim());
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_gstin");
    hiddenField.setAttribute("value", $('#customer_gstin').val().trim());
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_name");
    hiddenField.setAttribute("value", $('#customer_name').val().trim());
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_address");
    hiddenField.setAttribute("value", $('#customer_Add').val().trim());
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_gstin");
    hiddenField.setAttribute("value", $('#customer_gstin').val().trim());
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "customer_email");
    hiddenField.setAttribute("value", $('#customer_email').val().trim());
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("textarea");
    hiddenField.setAttribute("name", "comment");
    hiddenField.setAttribute("value", $('#comment').val().trim());
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "company_name");
    hiddenField.setAttribute("value", companyName);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "company_state");
    hiddenField.setAttribute("value", companyState);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "company_gstin");
    hiddenField.setAttribute("value", companyGSTIN);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "company_pan");
    hiddenField.setAttribute("value", companyPan);
    form.appendChild(hiddenField);

    var products = [];
    inState = 0;
    outState = 0;
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

function reloadProduct(id, optionrow) {
    $('#' + id + ' select').append(optionrow);
}
function removeCurrentRow(rowid) {
    if (currenltyAddedProducts - totalRemovedRows.length == 0) {
        swal('Done', 'Cannot Remove Row', 'success');
        return false;
    }
    $('#tr_' + rowid).remove();
    totalRemovedRows.push(rowid);
    setGrandTotal();
}
function autocomplete(listnum) {
    $("#hsn_txt_" + listnum).autocomplete({
        source: productsData,
        select: function (event, ui) {
            changeSelectDropdown(ui,listnum);
        }
    });
}

function changeSelectDropdown(uilist,listnum) {
    $('#select_' + listnum).val(uilist.item.prodvalue);
    $('#select_' + listnum).change();
}
function toggleModeOfPayment() {
    if ($('#mode_of_payment').is(':checked')) {
        $("#overlaycash").css("visibility", "visible");
        $("#overlaycard").css("visibility", "hidden");
//        $("#overlaycash").show();
//        $("#overlaycard").hide();
    } else {
        $("#overlaycard").css("visibility", "visible");
        $("#overlaycash").css("visibility", "hidden");
//        $("#overlaycard").show();
//        $("#overlaycash").hide();
    }
}
$(document).ready(function () {
    $('#pay_cash').hide();

});
$("#paid_amount").keypress(function () {

    $("#grandTotal").val();
    $("#refunt_amount")
});

function setRefundAmount(eventtarget) {
    if (Number($(eventtarget).val()) < 0) {
        $(eventtarget).val(Number($('#grandTotal').val()));
        return false;
    }
    if (Number($(eventtarget).val()) < Number($('#grandTotal').val())) {
        $('#refund_amount').val(0);
        return false;
    }
    $('#refund_amount').val( (Number($(eventtarget).val()) - Number($('#grandTotal').val()) ).toFixed(2) );
}