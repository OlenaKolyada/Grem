'use client';

import { GremLogo } from '@/app/ui/elements';
import { TopMenuContainer } from '@/app/components/menu';
import { BG_DARK_BLUE } from '@/app/ui/theme/colors';

export function Header() {

    return (
        <div className={`flex justify-between items-center p-6 h-32 ${BG_DARK_BLUE} text-white`}>
            <GremLogo/>
            <div className="flex items-center gap-4">
                <TopMenuContainer/>
            </div>
        </div>
    );
}