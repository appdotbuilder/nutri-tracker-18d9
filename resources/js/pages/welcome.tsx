import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

export default function Welcome() {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
            {/* Header */}
            <header className="container mx-auto px-4 py-6">
                <nav className="flex justify-between items-center">
                    <div className="flex items-center space-x-2">
                        <div className="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <span className="text-white font-bold text-lg">🏋️</span>
                        </div>
                        <span className="text-xl font-bold text-gray-800">FitTracker</span>
                    </div>
                    <div className="space-x-4">
                        <Link href="/login">
                            <Button variant="outline">Login</Button>
                        </Link>
                        <Link href="/register">
                            <Button>Get Started</Button>
                        </Link>
                    </div>
                </nav>
            </header>

            {/* Hero Section */}
            <main className="container mx-auto px-4 py-16">
                <div className="text-center mb-16">
                    <h1 className="text-5xl font-bold text-gray-800 mb-6">
                        🏋️‍♀️ Your Personal Fitness Tracker
                    </h1>
                    <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Track your body composition, log your meals, and monitor your workouts all in one place. 
                        Get insights into your fitness journey with automatic calorie calculations and body fat tracking.
                    </p>
                    <div className="flex justify-center space-x-4">
                        <Link href="/register">
                            <Button size="lg" className="text-lg px-8 py-3">
                                🚀 Start Tracking Now
                            </Button>
                        </Link>
                        <Link href="/login">
                            <Button variant="outline" size="lg" className="text-lg px-8 py-3">
                                📊 View Dashboard
                            </Button>
                        </Link>
                    </div>
                </div>

                {/* Features Grid */}
                <div className="grid md:grid-cols-3 gap-8 mb-16">
                    <Card className="hover:shadow-lg transition-shadow">
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span className="text-2xl">📏</span>
                                <span>Body Composition</span>
                            </CardTitle>
                            <CardDescription>
                                Calculate your body fat percentage using the US Navy method
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ul className="space-y-2 text-sm text-gray-600">
                                <li>• Track height, weight, and measurements</li>
                                <li>• Automatic body fat calculation</li>
                                <li>• Gender-specific formulas</li>
                                <li>• Progress monitoring over time</li>
                            </ul>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow">
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span className="text-2xl">🍎</span>
                                <span>Nutrition Tracking</span>
                            </CardTitle>
                            <CardDescription>
                                Log your daily food and drink intake with detailed macros
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ul className="space-y-2 text-sm text-gray-600">
                                <li>• Track calories, protein, fat, carbs</li>
                                <li>• Daily nutrition summaries</li>
                                <li>• Custom food entries</li>
                                <li>• Meal timing and portions</li>
                            </ul>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow">
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span className="text-2xl">🏃</span>
                                <span>Exercise Logging</span>
                            </CardTitle>
                            <CardDescription>
                                Track workouts with automatic calorie burn calculations
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ul className="space-y-2 text-sm text-gray-600">
                                <li>• 15+ exercise types supported</li>
                                <li>• Automatic calorie burn calculation</li>
                                <li>• Duration tracking in minutes/hours</li>
                                <li>• Weight-based calculations</li>
                            </ul>
                        </CardContent>
                    </Card>
                </div>

                {/* Exercise Types Preview */}
                <div className="bg-white rounded-lg p-8 shadow-sm mb-16">
                    <h2 className="text-2xl font-bold text-center mb-8">🎯 Supported Exercise Types</h2>
                    <div className="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                        {[
                            { name: 'Running', emoji: '🏃‍♂️' },
                            { name: 'Walking', emoji: '🚶‍♀️' },
                            { name: 'Cycling', emoji: '🚴‍♂️' },
                            { name: 'Swimming', emoji: '🏊‍♀️' },
                            { name: 'Yoga', emoji: '🧘‍♀️' },
                            { name: 'Weightlifting', emoji: '🏋️‍♂️' },
                            { name: 'Dancing', emoji: '💃' },
                            { name: 'Hiking', emoji: '🥾' },
                            { name: 'Basketball', emoji: '🏀' },
                            { name: 'Tennis', emoji: '🎾' },
                        ].map((exercise) => (
                            <div key={exercise.name} className="p-3 bg-gray-50 rounded-lg">
                                <div className="text-2xl mb-1">{exercise.emoji}</div>
                                <div className="text-sm font-medium">{exercise.name}</div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* Dashboard Preview */}
                <div className="bg-white rounded-lg p-8 shadow-sm">
                    <h2 className="text-2xl font-bold text-center mb-8">📊 Your Fitness Dashboard</h2>
                    <div className="grid md:grid-cols-2 gap-8">
                        <div className="space-y-4">
                            <h3 className="text-lg font-semibold flex items-center">
                                <span className="mr-2">📈</span>
                                Daily Overview
                            </h3>
                            <div className="bg-gray-50 p-4 rounded-lg">
                                <div className="flex justify-between items-center mb-2">
                                    <span>Calories Consumed</span>
                                    <span className="font-bold text-green-600">1,850 cal</span>
                                </div>
                                <div className="flex justify-between items-center mb-2">
                                    <span>Calories Burned</span>
                                    <span className="font-bold text-red-600">420 cal</span>
                                </div>
                                <div className="flex justify-between items-center">
                                    <span>Net Calories</span>
                                    <span className="font-bold">1,430 cal</span>
                                </div>
                            </div>
                        </div>
                        <div className="space-y-4">
                            <h3 className="text-lg font-semibold flex items-center">
                                <span className="mr-2">🎯</span>
                                Body Composition
                            </h3>
                            <div className="bg-gray-50 p-4 rounded-lg">
                                <div className="flex justify-between items-center mb-2">
                                    <span>Current Weight</span>
                                    <span className="font-bold">75.2 kg</span>
                                </div>
                                <div className="flex justify-between items-center mb-2">
                                    <span>Body Fat</span>
                                    <span className="font-bold text-blue-600">18.5%</span>
                                </div>
                                <div className="flex justify-between items-center">
                                    <span>BMI</span>
                                    <span className="font-bold text-green-600">22.8</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            {/* Call to Action */}
            <section className="bg-indigo-600 text-white py-16">
                <div className="container mx-auto px-4 text-center">
                    <h2 className="text-3xl font-bold mb-4">
                        Ready to Transform Your Fitness Journey? 💪
                    </h2>
                    <p className="text-xl mb-8 opacity-90">
                        Join thousands of users who are already tracking their way to better health
                    </p>
                    <Link href="/register">
                        <Button size="lg" variant="secondary" className="text-lg px-8 py-3">
                            🌟 Create Your Free Account
                        </Button>
                    </Link>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-gray-800 text-white py-8">
                <div className="container mx-auto px-4 text-center">
                    <p>&copy; 2024 FitTracker. Your personal fitness companion.</p>
                </div>
            </footer>
        </div>
    );
}