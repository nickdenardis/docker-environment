# Example Docker development environment

Local development environment with multiple hosts running through an Nginx proxy

## Set up

1. [Set up an SSH key](https://docs.github.com/en/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent)
1. [Install Docker Desktop](https://www.docker.com/products/docker-desktop)
1. Clone this repository `git clone git@github.com:nickdenardis/docker-environment.git ~/Sites/docker/nginx-proxy`
1. Copy the environment variables `cd ~/Sites/docker/nginx-proxy && cp .env.example .env`
1. Update the environment variables `.env`
1. Install optional aliases `aliases`
1. Install the hosts in `/etc/hosts`

## Create an SSL certificate

Example host `local.dock`

`cd ~/Sites/docker/nginx-proxy/ssl`

```
openssl req -x509 -nodes -new -sha512 \\n  -days 365 -newkey rsa:4096 -keyout ca.key \\n  -out ca.pem -subj "/C=US/CN=MY-CA"
openssl x509 -in ca.pem -text -noout
openssl x509 -outform pem -in ca.pem -out ca.crt
cat > v3.ext <<-EOF\nauthorityKeyIdentifier=keyid,issuer\nbasicConstraints=CA:FALSE\nkeyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment\nsubjectAltName = @alt_names \n[alt_names]\n# Local hosts\nDNS.1 = localhost\nDNS.2 = 127.0.0.1\nDNS.3 = ::1 \n# List your domain names here\nDNS.4 = local.dock\nDNS.5 = *.local.dock\nEOF
openssl req -new -nodes -newkey rsa:4096 \\n  -keyout local.dock.key -out local.dock.csr \\n  -subj "/C=US/ST=Michign/L=Detroit/O=Local/CN=local.dock"
```

## Initial Install

Build the PHP FPM images

`cd ~/Sites/docker/nginx-proxy/`
`docker build -t php-80-fpm:v1 ./php-80-fpm`

Start the Nginx proxy, MariaDB, Redis and the docker network

`cd ~/Sites/docker/nginx-proxy`  
`docker compose up -d`

Start the main and sub sites in one command

`docker-compose -f docker-compose.yml -f php-80/docker/docker-compose.yml up -d`

## Adding additional sites

Go into a sub directory and the docker directory

`cd ~/Sites/docker/nginx-proxy/php-80/docker`  
`docker compose up -d`

Do a composer install

`cd ~/Sites/docker/nginx-proxy/php-80/`  
`docker run --rm -it -v $PWD:/app composer install`

Update the `.env` file with the database and redis information from the `nginx config`

```
DB_CONNECTION=mysql
DB_HOST=example_app-db
DB_PORT=33016
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Install the node modules

`docker run --rm -it -v "$PWD":/usr/src/app -w /usr/src/app node npm install`

Build the site

`docker run --rm -it -v "$PWD":/usr/src/app -w /usr/src/app node npm run dev`

View the sites

`https://php80.local.dock`

## Bringing the site down

`cd ~/Sites/docker/nginx-proxy/php-80/docker`  
`docker compose down`

## Bringing Nginx down

`cd ~/Sites/docker/nginx-proxy`  
`docker compose down`
