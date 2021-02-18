<!--<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>
-->
	<tr> 
	  <td>&nbsp;</td>
	</tr>
	<tr> 
		<td align="left" style="padding-left:5px">Jumlah Rekod : <b><?=$RecordCount;?></b></td>
		<td align="right"><b>Sebanyak 
		<select name="linepage" onChange="do_page('<?=$href_search;?>')">
			<option value="10" <?php if($PageSize==10){ echo 'selected'; }?>>10</option>
			<option value="20" <?php if($PageSize==20){ echo 'selected'; }?>>20</option>
			<option value="50" <?php if($PageSize==50){ echo 'selected'; }?>>50</option>
			<option value="100" <?php if($PageSize==100){ echo 'selected'; }?>>100</option>
		</select> rekod dipaparkan bagi setiap halaman.&nbsp;&nbsp;&nbsp;</b> 
	  </td>
	</tr>
