<?php
/**
 * 404 template.
 *
 * @package IT_Cube_Enrollment
 */

get_header();
?>
<main id="content" class="content-main">
    <div class="container">
        <section class="content-shell">
            <h1 class="error-title">Страница не найдена</h1>
            <p>Возможно, ссылка устарела или страница была перемещена.</p>
            <p>
                <a class="button-primary" href="<?php echo esc_url(home_url('/')); ?>">Перейти на главную</a>
            </p>
        </section>
    </div>
</main>
<?php
get_footer();
