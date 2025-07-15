<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Namespace
    |--------------------------------------------------------------------------
    |
    | This value is the namespace of your application.
    |
     */
    'namespace' => 'App',

    /*
    |--------------------------------------------------------------------------
    | Application Admin URL
    |--------------------------------------------------------------------------
    |
    | This value is the URL of your admin application.
    |
     */
    'admin_app_url' => env('ADMIN_APP_URL', 'twill.' . env('APP_URL')),
    'admin_app_path' => env('ADMIN_APP_PATH', ''),


    /*
    |--------------------------------------------------------------------------
    | Application strict url handling
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will enable strict domain handling.
    |
     */
    'admin_app_strict' => env('ADMIN_APP_STRICT', false),

    /*
    |--------------------------------------------------------------------------
    | Application Admin Route Name
    |--------------------------------------------------------------------------
    |
    | This value is added to the admin route names of your Admin application.
    |
    */
    'admin_route_name_prefix' => env('ADMIN_ROUTE_NAME_PREFIX', 'twill.'),

    /*
    |--------------------------------------------------------------------------
    | Application Admin Title Suffix
    |--------------------------------------------------------------------------
    |
    | This value is added to the title tag of your Admin application.
    |
     */
    'admin_app_title_suffix' => env('ADMIN_APP_TITLE_SUFFIX', 'Admin'),

    /*
    |--------------------------------------------------------------------------
    | Admin subdomain routing support
    |--------------------------------------------------------------------------
    |
    | Enabling this allows adding top level keys to Twill's navigation and
    | dashboard modules configuration, mapping to a subdomain.
    | This is a very simple way to implement multi-tenant CMS/sites in Twill.
    | A navigation array looking like the following would expose your CMS on
    | the 'twill.subdomain1.app-url.test' and 'twill.subdomain2.app-url.test'
    | urls, with its corresponding links.
    | [
    |   'subdomain1' => [
    |     'module1' => [...],
    |     ...
    |   ],
    |   'subdomain2' => [
    |     'module2' => [...]
    |     ...
    |   ]
    | ]
    |
    | App name can be set per subdomain using the 'twill.app_names'
    | configuration array. For our example above:
    | [
    |   'app_names' => [
    |     'subdomain1' => 'App 1 name',
    |     'subdomain2' => 'App 2 name',
    |   ],
    | ]
    |
    | Subdomain configuration nesting also applies to the dashboard
    | 'modules' key.
    |
    | You can provide a custom 'block_single_layout' per subdomain by
    | creating a Blade file under resources/views/subdomain/layouts/blocks.
    |
     */
    'support_subdomain_admin_routing' => false,
    'admin_app_subdomain' => 'admin',
    'active_subdomain' => null,

    /*
    |--------------------------------------------------------------------------
    | Application Admin Route and domain pattern
    |--------------------------------------------------------------------------
    |
    | This value add some patterns for the domain and routes of the twill.
    |
     */
    'admin_route_patterns' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Prevent the routing system to duplicate prefix and module on route names
    |--------------------------------------------------------------------------
    |
     */
    'allow_duplicates_on_route_names' => true,

    /*
    |--------------------------------------------------------------------------
    | Twill middleware group configuration
    |--------------------------------------------------------------------------
    |
    | Right now this only allows you to redefine the default login redirect path.
    |
     */
    'admin_middleware_group' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Twill default tables naming configuration
    |--------------------------------------------------------------------------
    |
    | TODO: In Twill 3.0, all tables will be prefixed by `twill_`.
    |
     */
    'blocks_table' => 'blocks',
    'features_table' => 'features',
    'fileables_table' => 'fileables',
    'files_table' => 'files',
    'mediables_table' => 'mediables',
    'medias_table' => 'medias',
    'password_resets_table' => 'password_reset_tokens',
    'related_table' => 'related',
    'settings_table' => 'settings',
    'tagged_table' => 'tagged',
    'tags_table' => 'tags',
    'users_oauth_table' => 'twill_users_oauth',
    'users_table' => 'users',
    'permissions_table' => 'permissions',
    'roles_table' => 'roles',

    /*
    |--------------------------------------------------------------------------
    | Twill migrations configuration
    |--------------------------------------------------------------------------
    |
    | Since Laravel 5.8, migrations generated by Laravel use big integers
    | on the `id` column. Twill migrations helpers can be configured to
    | use regular integers for backwards compatiblity.
    |
     */
    'migrations_use_big_integers' => true,

    /*
    |
    | Since Twill 2.0, migrations are not published anymore but loaded
    | automatically in Twill's service provider. Set to false to prevent
    | this from happening if you need to customize Twill's tables.
    |
     */
    'load_default_migrations' => true,

    /*
    |--------------------------------------------------------------------------
    | Twill Auth related configuration
    |--------------------------------------------------------------------------
    |
     */
    'auth_login_redirect_path' => null,

    'templates_on_frontend_domain' => true,

    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY'),

    'custom_auth_service_provider' => false,



    /*
    |--------------------------------------------------------------------------
    | Twill FE Application configuration
    |--------------------------------------------------------------------------
    |
     */
    'js_namespace' => 'TWILL',
    'dev_mode' => (bool) env('TWILL_DEV_MODE', false),
    'dev_mode_url' => env('TWILL_DEV_MODE_URL', 'http://localhost:8080'),
    'public_directory' => env('TWILL_ASSETS_DIR', 'assets/twill'),
    'manifest_file' => 'twill-manifest.json',
    'vendor_path' => 'vendor/area17/twill',
    'custom_components_resource_path' => 'assets/js/components',
    'vendor_components_resource_path' => 'assets/vendor/js/components',
    'build_timeout' => 300,

    'internal_icons' => [
        'content-editor.svg',
        'close_modal.svg',
        'edit_large.svg',
        'google-sign-in.svg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Twill app locale
    |--------------------------------------------------------------------------
    |
     */
    'locale' => 'en',
    'fallback_locale' => 'en',

    'locales' => [
        'en' => 'English',
        'es' => 'Spanish',
    ],

    'available_user_locales' => [
        'en',
        'ar',
        'bs',
        'cs',
        'de',
        'es',
        'fr',
        'it',
        'nl',
        'no',
        'pl',
        'pt',
        'ru',
        'sl',
        'tr',
        'uk',
        'zh-Hans',
    ],

    /*
    |--------------------------------------------------------------------------
    | When a singleton is not seeded, you can use this flag to automatically seed it.
    |--------------------------------------------------------------------------
    */
    'auto_seed_singletons' => true,

    /*
    |--------------------------------------------------------------------------
    | The default crops that can be used in models. These can be extended by
    | a model specific $mediasParams property, or by overriding the getMediasParams
    | method.
    |--------------------------------------------------------------------------
    */
    'default_crops' => [
        'cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
            'flexible' => [
                [
                    'name' => 'free',
                    'ratio' => 0,
                ],
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
                [
                    'name' => 'portrait',
                    'ratio' => 3 / 5,
                ],
            ],
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | This parameter will enable some debug views:
    | - Shows an error if a view is missing in the editor/front-end
    |--------------------------------------------------------------------------
    */
    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | This parameter will throw errors if some error occurs instead of failing
    | silently (eg. when rendering blocks)
    |--------------------------------------------------------------------------
    */
    'strict' => env('TWILL_STRICT', false),

    /*
    |--------------------------------------------------------------------------
    | Base classes for automatic generation of Modules and Capsules
    |--------------------------------------------------------------------------
    |
     */
    'base_model' => A17\Twill\Models\Model::class,

    'base_translation_model' => A17\Twill\Models\Model::class,

    'base_slug_model' => A17\Twill\Models\Model::class,

    'base_revision_model' => A17\Twill\Models\Revision::class,

    'base_repository' => A17\Twill\Repositories\ModuleRepository::class,

    'base_controller' => A17\Twill\Http\Controllers\Admin\ModuleController::class,

    'base_nested_controller' => A17\Twill\Http\Controllers\Admin\NestedModuleController::class,

    'base_singleton_controller' => A17\Twill\Http\Controllers\Admin\SingletonModuleController::class,

    'base_request' => A17\Twill\Http\Requests\Admin\Request::class,

    /*
    |--------------------------------------------------------------------------
    | Non-standard configurations
    |--------------------------------------------------------------------------
    |
     */
    'bind_exception_handler' => false,

    'buckets' => [
        'homepage' => [
            'name' => 'Home',
            'buckets' => [
                'home_main_features' => [
                    'name' => 'Home main feature',
                    'bucketables' => [
                        [
                            'module' => 'homeFeatures',
                            'name' => 'Home Features',
                        ],
                    ],
                    'max_items' => 5,
                ],
                'home_art_and_ideas' => [
                    'name' => 'The Collection',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'highlights',
                            'name' => 'Highlights',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 6,
                ],
            ],
        ],

        'art_and_ideas' => [
            'name' => 'The Collection',
            'buckets' => [
                'art_and_ideas_main_features' => [
                    'name' => 'The Collection featured articles',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 2,
                ],
            ],
        ],
    ],

    'imgix_source_host' => env('IMGIX_SOURCE_HOST', 'artic-web.imgix.net'),

    'media_library' => [
        'disk' => 'twill_media_library',
        'endpoint_type' => env('MEDIA_LIBRARY_ENDPOINT_TYPE', 's3'),
        'cascade_delete' => env('MEDIA_LIBRARY_CASCADE_DELETE', false),
        'local_path' => env('MEDIA_LIBRARY_LOCAL_PATH', 'uploads'),
        'image_service' => env('MEDIA_LIBRARY_IMAGE_SERVICE', 'A17\Twill\Services\MediaLibrary\Imgix'),
        'acl' => env('MEDIA_LIBRARY_ACL', 'private'),
        'filesize_limit' => env('MEDIA_LIBRARY_FILESIZE_LIMIT', 50),
        'allowed_extensions' => ['svg', 'jpg', 'gif', 'png', 'jpeg', 'mp4'],
        'init_alt_text_from_filename' => true,
        'prefix_uuid_with_local_path' => config('twill.file_library.prefix_uuid_with_local_path', false),
        'translated_form_fields' => false,
        'show_file_name' => false,

        /*
        |--------------------------------------------------------------------------
        | Wysiwyg options for the caption field.
        |--------------------------------------------------------------------------
        */
        'media_caption_use_wysiwyg' => false,
        'media_caption_wysiwyg_options' => [
            'modules' => [
                'toolbar' => [
                    'bold',
                    'italic',
                ],
            ],
        ],
    ]
];
