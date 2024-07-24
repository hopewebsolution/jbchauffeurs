function allChecked(frm) {
    for (var i =0; i < frm.elements.length; i++)  {
        if(frm.elements[i].type == "checkbox" && frm.elements[i].name.substr(0,6) == "checks" && frm.elements[i].checked == false)
            return false;
    }
    return true;
}

var all_chk = false;
function checkedAll(frm) {
    all_chk = allChecked(frm);
    if(all_chk == false)
        all_chk = true;
    else
        all_chk = false;
    for (var i =0; i < frm.elements.length; i++) {
        if(frm.elements[i].type == "checkbox" && frm.elements[i].name.substr(0,6) == "checks")
            frm.elements[i].checked = all_chk;
    }
}

function checkChecked(frm) {
    var chk = true;
    for (var i =0; i < frm.elements.length; i++) {
        if(frm.elements[i].type == "checkbox" && frm.elements[i].name.substr(0,6) == "checks" && frm.elements[i].checked == false && frm.elements[i].name != "checkall") {
            chk = false;
            break;
        }
    }	
    frm.checkall.checked = chk;
    all_chk = chk;
}

function checkChecks(frm,msg) {
    var chk = false;
    for (var i =0; i < frm.elements.length; i++) {
        if(frm.elements[i].type == "checkbox" && frm.elements[i].name != "checkall" && frm.elements[i].checked == true) {
            chk = true;
            break;
        }
    }
    if(chk == true) {
        if(confirm('Do you want to perform this action?')) { 
            return true;
        }
        else
            return false;
    }
    else {
        alert(msg);
        return false;
    }	
}