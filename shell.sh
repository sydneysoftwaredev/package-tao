#!/usr/bin/env bash

docker run -it --rm --mount src=`pwd`,target=/app,type=bind --workdir /app joeniland/laravel-ci:8.1-20240612 $@