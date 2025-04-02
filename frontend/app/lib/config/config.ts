// app/lib/config/config.ts

export const CORE_ENTITIES = ['game', 'news', 'review'];
export const META_ENTITIES = ['developer', 'genre', 'platform', 'publisher', 'tag'];

export const API_URL = process.env.NEXT_PUBLIC_API_URL

console.log('NEXT_PUBLIC_API_URL', process.env.NEXT_PUBLIC_API_URL);
console.log('API URL:', API_URL);
console.log('Document cookie:', typeof window !== 'undefined' ? document.cookie : 'Not in browser');

export const API_CONFIG = {
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
};