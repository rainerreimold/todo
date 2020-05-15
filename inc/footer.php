<?php 

if (STORE_PAGE_PARSE_TIME == 'true') {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' - ' . getenv('REQUEST_URI') . ' (' . $parse_time . 's)' . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);

}

if (DISPLAY_PAGE_PARSE_TIME == 'true') {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	echo '<div class="parseTime">Zeit: ' . $parse_time . 's</div>';
}

if ((GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded == true) && ($ini_zlib_output_compression < 1)) {
	if ((PHP_VERSION < '4.0.4') && (PHP_VERSION >= '4')) {
		xtc_gzip_output(GZIP_LEVEL);
	}
}

?>
<br /><br />
<a href="javascript:history.back();" title="zur&uuml;ck">zur&uuml;ck</a>
<br />
<br />
<?php 
echo '<a href="'.PFAD.'/'.APPNAME.'/uebersicht" title="'.PFAD.'/'.APPNAME.'/uebersicht">&Uuml;bersicht</a>
<br />
<br />
<a href="'.PFAD.'/'.APPNAME.'/log/out" title="Lizenz - Logout">Logout</a>';

echo '<br /><small>
Wir befinden uns in
<br />';
echo dirname(__FILE__);
echo '<br>andere Funktion<br />';
echo getcwd();
echo '<br />
</small>
</center>
</div>
<script src="'.PFAD.'/'.APPNAME.'../jscripts/fontsize.js" language="javascript" type="text/javascript"></script>
</body>
</html>';
