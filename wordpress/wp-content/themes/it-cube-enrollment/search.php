<?php
/**
 * Search results template.
 *
 * @package IT_Cube_Enrollment
 */

get_header();
?>
<main id="content" class="content-main">
    <div class="container">
        <section class="content-shell">
            <h1 class="content-title">
                Результаты поиска: <?php echo esc_html(get_search_query()); ?>
            </h1>

            <?php if (have_posts()) : ?>
                <div class="posts-list">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="post-card">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html(get_the_excerpt()); ?></p>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p>По вашему запросу ничего не найдено.</p>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php
get_footer();
