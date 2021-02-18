<Script Language="JavaScript">
	function f_page(strFileName){
		var lst = document.frm.pglst.value;
		document.frm.action = strFileName + "&pglst=" + lst;
		document.frm.target = "_self";
		document.frm.submit();
	}
</script>
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="#EBEBEB">
    <tr>
      <td class="TablePageBold" width="50%" align="left"><b><?php echo "JUMLAH REKOD : $RecordCount - Halaman $PageNo daripada $MaxPage";  ?></b></td>

	  <td width="50%" align="right" class="normalTextSmall"><b>paparan 
	      <select name="pglst" class="TableTDText" onChange="f_page('<?php echo $pagepaparan;?>');">
		     <!--<option value="1" <?php if($PageSize == '1') { print 'selected'; } ?>>1</option>-->
			 <option value="10" <?php if($PageSize == '10') { print 'selected'; } ?>>10</option>
			 <option value="20" <?php if($PageSize == '20') { print 'selected'; } ?>>20</option>
			 <option value="50" <?php if($PageSize == '50') { print 'selected'; } ?>>50</option>
			 <option value="100" <?php if($PageSize == '100') { print 'selected'; } ?>>100</option>
			 <option value="500" <?php if($PageSize == '500') { print 'selected'; } ?>>500</option>
		  </select>&nbsp; rekod setiap halaman</b></td>
    </tr>
</table>
