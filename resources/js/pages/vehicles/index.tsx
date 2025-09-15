import React from 'react';
import AppLayout from '@/components/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Vehicle {
    id: number;
    vin: string;
    license_plate: string | null;
    make: string;
    model: string;
    year: number;
    color: string | null;
    status: string;
    battery_capacity: number | null;
    current_battery_level: number | null;
    odometer: number;
    vehicle_type: {
        name: string;
        category: string;
    };
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
    vehicles: {
        data: Vehicle[];
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
        title: 'Vehicles',
        href: '/vehicles',
    },
];

const getStatusColor = (status: string) => {
    switch (status.toLowerCase()) {
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'charging':
            return 'bg-blue-100 text-blue-800';
        case 'maintenance':
            return 'bg-orange-100 text-orange-800';
        case 'inactive':
            return 'bg-gray-100 text-gray-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getVehicleEmoji = (category: string) => {
    switch (category.toLowerCase()) {
        case 'car':
            return '🚗';
        case 'tuk-tuk':
            return '🛺';
        case 'bus':
            return '🚌';
        case 'bike':
            return '🚲';
        default:
            return '🚗';
    }
};

const getBatteryColor = (level: number | null) => {
    if (!level) return 'bg-gray-200';
    if (level >= 70) return 'bg-green-500';
    if (level >= 30) return 'bg-yellow-500';
    return 'bg-red-500';
};

export default function VehiclesIndex({ vehicles }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Fleet Vehicles" />
            
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">🚗 Fleet Vehicles</h1>
                        <p className="text-gray-600 mt-1">
                            Manage your electric vehicle fleet ({vehicles.meta.total} vehicles)
                        </p>
                    </div>
                    <Link href="/vehicles/create">
                        <Button className="bg-green-600 hover:bg-green-700">
                            ➕ Add Vehicle
                        </Button>
                    </Link>
                </div>

                {/* Filters & Stats */}
                <div className="grid gap-4 md:grid-cols-4">
                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Active</p>
                                <p className="text-2xl font-bold text-green-600">
                                    {vehicles.data.filter(v => v.status === 'active').length}
                                </p>
                            </div>
                            <span className="text-2xl">✅</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Charging</p>
                                <p className="text-2xl font-bold text-blue-600">
                                    {vehicles.data.filter(v => v.status === 'charging').length}
                                </p>
                            </div>
                            <span className="text-2xl">🔌</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Maintenance</p>
                                <p className="text-2xl font-bold text-orange-600">
                                    {vehicles.data.filter(v => v.status === 'maintenance').length}
                                </p>
                            </div>
                            <span className="text-2xl">🔧</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-4 border border-gray-200">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Avg Battery</p>
                                <p className="text-2xl font-bold text-purple-600">
                                    {Math.round(
                                        vehicles.data
                                            .filter(v => v.current_battery_level)
                                            .reduce((acc, v) => acc + (v.current_battery_level || 0), 0) /
                                        vehicles.data.filter(v => v.current_battery_level).length
                                    ) || 0}%
                                </p>
                            </div>
                            <span className="text-2xl">🔋</span>
                        </div>
                    </div>
                </div>

                {/* Vehicle Grid */}
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {vehicles.data.map((vehicle) => (
                        <div
                            key={vehicle.id}
                            className="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow"
                        >
                            {/* Vehicle Header */}
                            <div className="p-6 border-b border-gray-100">
                                <div className="flex items-center justify-between mb-3">
                                    <div className="flex items-center space-x-3">
                                        <span className="text-3xl">
                                            {getVehicleEmoji(vehicle.vehicle_type.category)}
                                        </span>
                                        <div>
                                            <h3 className="font-semibold text-gray-900">
                                                {vehicle.make} {vehicle.model}
                                            </h3>
                                            <p className="text-sm text-gray-500">
                                                {vehicle.year} • {vehicle.license_plate || 'No Plate'}
                                            </p>
                                        </div>
                                    </div>
                                    <span className={`px-3 py-1 rounded-full text-xs font-medium ${getStatusColor(vehicle.status)}`}>
                                        {vehicle.status.charAt(0).toUpperCase() + vehicle.status.slice(1)}
                                    </span>
                                </div>
                                
                                {/* Battery Level */}
                                {vehicle.current_battery_level && (
                                    <div className="space-y-2">
                                        <div className="flex justify-between text-sm">
                                            <span className="text-gray-600">Battery Level</span>
                                            <span className="font-medium">{vehicle.current_battery_level}%</span>
                                        </div>
                                        <div className="w-full bg-gray-200 rounded-full h-2">
                                            <div
                                                className={`h-2 rounded-full ${getBatteryColor(vehicle.current_battery_level)}`}
                                                style={{ width: `${vehicle.current_battery_level}%` }}
                                            ></div>
                                        </div>
                                    </div>
                                )}
                            </div>

                            {/* Vehicle Details */}
                            <div className="p-6 space-y-3">
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">VIN</span>
                                    <span className="font-mono text-xs">{vehicle.vin}</span>
                                </div>
                                
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Type</span>
                                    <span className="font-medium">{vehicle.vehicle_type.name}</span>
                                </div>
                                
                                {vehicle.color && (
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Color</span>
                                        <span className="font-medium">{vehicle.color}</span>
                                    </div>
                                )}
                                
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Odometer</span>
                                    <span className="font-medium">{vehicle.odometer.toLocaleString()} km</span>
                                </div>
                                
                                {vehicle.battery_capacity && (
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Battery Capacity</span>
                                        <span className="font-medium">{vehicle.battery_capacity} kWh</span>
                                    </div>
                                )}
                            </div>

                            {/* Action Buttons */}
                            <div className="p-6 pt-0 flex space-x-2">
                                <Link href={`/vehicles/${vehicle.id}`} className="flex-1">
                                    <Button variant="outline" className="w-full text-sm">
                                        👁️ View Details
                                    </Button>
                                </Link>
                                <Link href={`/vehicles/${vehicle.id}/edit`}>
                                    <Button variant="outline" size="sm">
                                        ✏️ Edit
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Empty State */}
                {vehicles.data.length === 0 && (
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">🚗</div>
                        <h3 className="text-lg font-medium text-gray-900 mb-2">No vehicles found</h3>
                        <p className="text-gray-600 mb-6">Get started by adding your first electric vehicle to the fleet.</p>
                        <Link href="/vehicles/create">
                            <Button className="bg-green-600 hover:bg-green-700">
                                ➕ Add First Vehicle
                            </Button>
                        </Link>
                    </div>
                )}

                {/* Pagination */}
                {vehicles.links && vehicles.links.length > 3 && (
                    <div className="flex justify-center space-x-2">
                        {vehicles.links.map((link, index) => (
                            <Link
                                key={index}
                                href={link.url || '#'}
                                className={`px-3 py-2 text-sm rounded-md ${
                                    link.active
                                        ? 'bg-green-600 text-white'
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