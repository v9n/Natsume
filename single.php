<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>

<?php get_template_part( 'loop', 'index' ); ?>

<?php
$posts=$wpdb->get_results($wpdb->prepare(
 "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = %s AND post_id <> %d " .
 "ORDER BY CHAR_LENGTH(meta_value) DESC, meta_value DESC LIMIT 5",
 '_wp-svbtle-kudos', get_the_ID()
));
?>

<div class="also">
  <h2 class='also-read-title'>Also read...</h2>
  <ul class='also-read-items'>
  <?php for($i=0; $i<count($posts); $i++): ?>
    <li>
      <h3>
        <a href="<?php echo get_permalink($posts[$i]->post_id); ?>">
        <?php echo get_the_title($posts[$i]->post_id); ?>
        </a>
      </h3>
    </li>
  <?php endfor; ?>
  </ul>
</div>

<?php comments_template(); ?>

<nav class="pagination">
  <span class="prev">
    <a href="<?php echo home_url( '/' ); ?>" class="back_to_blog">←&nbsp;&nbsp;&nbsp;read more</a>
  </span>
</nav>

<?php get_footer(); ?>
