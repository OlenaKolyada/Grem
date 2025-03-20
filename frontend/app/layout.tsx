// app/layout.tsx
import type { Metadata } from 'next';
import '@/app/ui/styles/global.css';
import { roboto } from '@/app/ui/fonts/fonts';
import { Header, Footer } from '@/app/ui/elements';
import { Providers } from '@/app/providers';
import { SideMenuContainer } from "@/app/components/menu";


export const metadata: Metadata = {
    description: 'Video game\'s news and reviews',
    title: 'Grem | Video game\'s news and reviews',
};

export default function RootLayout({
                                       children,
                                   }: {
    children: React.ReactNode;
}) {

    return (
        <html lang="en">
        <body className={`${roboto.className} antialiased min-h-screen flex flex-col`}>
        <Providers>
            <div className="flex flex-col flex-grow">
                <Header/>
                <div className="flex flex-grow min-h-0">
                    <SideMenuContainer/>
                    <main className="flex-grow flex flex-col ">{children}</main>
                </div>
            </div>
            <Footer/>
        </Providers>
        </body>
        </html>
    );
}