<?php
/**
 * Site header.
 *
 * @package IT_Cube_Enrollment
 */

$enroll_form_url = it_cube_enrollment_get_form_url();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content">Перейти к содержимому</a>
<header class="site-header">
    <div class="container site-header__inner">
        <div class="site-branding">
            <p class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>">IT-Куб</a>
            </p>
            <p class="site-tagline">Бесплатное IT-обучение для детей и подростков 7-18 лет</p>
        </div>

        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation">
            Меню
        </button>

        <nav id="site-navigation" class="main-navigation" aria-label="Главное меню">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'main-navigation__list',
                    'fallback_cb' => 'it_cube_enrollment_primary_menu_fallback',
                )
            );
            ?>
        </nav>

        <a class="header-action js-enroll-link" href="<?php echo esc_url($enroll_form_url); ?>" target="_blank" rel="noopener noreferrer">
            Подать заявку
        </a>
    </div>
</header>
