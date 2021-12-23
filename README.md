# hello

## Setup

### Clone this project.
> git clone git@github.com:jigarakatidus/hello.git

### Install Dependency
> docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs

### Start Services
> ./vendor/bin/sail up

### Run Migrations with Seed
> ./vendor/bin/sail artisan migrate --seed
