#!/bin/bash

MODE="$1"
PROD="prod"
DEV="dev"

if [ ! -f .env ]; then
  echo "Creating .env file from .env.example"
  cp .env.example .env
fi

if [ ! -d "www" ]; then
  echo "Creating the www directory"
  mkdir www
fi

if [ $MODE = $PROD ]; then
  echo "Running Production Containers"
  docker-compose down && \ 
  docker-compose build --force-rm --compress && \ 
  docker-compose -f docker-compose.yml up -d
elif [ $MODE = $DEV ]; then
  echo "Running Development Containers"
  docker-compose down && \ 
  docker-compose build --force-rm --compress && \ 
  docker-compose up -d
else
  echo "Provide a build environment(dev/prod)."
fi
