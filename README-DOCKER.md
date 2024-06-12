# Docker Setup

1. `docker-compose up -d`
2. Run install script in app container:

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

3. Access site at `http://tao.localhost`
