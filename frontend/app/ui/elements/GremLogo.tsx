// app/ui/elements/GremLogo.tsx

import Link from 'next/link';
import { API_URL } from "@/app/lib/config/constants";

export function GremLogo() {
    return (
        <div className={`flex flex-row items-center leading-none text-white`}>
            <Link href="/">
                <img
                    src={`${API_URL}/uploads/images/assets/logo.png`}
                    alt="Grem Logo"
                    width={100}
                    height={69}
                    style={{ objectFit: 'contain' }}
                />
            </Link>
        </div>
    );
}