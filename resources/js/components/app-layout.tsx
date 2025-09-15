import React from 'react';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppHeader } from '@/components/app-header';
import { AppContent } from '@/components/app-content';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { type BreadcrumbItem } from '@/types';

interface AppLayoutProps {
    children: React.ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default function AppLayout({ children, breadcrumbs }: AppLayoutProps) {
    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <div className="flex flex-1 flex-col">
                <AppHeader />
                <AppContent>
                    {breadcrumbs && <Breadcrumbs breadcrumbs={breadcrumbs} />}
                    <main className="flex-1">
                        {children}
                    </main>
                </AppContent>
            </div>
        </AppShell>
    );
}