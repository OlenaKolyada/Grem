// app/components/menu/SideMenuUi.tsx

import { NavLinksUi } from '@/app/components/menu';

const sideMenuUiStyles = {
    link: 'hidden md:flex h-[48px] max-w-[192px] grow items-center justify-start gap-2 ' +
        'rounded-md p-3 text-sm font-medium md:flex-none md:justify-start md:p-2 md:px-3',
    activeLink: '',
    text: 'md:block pl-3',
};

export function SideMenuUi() {
    return (
        <div className="flex h-full flex-col px-1 py-4 md:px-2">
            <div className="flex grow flex-row space-x-2 md:flex-col md:space-x-0 ">
                <NavLinksUi
                    styles={sideMenuUiStyles}

                />
            </div>
        </div>
    );
}