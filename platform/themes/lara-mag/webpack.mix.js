let mix = require('laravel-mix');
const purgeCss = require('@fullhuman/postcss-purgecss');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/themes/' + directory;
const dist = 'public/themes/' + directory;

mix
    .sass(
        source + '/assets/sass/lara-mag.scss',
        dist + '/css',
        {},
        [
            purgeCss({
                content: [
                    source + '/layouts/*.blade.php',
                    source + '/partials/*.blade.php',
                    source + '/partials/**/*.blade.php',
                    source + '/views/*.blade.php',
                    source + '/views/**/*.blade.php',
                    source + '/widgets/**/templates/frontend.blade.php',
                    'platform/plugins/contact/resources/views/forms/contact.blade.php'
                ],
                defaultExtractor: content => content.match(/[\w-/.:]+(?<!:)/g) || [],
                safelist: [
                    /^navigation-/,
                    /^language-/,
                    /language_bar_list/,
                    /^fancybox-/,
                    /^owl-/,
                    /^fa-/,
                    /^bb-/,
                    /show-admin-bar/,
                    /breadcrumb/,
                    /active/,
                    /current/,
                    /show/
                ],
            })
        ]
    )
    .sass(source + '/assets/sass/rtl.scss', dist + '/css')
    .scripts(
        [
            source + '/assets/js/jquery.min.js',
            source + '/assets/js/jquery.fancybox.min.js',
            source + '/assets/js/custom.js'
        ], dist + '/js/lara-mag.js')

    .copy(dist + '/css/lara-mag.css', source + '/public/css')
    .copy(dist + '/css/rtl.css', source + '/public/css')
    .copy(dist + '/js/lara-mag.js', source + '/public/js');
