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
- Copy `.env.example` as `.env` and update with your local settings (if necessary).
- Generate your application key: `php artisan key:generate`
- Migrate the database schema: `php artisan migrate`
- Create a superadmin user: `php artisan cms-toolkit:superadmin`
- Seed the database: `php artisan db:seed`
- Access the CMS [here](http://admin.aic.dev.a17.io/login).
- Access Templates Here [here](http://admin.aic.dev.a17.io/templates/home).

#### Frontend assets (To be defined)

```
$ npm install
```

If you've never used Gulp, you'll likely need the CLI:

```
npm install gulp-cli
```

And then for initial compile:

```
$ gulp build
```

Or for continuous work, with 'watch' task running, just:

```
$ gulp
```

To generate UI toolkit pages:

```
$ gulp toolkit
```
