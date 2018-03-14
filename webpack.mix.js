let mix = require('laravel-mix');

if (mix.inProduction()) {
  mix.copyDirectory('vendor/a17/laravel-cms-toolkit/public/assets/admin/fonts', 'public/assets/admin/fonts');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/icons/icons.svg', 'public/assets/admin/icons/icons.svg');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/icons/icons-files.svg', 'public/assets/admin/icons/icons-files.svg');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/css/app.css', 'public/assets/admin/css/app.css');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/js/main-dashboard.js', 'public/assets/admin/js/main-dashboard.js');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/js/main-listing.js', 'public/assets/admin/js/main-listing.js');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/js/main-form.js', 'public/assets/admin/js/main-form.js');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/js/main-buckets.js', 'public/assets/admin/js/main-buckets.js');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/js/manifest.js', 'public/assets/admin/js/manifest.js');
  mix.copy('vendor/a17/laravel-cms-toolkit/public/assets/admin/js/vendor.js', 'public/assets/admin/js/vendor.js');
  mix.version();
} else {
  mix.copyDirectory('vendor/a17/laravel-cms-toolkit/public', 'public');
}
