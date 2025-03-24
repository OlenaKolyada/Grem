// app/lib/config/config.ts

export const CORE_ENTITIES = ['game', 'news', 'review'];
export const META_ENTITIES = ['developer', 'genre', 'platform', 'publisher', 'tag'];

// Определяем разные URL для клиента и сервера
export const CLIENT_API_URL = process.env.NEXT_PUBLIC_API_URL;
export const SERVER_API_URL = process.env.SERVER_API_URL || process.env.NEXT_PUBLIC_API_URL;

// Функции для определения окружения
export const isServer = typeof window === 'undefined';
export const isDevEnvironment = process.env.NODE_ENV === 'development';

// Выбираем правильный URL исходя из условий:
// 1. На сервере в production используем SERVER_API_URL
// 2. В остальных случаях (клиент или dev) используем CLIENT_API_URL
export const API_URL = isServer && !isDevEnvironment
    ? SERVER_API_URL
    : CLIENT_API_URL;

// Для отладки
if (isDevEnvironment) {
    console.log('Dev environment detected');
    console.log('API URL:', API_URL);
    console.log('Is server:', isServer);
}

export const API_CONFIG = {
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
};