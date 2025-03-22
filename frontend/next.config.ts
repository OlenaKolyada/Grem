import type { NextConfig } from "next";

const nextConfig: NextConfig = {
    images: {
        unoptimized: true,
        remotePatterns: [
            {
                protocol: 'http',
                hostname: '127.0.0.1',
                port: '8001'
            },
            {
                protocol: 'http',
                hostname: 'localhost',
                port: '8001'
            }
        ]
    }
};

export default nextConfig;