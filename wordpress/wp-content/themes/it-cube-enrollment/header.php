<?php
/**
 * Site header.
 *
 * @package IT_Cube_Enrollment
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container site-header__inner">
        <div>
            <p class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>">IT-Куб</a>
            </p>
            <p class="site-tagline">Бесплатное IT-обучение для детей и подростков 7-18 лет</p>
        </div>
        <a class="header-action" href="https://forms.gle/gV1wny8C8a" target="_blank" rel="noopener noreferrer">
            Подать заявку
        </a>
    </div>
</header>
