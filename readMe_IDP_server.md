# Art Institute of Chicago - IDP server

This instructions are for testing the integration with an IDP server locally.

It uses a Docker Container built with [SimpleSAMLphp](https://simplesamlphp.org). Based on official PHP7 Apache [images](https://hub.docker.com/_/php/).

#### Prerequisites

- Docker Machine running on your computer.

#### Launching your IDP server

To start the IDP server you need to run:

```
$ docker-compose up
```

Once launched the IDP server can be found on the Docker Machine IP and port 8080.
To find the ip run

```
$ docker-machine env
```

e.g:

```
$ docker-machine env
export DOCKER_TLS_VERIFY="1"
export DOCKER_HOST="tcp://192.168.99.100:2376"
export DOCKER_CERT_PATH="/Users/pablo/.docker/machine/machines/default"
export DOCKER_MACHINE_NAME="default"
# Run this command to configure your shell:
# eval $(docker-machine env)
```

#### Usage.

On the Login form you can add the button with the route('saml_login') as href.
```html
<a href="{{ route('saml_login') }}" class="login__google" tabindex="4">
  <span>Sign in with Google</span>
</a>
```

Your Application needs to be running on the IP 192.168.10.20
And you must be using the localhost as `'http://admin.aic.dev.a17.io/'`
If you change the url alias, make sure that you change it also on the `docker-composer.yml` file

The address of the IDP server can be changed on the `saml2_setting.php` file, also the EntityID

There are two static users configured in the IdP with the following data:

| UID | Username | Password | Group | Email |
|---|---|---|---|---|
| 1 | user1 | user1pass | group1 | user1@example.com |
| 2 | user2 | user2pass | group2 | user2@example.com |


#### TO-DO

- Creating the User when authorized by the IDP on the `EventServiceProvider.php` file
- Implementing the logout with route 'saml_logout'

