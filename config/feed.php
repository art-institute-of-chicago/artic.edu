<?php

return [
    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\Models\Article@getAllFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => 'feed',

            'title' => 'Articles',

            'description' => 'The latest articles from the Art Institute of Chicago',

            'language' => 'en-US',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::feed',
        ],
    ],
];
