

# Ajutam - Aplicatie management voluntari


## Getting started

### Installing
#### Manual

```bash
# Clone the project and run composer
composer install
cd laravue

# Migration and DB seeder (after changing your DB settings in .env)
php artisan migrate --seed

# Install passport
php artisan passport:install

# Install dependency with NPM
npm install

# develop
npm run dev # or npm run watch

# Build on production
npm  run production
```

#### Docker
```sh
docker-compose up -d
```
Run database migration and seed within Docker container
```sh
# Get laravel docker container ID from containers list
docker ps

docker exec -it <container ID> php artisan migrate --seed 
# Where <container ID> is the "laravel" container name, ex: docker_laravel_1
```

`npm` commands are also supported:
```sh
docker exec -it <container ID> npm run watch 
# Where <container ID> is the "laravel" container name, ex: docker_laravel_1
...
```

## Running the tests
* Tests system is under development

## Deployment and/or CI/CD
This project uses [Envoy](https://laravel.com/docs/5.8/envoy) for deployment, and [GitLab CI/CD](https://about.gitlab.com/product/continuous-integration/). Please check `Envoy.blade.php` and `.gitlab-ci.yml` for more detail.

## Built with
* [Laravel](https://laravel.com/) - The PHP Framework For Web Artisans
* [VueJS](https://vuejs.org/) - The Progressive JavaScript Framework
* [Element](https://element.eleme.io/) - A  Vue 2.0 based component library for developers, designers and product managers
* [Vue Admin Template](https://github.com/PanJiaChen/vue-admin-template) - A minimal vue admin template with Element UI


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details.

