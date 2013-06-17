<?php if (is_single()) : ?>

			<div class="browse"><?php previous_post_link('&laquo; %link') ?> <?php next_post_link(' %link &raquo;') ?></div>

<?php else : ?>

			<div class="browse"><?php posts_nav_link() ?></div>

<?php endif; ?>