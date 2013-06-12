<?php global $hemingway ?>
<hr class="hide" />
        <div id="ancillary">
                <div class="inside">
                        <div class="block first">
				<?php if ( !dynamic_sidebar('bottom-1') ) $hemingway->get_block_output('block_1'); ?>
                        </div>

                        <div class="block">
                                <?php if ( !dynamic_sidebar('bottom-2') ) $hemingway->get_block_output('block_2'); ?>
                        </div>

                        <div class="block">
                                <?php if ( !dynamic_sidebar('bottom-3') ) $hemingway->get_block_output('block_3'); ?>
                        </div>

                        <div class="clear"></div>
                </div>
        </div>
        <!-- [END] #ancillary -->
