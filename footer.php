            <footer class="footer">
                <div class="pure-menu pure-menu-horizontal pure-menu-open">
                    <ul>
                      <?php echo str_replace('<a ', '<a class="pure-button pure-button-warning" ', wp_nav_menu( [
                        'theme_location' => 'secondary', 
                        'container' => false , 'items_wrap' => '%3$s',
                        'echo' => 0
                      ] )); ?>
<!--
 <li><a href="http://axcoto.com/">About</a></li>
                        <li><a href="http://twitter.com/kureikain/">Twitter</a></li>
                        <li><a href="http://facebook.com/kureikain/">Facebook</a></li>
                        <li><a href="http://github.com/kureikain/">Github</a></li>-->

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
