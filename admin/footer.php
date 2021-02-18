<!--- FOOTER --->
<?
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$finish = $time;
$totaltime = ($finish - $start);
?>
    <tr>
        <td background="img/b_left.gif">&nbsp;</td>
        <td>
            <div id="footer">
            <div id="noprint">
            <div class="navibottom">
            <!--<a href="view.php">Contact Us </a> &nbsp;|
            &nbsp; <a href="view.php">FAQ</a> &nbsp;|
            &nbsp; <a href="view.php">Disclaimer</a> &nbsp;-->
            <?php printf ("Halaman ini mengambil masa %f saat untuk dipaparkan.", $totaltime.""); ?>
            </div>
            <div class="copyright" align="right">Copyright 2011 Jabatan Kemajuan Islam Malaysia (JAKIM)</div>
            </div>
            </div>
        </td>
        <td background="img/b_right.gif">&nbsp;</td>
    </tr>

  	<tr>
    	<td width="5" height="5"background="img/b3.gif"></td>
    	<td background="img/b_bottom.gif"></td>
    	<td width="5" height="5"background="img/b4.gif"></td>
  	</tr>
  </tbody>
</table>
<!--<script type="text/javascript">

var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});

</script>//-->
</body>
</html>