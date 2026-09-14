<?php
/**
 * Single post template.
 *
 * @package IT_Cube_Enrollment
 */

get_header();

$posts_page_id = (int) get_option('page_for_posts');
$posts_page_url = $posts_page_id > 0 ? get_permalink($posts_page_id) : home_url('/novosti/');
?>
<main id="content" class="content-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="content-shell">
                    <h1 class="content-title"><?php the_title(); ?></h1>
                    <p class="content-meta">Опубликовано: <?php echo esc_html(get_the_date('d.m.Y')); ?></p>
                    <div class="content-body">
                        <?php the_content(); ?>
                    </div>
                    <p class="section-link-wrap">
                        <a class="text-link" href="<?php echo esc_url((string) $posts_page_url); ?>">
                            ← Ко всем новостям
                        </a>
                    </p>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
