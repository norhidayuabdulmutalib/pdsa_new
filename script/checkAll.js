	function Check(){
		var strNo;
		var intNo=0;
		
		if(document.ilim.elements['chbCheck[]'].length > 1){
			for(i=0;i<document.ilim.elements['chbCheck[]'].length;i++){
				if(document.ilim.elements['chbCheck[]'][i].checked == true){
					intNo = intNo + 1;
				}
			}
			if(document.ilim.elements['chbCheck[]'].length == intNo){
				document.ilim.chbCheckAll.checked = true;  
			}else{
				document.ilim.chbCheckAll.checked = false;
			}
		}else{
			if(document.ilim.elements['chbCheck[]'].checked == true){
				document.ilim.chbCheckAll.checked = true;  
			}else{
				document.ilim.chbCheckAll.checked = false;
			}
		}
	}


	function CheckAll(){
		//If there is no record
		intCount = document.ilim.hdnCounter.value - 0;
		if(intCount == 0){
			alert('Tiada rekod untuk dipilih.');
			document.ilim.chbCheckAll.checked = false;
			return false;
		}
		//document.ilim.chbCheckAll.checked = true;
		if (document.ilim.chbCheckAll.checked == true){
		//alert(intCount);
			if(document.ilim.elements['chbCheck[]'].length > 1){
				for(i=0;i<document.ilim.elements['chbCheck[]'].length;i++){
					document.ilim.elements['chbCheck[]'][i].checked = true;
				} 
			}else{
				document.ilim.elements['chbCheck[]'].checked = true;
			}
		}else{
			if(document.ilim.elements['chbCheck[]'].length > 1){
				for(i=0;i<document.ilim.elements['chbCheck[]'].length;i++){
					document.ilim.elements['chbCheck[]'][i].checked = false;
				} 
			}else{
				document.ilim.elements['chbCheck[]'].checked = false;
			}
		}  
	}

