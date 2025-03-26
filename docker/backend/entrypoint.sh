#!/bin/bash
set -e

# Установка зависимостей, если vendor не существует
if [ ! -d ./vendor ]; then
    composer install --no-interaction
    php bin/console assets:install --symlink
fi

# Запуск сервера Apache
apache2-foreground