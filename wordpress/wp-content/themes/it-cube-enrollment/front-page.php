<?php
/**
 * Front page template for enrollment campaign.
 *
 * @package IT_Cube_Enrollment
 */

$enroll_form_url = it_cube_enrollment_get_form_url();
$news_page_id = (int) get_option('page_for_posts');
$news_page_url = $news_page_id > 0 ? get_permalink($news_page_id) : home_url('/novosti/');
$recent_posts = get_posts(
    array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => 3,
    )
);

get_header();
?>

<main id="content">
    <section class="hero">
        <div class="container hero__grid">
            <div class="hero__content">
                <p class="hero__eyebrow" aria-label="Ключевые условия набора">
                    <span class="hero__chip">Бесплатно</span>
                    <span class="hero__chip">7-18 лет</span>
                    <span class="hero__chip">Места ограничены</span>
                </p>

                <h1>СТАРТОВАЛА ЗАПИСЬ НА НОВЫЙ УЧЕБНЫЙ ГОД В IT-КУБЕ!</h1>
                <p class="hero__lead">
                    Бесплатные занятия для детей и подростков 7-18 лет: современные IT-направления,
                    практика с первого занятия и поддержка наставников. Места ограничены — подайте заявку сейчас.
                </p>

                <a class="button-primary js-enroll-link" href="<?php echo esc_url($enroll_form_url); ?>" target="_blank" rel="noopener noreferrer">
                    Записаться на обучение
                </a>
                <p class="hero__note">Заполнение формы занимает 1-2 минуты.</p>
            </div>

            <div
                class="hero__illustration"
                role="img"
                aria-label="Дети работают за ноутбуками: один пишет код, двое обсуждают задачу, наставник помогает">
                <h2 class="hero__visual-title">Иллюстрация первого экрана</h2>
                <p class="hero__visual-desc">
                    Динамичная сцена занятий: дети 10-16 лет за ноутбуками, командная работа, код и проектные задачи.
                </p>
                <div class="hero__mock" aria-hidden="true">
                    <div class="hero__mock-row">
                        <span class="hero__mock-pill"></span>
                        <span class="hero__mock-pill"></span>
                        <span class="hero__mock-pill hero__mock-pill--accent"></span>
                    </div>
                    <p class="hero__mock-code">if (idea) {<br>  buildProject();<br>  shareWithTeam();<br>}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="o-programme" class="landing-section">
        <div class="container">
            <h2>О программе</h2>
            <p class="section-intro">
                В IT-Кубе дети и подростки получают современные цифровые навыки через реальную практику.
                Здесь не просто теория, а делают своими руками: пишут код, решают задачи, работают в команде,
                превращают идеи в проекты. Ребята учатся мыслить системно, доводить работу до результата
                и уверенно применять знания на практике. Программа подходит и тем, кто только начинает,
                и тем, кто уже интересуется IT.
            </p>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <h2>Как проходит обучение</h2>
            <div class="timeline-grid">
                <article class="timeline-card">
                    <h3>1. Старт и выбор направления</h3>
                    <p>Определяем интересы ребёнка и помогаем выбрать подходящую траекторию обучения.</p>
                </article>
                <article class="timeline-card">
                    <h3>2. Практика на каждом занятии</h3>
                    <p>С первых уроков дети пишут код, собирают решения, тестируют и улучшают результат.</p>
                </article>
                <article class="timeline-card">
                    <h3>3. Командные проекты</h3>
                    <p>Участники работают в командах, распределяют роли и собирают полноценные проекты.</p>
                </article>
                <article class="timeline-card">
                    <h3>4. Презентация результата</h3>
                    <p>Ребята учатся защищать свои решения и презентовать проекты уверенно и по делу.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="skills" class="landing-section">
        <div class="container">
            <h2>Чему учатся в IT-Кубе</h2>
            <div class="skills-grid">
                <article class="skill-card">
                    <h3>Логика и алгоритмы</h3>
                    <p>Учатся разбивать сложные задачи на понятные шаги и находить эффективные решения.</p>
                </article>
                <article class="skill-card">
                    <h3>Инженерное мышление</h3>
                    <p>Анализируют, тестируют гипотезы и улучшают результат на каждом этапе работы.</p>
                </article>
                <article class="skill-card">
                    <h3>Работа в команде</h3>
                    <p>Распределяют роли, договариваются и вместе доводят задачи до общего результата.</p>
                </article>
                <article class="skill-card">
                    <h3>Создание проектов</h3>
                    <p>Проходят путь от идеи и прототипа до презентации собственного IT-продукта.</p>
                </article>
                <article class="skill-card">
                    <h3>Программирование</h3>
                    <p>Осваивают языки и инструменты разработки на практике, а не только в теории.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="audience" class="landing-section">
        <div class="container">
            <h2>Кому подойдёт</h2>
            <ul class="fit-list">
                <li>Новичкам, которые хотят начать путь в IT с понятной и дружелюбной программы.</li>
                <li>Тем, кто любит гаджеты и технологии и хочет понять, как всё устроено внутри.</li>
                <li>Тем, кто задумывается о будущей профессии и хочет попробовать себя в IT-направлениях.</li>
                <li>Тем, кто хочет попробовать бесплатно и выбрать интересную траекторию обучения.</li>
            </ul>
        </div>
    </section>

    <section id="benefits" class="landing-section">
        <div class="container">
            <h2>Преимущества</h2>
            <div class="badges">
                <span class="badge">Бесплатно</span>
                <span class="badge">Занятия в течение учебного года</span>
                <span class="badge">Практико-ориентированный подход</span>
                <span class="badge">Ограниченное количество мест</span>
            </div>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <h2>Новости IT-Куба</h2>
            <div class="posts-grid">
                <?php if (!empty($recent_posts)) : ?>
                    <?php foreach ($recent_posts as $post_item) : ?>
                        <article class="post-card">
                            <h3>
                                <a href="<?php echo esc_url(get_permalink($post_item->ID)); ?>">
                                    <?php echo esc_html(get_the_title($post_item->ID)); ?>
                                </a>
                            </h3>
                            <p><?php echo esc_html(wp_trim_words(strip_tags((string) $post_item->post_content), 22)); ?></p>
                            <a class="text-link" href="<?php echo esc_url(get_permalink($post_item->ID)); ?>">Читать новость</a>
                        </article>
                    <?php endforeach; ?>
                <?php else : ?>
                    <article class="post-card post-card--empty">
                        <h3>Скоро здесь появятся новости</h3>
                        <p>Добавьте первую запись в админке WordPress, и она автоматически появится в этом блоке.</p>
                    </article>
                <?php endif; ?>
            </div>
            <p class="section-link-wrap">
                <a class="text-link" href="<?php echo esc_url((string) $news_page_url); ?>">Смотреть все новости</a>
            </p>
        </div>
    </section>

    <section class="landing-section">
        <div class="container">
            <h2>Частые вопросы</h2>
            <div class="faq-grid">
                <article class="faq-card">
                    <h3>Нужен ли опыт в программировании?</h3>
                    <p>Нет. В IT-Кубе есть программы для начинающих, где всё объясняется поэтапно и на практике.</p>
                </article>
                <article class="faq-card">
                    <h3>Сколько стоит обучение?</h3>
                    <p>Обучение бесплатное для детей и подростков 7-18 лет в рамках текущего набора.</p>
                </article>
                <article class="faq-card">
                    <h3>Как записаться?</h3>
                    <p>Нажмите кнопку «Записаться сейчас», заполните форму и дождитесь обратной связи.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="enroll" class="landing-section">
        <div class="container cta">
            <h2>Дайте ребёнку сильный старт в IT уже в этом учебном году</h2>
            <p>
                Оставьте заявку, чтобы занять место в группе. Обучение бесплатное, набор ведётся для детей
                и подростков 7-18 лет, количество мест ограничено.
            </p>
            <a class="button-primary js-enroll-link" href="<?php echo esc_url($enroll_form_url); ?>" target="_blank" rel="noopener noreferrer">
                Записаться сейчас
            </a>
        </div>
    </section>
</main>

<?php
get_footer();
