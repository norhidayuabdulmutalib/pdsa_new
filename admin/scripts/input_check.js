// JavaScript Document
function chkNumbers(nums){
	var numbers = /^[0-9]+$/;  
	if(nums.value==''){
		return true;
	} else {
		if(nums.value.match(numbers)){  
			return true;  
		} else {  
			alert("Sila masukkan hanya nombor sahaja.");  
			nums.focus();
			var str = nums.value;
			var newStr = str.substring(0, str.length-1);
			nums.value=newStr;
			return false;  
		}
	}
} 
function chkDecimal(nums){
	var numbers = /(^\d+$)|(^\d+\.\d+$)/; 
	if(nums.value==''){
		return true;
	} else {
		if(nums.value.match(numbers)){  
			return true;  
		} else {  
			alert("Sila masukkan hanya decimal sahaja.");  
			nums.focus();
			nums.value='0.00';
			return false;  
		}
	}
} 

function chkPhone(nums){
	//var numbers = /^[0-9]+$/;  
	var numbers = /^\d+(-\d+)?$/
	if(nums.value==''){
		return true;
	} else {
		if(nums.value.match(numbers)){  
			return true;  
		} else {  
			alert("Sila masukkan nombor sahaja.");  
			nums.focus();
			var str = nums.value;
			var newStr = str.substring(0, str.length-1);
			nums.value=newStr;
			return false;  
		}
	}
} 

function chkIC(nums){
	//var numbers = /^[0-9]+$/;  
	var numbers = "0123456789-"
	if(nums.value==''){
		return true;
	} else {
		if(nums.value.match(numbers)){  
			return true;  
		} else {  
			alert("Sila masukkan No. Kad Pengenalan dengan betul.");  
			var str = nums.value;
			nums.focus();
			var newStr = str.substring(0, str.length-1);
			nums.value=newStr;
			return false;  
		}
	}
} 

function validateEmail(input){
	var atpos=input.value.indexOf("@");
	var dotpos=input.value.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=input.value.length){
		alert("Sila masukkan hanya alamat emel anda yang sah sahaja.");
		input.focus();
		input.value='';
		return false;
	}
}
function chkRegister(vals){
	var numbers = /^[-A-Z0-9]+$/; ///^([-a-z0-9_ ])+$/i  
	var values = vals.value;

	values = values.replace(/\s/g, "");
	values = values.toUpperCase();
  	
	if(values.match(numbers)){
		vals.value = values;
      	return true;  
    } else {  
        alert("Sila masukkan format pendaftaran syarikat yang betul.");  
		vals.value='';
        return false;  
    }
} 

function hideshow(which){
if (!document.getElementById)
return
if (which.style.visibility=="visible")
which.style.display="hidden"
else
which.style.display="visible"
}