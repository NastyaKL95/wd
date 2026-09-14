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
 * Registers theme basics.
 */
function it_cube_enrollment_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'it_cube_enrollment_setup');

/**
 * Adds default options after theme activation.
 */
function it_cube_enrollment_set_default_options()
{
    $defaults = array(
        'it_cube_contact_phone' => '[добавить номер]',
        'it_cube_contact_email' => '[добавить e-mail]',
        'it_cube_contact_address' => '[добавить адрес]',
        'it_cube_seo_meta_description' => 'Бесплатное IT-обучение для детей и подростков 7-18 лет в IT-Кубе: программирование, проектная работа, командные задачи. Места ограничены.',
        'it_cube_seo_meta_keywords' => 'IT-Куб, запись в IT-Куб, бесплатное обучение 7-18 лет, программирование для детей, IT-курсы для подростков',
        'it_cube_seo_robots' => 'index,follow',
        'it_cube_seo_og_image' => '',
        'it_cube_seo_twitter_card' => 'summary_large_image',
    );

    foreach ($defaults as $key => $value) {
        if (get_option($key, null) === null) {
            add_option($key, $value);
        }
    }
}
add_action('after_switch_theme', 'it_cube_enrollment_set_default_options');

/**
 * Enqueues theme assets.
 */
function it_cube_enrollment_enqueue_assets()
{
    wp_enqueue_style(
        'it-cube-enrollment-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'it-cube-enrollment-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
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
        'Контакты для футера',
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
    echo '<p>Данные выводятся в футере главной страницы.</p>';
}

/**
 * SEO section text.
 */
function it_cube_enrollment_seo_section_cb()
{
    echo '<p>Заполните SEO-поля для meta и Open Graph. Если OG image не задано, будет использоваться иконка сайта.</p>';
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
        <p>Раздел позволяет управлять контактами в футере и SEO/OG параметрами без изменения SQL.</p>
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
        return (string) get_permalink();
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
    $path = is_string($request_uri) ? (string) strtok($request_uri, '?') : '/';
    if ($path === '') {
        $path = '/';
    }

    return home_url($path);
}

/**
 * Prints SEO and Open Graph tags.
 */
function it_cube_enrollment_output_seo_meta()
{
    if (is_admin()) {
        return;
    }

    $default_description = 'Бесплатное IT-обучение для детей и подростков 7-18 лет в IT-Кубе: программирование, проектная работа, командные задачи. Места ограничены.';
    $default_keywords = 'IT-Куб, запись в IT-Куб, бесплатное обучение 7-18 лет, программирование для детей, IT-курсы для подростков';

    $title = wp_get_document_title();
    $description = it_cube_enrollment_get_option('it_cube_seo_meta_description', $default_description);
    $keywords = it_cube_enrollment_get_option('it_cube_seo_meta_keywords', $default_keywords);
    $robots = it_cube_enrollment_get_option('it_cube_seo_robots', 'index,follow');
    $twitter_card = it_cube_enrollment_get_option('it_cube_seo_twitter_card', 'summary_large_image');
    $canonical = it_cube_enrollment_get_canonical_url();
    $site_name = get_bloginfo('name');
    $og_image = it_cube_enrollment_get_option('it_cube_seo_og_image', '');

    if ($og_image === '') {
        $og_image = (string) get_site_icon_url(512);
    }

    echo "\n";
    printf('<meta name="description" content="%s" />' . "\n", esc_attr($description));
    printf('<meta name="keywords" content="%s" />' . "\n", esc_attr($keywords));
    printf('<meta name="robots" content="%s" />' . "\n", esc_attr($robots));
    printf('<link rel="canonical" href="%s" />' . "\n", esc_url($canonical));

    printf('<meta property="og:locale" content="ru_RU" />' . "\n");
    printf('<meta property="og:type" content="website" />' . "\n");
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
