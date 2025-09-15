import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
        } | null;
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    return (
        <>
            <Head title="EV Fleet Management Platform" />
            
            <div className="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-indigo-50">
                {/* Navigation */}
                <nav className="flex items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-sm shadow-sm">
                    <div className="flex items-center space-x-2">
                        <div className="p-2 bg-green-600 rounded-lg">
                            <span className="text-2xl">⚡</span>
                        </div>
                        <h1 className="text-xl font-bold text-gray-900">EV Fleet Manager</h1>
                    </div>
                    
                    <div className="flex items-center space-x-4">
                        {auth.user ? (
                            <Link href="/dashboard">
                                <Button>Go to Dashboard</Button>
                            </Link>
                        ) : (
                            <div className="flex space-x-2">
                                <Link href="/login">
                                    <Button variant="ghost">Sign In</Button>
                                </Link>
                                <Link href="/register">
                                    <Button>Get Started</Button>
                                </Link>
                            </div>
                        )}
                    </div>
                </nav>

                {/* Hero Section */}
                <div className="px-6 py-16 text-center">
                    <div className="max-w-4xl mx-auto">
                        <div className="flex justify-center mb-6">
                            <div className="flex space-x-2 text-6xl">
                                <span>🚌</span>
                                <span>🛺</span>
                                <span>🚲</span>
                            </div>
                        </div>
                        
                        <h2 className="mb-4 text-5xl font-bold text-gray-900">
                            🚗⚡ Multi-Tenant EV Fleet Management
                        </h2>
                        
                        <p className="mb-8 text-xl text-gray-600 max-w-2xl mx-auto">
                            Complete electric vehicle fleet management platform with real-time GPS tracking, 
                            predictive maintenance, and multi-tenant architecture for scalable operations.
                        </p>

                        <div className="flex justify-center space-x-4 mb-12">
                            <Link href="/register">
                                <Button size="lg" className="bg-green-600 hover:bg-green-700">
                                    🚀 Start Free Trial
                                </Button>
                            </Link>
                            <Button variant="outline" size="lg">
                                📊 View API Docs
                            </Button>
                        </div>
                    </div>
                </div>

                {/* Features Grid */}
                <div className="px-6 py-16 bg-white/50">
                    <div className="max-w-6xl mx-auto">
                        <h3 className="mb-12 text-3xl font-bold text-center text-gray-900">
                            🎯 Platform Features
                        </h3>
                        
                        <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            {/* Fleet Management */}
                            <div className="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="mb-4 text-4xl">🚗</div>
                                <h4 className="mb-2 text-xl font-semibold">Fleet Management</h4>
                                <p className="text-gray-600">
                                    Manage diverse vehicle types including e-bikes, tuk-tuks, buses, and electric cars 
                                    with comprehensive vehicle profiles and specifications.
                                </p>
                                <div className="mt-4 space-y-2">
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Vehicle registration & profiles
                                    </div>
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Battery monitoring & alerts
                                    </div>
                                </div>
                            </div>

                            {/* Real-time Tracking */}
                            <div className="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="mb-4 text-4xl">📍</div>
                                <h4 className="mb-2 text-xl font-semibold">GPS Tracking</h4>
                                <p className="text-gray-600">
                                    Real-time vehicle location tracking with geofencing capabilities, 
                                    route optimization, and driver behavior monitoring.
                                </p>
                                <div className="mt-4 space-y-2">
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        Live GPS coordinates
                                    </div>
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        Geofence alerts & zones
                                    </div>
                                </div>
                            </div>

                            {/* Driver Management */}
                            <div className="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="mb-4 text-4xl">👨‍✈️</div>
                                <h4 className="mb-2 text-xl font-semibold">Driver Management</h4>
                                <p className="text-gray-600">
                                    Complete driver profiles with license tracking, performance ratings, 
                                    and certification management for compliance.
                                </p>
                                <div className="mt-4 space-y-2">
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                        License & certification tracking
                                    </div>
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                        Performance ratings & analytics
                                    </div>
                                </div>
                            </div>

                            {/* Predictive Maintenance */}
                            <div className="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="mb-4 text-4xl">🔧</div>
                                <h4 className="mb-2 text-xl font-semibold">Predictive Maintenance</h4>
                                <p className="text-gray-600">
                                    AI-powered maintenance scheduling based on vehicle usage, battery health, 
                                    and historical data to minimize downtime.
                                </p>
                                <div className="mt-4 space-y-2">
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                                        Automated service reminders
                                    </div>
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                                        Parts inventory tracking
                                    </div>
                                </div>
                            </div>

                            {/* Multi-Tenant */}
                            <div className="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="mb-4 text-4xl">🏢</div>
                                <h4 className="mb-2 text-xl font-semibold">Multi-Tenant Architecture</h4>
                                <p className="text-gray-600">
                                    Complete data isolation for multiple organizations with custom branding, 
                                    role-based access control, and tenant-specific configurations.
                                </p>
                                <div className="mt-4 space-y-2">
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                        Database-level isolation
                                    </div>
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                        Custom tenant domains
                                    </div>
                                </div>
                            </div>

                            {/* REST API */}
                            <div className="p-6 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                <div className="mb-4 text-4xl">🔌</div>
                                <h4 className="mb-2 text-xl font-semibold">RESTful API</h4>
                                <p className="text-gray-600">
                                    Comprehensive REST API with JSON serialization for mobile app integration, 
                                    third-party services, and custom applications.
                                </p>
                                <div className="mt-4 space-y-2">
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                                        Flutter mobile app ready
                                    </div>
                                    <div className="flex items-center text-sm text-gray-500">
                                        <span className="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                                        Swagger documentation
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Technology Stack */}
                <div className="px-6 py-16">
                    <div className="max-w-4xl mx-auto text-center">
                        <h3 className="mb-8 text-3xl font-bold text-gray-900">
                            🛠️ Built with Modern Technology
                        </h3>
                        
                        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                            <div className="p-4 bg-white rounded-lg shadow-sm">
                                <div className="text-3xl mb-2">🐘</div>
                                <h4 className="font-semibold">Laravel PHP</h4>
                                <p className="text-sm text-gray-500">Backend API</p>
                            </div>
                            <div className="p-4 bg-white rounded-lg shadow-sm">
                                <div className="text-3xl mb-2">🗄️</div>
                                <h4 className="font-semibold">MySQL</h4>
                                <p className="text-sm text-gray-500">Database</p>
                            </div>
                            <div className="p-4 bg-white rounded-lg shadow-sm">
                                <div className="text-3xl mb-2">📱</div>
                                <h4 className="font-semibold">Flutter</h4>
                                <p className="text-sm text-gray-500">Mobile App</p>
                            </div>
                            <div className="p-4 bg-white rounded-lg shadow-sm">
                                <div className="text-3xl mb-2">🔒</div>
                                <h4 className="font-semibold">Laravel Sanctum</h4>
                                <p className="text-sm text-gray-500">Authentication</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* CTA Section */}
                <div className="px-6 py-16 bg-gradient-to-r from-green-600 to-blue-600 text-white">
                    <div className="max-w-3xl mx-auto text-center">
                        <h3 className="mb-4 text-3xl font-bold">
                            🚀 Ready to Electrify Your Fleet?
                        </h3>
                        <p className="mb-8 text-xl opacity-90">
                            Join forward-thinking companies using our platform to manage their electric vehicle fleets 
                            efficiently and sustainably.
                        </p>
                        
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href="/register">
                                <Button size="lg" className="bg-white text-green-600 hover:bg-gray-100">
                                    ✨ Start Your Free Trial
                                </Button>
                            </Link>
                            <Button size="lg" variant="outline" className="border-white text-white hover:bg-white/10">
                                📞 Schedule Demo
                            </Button>
                        </div>
                    </div>
                </div>

                {/* Footer */}
                <footer className="px-6 py-8 bg-gray-900 text-white">
                    <div className="max-w-4xl mx-auto text-center">
                        <div className="flex items-center justify-center space-x-2 mb-4">
                            <div className="p-2 bg-green-600 rounded-lg">
                                <span className="text-xl">⚡</span>
                            </div>
                            <span className="text-lg font-semibold">EV Fleet Manager</span>
                        </div>
                        <p className="text-gray-400">
                            Multi-tenant electric vehicle fleet management platform for the future of transportation.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}