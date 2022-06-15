![Art Institute of Chicago](https://raw.githubusercontent.com/Art-Institute-of-Chicago/template/master/aic-logo.gif)

# artic.edu
> The code that runs the main website of the Art Institute of Chicago

This repository is all the code that runs [artic.edu](https://www.artic.edu/). With artworks in our collection, exhibitions, events, articles, and more, artic.edu is the main home for our museum's presence on the web. Take a look through our code, let us know if you have any questions, and feel free to use any portion of our code you like.

In production since 2018, our website is actively maintained by a team of developers, product managers, and system administrators at the Art Institute of Chicago. See our [contributors](CONTRIBUTORS.md) for more details.



## Overview

Our website is a Laravel website built with the Twill CMS. This repo includes all frontend, the Twill CMS, and an API.

Portions of the website rely heavily on our [API](https://api.artic.edu). Check out a [talk](https://www.youtube.com/watch?v=bGXh5qkOjnQ) and a [paper](https://mw19.mwconf.org/paper/building-a-data-hub-microservices-apis-and-system-integration-at-the-art-institute-of-chicago/) describing our API's architecture, and browse the [code](https://github.com/orgs/art-institute-of-chicago/repositories?q=data-*&type=&language=&sort=) that powers our API.



## Requirements

* PHP 7.3
* Node 8.17.0
* NPM 6.13.0
* PostgreSQL 11.*
* Homestead 12.*
* krpano 1.12.* (for virtual tour blocks)



## Installing

### Homestead

For local development, we run our website in a [Homestead](https://laravel.com/docs/master/homestead) environment which provides all the software required to run the website.

* Rename `Homestead.sample.yaml` to `Homestead.yaml`.
* Update `folders.map` in `Homestead.yaml` with your local path to the website repository.
* If you have another vagrant machine running at the same IP as the one at the top of `Homestead.yaml`, change it.
* Run `composer install` to install composer dependencies. This step should typically be done inside the VM, but in order to get the VM running, you may need to install the dependencies from outside the VM.
* Run `homestead up` to provision your vagrant machine.
* In case the system didn't update your `/etc/hosts` file automatically:
  * Add the IP and domain defined at `Homestead.yaml` to your local `/etc/hosts` file.

Once Homestead is set up, then install the website code itself:

* Run `homestead ssh` to ssh into the VM.
* `cd` into the project folder in `/home/vagrant/artic.edu`.
* Run `composer install` inside the VM to ensure dependencies are installed.
* Copy `.env.example` as `.env` and update with your local settings (if necessary).
* Run `php artisan key:generate` to generate your application key.
* Run `php artisan migrate` to migrate the database schema.
* Run `php artisan twill:superadmin` to create a superadmin user.
* Build all necessary Twill assets: `php artisan twill:build`
* Access the frontend at http://{your_dev_domain}.
* Access the CMS at http://admin.{your_dev_domain}.

### krpano
In order to use the virtual tour blocks, you will need to put the `tour.js` file in place from the krpano library. To do so, [download krpano](https://krpano.com/download/). Follow the instructions to install the package, and look for `viewer/krpano.js` among the files. Copy `krpano.js` to the `public/virtual-tours` directory in this project and rename it to `tour.js`.

## Developing

### Frontend

There are NPM packages required by the frontend of the website. To install them initially run:

```bash
npm ci
npm run build
```

For continuous work, run the following which runs as a `watch` command on locally changed JS and SCSS files:

```bash
npm run dev
```

We recommend using [nvm](https://github.com/nvm-sh/nvm) or another node version manager to install exactly the node version listed in the requirements.


### CMS

To compile all that is needed by the CMS, run:

```bash
php artisan twill:build
```


### Style guide

Run this command to generate a style guide that will be served from http://{your_dev_domain}/styleguide

```bash
npm run toolkit
```


### Upgrading Twill

Update the version of Twill in `composer.json`. Then to avoid composer running into memory issues, run:

```bash
php -d memory_limit=-1 `which composer` update area17/twill --with-dependencies --optimize-autoloader
```

There are usually local files that need updating to reflect the latest version. Look through the "Files changed" of a diff between versions in the Twill codebase: https://github.com/area17/twill/compare/2.3.0...2.4.0.

Once ready, run:

```bash
php artisan twill:update
php artisan twill:build
```


### More documentation

We've developed detailed descriptions of a few key aspects of our website codebase:

* [API models](docs/apiModels.md): How we've developed Eloquent-style model classes that are backed by our API
* [Images](docs/images.md): How to use images in the various types of models in our codebase

## Testing

The website unit tests are configured to run with its own PostgreSQL database out of the box,
see [.env.testing](.env.testing). You'll need to create a database `testing` in your local
DB environment and run the following before you run any tests:

```
php artisan migrate:fresh --env=testing
```

## Contributing

We welcome your contributions. Please fork this repository and make your changes in a separate branch. To better understand how we organize our code, please review our [version control guidelines](https://docs.google.com/document/d/1B-27HBUc6LDYHwvxp3ILUcPTo67VFIGwo5Hiq4J9Jjw).

```bash
# Clone the repo to your computer
git clone git@github.com:your-github-account/website.git

# Enter the folder that was created by the clone
cd website

# Install

# Start a feature branch
git checkout -b feature/good-short-description

# ... make some changes, commit your code

# Push your branch to GitHub
git push origin feature/good-short-description
```

Then on github.com, create a Pull Request to merge your changes into our `develop` branch.

This project is released with a Contributor Code of Conduct. By participating in this project you agree to abide by its [terms](CODE_OF_CONDUCT.md).

We welcome bug reports and questions under GitHub's [Issues](issues). For other concerns, you can reach our engineering team at [engineering@artic.edu](mailto:engineering@artic.edu)



## Acknowledgments

Thank you to everyone who has ever contributed to our website project! We appreciated all contributions, big and small. Learn more about who has worked on this project in our [contributors](CONTRIBUTORS.md) doc.



## Licensing

This project is licensed under the [GNU Affero General Public License Version 3](LICENSE).
