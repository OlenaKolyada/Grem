#!/bin/bash
set -e

# Установка зависимостей, если vendor не существует
if [ ! -d ./vendor ]; then
    composer install --no-interaction
fi

# Запуск сервера Apache
apache2-foreground