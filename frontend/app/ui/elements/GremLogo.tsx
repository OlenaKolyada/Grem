// app/ui/elements/GremLogo.tsx

import Image from 'next/image';
import Link from 'next/link';
import { IMAGE_URL, BASE_URL } from "@/app/lib/config";

export function GremLogo() {
    return (
        <div className={`flex flex-row items-center leading-none text-white`}>
            <Link href={BASE_URL}>
                <Image
                    src={`${IMAGE_URL}/uploads/images/assets/logo.png`}
                    alt="Grem Logo"
                    width={100}
                    height={69}
                />
            </Link>
        </div>
    );
}