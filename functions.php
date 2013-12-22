<?php

add_action( 'after_setup_theme', 'theme_setup' );
add_action( 'init', 'widgets_init' );
add_action( 'admin_head', 'load_theme_scripts');
add_action( 'init', 'register_custom_menu');
add_action( 'load-post.php', 'wp_svbtle_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'wp_svbtle_post_meta_boxes_setup' );
//add_action( 'template_redirect', 'add_cache_header');

add_filter( 'the_content', function ($content) {
  //Replace all ``` and ``` pair to <pre><code></code></pre>
  //Replace all ```!lang and ``` pair to <pre><code class=""></code></pre>
  // UTF-8, `` become &#8220;
  $sep = "\n\r\n```";

  $close = "\n```";
  $occuring = substr_count($content, $sep);
  //die($content);
  if ( $occuring < 1 ) {
    //Could be an syntax error?
    return $content;
  }
  $_content = '';
  // Use  to avoid 
  $segment = explode($sep, $content);

  $total_code_block = count($segment) - 1;
  $block = 0;
  while ($block <= $total_code_block) {
    $value = $segment[$block];
    if (0 === $block) {
      $_content = $segment[$block];
      $block++;
      continue;
    }

    //Find next .... for closing
    $pos = strpos($value, $close);
    if (FALSE !== $pos) {
      $_content .= "<pre role=\"hw\"><code>" . substr($value, 0, $pos-1) . '</code></pre>' . substr($value, $pos+strlen($close)+1);
    } else {
      $_content .= $value;
    }

    $block ++;
  }

  return $_content;

}, 0);
  
function exclude_category( $query ) {
  $options = get_option ( 'natsume_options' ); 
  if ($query->is_home() && $query->is_main_query() ) {
    //
    $query->set( 'cat', "{$options['exclude_cat']}" );
  }
}
add_action( 'pre_get_posts', 'exclude_category' );

add_filter('wp_headers', function ($headers) {
  $cache = 24 * 7 * 3600; //7 days
  $headers['Cache-Control'] = "max-age=$cache";
  $time = date('Y-m-d h:i:s');
  $headers['X-Genat'] = $time;
  $headers['Expires'] = NULL; //Use Cache-Control
  $headers['Server'] = 'Axcoto'; //Use Cache-Control
  $headers['X-Rev'] = 12;
  return $headers;
});

function theme_setup() {
	global $wp_version;
	if (version_compare($wp_version, '3.4' , '>=')){ 
		add_theme_support( 'custom-header', array(
			// Header image default
			'default-image'			=> get_template_directory_uri() . '/images/icons/bolt_large.png',
			'header-text'			=> false,
			'default-text-color'		=> '000',
			'width'				=> '100',
			'flex-width'                    => true,
			'height'			=> '100',
			'flex-height'                   => true,
			'random-default'		=> true,
			'wp-head-callback'		=> 'theme_header_style',
			'admin-head-callback'		=> 'theme_admin_header_style',
			'admin-preview-callback'	=> 'theme_admin_header_image'
		) );
  } 
  register_default_headers( array(
		'bolt' => array(
			'url' => '%s/images/icons/bolt_large.png',
			'thumbnail_url' => '%s/images/icons/thumbs/bolt.png',
			'description' => 'bolt'
		),
		'sunrise' => array(
			'url' => '%s/images/icons/sunrise_large.png',
			'thumbnail_url' => '%s/images/icons/thumbs/sunrise.png',
			'description' => 'sunrise'
		)
	) );
}

function widgets_init() {
	register_sidebar(array(
		'name' => __( 'Sidebar', 's' ),
		'id' => 'sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<span class="hidden">',
		'after_title' => '</span>',
	));
}

function theme_header_style() {
}
function theme_admin_header_style() {
}
function theme_admin_header_image() {
   	?><div style="display:inline-block;height:50px;background-color:#000;"><img src=<?php header_image(); ?> height="50px"></div>
    <?php
}

function register_custom_menu() {
	register_nav_menu( 'primary', __( 'Primary Menu') );
	register_nav_menu( 'secondary', __( 'Secondary Menu') );
}

require_once ( get_template_directory() . '/theme-options.php' );

function wp_svbtle_external_url( $object, $box ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), '_wp_svbtle_external_url' ); ?>
	<p>
		<input class="widefat" type="text" name="wp_svbtle_external_url" id="wp_svbtle_external_url" value="<?php echo esc_attr( get_post_meta( $object->ID, '_wp_svbtle_external_url', true ) ); ?>" size="30" />
	</p>
<?php }


function wp_svbtle_post_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'wp_svbtle_add_post_meta_boxes' );
	add_action( 'save_post', 'wp_svbtle_save_post_class_meta', 10, 2 );
}

function wp_svbtle_add_post_meta_boxes() {
	add_meta_box(
		'wp_svbtle_external_url', esc_html__( 'External Url', 'example' ),
		'wp_svbtle_external_url',
		'post',
		'side',
		'high'
	);
}

function wp_svbtle_save_post_class_meta( $post_id, $post ) {

	if ( !isset( $_POST['_wp_svbtle_external_url'] ) || !wp_verify_nonce( $_POST['_wp_svbtle_external_url'], basename( __FILE__ ) ) )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );

	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	$new_meta_value = ( isset( $_POST['wp_svbtle_external_url'] ) ? esc_url_raw( $_POST['wp_svbtle_external_url'] ) : '' );

	$meta_key = '_wp_svbtle_external_url';
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}


function print_post_title() {
global $post;
$thePostID = $post->ID;
$post_id = get_post($thePostID);
$title = $post_id->post_title;
$perm = get_permalink($post_id);
$post_keys = array(); $post_val = array();
$post_keys = get_post_custom_keys($thePostID);
$is_link = 0;

if (!empty($post_keys)) {
foreach ($post_keys as $pkey) {
if ($pkey=='_wp_svbtle_external_url' || $pkey=='_wp_svbtle_external_url' || $pkey=='_wp_svbtle_external_url') {
$post_val = get_post_custom_values($pkey);
}
}
if (empty($post_val)) {
$link = $perm;
} else {
$link = $post_val[0];
$is_link = 1;
}
} else {
$link = $perm;
}
if ($is_link): ?>
	<a href="<?php echo $link ?>" class="title"><?php echo the_title() ?></a>
	<a href="<?php echo the_permalink() ?>" class="anchor"><img src="<?php echo get_bloginfo('stylesheet_directory') ?>/images/anchor.svg" class="scalable"></a>
<?php else: ?>
	<a href="<?php the_permalink(); ?>" class="no-link" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>

<?php endif; 

}


if ( ! function_exists( 'wp_svbtle_comment' ) ) :

function wp_svbtle_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p class="row">
			<strong class="ping-label span1"><?php _e( 'Pingback:', 'the-bootstrap' ); ?></strong>
			<span class="span7"><?php comment_author_link(); edit_comment_link( __( 'Edit', 'the-bootstrap' ), '<span class="sep">&nbsp;</span><span class="edit-link label">', '</span>' ); ?></span>
		</p>
	<?php
			break;
		default :
			$offset	=	$depth - 1;
			$span	=	7 - $offset;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment row">
			<div class="comment-author-avatar span1<?php if ($offset) echo " offset{$offset}"; ?>">
				<?php echo get_avatar( $comment, 70 ); ?>
			</div>
			<footer class="comment-meta span<?php echo $span; ?>">
				<div class="comment-author vcard">
					<?php
						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s <span class="says">said</span> on %2$s:', 'the-bootstrap' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'the-bootstrap' ), get_comment_date(), get_comment_time() )
							)
						);
						edit_comment_link( __( 'Edit', 'the-bootstrap' ), '<span class="sep">&nbsp;</span><span class="edit-link label">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( ! $comment->comment_approved ) : ?>
				<div class="comment-awaiting-moderation alert alert-info"><em><?php _e( 'Your comment is awaiting moderation.', 'the-bootstrap' ); ?></em></div>
				<?php endif; ?>

			</footer>

			<div class="comment-content span<?php echo $span; ?>">
				<?php
				comment_text();
				comment_reply_link( array_merge( $args, array(
					'reply_text'	=>	__( 'Reply <span>&darr;</span>', 'the-bootstrap' ),
					'depth'			=>	$depth,
					'max_depth'		=>	$args['max_depth']
				) ) ); ?>
			</div>

		</article><!-- #comment-<?php comment_ID(); ?> -->
	<?php
			break;
	endswitch;
}
endif; // ends check for wp_svbtle_comment()

// Modifying the Comment Call before and after comment_form gets called in comments.php
add_action('comment_form_before','svbtle_comment_form_before');
add_action('comment_form_after','svbtle_comment_form_after');
function svbtle_comment_form_before() {
 echo '<div class="comments">';
 }

 function svbtle_comment_form_after() {
 echo '</div>';
 }
