@extends('layouts.app')

@section('title', 'Database Manager - JerukPin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-6">
                <h1 class="text-3xl font-bold text-white">🔧 Database Manager</h1>
                <p class="text-orange-100 mt-2">Monitor and manage your JerukPin database</p>
            </div>
        </div>

        <!-- Database Status -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <span class="text-3xl">📊</span>
                Current Database Status
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Users Count -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border-2 border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 mb-1">Total Users</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $userCount }}</p>
                        </div>
                        <div class="text-5xl">👥</div>
                    </div>
                </div>

                <!-- Products Count -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border-2 border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600 mb-1">Total Products</p>
                            <p class="text-3xl font-bold text-green-900">{{ $productCount }}</p>
                        </div>
                        <div class="text-5xl">🍊</div>
                    </div>
                </div>

                <!-- Categories Count -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 border-2 border-orange-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-orange-600 mb-1">Categories</p>
                            <p class="text-3xl font-bold text-orange-900">{{ $categoryCount }}</p>
                        </div>
                        <div class="text-5xl">📂</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <span class="text-3xl">⚙️</span>
                Database Actions
            </h2>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-2 border-green-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">✅</span>
                        <div>
                            <p class="font-bold text-green-900">Success!</p>
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">❌</span>
                        <div>
                            <p class="font-bold text-red-900">Error!</p>
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                <!-- Seed Database Button -->
                <form action="{{ route('admin.database.seed') }}" method="POST" onsubmit="return confirm('Are you sure you want to seed the database? This will add sample data.');">
                    @csrf
                    <button type="submit" class="w-full group relative overflow-hidden bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                        <span class="relative z-10 flex items-center justify-between">
                            <span class="flex items-center gap-3">
                                <span class="text-2xl">🌱</span>
                                <span>Seed Database</span>
                            </span>
                            <span class="text-sm opacity-75">Add sample products & data</span>
                        </span>
                    </button>
                </form>

                <!-- Refresh Status Button -->
                <form action="{{ route('admin.database.manager') }}" method="GET">
                    <button type="submit" class="w-full group bg-gray-100 hover:bg-gray-200 text-gray-800 py-4 px-6 rounded-xl font-bold text-lg shadow hover:shadow-md transform hover:scale-[1.02] transition-all duration-300">
                        <span class="flex items-center justify-between">
                            <span class="flex items-center gap-3">
                                <span class="text-2xl">🔄</span>
                                <span>Refresh Status</span>
                            </span>
                            <span class="text-sm opacity-75">Update counts</span>
                        </span>
                    </button>
                </form>
            </div>

            <!-- Warning Notice -->
            <div class="mt-8 bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6">
                <div class="flex items-start gap-4">
                    <span class="text-3xl flex-shrink-0">⚠️</span>
                    <div>
                        <p class="font-bold text-yellow-900 mb-2">Important Notes:</p>
                        <ul class="text-sm text-yellow-800 space-y-1">
                            <li>• Seeding will create sample products and categories</li>
                            <li>• Existing data will NOT be deleted (unless duplicates)</li>
                            <li>• Admin account will be updated if email matches</li>
                            <li>• Only use when you need to populate database</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg font-medium shadow hover:shadow-md transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Homepage
            </a>
        </div>
    </div>
</div>
@endsection
