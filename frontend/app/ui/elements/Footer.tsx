// app/ui/elements/Footer.tsx
import Image from 'next/image';
import { API_URL } from "@/app/lib/config/config";

export function Footer() {
    return (
        <div className="md:ml-0 bg-gray-100 rounded-lg mt-auto py-3">
            <div className="flex flex-col items-center mt-3">
                <Image
                    src={`${API_URL}/uploads/images/assets/funkycorgi.png`}
                    alt="Funky Corgi"
                    width={50}
                    height={50}
                />
                <p className="text-xl mt-1 text-stone-800 md:text-xs md:leading-normal">
                    &copy; 2024-2025 Funky Corgi
                </p>
            </div>
        </div>
    );
}