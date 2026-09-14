<?php
/**
 * Blog home template.
 *
 * @package IT_Cube_Enrollment
 */

get_header();
?>
<main id="content" class="content-main">
    <div class="container">
        <section class="content-shell">
            <h1 class="content-title">Новости IT-Куба</h1>
            <p class="section-intro">Новости занятий, анонсы мероприятий, результаты проектов и достижения учеников.</p>

            <div class="posts-list">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="post-card">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="content-meta"><?php echo esc_html(get_the_date('d.m.Y')); ?></p>
                            <p><?php echo esc_html(get_the_excerpt()); ?></p>
                            <a class="text-link" href="<?php the_permalink(); ?>">Читать полностью</a>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <article class="post-card post-card--empty">
                        <h2>Пока нет публикаций</h2>
                        <p>Добавьте первую новость в разделе «Записи» в админке WordPress.</p>
                    </article>
                <?php endif; ?>
            </div>

            <nav class="pagination" aria-label="Навигация по новостям">
                <?php
                echo wp_kses_post(
                    paginate_links(
                        array(
                            'type' => 'list',
                            'prev_text' => 'Назад',
                            'next_text' => 'Вперёд',
                        )
                    )
                );
                ?>
            </nav>
        </section>
    </div>
</main>
<?php
get_footer();
