import Image from "next/image";
import { API_URL } from "@/app/lib/config/config";

interface EntityImageProps {
    id: number | undefined;
    categoryName: string;
    title?: string;
    coverUrl?: string;
    width?: string;
    height?: string;
    className?: string;
    imageType?: 'cover' | 'avatar'; // Новый параметр
}

export function EntityImage({
                                id,
                                categoryName,
                                title,
                                coverUrl,
                                width = "w-full sm:w-2/5 md:w-[300px] lg:w-[250px]",
                                height = "h-[250px]",
                                className = "",
                                imageType = 'cover'
                            }: EntityImageProps) {
    const imageUrl = coverUrl
        ? `${API_URL}/${coverUrl}`
        : `${API_URL}//uploads/images/${categoryName}/${id}/${imageType}.jpg`;

    return (
        <div className={`relative ${width} ${height} shrink-0 overflow-hidden ${className}`}>
            <Image
                src={imageUrl}
                alt={title ?? ''}
                fill
                className="object-cover object-center rounded-lg"
                sizes="(max-width: 768px) 100vw, 400px"
            />
        </div>
    );
}