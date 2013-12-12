            <footer class="footer">
                <div class="pure-menu pure-menu-horizontal pure-menu-open">
                    <ul>
                        <li><a href="http://axcoto.com/">About</a></li>
                        <li><a href="http://twitter.com/kureikain/">Twitter</a></li>
                        <li><a href="http://facebook.com/kureikain/">Facebook</a></li>
                        <li><a href="http://github.com/kureikain/">Github</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
</div>


<script src="http://yui.yahooapis.com/3.12.0/build/yui/yui-min.js"></script>
<script>
YUI().use('node-base', 'node-event-delegate', function (Y) {
    // This just makes sure that the href="#" attached to the <a> elements
    // don't scroll you back up the page.
    Y.one('body').delegate('click', function (e) {
        e.preventDefault();
    }, 'a[href="#"]');
});
</script>

<?php $options = get_option ( 'svbtle_options' ); ?>

<script data-cfasync="false" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script data-cfasync="false" src="<?php echo get_bloginfo('template_directory'); ?>/highlight/highlight.pack.js"></script>
<script>
$(document).ready(function() {
  $('pre code').each(function(i, e) {hljs.highlightBlock(e)});
  $('blockquote p').each(function(i, e) {hljs.highlightBlock(e)});
});
</script>
    <?php wp_footer(); ?>
	</body>
</html>
