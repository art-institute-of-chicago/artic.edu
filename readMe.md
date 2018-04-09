# Art Institute of Chicago

This development repository for the AIC build, uses as its foundation the AREA 17 FE boilerplate and the AREA 17 CMS Toolkit.

#### Homestead config

- Rename `Homestead.example.yaml` to `Homestead.yaml`
- Update `folders.map` with your local path to the AIC repository
- Change the IP at the top if you have another vagrant machine running at the same IP
- Install composer dependencies `composer install`. This step should be done inside the VM, but in order to get the VM running you need to install the dependencies. TODO: Solve this egg-chicken issue.
- Provision your vagrant machine with `vagrant up`

In case the system didn't update your /etc/hosts file automatically:

- Add the ip and domain defined at `Homestead.yaml` to your `/etc/hosts` file.


#### Application setup

- Hop into the vm with `vagrant ssh` and cd into the aic folder in `/home/vagrant/aic`
- Ensure dependencies are installed with `composer install`
- You may get an error with mcrypt - Please do the following:
-- sudo apt-get update
-- sudo apt-get install mcrypt php7.1-mcrypt
- Copy `.env.example` as `.env` and update with your local settings (if necessary).
- Generate your application key: `php artisan key:generate`
- Migrate the database schema: `php artisan migrate`
- Create a superadmin user: `php artisan cms-toolkit:superadmin`
- Seed the database: `php artisan db:seed`
- Access the CMS [here](http://admin.aic.dev.a17.io/login).
- Access Templates Here [here](http://admin.aic.dev.a17.io/templates/home).

#### Frontend assets

```
$ npm install
```

If you've never used Gulp, you'll likely need the CLI:

```
npm install gulp-cli
```

And then for initial compile:

```
$ npm run build
```

Or for continuous work, with 'watch' task running, just:

```
$ npm run dev
```

To generate UI toolkit pages:

```
$ npm run toolkit
```

To generate toolkit with 'watch' task running:

```
$ npm run cms-dev
```

To generate UI toolkit:

```
$ npm run cms-prod
```

### Deployment (staging only for now)

**Install Laravel Envoy**
  ```shell
  $ composer global require "laravel/envoy=~1.0"
  ```

**Add in your `~/.ssh/config`**

```
Host aic.stage.a17.io
    Hostname 34.239.185.137
    User web
    IdentityFile ~/.ssh/id_rsa
```

**…then…**

```
$ envoy run deploy
```

On your first deploy, make sure you ran `npm run production` locally at least once.

If you just provisioned a new server, a few preliminary steps are necessary on the server before being able to deploy with Envoy:

- creating a .env file for your Laravel application
```shell
# @ /home/web/www/aic.stage.a17.io/shared/
$ touch .env
# edit it with your favorite cli editor
# leave APP_KEY empty
```

- creating a robots.txt file
```shell
# @ /home/web/www/aic.stage.a17.io/shared/
$ touch robots.txt
# edit it with your favorite cli editor and add:
# User-agent: *
# Disallow: /
# Remove the / once live on prod
```

After you first deploy with Envoy (locally), ssh into the server and run:
```shell
# @ /home/web/www/aic.stage.a17.io/current/
$ php artisan key:generate
```

Redeploy to clear config caches and you should be all set.

To create the superadmin user for the CMS, ssh into the server and run:
```shell
# @ /home/web/www/aic.stage.a17.io/current/
$ php artisan cms-toolkit:superadmin
```

#### API Documentation setup

API is documented via Swagger. Annotations in the source code are parsed and used to generate the Swagger documentation.

**Regenerating the Swagger documentation**

```shell
# @ /home/web/www/aic.stage.a17.io/current/
$ ./vendor/bin/swagger -o storage/api-docs/api-docs.json -e vendor,node_modules
```

Swagger is accessible at:
https://admin.aic.stage.a17.io/api/documentation
