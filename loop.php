<?php if ( have_posts() ) : ?>

<div class="posts">
  <h1 class="content-subhead">
<?php 
$post_id = get_the_ID();
if (!empty($post_id) && $s = get_post_meta($post_id, 'headline', true)) {
  echo $s;
} else {
  echo ['Just my daily though and stuff', 
    'Hoàng hà viễn thướng bạch vân gian',
    'Nhất phiến cô thành vạn nhận san',
    'Khương địch hà tu oán dương liễu',
    'Xuân phong bất độ ngọc môn quan'][rand(0,4)]
;
}
unset ($s);
unset ($post_id);
?>
</h1>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php $kudos = get_post_meta( $post->ID, '_wp-svbtle-kudos', true ) ? get_post_meta( $post->ID, '_wp-svbtle-kudos', true ) : '0';?>
					
			<section id="<?php the_ID(); ?>" class="post">
        <header class="post-header">
          <img class="post-avatar" width="48" height="48" src="https://1.gravatar.com/avatar/738f5eacec5048869fd3f6866f39d1af?d=https%3A%2F%2Fidenticons.github.com%2Ff816fb5e358e95c718f79cc25ee91855.png&r=x&s=48" alt="me :-)">
          <h2 class="post-title entry-title"><?php print_post_title(); ?></h2>
          <p class="meta">
            By
            <a class="post-author" href="#" ><?php the_author(); ?></a>
            in 
            <?php foreach ((get_the_category()) as $key=>$category) : ?>
            <a class="post-category post-category-<?php echo ['alpha','beta','teta', 'zeta'][$key];?>" href="<?php echo get_category_link( $category->term_id );?>" title="<?php esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) )?>">
              <?php echo $category->cat_name?>
            </a>
            <?php endforeach; ?>
          </p>
        </header>

				<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php else : ?>
					<div class="entry-content">
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'boilerplate' ) ); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'boilerplate' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
				<?php endif; ?>
			</section><!-- #post-## -->

	<?php endwhile; // End the loop. Whew. ?>
</div>	

	<?php if (  $wp_query->max_num_pages > 1 ) : ?>

		<nav class="pagination">

			<span class="next">
				<?php next_posts_link( __( 'Continue&nbsp;&nbsp;&nbsp;→', 'boilerplate' ) ); ?>
			</span>

		  <span class="prev">
				<?php previous_posts_link( __( '←&nbsp;&nbsp;&nbsp;Newer', 'boilerplate' ) ); ?>
			</span>
		
		</nav>

	<?php endif; ?>

<?php else : ?>

	<article id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'boilerplate' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'boilerplate' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

<?php endif; ?>
