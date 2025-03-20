import Image from "next/image";
import { IMAGE_URL } from "@/app/lib/config";

interface TwitchAccountProps {
    twitchUrl?: string | null;
    className?: string;
}

export function TwitchAccount({ twitchUrl, className = "mt-3" }: TwitchAccountProps) {
    if (!twitchUrl) return null;

    return (
        <p className={className}>
            <a
                href={twitchUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="inline-block"
            >
                <Image
                    src={`${IMAGE_URL}/uploads/images/assets/twitch-logo.png`}
                    alt="User Twitch Account"
                    width={50}
                    height={69}
                />
            </a>
        </p>
    );
}