<?php
/**
 * Front page template for enrollment campaign.
 *
 * @package IT_Cube_Enrollment
 */

get_header();
?>

<main>
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

                <a class="button-primary" href="https://forms.gle/gV1wny8C8a" target="_blank" rel="noopener noreferrer">
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

    <section class="landing-section">
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

    <section class="landing-section">
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

    <section class="landing-section">
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
        <div class="container cta">
            <h2>Дайте ребёнку сильный старт в IT уже в этом учебном году</h2>
            <p>
                Оставьте заявку, чтобы занять место в группе. Обучение бесплатное, набор ведётся для детей
                и подростков 7-18 лет, количество мест ограничено.
            </p>
            <a class="button-primary" href="https://forms.gle/gV1wny8C8a" target="_blank" rel="noopener noreferrer">
                Записаться сейчас
            </a>
        </div>
    </section>
</main>

<?php
get_footer();
