<?php
/**
 * Theme bootstrap for IT Cube Enrollment.
 *
 * @package IT_Cube_Enrollment
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme version.
 */
define('IT_CUBE_THEME_VERSION', '1.1.0');

/**
 * Returns default theme options.
 */
function it_cube_enrollment_default_options()
{
    return array(
        'it_cube_contact_phone' => '[добавить номер]',
        'it_cube_contact_email' => '[добавить e-mail]',
        'it_cube_contact_address' => '[добавить адрес]',
        'it_cube_enroll_form_url' => 'https://forms.gle/gV1wny8C8a',
        'it_cube_seo_meta_description' => 'Бесплатное IT-обучение для детей и подростков 7-18 лет в IT-Кубе: программирование, проектная работа, командные задачи. Места ограничены.',
        'it_cube_seo_meta_keywords' => 'IT-Куб, запись в IT-Куб, бесплатное обучение 7-18 лет, программирование для детей, IT-курсы для подростков',
        'it_cube_seo_robots' => 'index,follow',
        'it_cube_seo_og_image' => '',
        'it_cube_seo_twitter_card' => 'summary_large_image',
    );
}

/**
 * Registers theme basics.
 */
function it_cube_enrollment_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo', array('height' => 80, 'width' => 220, 'flex-height' => true, 'flex-width' => true));

    register_nav_menus(
        array(
            'primary' => 'Главное меню',
            'footer' => 'Меню в футере',
        )
    );
}
add_action('after_setup_theme', 'it_cube_enrollment_setup');

/**
 * Sets option defaults and first site structure at theme activation.
 */
function it_cube_enrollment_on_activation()
{
    it_cube_enrollment_ensure_default_options();

    it_cube_enrollment_prepare_pages();
    it_cube_enrollment_prepare_default_menu();
    update_option('it_cube_site_bootstrapped', 'yes');
}
add_action('after_switch_theme', 'it_cube_enrollment_on_activation');

/**
 * Runs one-time bootstrap if theme was updated in-place.
 */
function it_cube_enrollment_maybe_bootstrap_site()
{
    it_cube_enrollment_ensure_default_options();

    $bootstrapped = get_option('it_cube_site_bootstrapped', 'no');
    if ($bootstrapped === 'yes') {
        return;
    }

    it_cube_enrollment_prepare_pages();
    it_cube_enrollment_prepare_default_menu();
    update_option('it_cube_site_bootstrapped', 'yes');
}
add_action('init', 'it_cube_enrollment_maybe_bootstrap_site');

/**
 * Creates missing options with defaults.
 */
function it_cube_enrollment_ensure_default_options()
{
    $defaults = it_cube_enrollment_default_options();

    foreach ($defaults as $key => $value) {
        if (get_option($key, null) === null) {
            add_option($key, $value);
        }
    }
}

/**
 * Ensures key pages exist and binds static front page.
 */
function it_cube_enrollment_prepare_pages()
{
    $front_id = it_cube_enrollment_ensure_page(
        'Главная IT-Куб',
        'it-cube-enrollment-home',
        'Главная страница управляется шаблоном front-page.php темы IT Cube Enrollment.'
    );
    $news_id = it_cube_enrollment_ensure_page(
        'Новости',
        'novosti',
        'Здесь публикуются новости, мероприятия и достижения учеников IT-Куба.'
    );
    it_cube_enrollment_ensure_page(
        'Контакты',
        'kontakty',
        "Телефон: [добавить номер]\nE-mail: [добавить e-mail]\nАдрес: [добавить адрес]"
    );

    if ($front_id > 0) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_id);
    }

    if ($news_id > 0) {
        update_option('page_for_posts', $news_id);
    }
}

/**
 * Creates page if missing and returns page ID.
 */
function it_cube_enrollment_ensure_page($title, $slug, $content)
{
    $existing = get_page_by_path($slug, OBJECT, 'page');
    if ($existing instanceof WP_Post) {
        return (int) $existing->ID;
    }

    $page_id = wp_insert_post(
        array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_title' => $title,
            'post_name' => $slug,
            'post_content' => $content,
        ),
        true
    );

    if (is_wp_error($page_id)) {
        return 0;
    }

    return (int) $page_id;
}

/**
 * Ensures a default primary menu exists.
 */
function it_cube_enrollment_prepare_default_menu()
{
    $menu_id = it_cube_enrollment_get_or_create_menu('Главное меню IT-Куб');
    if ($menu_id <= 0) {
        return;
    }

    $footer_menu_id = it_cube_enrollment_get_or_create_menu('Футер меню IT-Куб');

    $locations = get_theme_mod('nav_menu_locations');
    if (!is_array($locations)) {
        $locations = array();
    }
    $locations['primary'] = $menu_id;
    if ($footer_menu_id > 0) {
        $locations['footer'] = $footer_menu_id;
    }
    set_theme_mod('nav_menu_locations', $locations);

    $existing_items = wp_get_nav_menu_items($menu_id);
    if (!is_array($existing_items) || count($existing_items) === 0) {
        $items = array(
            array('title' => 'О программе', 'url' => home_url('/#o-programme')),
            array('title' => 'Навыки', 'url' => home_url('/#skills')),
            array('title' => 'Кому подойдёт', 'url' => home_url('/#audience')),
            array('title' => 'Преимущества', 'url' => home_url('/#benefits')),
            array('title' => 'Запись', 'url' => home_url('/#enroll')),
            array('title' => 'Новости', 'url' => home_url('/novosti/')),
            array('title' => 'Контакты', 'url' => home_url('/kontakty/')),
        );

        foreach ($items as $item) {
            wp_update_nav_menu_item(
                $menu_id,
                0,
                array(
                    'menu-item-title' => $item['title'],
                    'menu-item-url' => $item['url'],
                    'menu-item-status' => 'publish',
                )
            );
        }
    }

    if ($footer_menu_id > 0) {
        $footer_items = wp_get_nav_menu_items($footer_menu_id);
        if (!is_array($footer_items) || count($footer_items) === 0) {
            $links = array(
                array('title' => 'Главная', 'url' => home_url('/')),
                array('title' => 'Новости', 'url' => home_url('/novosti/')),
                array('title' => 'Контакты', 'url' => home_url('/kontakty/')),
            );

            foreach ($links as $link) {
                wp_update_nav_menu_item(
                    $footer_menu_id,
                    0,
                    array(
                        'menu-item-title' => $link['title'],
                        'menu-item-url' => $link['url'],
                        'menu-item-status' => 'publish',
                    )
                );
            }
        }
    }
}

/**
 * Returns existing menu ID or creates one.
 */
function it_cube_enrollment_get_or_create_menu($menu_name)
{
    $menu_object = wp_get_nav_menu_object($menu_name);
    if ($menu_object) {
        return (int) $menu_object->term_id;
    }

    $menu_id = wp_create_nav_menu($menu_name);
    if (is_wp_error($menu_id)) {
        return 0;
    }

    return (int) $menu_id;
}

/**
 * Primary menu fallback when no menu assigned.
 */
function it_cube_enrollment_primary_menu_fallback()
{
    $items = array(
        array('title' => 'О программе', 'url' => home_url('/#o-programme')),
        array('title' => 'Навыки', 'url' => home_url('/#skills')),
        array('title' => 'Кому подойдёт', 'url' => home_url('/#audience')),
        array('title' => 'Преимущества', 'url' => home_url('/#benefits')),
        array('title' => 'Запись', 'url' => home_url('/#enroll')),
        array('title' => 'Новости', 'url' => home_url('/novosti/')),
    );

    echo '<ul class="main-navigation__list">';
    foreach ($items as $item) {
        printf(
            '<li><a href="%s">%s</a></li>',
            esc_url($item['url']),
            esc_html($item['title'])
        );
    }
    echo '</ul>';
}

/**
 * Footer menu fallback when no menu assigned.
 */
function it_cube_enrollment_footer_menu_fallback()
{
    $items = array(
        array('title' => 'Главная', 'url' => home_url('/')),
        array('title' => 'Новости', 'url' => home_url('/novosti/')),
        array('title' => 'Контакты', 'url' => home_url('/kontakty/')),
    );

    echo '<ul class="footer-menu">';
    foreach ($items as $item) {
        printf(
            '<li><a href="%s">%s</a></li>',
            esc_url($item['url']),
            esc_html($item['title'])
        );
    }
    echo '</ul>';
}

/**
 * Enqueues theme assets.
 */
function it_cube_enrollment_enqueue_assets()
{
    wp_enqueue_style(
        'it-cube-enrollment-style',
        get_stylesheet_uri(),
        array(),
        IT_CUBE_THEME_VERSION
    );

    wp_enqueue_script(
        'it-cube-enrollment-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        IT_CUBE_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'it_cube_enrollment_enqueue_assets');

/**
 * Returns sanitized option value with fallback.
 */
function it_cube_enrollment_get_option($key, $fallback)
{
    $value = get_option($key);
    if (!is_string($value) || $value === '') {
        return $fallback;
    }

    return $value;
}

/**
 * Returns current enrollment form URL.
 */
function it_cube_enrollment_get_form_url()
{
    return it_cube_enrollment_get_option('it_cube_enroll_form_url', 'https://forms.gle/gV1wny8C8a');
}

/**
 * Adds theme settings page in admin.
 */
function it_cube_enrollment_add_settings_page()
{
    add_theme_page(
        'Настройки IT-Куб',
        'Настройки IT-Куб',
        'manage_options',
        'it-cube-enrollment-settings',
        'it_cube_enrollment_render_settings_page'
    );
}
add_action('admin_menu', 'it_cube_enrollment_add_settings_page');

/**
 * Registers settings fields.
 */
function it_cube_enrollment_register_settings()
{
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_contact_phone',
        array('type' => 'string', 'sanitize_callback' => 'sanitize_text_field')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_contact_email',
        array('type' => 'string', 'sanitize_callback' => 'sanitize_email')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_contact_address',
        array('type' => 'string', 'sanitize_callback' => 'sanitize_textarea_field')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_enroll_form_url',
        array('type' => 'string', 'sanitize_callback' => 'esc_url_raw')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_seo_meta_description',
        array('type' => 'string', 'sanitize_callback' => 'sanitize_textarea_field')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_seo_meta_keywords',
        array('type' => 'string', 'sanitize_callback' => 'sanitize_text_field')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_seo_og_image',
        array('type' => 'string', 'sanitize_callback' => 'esc_url_raw')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_seo_robots',
        array('type' => 'string', 'sanitize_callback' => 'it_cube_enrollment_sanitize_robots')
    );
    register_setting(
        'it_cube_enrollment_settings_group',
        'it_cube_seo_twitter_card',
        array('type' => 'string', 'sanitize_callback' => 'it_cube_enrollment_sanitize_twitter_card')
    );

    add_settings_section(
        'it_cube_contact_section',
        'Контакты и заявка',
        'it_cube_enrollment_contact_section_cb',
        'it-cube-enrollment-settings'
    );
    add_settings_section(
        'it_cube_seo_section',
        'SEO и Open Graph',
        'it_cube_enrollment_seo_section_cb',
        'it-cube-enrollment-settings'
    );

    add_settings_field(
        'it_cube_contact_phone',
        'Телефон',
        'it_cube_enrollment_render_text_field',
        'it-cube-enrollment-settings',
        'it_cube_contact_section',
        array(
            'option_name' => 'it_cube_contact_phone',
            'placeholder' => '+7 (000) 000-00-00',
        )
    );
    add_settings_field(
        'it_cube_contact_email',
        'E-mail',
        'it_cube_enrollment_render_text_field',
        'it-cube-enrollment-settings',
        'it_cube_contact_section',
        array(
            'option_name' => 'it_cube_contact_email',
            'placeholder' => 'mail@example.ru',
            'type' => 'email',
        )
    );
    add_settings_field(
        'it_cube_contact_address',
        'Адрес',
        'it_cube_enrollment_render_textarea_field',
        'it-cube-enrollment-settings',
        'it_cube_contact_section',
        array(
            'option_name' => 'it_cube_contact_address',
            'placeholder' => 'г. Чита, ул. ...',
            'rows' => 3,
        )
    );
    add_settings_field(
        'it_cube_enroll_form_url',
        'Ссылка на форму записи',
        'it_cube_enrollment_render_text_field',
        'it-cube-enrollment-settings',
        'it_cube_contact_section',
        array(
            'option_name' => 'it_cube_enroll_form_url',
            'placeholder' => 'https://forms.gle/...',
            'type' => 'url',
        )
    );

    add_settings_field(
        'it_cube_seo_meta_description',
        'Meta description',
        'it_cube_enrollment_render_textarea_field',
        'it-cube-enrollment-settings',
        'it_cube_seo_section',
        array(
            'option_name' => 'it_cube_seo_meta_description',
            'placeholder' => 'Краткое описание страницы (120-180 символов).',
            'rows' => 4,
        )
    );
    add_settings_field(
        'it_cube_seo_meta_keywords',
        'Meta keywords',
        'it_cube_enrollment_render_text_field',
        'it-cube-enrollment-settings',
        'it_cube_seo_section',
        array(
            'option_name' => 'it_cube_seo_meta_keywords',
            'placeholder' => 'ключ1, ключ2, ключ3',
        )
    );
    add_settings_field(
        'it_cube_seo_og_image',
        'OG image URL',
        'it_cube_enrollment_render_text_field',
        'it-cube-enrollment-settings',
        'it_cube_seo_section',
        array(
            'option_name' => 'it_cube_seo_og_image',
            'placeholder' => 'https://site.ru/path/to/og-image.jpg',
            'type' => 'url',
        )
    );
    add_settings_field(
        'it_cube_seo_robots',
        'Robots',
        'it_cube_enrollment_render_select_field',
        'it-cube-enrollment-settings',
        'it_cube_seo_section',
        array(
            'option_name' => 'it_cube_seo_robots',
            'options' => array(
                'index,follow' => 'index,follow',
                'noindex,nofollow' => 'noindex,nofollow',
            ),
        )
    );
    add_settings_field(
        'it_cube_seo_twitter_card',
        'Twitter Card',
        'it_cube_enrollment_render_select_field',
        'it-cube-enrollment-settings',
        'it_cube_seo_section',
        array(
            'option_name' => 'it_cube_seo_twitter_card',
            'options' => array(
                'summary_large_image' => 'summary_large_image',
                'summary' => 'summary',
            ),
        )
    );
}
add_action('admin_init', 'it_cube_enrollment_register_settings');

/**
 * Contact section text.
 */
function it_cube_enrollment_contact_section_cb()
{
    echo '<p>Заполняемые данные выводятся в футере и кнопках записи на главной странице.</p>';
}

/**
 * SEO section text.
 */
function it_cube_enrollment_seo_section_cb()
{
    echo '<p>Заполните SEO-поля для meta и Open Graph. Если OG image не задано, будет использована картинка записи или иконка сайта.</p>';
}

/**
 * Sanitizes robots value.
 */
function it_cube_enrollment_sanitize_robots($value)
{
    $allowed = array('index,follow', 'noindex,nofollow');
    if (!in_array($value, $allowed, true)) {
        return 'index,follow';
    }

    return $value;
}

/**
 * Sanitizes twitter card value.
 */
function it_cube_enrollment_sanitize_twitter_card($value)
{
    $allowed = array('summary_large_image', 'summary');
    if (!in_array($value, $allowed, true)) {
        return 'summary_large_image';
    }

    return $value;
}

/**
 * Renders text input.
 */
function it_cube_enrollment_render_text_field($args)
{
    $name = isset($args['option_name']) ? $args['option_name'] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $type = isset($args['type']) ? $args['type'] : 'text';
    $value = get_option($name, '');
    ?>
    <input
        class="regular-text"
        type="<?php echo esc_attr($type); ?>"
        name="<?php echo esc_attr($name); ?>"
        value="<?php echo esc_attr($value); ?>"
        placeholder="<?php echo esc_attr($placeholder); ?>"
    />
    <?php
}

/**
 * Renders textarea input.
 */
function it_cube_enrollment_render_textarea_field($args)
{
    $name = isset($args['option_name']) ? $args['option_name'] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $rows = isset($args['rows']) ? (int) $args['rows'] : 4;
    $value = get_option($name, '');
    ?>
    <textarea
        class="large-text"
        name="<?php echo esc_attr($name); ?>"
        rows="<?php echo esc_attr((string) $rows); ?>"
        placeholder="<?php echo esc_attr($placeholder); ?>"
    ><?php echo esc_textarea($value); ?></textarea>
    <?php
}

/**
 * Renders select input.
 */
function it_cube_enrollment_render_select_field($args)
{
    $name = isset($args['option_name']) ? $args['option_name'] : '';
    $options = isset($args['options']) && is_array($args['options']) ? $args['options'] : array();
    $value = get_option($name, '');
    ?>
    <select name="<?php echo esc_attr($name); ?>">
        <?php foreach ($options as $option_value => $label) : ?>
            <option value="<?php echo esc_attr($option_value); ?>" <?php selected($value, $option_value); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

/**
 * Renders admin page markup.
 */
function it_cube_enrollment_render_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Настройки темы IT-Куб</h1>
        <p>Раздел позволяет полностью управлять контактами и SEO/OG параметрами сайта без изменения SQL.</p>
        <form action="options.php" method="post">
            <?php
            settings_fields('it_cube_enrollment_settings_group');
            do_settings_sections('it-cube-enrollment-settings');
            submit_button('Сохранить настройки');
            ?>
        </form>
    </div>
    <?php
}

/**
 * Returns canonical URL for current request.
 */
function it_cube_enrollment_get_canonical_url()
{
    if (is_singular()) {
        $url = get_permalink();
        if (is_string($url) && $url !== '') {
            return $url;
        }
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
    $path = is_string($request_uri) ? (string) strtok($request_uri, '?') : '/';
    if ($path === '') {
        $path = '/';
    }

    return home_url($path);
}

/**
 * Returns Open Graph image URL.
 */
function it_cube_enrollment_get_og_image_url()
{
    $option_image = it_cube_enrollment_get_option('it_cube_seo_og_image', '');
    if ($option_image !== '') {
        return $option_image;
    }

    if (is_singular() && has_post_thumbnail()) {
        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
        if (is_string($thumbnail) && $thumbnail !== '') {
            return $thumbnail;
        }
    }

    $icon = get_site_icon_url(512);
    if (is_string($icon)) {
        return $icon;
    }

    return '';
}

/**
 * Returns current meta description.
 */
function it_cube_enrollment_get_meta_description()
{
    $default_description = it_cube_enrollment_get_option(
        'it_cube_seo_meta_description',
        'Бесплатное IT-обучение для детей и подростков 7-18 лет в IT-Кубе: программирование, проектная работа, командные задачи. Места ограничены.'
    );

    if (is_singular()) {
        $excerpt = get_the_excerpt();
        if (is_string($excerpt) && $excerpt !== '') {
            return wp_strip_all_tags($excerpt, true);
        }
    }

    return $default_description;
}

/**
 * Prints SEO and Open Graph tags.
 */
function it_cube_enrollment_output_seo_meta()
{
    if (is_admin()) {
        return;
    }

    if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) {
        return;
    }

    $title = wp_get_document_title();
    $description = it_cube_enrollment_get_meta_description();
    $keywords = it_cube_enrollment_get_option('it_cube_seo_meta_keywords', '');
    $robots = it_cube_enrollment_get_option('it_cube_seo_robots', 'index,follow');
    $twitter_card = it_cube_enrollment_get_option('it_cube_seo_twitter_card', 'summary_large_image');
    $canonical = it_cube_enrollment_get_canonical_url();
    $site_name = get_bloginfo('name');
    $og_image = it_cube_enrollment_get_og_image_url();
    $og_type = is_singular() ? 'article' : 'website';

    echo "\n";
    printf('<meta name="description" content="%s" />' . "\n", esc_attr($description));
    if ($keywords !== '') {
        printf('<meta name="keywords" content="%s" />' . "\n", esc_attr($keywords));
    }
    printf('<meta name="robots" content="%s" />' . "\n", esc_attr($robots));
    printf('<link rel="canonical" href="%s" />' . "\n", esc_url($canonical));

    printf('<meta property="og:locale" content="ru_RU" />' . "\n");
    printf('<meta property="og:type" content="%s" />' . "\n", esc_attr($og_type));
    printf('<meta property="og:title" content="%s" />' . "\n", esc_attr($title));
    printf('<meta property="og:description" content="%s" />' . "\n", esc_attr($description));
    printf('<meta property="og:url" content="%s" />' . "\n", esc_url($canonical));
    printf('<meta property="og:site_name" content="%s" />' . "\n", esc_attr($site_name));

    if ($og_image !== '') {
        printf('<meta property="og:image" content="%s" />' . "\n", esc_url($og_image));
    }

    printf('<meta name="twitter:card" content="%s" />' . "\n", esc_attr($twitter_card));
    printf('<meta name="twitter:title" content="%s" />' . "\n", esc_attr($title));
    printf('<meta name="twitter:description" content="%s" />' . "\n", esc_attr($description));
    if ($og_image !== '') {
        printf('<meta name="twitter:image" content="%s" />' . "\n", esc_url($og_image));
    }
}
add_action('wp_head', 'it_cube_enrollment_output_seo_meta', 5);
