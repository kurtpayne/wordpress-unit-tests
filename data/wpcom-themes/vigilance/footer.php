	<div id="footer">
		<?php include (COPY); ?>
	</div><!--end footer-->
</div><!--end wrapper-->
<?php wp_footer(); ?>
<?php
	$tmp_stats_code = get_option('V_stats_code');
	if($tmp_stats_code != ''){
		echo stripslashes($tmp_stats_code);
	}
?>
</body>
</html>
	