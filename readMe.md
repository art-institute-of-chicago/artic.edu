![Art Institute of Chicago](https://raw.githubusercontent.com/Art-Institute-of-Chicago/template/master/aic-logo.gif)

# artic.edu
> The code that runs the main website of the Art Institute of Chicago

This repository is all the code that runs artic.edu. With artworks in our collection, exhibitions, events, articles, and more, artic.edu is the main home for our museum's presence on the web. Take a look through our code, let us know if you have any questions, and feel free to use any portion of our code you like.

In production since 2018, our website is actively maintained by a team of developers, product managers and system administrators at the Art Institute of Chicago. See our [contributors](CONTRIBUTORS.md) for more details.

## Overview

Our website is a Laravel website built with the Twill CMS. This repo includes all frontend, the Twill CMS, and an API.

Portions of the website rely heavily on our [API](https://api.artic.edu). Check out a [talk](https://www.youtube.com/watch?v=bGXh5qkOjnQ) and a [paper](https://mw19.mwconf.org/paper/building-a-data-hub-microservices-apis-and-system-integration-at-the-art-institute-of-chicago/) describing our API's architecture, and browse the [code](https://github.com/orgs/art-institute-of-chicago/repositories?q=data-*&type=&language=&sort=) that powers our API.

## Requirements

* PHP 7.1
* Node 8.17.0
* NPM 6.13.0
* PostgreSQL 11.*
* Homestead 12.*
## Installing

For local development, we run our website in a [Homestead](https://laravel.com/docs/master/homestead) environment which provides all the software required to run the website.

* Rename `Homestead.sample.yaml` to `Homestead.yaml`
* Update `folders.map` in `Homestead.yaml` with your local path to the website repository
* Change the IP at the top if you have another vagrant machine running at the same IP
* Install composer dependencies `composer install`. This step should typically be done inside the VM, but in order to get the VM running you need to install the dependencies from outwside the VM.
* Provision your vagrant machine with `homestead up`
* In case the system didn't update your `/etc/hosts` file automatically:
  * Add the IP and domain defined at `Homestead.yaml` to your `/etc/hosts` file.

Once Homestead is set up, then install the website code itself:

* Hop into the VM with `homestead ssh` and cd into the aic folder in `/home/vagrant/aic`
* Ensure dependencies are installed with `composer install`
* Copy `.env.example` as `.env` and update with your local settings (if necessary).
* Generate your application key: `php artisan key:generate`
* Migrate the database schema: `php artisan migrate`
* Create a superadmin user: `php artisan twill:superadmin`
* Seed the database: `php artisan db:seed`
* Build all necessary Twill assets: `php artisan twill:build`
* Access the frontend at http://{your_dev_domain}.
* Access the CMS at http://admin.{your_dev_domain}.

## Developing
### Frontend

There are NPM packages required by the frontend of the website. To install them initially run:

```
$ npm install
$ npm run build
```

For continuous work, run the following which runs as a `watch` command on locally changed JS and SCSS files:

```
$ npm run dev
```

### CMS

To compile all that is needed by the CMS, run:

```
php artisan twill:build
```

### Style guide

Run this command to generate a style guide that will be served from http://{your_dev_domain}/styleguide

```
$ npm run toolkit
```

### Upgrading Twill

Update the version of Twill in `composer.json`. Then to avoid composer running into memory issues, run:

```
php -d memory_limit=-1 `which composer` update area17/twill --with-dependencies --optimize-autoloader
```

There are usually local files that need updating to reflect the latest version. Look through the "Files changed" of a diff between versions in the Twill codebase: https://github.com/area17/twill/compare/2.3.0...2.4.0.

Once ready, run:

```
php artisan twill:update
php artisan twill:build
```
### API models

For a description of how we've developed Eloquent-style model classes that are backed by our API, please refer to [docs/apiModels.md](docs/apiModels.md)

### Images

For an overview of how to use images in the various types of models in our codebsae, please refer to [docs/images.md](docs/images.md)
