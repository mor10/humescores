<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Humescores
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php humescores_the_category_list(); ?>
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="entry-meta">
			<?php humescores_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	
	<?php
	if ( has_post_thumbnail() ) { ?>
	<figure class="featured-image full-bleed">
		<?php
		the_post_thumbnail('humescores-full-bleed');
		?>
	</figure><!-- .featured-image full-bleed -->
	<?php } ?>

	<section class="post-content">
		
		<?php
		if ( !is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="post-content__wrap">
			<div class="entry-meta">
				<?php humescores_posted_on(); ?>
			</div><!-- .entry-meta -->
			<div class="post-content__body">
		<?php
		endif; ?>
		
		<div class="entry-content">
			<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'humescores' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'humescores' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php humescores_entry_footer(); ?>
		</footer><!-- .entry-footer -->

		<?php
		if ( !is_active_sidebar( 'sidebar-1' ) ) : ?>
			</div><!-- .post-content__body -->
		</div><!-- .post-content__wrap -->
		<?php endif; ?>
		
		<?php
		humescores_post_navigation();

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
	</section><!-- .post-content -->
	
	<?php
	get_sidebar();
	?>
</article><!-- #post-## -->
