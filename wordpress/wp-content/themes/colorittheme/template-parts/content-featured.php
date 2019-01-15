<?php
/**
 * The template used for displaying featured page content
 * <span class="entry-title card-title grey-text text-darken-4"><?php the_category('<h4 class="center">'); ?></span>
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
<div class="card">

<div class="card-image waves-effect waves-block waves-light">
		<?php colorit_post_thumbnail(); ?>
</div><!-- .card-image waves-effect waves-block waves-light -->

	<div class="card-content">
      <span class="card-title activator grey-text text-darken-4"> <?php the_title( sprintf( '<p class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></p>' ); ?><i class="material-icons right">more_vert</i></span>
      <?php the_category('<h4 class="center">'); ?>
    </div>
    <div class="card-reveal">
      <span class="card-title grey-text text-darken-4"> <?php the_title( sprintf( '<p class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></p>' ); ?><i class="material-icons right">close</i></span>
     <?php
     //excerpt of the posts
			colorit_excerpt();
		?>

</div>

</article><!-- #post-## -->
