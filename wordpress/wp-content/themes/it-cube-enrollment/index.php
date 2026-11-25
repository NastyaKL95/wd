<?php
/**
 * Fallback template.
 *
 * @package IT_Cube_Enrollment
 */

get_header();
?>
<main id="content" class="content-main">
    <div class="container">
        <section class="content-shell">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article>
                        <h1 class="content-title"><?php the_title(); ?></h1>
                        <div class="content-body"><?php the_content(); ?></div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <h1 class="content-title">IT-Куб</h1>
                <p>Контент пока не добавлен. Используйте админку WordPress для публикации страниц и новостей.</p>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php
get_footer();
