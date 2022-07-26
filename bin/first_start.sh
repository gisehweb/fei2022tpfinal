#!/bin/bash

docker-compose exec backend composer install
docker-compose exec backend chmod 777 ./web/assets -R
docker-compose exec backend chmod 777 ./runtime -R