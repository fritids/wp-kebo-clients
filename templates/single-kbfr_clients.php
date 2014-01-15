<?php
/**
 * The template for displaying the Testimonials Archive page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */
get_header();
?>

<div class="kcontainer" style="overflow: hidden;">

    <div class="kfriends">

            <header class="page-header">
                <h1 class="page-title"><?php __('Friends', 'kbfr'); ?></h1>
            </header><!-- .page-header -->

            <?php if ( have_posts() ) : ?>

                <div class="kfriends-container">

                    <?php while ( have_posts()) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class('kfriends'); ?>>

                            <div class="entry-content">
                                
                                <?php
                                // check if the post has a Post Thumbnail assigned to it.
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'thumbnail' );
                                }
                                ?>
                                
                                <h2 class="entry-title"><?php the_title(); ?></h2>

                                <div class="ktestimonial-text">
                                    <?php the_content(); ?>
                                </div>

                            </div><!-- .entry-content -->

                        </article><!-- #post-<?php the_ID(); ?> -->

                    <?php endwhile; ?>
                        
                </div><!-- .kfriends-container -->
                        
                <?php kbcl_pagination_nav(); ?>

            <?php else : ?>
                        
                <?php
                global $wp_post_types;
                $cpt = $wp_post_types['kbfr_friends'];
                ?>
                <?php if ( current_user_can( 'publish_posts' ) ) : ?>

                    <p><?php printf( __('Ready to create your first %2$s? <a href="%1$s">Get started here</a>.', 'kbfr'), admin_url( 'post-new.php?post_type=kbfr_friends' ), $cpt->labels->singular_name ); ?></p>

                <?php else : ?>

                    <p><?php printf( __('Sorry, there are currently no %1$s to display.', 'kbfr'), $cpt->labels->name ); ?></p>

                <?php endif; ?>

            <?php endif; ?>

    </div><!-- .kcontainer -->
    
</div><!-- .kfriends -->

<?php get_footer(); ?>