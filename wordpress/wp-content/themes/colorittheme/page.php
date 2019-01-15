<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 */

get_header();?>

<?php if (is_front_page()) {?>


<div id="primary" class="row">
	<main id="main" class="site-main" role="main">
	<?php
		
		
		
			$args =array(
				'type' 			=> 'post',
				'post_per_page'	=> 1,
				
			);
			$query =new WP_Query($args);
			if($query->have_posts()):

			// Start the loop.
		while ( $query->have_posts() ) : $query->the_post();
				?>
			<div class="col l6 m6 s12">
				<?php
		// Include the page content template.
		get_template_part( 'template-parts/content', 'featured' );?>
			
			</div>
				
				<?php
		// If comments are open or we have at least one comment, load up the comment template.
		//if ( comments_open() || get_comments_number() ) {
		//	comments_template();
		//}

		// End of the loop.
		wp_reset_postdata();
	endwhile;
endif;

?>

</main><!-- .site-main -->
</div>
<?php 
	
		}else{	?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php //get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->


<?php }get_footer(); ?>
