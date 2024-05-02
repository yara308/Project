/**
 * HELPER FUNCTIONS
 *
 */

//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}

// Return url parameter/query string
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// live datetime
function liveDateTime (id) {
    var date = new Date().toLocaleString(langCode, {
        day : "numeric",
        month : "short",
        year : "numeric",
        hour : "numeric",
        minute : "numeric",
        second : "numeric",
        hour12: true,
        timeZone: timezone
    });
    document.getElementById(id).innerHTML = date;
    setTimeout('liveDateTime("'+id+'");','1000');
    return true;
}

function getNumber(t) {
    return window.accounting.unformat(t);
}

function formatDecimal(t, e) {
    return window.accounting.formatNumber(t, e, "", ".");
}

function is_numeric(t) {
    return ("number" == typeof t || "string" == typeof t && -1 === " \n\r\t\f\v\u2028\u2029　".indexOf(t.slice(-1))) && "" !== t && !isNaN(t);
}

function is_float(t) {
    return !(+t !== t || isFinite(t) && !(t % 1));
}

function formatDate(date) {
  var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];
  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();
  return day + ' ' + monthNames[monthIndex] + ' ' + year;
}

function generateHashCode (str) {
    var hash = 0;
    var char;
    if (str === null) return hash;
    if (str.length == 0) return hash;
    for (i = 0; i < str.length; i++) {
        char = str.charCodeAt(i);
        hash = ((hash<<5)-hash)+char;
        hash = hash & hash;
    }
    return hash;
};

function isHTML(str) {
  var doc = new DOMParser().parseFromString(str, "text/html");
  return Array.from(doc.body.childNodes).some(node => node.nodeType === 1);
}

if (getParameterByName('recache') && getParameterByName('lang')) {
    $.ajax({
        type: 'POST',
        url: window.baseUrl+"/_inc/language.php",
        data: "action_type=RECACHE&lang="+getParameterByName('lang'),
        dataType: "JSON",
        beforeSend: function() {},
        complete: function() {},
        success: function(response) {
            localStorage.setItem("trans",JSON.stringify(response.trans));
        },
        error: function(xhr, ajaxOptions, thrownError) {
            toastr.error(JSON.parse(xhr.responseText).errorMsg, "Error!");
        }
    });
}

function trans(key) {
    var trans = JSON.parse(localStorage.getItem("trans"));
    var value = key;
    $.each(trans, function(index, item) {
        if (item.key == key) {
            if (item.value && item.value != 'null') {
                value = item.value;
            } 
            return true;
        }
    });
    if (value == key) {
        $.ajax({
            type: 'POST',
            url: window.baseUrl+"/_inc/language.php",
            data: "action_type=ADDKEY&key="+key,
            dataType: "JSON",
            beforeSend: function() {},
            complete: function() {},
            success: function(response) {
                //...
            },
            error: function(xhr, ajaxOptions, thrownError) {
                toastr.error(JSON.parse(xhr.responseText).errorMsg, "Error!");
            }
        });
    }
    return value;
}

function curConvert(code, conVal, val)
{
    var conVal = parseFloat(conVal);
    var val = parseFloat(val);
    if (conVal == 0 || val == 0 || code == 'USD') {
        return val;
    }
    return (conVal / 1) * val;
}