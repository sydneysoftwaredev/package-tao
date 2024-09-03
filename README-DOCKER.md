# Docker Setup

After cloning <https://github.com/oat-sa/package-tao>, do the following:

1. `docker compose up -d`
2. `./shell.sh composer install`
3. Run install script in app container:

    ```shell
    docker exec -it --user www-data tao_phpfpm php tao/scripts/taoInstall.php \
    --db_driver pdo_mysql \
    --db_host tao_db \
    --db_name tao \
    --db_user tao \
    --db_pass tao \
    --file_path /var/www/html \
    --module_namespace http://sample/first.rdf \
    --module_url http://tao.localhost \
    --instance_name tao \
    --user_login admin \
    --user_pass admin \
    -vvv -e taoCe
    ```

4. Access site at `http://tao.localhost`

## To add extensions

```shell
docker run -it --rm --mount src=`pwd`,target=/app,type=bind --workdir /app joeniland/laravel-ci:8.1-20240612 composer require oat-sa/extension-tao-devtools --dev 
```
