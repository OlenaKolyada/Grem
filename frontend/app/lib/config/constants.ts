// app/lib/config/constants.ts

export const CORE_ENTITIES = ['game', 'news', 'review'];
export const META_ENTITIES = ['developer', 'genre', 'platform', 'publisher', 'tag'];

export const API_URL = process.env.NEXT_PUBLIC_API_URL;

export const API_CONFIG = {
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
};