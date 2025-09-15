import React from 'react';
import AppLayout from '@/components/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="EV Fleet Dashboard" />
            
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">⚡ Fleet Dashboard</h1>
                        <p className="text-gray-600 mt-1">Monitor your electric vehicle fleet in real-time</p>
                    </div>
                    <div className="text-right">
                        <div className="text-sm text-gray-500">Last updated</div>
                        <div className="text-lg font-semibold text-gray-900">2 minutes ago</div>
                    </div>
                </div>

                {/* Key Metrics */}
                <div className="grid gap-4 md:grid-cols-4">
                    <div className="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Total Vehicles</p>
                                <p className="text-3xl font-bold text-gray-900">45</p>
                            </div>
                            <div className="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">🚗</span>
                            </div>
                        </div>
                        <div className="mt-2 flex items-center text-sm">
                            <span className="text-green-600">↗ 12%</span>
                            <span className="text-gray-500 ml-1">vs last month</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Active Vehicles</p>
                                <p className="text-3xl font-bold text-gray-900">38</p>
                            </div>
                            <div className="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">✅</span>
                            </div>
                        </div>
                        <div className="mt-2 flex items-center text-sm">
                            <span className="text-green-600">84%</span>
                            <span className="text-gray-500 ml-1">utilization rate</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Drivers Online</p>
                                <p className="text-3xl font-bold text-gray-900">22</p>
                            </div>
                            <div className="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">👨‍✈️</span>
                            </div>
                        </div>
                        <div className="mt-2 flex items-center text-sm">
                            <span className="text-green-600">↗ 5</span>
                            <span className="text-gray-500 ml-1">since morning</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Maintenance Due</p>
                                <p className="text-3xl font-bold text-orange-600">3</p>
                            </div>
                            <div className="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <span className="text-2xl">🔧</span>
                            </div>
                        </div>
                        <div className="mt-2 flex items-center text-sm">
                            <span className="text-orange-600">↗ 1</span>
                            <span className="text-gray-500 ml-1">this week</span>
                        </div>
                    </div>
                </div>

                {/* Main Content Grid */}
                <div className="grid gap-6 lg:grid-cols-3">
                    {/* Fleet Status */}
                    <div className="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div className="p-6 border-b border-gray-200">
                            <h3 className="text-lg font-semibold text-gray-900">🚗 Fleet Status</h3>
                            <p className="text-sm text-gray-600">Real-time vehicle status overview</p>
                        </div>
                        <div className="p-6">
                            <div className="space-y-4">
                                <div className="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                                    <div className="flex items-center space-x-3">
                                        <div className="h-3 w-3 bg-green-500 rounded-full"></div>
                                        <div>
                                            <div className="font-medium text-gray-900">Tesla Model 3 - EV001</div>
                                            <div className="text-sm text-gray-600">Battery: 85% • Downtown Zone</div>
                                        </div>
                                    </div>
                                    <div className="text-sm">
                                        <span className="px-2 py-1 bg-green-100 text-green-800 rounded-full">Active</span>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <div className="flex items-center space-x-3">
                                        <div className="h-3 w-3 bg-blue-500 rounded-full"></div>
                                        <div>
                                            <div className="font-medium text-gray-900">BYD Tuk-Tuk - TT002</div>
                                            <div className="text-sm text-gray-600">Battery: 67% • Industrial Area</div>
                                        </div>
                                    </div>
                                    <div className="text-sm">
                                        <span className="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Charging</span>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between p-4 bg-orange-50 rounded-lg border border-orange-200">
                                    <div className="flex items-center space-x-3">
                                        <div className="h-3 w-3 bg-orange-500 rounded-full"></div>
                                        <div>
                                            <div className="font-medium text-gray-900">Nissan E-Bus - EB003</div>
                                            <div className="text-sm text-gray-600">Battery: 45% • Service Center</div>
                                        </div>
                                    </div>
                                    <div className="text-sm">
                                        <span className="px-2 py-1 bg-orange-100 text-orange-800 rounded-full">Maintenance</span>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between p-4 bg-purple-50 rounded-lg border border-purple-200">
                                    <div className="flex items-center space-x-3">
                                        <div className="h-3 w-3 bg-purple-500 rounded-full"></div>
                                        <div>
                                            <div className="font-medium text-gray-900">E-Bike Fleet - EB004-010</div>
                                            <div className="text-sm text-gray-600">7 bikes • Various locations</div>
                                        </div>
                                    </div>
                                    <div className="text-sm">
                                        <span className="px-2 py-1 bg-purple-100 text-purple-800 rounded-full">Mixed Status</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Quick Actions & Alerts */}
                    <div className="space-y-6">
                        {/* Quick Actions */}
                        <div className="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div className="p-6 border-b border-gray-200">
                                <h3 className="text-lg font-semibold text-gray-900">⚡ Quick Actions</h3>
                            </div>
                            <div className="p-6 space-y-3">
                                <button className="w-full p-3 text-left bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors">
                                    <div className="font-medium text-blue-900">🚗 Add New Vehicle</div>
                                    <div className="text-sm text-blue-700">Register a new EV to the fleet</div>
                                </button>
                                
                                <button className="w-full p-3 text-left bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors">
                                    <div className="font-medium text-green-900">👨‍✈️ Add Driver</div>
                                    <div className="text-sm text-green-700">Register new driver profile</div>
                                </button>
                                
                                <button className="w-full p-3 text-left bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition-colors">
                                    <div className="font-medium text-purple-900">📍 Create Geofence</div>
                                    <div className="text-sm text-purple-700">Set up monitoring zones</div>
                                </button>
                            </div>
                        </div>

                        {/* Alerts */}
                        <div className="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div className="p-6 border-b border-gray-200">
                                <h3 className="text-lg font-semibold text-gray-900">🚨 Alerts</h3>
                            </div>
                            <div className="p-6 space-y-3">
                                <div className="p-3 bg-red-50 rounded-lg border border-red-200">
                                    <div className="flex items-start space-x-2">
                                        <span className="text-red-500">⚠️</span>
                                        <div>
                                            <div className="font-medium text-red-900">Low Battery Alert</div>
                                            <div className="text-sm text-red-700">EV001 battery at 15%</div>
                                            <div className="text-xs text-red-600 mt-1">2 minutes ago</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div className="p-3 bg-orange-50 rounded-lg border border-orange-200">
                                    <div className="flex items-start space-x-2">
                                        <span className="text-orange-500">🔧</span>
                                        <div>
                                            <div className="font-medium text-orange-900">Maintenance Due</div>
                                            <div className="text-sm text-orange-700">TT002 service in 2 days</div>
                                            <div className="text-xs text-orange-600 mt-1">1 hour ago</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div className="p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <div className="flex items-start space-x-2">
                                        <span className="text-blue-500">📍</span>
                                        <div>
                                            <div className="font-medium text-blue-900">Geofence Exit</div>
                                            <div className="text-sm text-blue-700">EB005 left downtown zone</div>
                                            <div className="text-xs text-blue-600 mt-1">5 minutes ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Battery Levels Overview */}
                <div className="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div className="p-6 border-b border-gray-200">
                        <h3 className="text-lg font-semibold text-gray-900">🔋 Fleet Battery Status</h3>
                        <p className="text-sm text-gray-600">Current battery levels across all vehicles</p>
                    </div>
                    <div className="p-6">
                        <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <div className="space-y-3">
                                <div className="flex justify-between text-sm">
                                    <span className="font-medium">E-Bikes (7)</span>
                                    <span className="text-green-600">Avg: 78%</span>
                                </div>
                                <div className="w-full bg-gray-200 rounded-full h-2">
                                    <div className="bg-green-500 h-2 rounded-full" style={{ width: '78%' }}></div>
                                </div>
                            </div>
                            
                            <div className="space-y-3">
                                <div className="flex justify-between text-sm">
                                    <span className="font-medium">Tuk-Tuks (5)</span>
                                    <span className="text-blue-600">Avg: 65%</span>
                                </div>
                                <div className="w-full bg-gray-200 rounded-full h-2">
                                    <div className="bg-blue-500 h-2 rounded-full" style={{ width: '65%' }}></div>
                                </div>
                            </div>
                            
                            <div className="space-y-3">
                                <div className="flex justify-between text-sm">
                                    <span className="font-medium">Buses (3)</span>
                                    <span className="text-purple-600">Avg: 52%</span>
                                </div>
                                <div className="w-full bg-gray-200 rounded-full h-2">
                                    <div className="bg-purple-500 h-2 rounded-full" style={{ width: '52%' }}></div>
                                </div>
                            </div>
                            
                            <div className="space-y-3">
                                <div className="flex justify-between text-sm">
                                    <span className="font-medium">Cars (30)</span>
                                    <span className="text-indigo-600">Avg: 71%</span>
                                </div>
                                <div className="w-full bg-gray-200 rounded-full h-2">
                                    <div className="bg-indigo-500 h-2 rounded-full" style={{ width: '71%' }}></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}