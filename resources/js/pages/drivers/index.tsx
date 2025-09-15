import React from 'react';
import AppLayout from '@/components/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Driver {
    id: number;
    employee_id: string;
    first_name: string;
    last_name: string;
    email: string | null;
    phone: string | null;
    license_number: string;
    license_expiry_date: string;
    date_of_birth: string;
    address: string | null;
    emergency_contact_name: string | null;
    emergency_contact_phone: string | null;
    status: string;
    rating: number | null;
    total_trips: number;
    tenant: {
        name: string;
    };
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    current_page: number;
    from: number;
    last_page: number;
    path: string;
    per_page: number;
    to: number;
    total: number;
}

interface Props {
    drivers: {
        data: Driver[];
        links: PaginationLink[];
        meta: PaginationMeta;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Drivers',
        href: '/drivers',
    },
];

const getStatusColor = (status: string) => {
    switch (status.toLowerCase()) {
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'on_trip':
            return 'bg-blue-100 text-blue-800';
        case 'off_duty':
            return 'bg-yellow-100 text-yellow-800';
        case 'inactive':
            return 'bg-gray-100 text-gray-800';
        case 'suspended':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const formatStatus = (status: string) => {
    return status.split('_').map(word => 
        word.charAt(0).toUpperCase() + word.slice(1)
    ).join(' ');
};

const getRatingStars = (rating: number | null) => {
    if (!rating) return '⭐ No rating';
    const stars = '⭐'.repeat(Math.floor(rating));
    return `${stars} ${rating.toFixed(1)}`;
};

const isLicenseExpiringSoon = (expiryDate: string) => {
    const expiry = new Date(expiryDate);
    const today = new Date();
    const diffDays = Math.ceil((expiry.getTime() - today.getTime()) / (1000 * 3600 * 24));
    return diffDays <= 30 && diffDays > 0;
};

const isLicenseExpired = (expiryDate: string) => {
    const expiry = new Date(expiryDate);
    const today = new Date();
    return expiry < today;
};

export default function DriversIndex({ drivers }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Fleet Drivers" />
            
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">👨‍✈️ Fleet Drivers</h1>
                        <p className="text-gray-600 mt-1">
                            Manage your driver workforce ({drivers.meta.total} drivers)
                        </p>
                    </div>
                    <Link href="/drivers/create">
                        <Button className="bg-blue-600 hover:bg-blue-700">
                            ➕ Add Driver
                        </Button>
                    </Link>
                </div>

                {/* Stats */}
                <div className="grid gap-4 md:grid-cols-4">
                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Active</p>
                                <p className="text-2xl font-bold text-green-600">
                                    {drivers.data.filter(d => d.status === 'active').length}
                                </p>
                            </div>
                            <span className="text-2xl">✅</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">On Trip</p>
                                <p className="text-2xl font-bold text-blue-600">
                                    {drivers.data.filter(d => d.status === 'on_trip').length}
                                </p>
                            </div>
                            <span className="text-2xl">🚗</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Off Duty</p>
                                <p className="text-2xl font-bold text-yellow-600">
                                    {drivers.data.filter(d => d.status === 'off_duty').length}
                                </p>
                            </div>
                            <span className="text-2xl">🏠</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Avg Rating</p>
                                <p className="text-2xl font-bold text-purple-600">
                                    {(drivers.data
                                        .filter(d => d.rating)
                                        .reduce((acc, d) => acc + (d.rating || 0), 0) /
                                    drivers.data.filter(d => d.rating).length || 0).toFixed(1)}
                                </p>
                            </div>
                            <span className="text-2xl">⭐</span>
                        </div>
                    </div>
                </div>

                {/* Drivers Grid */}
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {drivers.data.map((driver) => (
                        <div
                            key={driver.id}
                            className="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow"
                        >
                            {/* Driver Header */}
                            <div className="p-6 border-b border-gray-100">
                                <div className="flex items-center justify-between mb-3">
                                    <div className="flex items-center space-x-3">
                                        <div className="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span className="text-2xl">👤</span>
                                        </div>
                                        <div>
                                            <h3 className="font-semibold text-gray-900">
                                                {driver.first_name} {driver.last_name}
                                            </h3>
                                            <p className="text-sm text-gray-500">
                                                ID: {driver.employee_id}
                                            </p>
                                        </div>
                                    </div>
                                    <span className={`px-3 py-1 rounded-full text-xs font-medium ${getStatusColor(driver.status)}`}>
                                        {formatStatus(driver.status)}
                                    </span>
                                </div>
                                
                                {/* Rating & Trips */}
                                <div className="flex justify-between items-center">
                                    <div className="text-sm">
                                        <span className="text-gray-600">Rating: </span>
                                        <span className="font-medium">
                                            {getRatingStars(driver.rating)}
                                        </span>
                                    </div>
                                    <div className="text-sm">
                                        <span className="text-gray-600">Trips: </span>
                                        <span className="font-bold text-blue-600">{driver.total_trips}</span>
                                    </div>
                                </div>
                            </div>

                            {/* Driver Details */}
                            <div className="p-6 space-y-3">
                                {driver.email && (
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Email</span>
                                        <span className="font-medium truncate ml-2">{driver.email}</span>
                                    </div>
                                )}
                                
                                {driver.phone && (
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Phone</span>
                                        <span className="font-medium">{driver.phone}</span>
                                    </div>
                                )}
                                
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">License</span>
                                    <span className="font-mono text-xs">{driver.license_number}</span>
                                </div>
                                
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">License Expiry</span>
                                    <div className="flex items-center space-x-2">
                                        <span className="font-medium">
                                            {new Date(driver.license_expiry_date).toLocaleDateString()}
                                        </span>
                                        {isLicenseExpired(driver.license_expiry_date) && (
                                            <span className="text-red-500">❌</span>
                                        )}
                                        {isLicenseExpiringSoon(driver.license_expiry_date) && !isLicenseExpired(driver.license_expiry_date) && (
                                            <span className="text-orange-500">⚠️</span>
                                        )}
                                    </div>
                                </div>
                                
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Age</span>
                                    <span className="font-medium">
                                        {new Date().getFullYear() - new Date(driver.date_of_birth).getFullYear()} years
                                    </span>
                                </div>
                                
                                {driver.emergency_contact_name && (
                                    <div className="pt-2 border-t border-gray-100">
                                        <div className="text-xs text-gray-500 mb-1">Emergency Contact:</div>
                                        <div className="text-sm font-medium">{driver.emergency_contact_name}</div>
                                        {driver.emergency_contact_phone && (
                                            <div className="text-sm text-gray-600">{driver.emergency_contact_phone}</div>
                                        )}
                                    </div>
                                )}
                            </div>

                            {/* Action Buttons */}
                            <div className="p-6 pt-0 flex space-x-2">
                                <Link href={`/drivers/${driver.id}`} className="flex-1">
                                    <Button variant="outline" className="w-full text-sm">
                                        👁️ View Profile
                                    </Button>
                                </Link>
                                <Link href={`/drivers/${driver.id}/edit`}>
                                    <Button variant="outline" size="sm">
                                        ✏️ Edit
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Empty State */}
                {drivers.data.length === 0 && (
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">👨‍✈️</div>
                        <h3 className="text-lg font-medium text-gray-900 mb-2">No drivers found</h3>
                        <p className="text-gray-600 mb-6">Get started by adding your first driver to the fleet.</p>
                        <Link href="/drivers/create">
                            <Button className="bg-blue-600 hover:bg-blue-700">
                                ➕ Add First Driver
                            </Button>
                        </Link>
                    </div>
                )}

                {/* License Expiry Warnings */}
                {drivers.data.some(d => isLicenseExpired(d.license_expiry_date) || isLicenseExpiringSoon(d.license_expiry_date)) && (
                    <div className="bg-orange-50 border border-orange-200 rounded-lg p-6">
                        <div className="flex items-center mb-3">
                            <span className="text-2xl mr-3">⚠️</span>
                            <h3 className="text-lg font-semibold text-orange-900">License Alerts</h3>
                        </div>
                        <div className="space-y-2">
                            {drivers.data
                                .filter(d => isLicenseExpired(d.license_expiry_date))
                                .map(driver => (
                                    <div key={driver.id} className="text-sm text-red-800">
                                        <strong>{driver.first_name} {driver.last_name}</strong> - License expired on {new Date(driver.license_expiry_date).toLocaleDateString()}
                                    </div>
                                ))}
                            {drivers.data
                                .filter(d => isLicenseExpiringSoon(d.license_expiry_date) && !isLicenseExpired(d.license_expiry_date))
                                .map(driver => (
                                    <div key={driver.id} className="text-sm text-orange-800">
                                        <strong>{driver.first_name} {driver.last_name}</strong> - License expires on {new Date(driver.license_expiry_date).toLocaleDateString()}
                                    </div>
                                ))}
                        </div>
                    </div>
                )}

                {/* Pagination */}
                {drivers.links && drivers.links.length > 3 && (
                    <div className="flex justify-center space-x-2">
                        {drivers.links.map((link, index) => (
                            <Link
                                key={index}
                                href={link.url || '#'}
                                className={`px-3 py-2 text-sm rounded-md ${
                                    link.active
                                        ? 'bg-blue-600 text-white'
                                        : link.url
                                        ? 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'
                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                }`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                )}
            </div>
        </AppLayout>
    );
}