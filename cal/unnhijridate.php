<?php
/*
Plugin Name: Usayd's Hijri Date
Plugin URI: http://www.usayd.com/pluginshacks/hijri-date/
Description: Adds the Hijri Date to your posts and an admin panel for configuration.
Version: 1.87
Author: Usayd Younis
Author URI: http://www.usayd.com
*/
/* 
Please refer to the readme.txt for installation instructions. The hirji calculations have external permissions. Stable version from 0.15. 0.6+ comes with admin panel.
*/
/*  Copyright 2005  Usayd Younis  (email : plugins@usayd.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
function show_hijridate($hijri_time_format = false, $Gregorian_time_format = false, $seperator = false) {
echo unn_hijridate($hijri_time_format, $Gregorian_time_format, $seperator);
}
function unn_hijridate($hijri_time_format = false, $Gregorian_time_format = false, $seperator = false) {
$current_settings = get_option('unn_hijridate_options');
if ($hijri_time_format === false) $hijri_time_format = $current_settings['hijri_time_format'];
if ($Gregorian_time_format === false) $Gregorian_time_format = $current_settings['Gregorian_time_format'];
if ($seperator === false) $seperator = $current_settings['seperator'];
	if ($current_settings['hijriandGregorian'] == 0){
		$timestamp = strtotime(get_post_time('Y-m-d H:i:s', true));
	
		$thisYear = strftime("%Y", $timestamp);
		$thisMonth = strftime("%m", $timestamp);
		if ($thisMonth < 10)
			$thisMonth = substr($thisMonth, 1, 1);
		$thisDay = trim(strftime("%e", $timestamp));
	
		$greg_part = strftime($Gregorian_time_format, $timestamp);

		$hijri_date = jd2hijri(greg2jd($thisDay, $thisMonth, $thisYear));
		$hijri_part = sprintf($hijri_time_format, $hijri_date[0],
		hijrimonth2name($hijri_date[1]), $hijri_date[2]);

		return $current_settings['start']. $greg_part .$seperator. $hijri_part .$current_settings['end'];

	} else if ($current_settings['hijriandGregorian'] == 1) {

		//hijri_date
		$timestamp = strtotime(get_post_time('Y-m-d H:i:s', true));
	
		$thisYear = strftime("%Y", $timestamp);
		$thisMonth = strftime("%m", $timestamp);
		if ($thisMonth < 10)
			$thisMonth = substr($thisMonth, 1, 1);
		$thisDay = trim(strftime("%e", $timestamp));

		$hijri_date = jd2hijri(greg2jd($thisDay, $thisMonth, $thisYear));
		$hijri_part = sprintf("$hijri_time_format", $hijri_date[0],
		hijrimonth2name($hijri_date[1]), $hijri_date[2]);

		return $current_settings['start']. $hijri_part .$current_settings['end'];

	} else if ($current_settings['hijriandGregorian'] == 2) {

		// Gregorian_date() {
		$timestamp = strtotime(get_post_time('Y-m-d H:i:s', true));
	
		$thisYear = strftime("%Y", $timestamp);
		$thisMonth = strftime("%m", $timestamp);
		if ($thisMonth < 10)
			$thisMonth = substr($thisMonth, 1, 1);
		$thisDay = trim(strftime("%e", $timestamp));

		$greg_part = strftime($Gregorian_time_format, $timestamp);

		$hijri_date = jd2hijri(greg2jd($thisDay, $thisMonth, $thisYear));
		$hijri_part = sprintf($hijri_time_format, $hijri_date[0],
		hijrimonth2name($hijri_date[1]), $hijri_date[2]);

		return $current_settings['start']. $greg_part .$current_settings['end'];
	}

}

function greg2jd($d, $m, $y) {
	$jd = (1461 * ($y + 4800 + ($m - 14) / 12)) / 4 +
	(367 * ($m - 2 - 12 * (($m - 14) / 12))) / 12 -
	(3 * (($y + 4900 + ($m - 14) / 12) / 100 )) / 4 +
	$d - 32075;

	return $jd;
}

function jd2hijri($jd) {
	$jd = $jd - 1948440 + 10632;
	$n = (int) (($jd - 1) / 10631);
	$jd = $jd - 10631 * $n + 354;
	$j = ((int) ((10985 - $jd) / 5316)) *
	((int) (50 * $jd / 17719)) +
	((int) ($jd / 5670)) *
	((int) (43 * $jd / 15238));
	$jd = $jd - ((int) ((30 - $j) / 15)) *
	((int) ((17719 * $j) / 50)) -
	((int) ($j / 16)) *
	((int) ((15238 * $j) / 43)) + 29;
	$m = (int) (24 * $jd / 709);
	$d = $jd - (int) (709 * $m / 24);
	$y = 30 * $n + $j - 30;

	return array($d, $m, $y);
}

function hijrimonth2name($m) {
	switch($m) {
		case 1:
			return 'Muharram';
		case 2:
			return 'Safar';
		case 3:
			return 'Rabbi al-Awwal';
		case 4:
			return 'Rabbi al-Thanni';
		case 5:
			return 'Jumada al-Ula';
		case 6:
			return 'Jumada al-Thanni';
		case 7:
			return 'Rajab';
		case 8:
			return 'Shaban';
		case 9:
			return 'Ramadhan';
		case 10:
			return 'Shawwal';
		case 11:
			return 'Dhul-Qadah';
		case 12:
			return 'Dhul-Hijjah';
	}
}


function bstOffset($currDate) {
	$thisYear = (date("Y"));
	$marStartDate = ($thisYear."-03-25");
	$octStartDate = ($thisYear."-10-25");
	$marEndDate = ($thisYear."-03-31");
	$octEndDate = ($thisYear."-10-31");


	while ($marStartDate <= $marEndDate) {
		$day = date("l", strtotime($marStartDate));
		if ($day == "Sunday")
			$bstStartDate = $marStartDate;
		$marStartDate++;
	}


	$bstStartDate = (date("U", strtotime($bstStartDate))+(60*60));


	while ($octStartDate <= $octEndDate) {
		$day = date("l", strtotime($octStartDate));
		if ($day == "Sunday")
			$bstEndDate = $octStartDate;
		$octStartDate++;
	}

	$bstEndDate = (date("U", strtotime($bstEndDate))+(60*60));

        if ($currDate < bstEndDate && $currDate > $bstStartDate)
		return 1;
	else
		return 0;
}
// begin options page (borrowed from footnotes plugin)
//function unn_hijridate_options_page() { 
	//$current_settings = get_option('unn_hijridate_options');
	if ($_POST['action']){?>
		<div class="updated"><p><strong>Options saved.</strong></p></div>
 	<?php } ?>
    <div class="wrap" id="hijridate-options">
		<h2>Hijri Date Options</h2>
		<p>There are a few options you can set for displaying your date using the <a href="http://www.usayd.com/pluginshacks/hijri-date/">Hijri Date plugin</a>.</p>
		<p>You can use any HTML entity for the options. The time format is using <a href="http://de3.php.net/manual/en/function.strftime.php">strftime</a>.</p>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<fieldset>
				<legend>Options:</legend>
				<input type="hidden" name="action" value="save_options" />
				<table width="100%" cellspacing="2" cellpadding="5" class="editform">
				<tr>
					<th scope="row"><?php //_e('Show:') ?></th> 
					<td>
						<label for="hijriandGregorian0"><input name="hijriandGregorian" id="hijriandGregorian0" type="radio" value="0" <?php if ($current_settings['hijriandGregorian'] == 0) echo 'checked="checked"'; ?> /> <?php //_e('Hijri and Gregorian') ?></label><br />
						<label for="hijriandGregorian1"><input name="hijriandGregorian" id="hijriandGregorian1" type="radio" value="1" <?php if ($current_settings['hijriandGregorian'] == 1) echo 'checked="checked"'; ?> /> <?php //_e('Only Hijri') ?></label><br />
						<label for="hijriandGregorian2"><input name="hijriandGregorian" id="hijriandGregorian2" type="radio" value="2" <?php if ($current_settings['hijriandGregorian'] == 2) echo 'checked="checked"'; ?> /> <?php //_e('Only Gregorian') ?></label><br />
					</td> 
				</tr>
				<tr>
					<th width="33%" valign="top" scope="row"><label for="Gregorian_time_format">Gregorian Time Format:</label></th><td><input type="text" name="Gregorian_time_format" id="Gregorian_time_format" value="<?php echo $current_settings['Gregorian_time_format']; ?>" /><br /><?php _e('Default: %d %B %YCE'); ?></td> 
				</tr>
				<tr>
				<tr>
					<th width="33%" valign="top" scope="row"><label for="hijri_time_format">Hijri Time Format:</label></th><td><input type="text" name="hijri_time_format" id="hijri_time_format" value="<?php echo $current_settings['hijri_time_format']; ?>" /><br /><?php _e('Default: %02d %s %dAH'); ?></td> 
				</tr>
				<tr>
					<th width="33%" valign="top" scope="row"><label for="start">Before the date:</label></th><td><input type="text" name="start" value="<?php echo $current_settings['start']; ?>" /></td>
				</tr>
				<tr>
					<th width="33%" valign="top" scope="row"><label for="seperator">Seperator:</label></th><td><input type="text" id="seperator" name="seperator" value="<?php echo $current_settings['seperator']; ?>" /><br /><?php _e('Default: | '); ?></td>
				</tr>
				<tr>
					<th width="33%" valign="top" scope="row"><label for="end">After the date:</label></th><td><input type="text" name="end" value="<?php echo $current_settings['end']; ?>" /></td>
				</tr>
				</table>
			</fieldset>
			<fieldset class="options"><legend>Preview</legend>
				<div align="center"><strong><?php echo unn_hijridate(); ?></strong></div>
				<br />
</fieldset>
			<div style="text-align: center; clear: both; color: darkgrey;"><small>HijriDate is by <a href="http://www.usayd.com/" style="color: #666; border: 0px;">Usayd Younis</a> &copy;2005. This is version 1.85</small></div>
			<p class="submit">
				<input type="submit" name="Submit" value="Update Options &raquo;" />
			</p>
			<script type="text/javascript"><!--
document.getElementById('hijriandGregorian1').onclick = document.getElementById('hijriandGregorian2').onclick = function () { document.getElementById('seperator').disabled = true; };
document.getElementById('hijriandGregorian0').onclick = function () { document.getElementById('seperator').disabled = false; };
--></script>
		</form>
	</div>
<?php 
//}

function unn_add_options() {
	// Add a new menu under Options:
	add_options_page('HijriDate', 'HijriDate', 8, __FILE__, 'unn_hijridate_options_page');
}

function unn_save_options() {
	global $hijridate_options;
	// create array
	if (isset($_POST['hijriandGregorian'])) {
		$hijridate_options['hijriandGregorian'] = (int) $_POST['hijriandGregorian'];
		$hijridate_options['Gregorian_time_format'] = $_POST['Gregorian_time_format'];
		$hijridate_options['hijri_time_format'] = $_POST['hijri_time_format'];
		$hijridate_options['start'] = $_POST['start'];
		$hijridate_options['seperator'] = $_POST['seperator'];
		$hijridate_options['end'] = $_POST['end'];

		update_option('unn_hijridate_options', $hijridate_options);
	}
}

//add_action('admin_menu', 'unn_add_options'); 		// Insert the Admin panel.

/*if (!get_option('unn_hijridate_options')){
	// create default options
	$hijridate_options = array();
	$hijridate_options['hijriandGregorian'] = 0;
	$hijridate_options['Gregorian_time_format'] = '%d %B %YCE';
	$hijridate_options['hijri_time_format'] = '%02d %s %dAH';
	$hijridate_options['start'] = '';
	$hijridate_options['seperator'] = ' | ';
	$hijridate_options['end'] = '';

	update_option('unn_hijridate_options', $hijridate_options);
}*/
//update_option('unn_hijridate_options', $hijridate_options);

if ($_POST['action'] == 'save_options'){
	unn_save_options();
}
?>