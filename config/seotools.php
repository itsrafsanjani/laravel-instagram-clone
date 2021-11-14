<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => 'Laragram | Social Media', // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Laragram is a social media platform created with Laravel and VueJS.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['laravel', 'laravel instagram clone', 'laragram', 'instagram', 'php', 'mysql', 'postgresql'],
            'canonical'    => Url::current(), // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Laragram | Social Media', // set false to total remove
            'description' => 'Laragram is a social media platform created with Laravel and VueJS.', // set false to total remove
            'url'         => Url::current(), // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'site_name'   => config('app.name'),
            'images'      => [Storage::url('images/laragram.jpg')],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary_large_image',
//            'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Laragram | Social Media', // set false to total remove
            'description' => 'Laragram is a social media platform created with Laravel and VueJS.', // set false to total remove
            'url'         => Url::current(), // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [Storage::url('images/laragram.jpg')],
        ],
    ],
];
