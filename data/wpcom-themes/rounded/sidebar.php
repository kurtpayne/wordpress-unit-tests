<!-- SIDEBAR LINKS -->
<div id="menu">

<div id="nav">

<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>

<br />

	<div class="sideitem">
			 <div class="sideitemtop">
			 <img src="<?php bloginfo('template_directory'); ?>/img/stl.gif" alt="" 
			 width="15" height="15" class="corner" 
			 style="display: none" />
			 </div>


				<!-- POSTS BY CATEGORY -->
				<h2><?php _e('Categories'); ?></h2>
				<ul>
					<?php wp_list_cats(); ?>
				</ul>
				
		

		<div class="sideitembottom">
				 <img src="<?php bloginfo('template_directory'); ?>/img/sbl.gif" alt="" 
				 width="15" height="15" class="corner" 
				 style="display: none" />
				</div>

		</div><!-- end sideitem -->




		<br />

	<div class="sideitem">
			 <div class="sideitemtop">
			 <img src="<?php bloginfo('template_directory'); ?>/img/stl.gif" alt="" 
			 width="15" height="15" class="corner" 
			 style="display: none" />
			 </div>



		
				<!-- POSTS BY DATE -->
				<h2><?php _e('Archives'); ?></h2>
					<ul>
					 <?php wp_get_archives('type=monthly'); ?>
					</ul>
				
				

			<div class="sideitembottom">
				 <img src="<?php bloginfo('template_directory'); ?>/img/sbl.gif" alt="" 
				 width="15" height="15" class="corner" 
				 style="display: none" />
				</div>

		</div><!-- end sideitem -->




<br />
<!-- YOUR LINKS -->

	<div class="sideitem">
			 <div class="sideitemtop">
			 <img src="<?php bloginfo('template_directory'); ?>/img/stl.gif" alt="" 
			 width="15" height="15" class="corner" 
			 style="display: none" />
			 </div>

					<?php wp_list_bookmarks(); ?>

					
					
		<div class="sideitembottom">
				 <img src="<?php bloginfo('template_directory'); ?>/img/sbl.gif" alt="" 
				 width="15" height="15" class="corner" 
				 style="display: none" />
				</div>

		</div><!-- end sideitem -->
					
					<br />



			


					<div class="sideitem">
			 <div class="sideitemtop">
			 <img src="<?php bloginfo('template_directory'); ?>/img/stl.gif" alt="" 
			 width="15" height="15" class="corner" 
			 style="display: none" />
			 </div>


			<!-- SEARCH THE SITE -->
				<h2>Searching</h2>
			<!--   <label for="s"><?php _e('Enter keywords'); ?></label>	-->
			   <form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
				<div>
					<input type="text" name="s" id="s" size="15" />
					<input type="submit" value="<?php _e('Search'); ?>" />
				</div>
				</form>



				<div class="sideitembottom">
				 <img src="<?php bloginfo('template_directory'); ?>/img/sbl.gif" alt="" 
				 width="15" height="15" class="corner" 
				 style="display: none" />
				</div>

		</div><!-- end sideitem -->



<?php endif; ?>

	<div class="reset">&nbsp;</div>
</div><!-- end NAV -->
</div><!-- end MENU -->
