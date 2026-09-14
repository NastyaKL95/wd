<?php
/**
 * Search form template.
 *
 * @package IT_Cube_Enrollment
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text">Поиск по сайту:</span>
        <input type="search" class="search-field" placeholder="Введите запрос..." value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
    </label>
    <button type="submit" class="button-primary">Найти</button>
</form>
