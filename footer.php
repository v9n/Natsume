            <footer class="footer">
                <div class="pure-menu pure-menu-horizontal pure-menu-open">
                    <ul>
                      <?php wp_nav_menu([
                        'theme_location' => 'secondary', 
                        'container' => false , 'items_wrap' => '%3$s',
                        ]);?>

                    </ul>
                 </div>
                 <p>
                    Proudly made with MacVim, use <a href="http://github.com/kureikain/natsume/">Natsume</a> theme.
                                        </p>

            </footer>
        </div>
    </div>
</div>

<?php	empty($option) && $options = get_option ( 'natsume_options' ); ?>

<script data-cfasync="false" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script data-cfasync="false" src="<?php echo get_bloginfo('template_directory'); ?>/highlight/highlight.pack.js"></script>
<script>
$(document).ready(function() {
  $('code').each(function(i, e) {hljs.highlightBlock(e)});
});
</script>

<?php echo $options['google_analytics'];?>
    <?php wp_footer(); ?>
	</body>
</html>
