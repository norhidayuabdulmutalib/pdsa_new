	function Check(){
		var strNo;
		var intNo=0;
		
		if(document.frm.elements['chbCheck[]'].length > 1){
			for(i=0;i<document.frm.elements['chbCheck[]'].length;i++){
				if(document.frm.elements['chbCheck[]'][i].checked == true){
					intNo = intNo + 1;
				}
			}
			if(document.frm.elements['chbCheck[]'].length == intNo){
				document.frm.chbCheckAll.checked = true;  
			}else{
				document.frm.chbCheckAll.checked = false;
			}
		}else{
			if(document.frm.elements['chbCheck[]'].checked == true){
				document.frm.chbCheckAll.checked = true;  
			}else{
				document.frm.chbCheckAll.checked = false;
			}
		}
	}


	function CheckAll(){
		//If there is no record
		intCount = document.frm.hdnCounter.value - 0;
		if(intCount == 0){
			alert('Tiada rekod untuk dipilih.');
			document.frm.chbCheckAll.checked = false;
			return false;
		}
		//document.frm.chbCheckAll.checked = true;
		if (document.frm.chbCheckAll.checked == true){
		//alert(intCount);
			if(document.frm.elements['chbCheck[]'].length > 1){
				for(i=0;i<document.frm.elements['chbCheck[]'].length;i++){
					document.frm.elements['chbCheck[]'][i].checked = true;
				} 
			}else{
				document.frm.elements['chbCheck[]'].checked = true;
			}
		}else{
			if(document.frm.elements['chbCheck[]'].length > 1){
				for(i=0;i<document.frm.elements['chbCheck[]'].length;i++){
					document.frm.elements['chbCheck[]'][i].checked = false;
				} 
			}else{
				document.frm.elements['chbCheck[]'].checked = false;
			}
		}  
	}

