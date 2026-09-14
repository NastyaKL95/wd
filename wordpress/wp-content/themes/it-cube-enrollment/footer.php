<?php
/**
 * Site footer.
 *
 * @package IT_Cube_Enrollment
 */

$phone = it_cube_enrollment_get_option('it_cube_contact_phone', '[добавить номер]');
$email = it_cube_enrollment_get_option('it_cube_contact_email', '[добавить e-mail]');
$address = it_cube_enrollment_get_option('it_cube_contact_address', '[добавить адрес]');
?>
<footer class="site-footer">
    <div class="container footer-grid">
        <p><strong>IT-Куб - Забайкальский край</strong></p>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer',
                'container' => false,
                'menu_class' => 'footer-menu',
                'fallback_cb' => 'it_cube_enrollment_footer_menu_fallback',
            )
        );
        ?>
        <p>Сайт: <a href="https://it-cube.zabedu.ru/" target="_blank" rel="noopener noreferrer">it-cube.zabedu.ru</a></p>
        <p>Телефон: <?php echo esc_html($phone); ?></p>
        <p>E-mail: <?php echo esc_html($email); ?></p>
        <p>Адрес: <?php echo esc_html($address); ?></p>
        <p class="footer-legal">
            © <?php echo esc_html(gmdate('Y')); ?> IT-Куб. Все права защищены.
            При необходимости добавьте сведения об организации, данные лицензии и политику обработки персональных данных.
        </p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
