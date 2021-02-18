<!--
############## MyNews Templates ###############
###############################################

In both template blocks, TEASER & STORY, below
you can use following replacement tags inside:

{title}           title of the news item
{time}            date you set for this news item
{edit}            edit link if you're in admin mode
{delete}          delete link if you're in admin mode
{teaser}          preview/teaser text of this news
{urltofullstory}  url to the whole story of this news
{story}           fullstory text of this news
{urltoallnews}    url back to all news

###############################################
###############################################
-->



<!--TEASER-->
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="smtxt" style="margin-bottom:10px;">
	<tr bgcolor="#eeeeee">
		<td align="left" style="border-bottom:1px dotted #bbbbbb;"><strong>{title} [{time}]</strong></td>
	   <td align="right" style="border-bottom:1px dotted #bbbbbb;">{edit} {delete} </td>
	</tr>
	<tr>
		<td colspan="2" align="left">{teaser} <? if("{urltofullstory}" != "") {?><a href="file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burltofullstory%7D">read more</a><? }?></td>
	</tr>
</table>
<!--TEASER-->





<!--STORY-->
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="smtxt" style="margin-bottom:10px;">
	<tr bgcolor="#eeeeee">
		<td align="left" style="border-bottom:1px dotted #bbbbbb;"><strong>{title} [{time}]</strong></td>
	   <td align="right" style="border-bottom:1px dotted #bbbbbb;">{edit} {delete} </td>
	</tr>
	<tr>
		<td colspan="2" align="left">{story}</td>
	</tr>
	<tr>
		<td colspan="2" align="right" style="padding-top:5px;"><a href="file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burltoallnews%7D">back to all news</a></td>
	</tr>	
</table>
<!--STORY-->
