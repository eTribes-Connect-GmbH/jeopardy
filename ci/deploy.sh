#!/usr/bin/env bash

echo "Sync to server"
rsync -avz --exclude="var" --exclude="ci" --exclude=".git" --exclude=".idea" ../. skillz:/var/www/virtual/skillz
rsync -avz --exclude="var" --exclude="ci" --exclude=".git" --exclude=".idea" ../.env.prod skillz:/var/www/virtual/skillz/.env
ssh skillz 'cd /var/www/virtual/skillz && ./bin/console cache:clear'
