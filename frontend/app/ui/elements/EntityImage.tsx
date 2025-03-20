import Image from "next/image";
import { IMAGE_URL } from "@/app/lib/config";

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
                                width = "w-full md:w-[350px]",
                                height = "h-[250px]",
                                className = "",
                                imageType = 'cover'
                            }: EntityImageProps) {
    const imageUrl = coverUrl
        ? `${IMAGE_URL}${coverUrl}`
        : `/images/${categoryName}/${id}/${imageType}.jpg`;

    return (
        <div className={`relative ${width} ${height} shrink-0 ${className}`}>
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