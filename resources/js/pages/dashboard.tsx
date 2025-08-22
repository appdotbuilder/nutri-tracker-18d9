import React, { useState } from 'react';
import AppLayout from '@/components/app-layout';
import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Badge } from '@/components/ui/badge';
import { type BreadcrumbItem } from '@/types';

interface UserProfile {
    id: number;
    height: number | null;
    weight: number | null;
    neck_circumference: number | null;
    waist_circumference: number | null;
    gender: string | null;
    body_fat_percentage: number | null;
}

interface FoodLog {
    id: number;
    name: string;
    calories: number;
    protein: number;
    fat: number;
    carbohydrates: number;
    logged_date: string;
}

interface ExerciseLog {
    id: number;
    exercise_type: string;
    duration_minutes: number;
    calories_burned: number;
    logged_date: string;
}

interface DailyNutrition {
    calories: number;
    protein: number;
    fat: number;
    carbohydrates: number;
}

interface Props {
    profile: UserProfile | null;
    todaysFoodLogs: FoodLog[];
    todaysExerciseLogs: ExerciseLog[];
    dailyNutrition: DailyNutrition;
    totalCaloriesBurned: number;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Fitness Dashboard',
        href: '/dashboard',
    },
];

const exerciseTypes = [
    { value: 'running', label: '🏃‍♂️ Running' },
    { value: 'walking', label: '🚶‍♀️ Walking' },
    { value: 'cycling', label: '🚴‍♂️ Cycling' },
    { value: 'swimming', label: '🏊‍♀️ Swimming' },
    { value: 'yoga', label: '🧘‍♀️ Yoga' },
    { value: 'weightlifting', label: '🏋️‍♂️ Weightlifting' },
    { value: 'dancing', label: '💃 Dancing' },
    { value: 'hiking', label: '🥾 Hiking' },
    { value: 'basketball', label: '🏀 Basketball' },
    { value: 'soccer', label: '⚽ Soccer' },
    { value: 'tennis', label: '🎾 Tennis' },
    { value: 'jump_rope', label: '🪢 Jump Rope' },
    { value: 'rowing', label: '🚣‍♂️ Rowing' },
    { value: 'pilates', label: '🤸‍♀️ Pilates' },
    { value: 'martial_arts', label: '🥋 Martial Arts' },
];

export default function Dashboard({ 
    profile, 
    todaysFoodLogs, 
    todaysExerciseLogs, 
    dailyNutrition, 
    totalCaloriesBurned 
}: Props) {
    const [activeTab, setActiveTab] = useState('overview');

    const profileForm = useForm({
        height: profile?.height?.toString() || '',
        weight: profile?.weight?.toString() || '',
        neck_circumference: profile?.neck_circumference?.toString() || '',
        waist_circumference: profile?.waist_circumference?.toString() || '',
        gender: profile?.gender || '',
    });

    const foodForm = useForm({
        name: '',
        calories: '',
        protein: '',
        fat: '',
        carbohydrates: '',
        logged_date: new Date().toISOString().split('T')[0],
    });

    const exerciseForm = useForm({
        exercise_type: '',
        duration_minutes: '',
        logged_date: new Date().toISOString().split('T')[0],
    });

    const handleProfileSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        profileForm.post(route('fitness.profile.store'), {
            preserveState: true,
        });
    };

    const handleFoodSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        foodForm.post(route('fitness.food.store'), {
            preserveState: true,
            onSuccess: () => {
                foodForm.reset('name', 'calories', 'protein', 'fat', 'carbohydrates');
            },
        });
    };

    const handleExerciseSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        exerciseForm.post(route('fitness.exercise.store'), {
            preserveState: true,
            onSuccess: () => {
                exerciseForm.reset('exercise_type', 'duration_minutes');
            },
        });
    };

    const netCalories = dailyNutrition.calories - totalCaloriesBurned;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Fitness Dashboard" />
            
            <div className="container mx-auto p-6 space-y-6">
                {/* Header */}
                <div className="text-center">
                    <h1 className="text-3xl font-bold mb-2">🏋️‍♀️ Your Fitness Dashboard</h1>
                    <p className="text-muted-foreground">Track your body composition, nutrition, and exercise</p>
                </div>

                {/* Daily Overview Cards */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Calories In</CardTitle>
                            <span className="text-xl">🍎</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-600">
                                {Math.round(dailyNutrition.calories)}
                            </div>
                            <p className="text-xs text-muted-foreground">cal consumed</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Calories Out</CardTitle>
                            <span className="text-xl">🔥</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-red-600">
                                {Math.round(totalCaloriesBurned)}
                            </div>
                            <p className="text-xs text-muted-foreground">cal burned</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Net Calories</CardTitle>
                            <span className="text-xl">⚖️</span>
                        </CardHeader>
                        <CardContent>
                            <div className={`text-2xl font-bold ${netCalories > 0 ? 'text-blue-600' : 'text-orange-600'}`}>
                                {Math.round(netCalories)}
                            </div>
                            <p className="text-xs text-muted-foreground">net balance</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Body Fat</CardTitle>
                            <span className="text-xl">📏</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-purple-600">
                                {profile?.body_fat_percentage ? `${profile.body_fat_percentage}%` : 'N/A'}
                            </div>
                            <p className="text-xs text-muted-foreground">body fat %</p>
                        </CardContent>
                    </Card>
                </div>

                {/* Main Content Tabs */}
                <Tabs value={activeTab} onValueChange={setActiveTab} className="w-full">
                    <TabsList className="grid w-full grid-cols-4">
                        <TabsTrigger value="overview">📊 Overview</TabsTrigger>
                        <TabsTrigger value="profile">📏 Profile</TabsTrigger>
                        <TabsTrigger value="nutrition">🍎 Nutrition</TabsTrigger>
                        <TabsTrigger value="exercise">🏃 Exercise</TabsTrigger>
                    </TabsList>

                    <TabsContent value="overview" className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Today's Nutrition */}
                            <Card>
                                <CardHeader>
                                    <CardTitle>Today's Nutrition</CardTitle>
                                    <CardDescription>Macronutrient breakdown</CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="flex justify-between items-center">
                                        <span>Protein</span>
                                        <Badge variant="secondary">{Math.round(dailyNutrition.protein)}g</Badge>
                                    </div>
                                    <div className="flex justify-between items-center">
                                        <span>Fat</span>
                                        <Badge variant="secondary">{Math.round(dailyNutrition.fat)}g</Badge>
                                    </div>
                                    <div className="flex justify-between items-center">
                                        <span>Carbohydrates</span>
                                        <Badge variant="secondary">{Math.round(dailyNutrition.carbohydrates)}g</Badge>
                                    </div>
                                </CardContent>
                            </Card>

                            {/* Today's Exercise */}
                            <Card>
                                <CardHeader>
                                    <CardTitle>Today's Exercise</CardTitle>
                                    <CardDescription>Workout summary</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    {todaysExerciseLogs.length > 0 ? (
                                        <div className="space-y-3">
                                            {todaysExerciseLogs.map((log) => (
                                                <div key={log.id} className="flex justify-between items-center">
                                                    <div>
                                                        <p className="font-medium capitalize">{log.exercise_type.replace('_', ' ')}</p>
                                                        <p className="text-sm text-muted-foreground">{log.duration_minutes} minutes</p>
                                                    </div>
                                                    <Badge>{Math.round(log.calories_burned)} cal</Badge>
                                                </div>
                                            ))}
                                        </div>
                                    ) : (
                                        <p className="text-muted-foreground">No exercises logged today</p>
                                    )}
                                </CardContent>
                            </Card>
                        </div>

                        {/* Recent Food Logs */}
                        <Card>
                            <CardHeader>
                                <CardTitle>Today's Food Log</CardTitle>
                                <CardDescription>Your daily food intake</CardDescription>
                            </CardHeader>
                            <CardContent>
                                {todaysFoodLogs.length > 0 ? (
                                    <div className="space-y-3">
                                        {todaysFoodLogs.map((log) => (
                                            <div key={log.id} className="flex justify-between items-center p-3 bg-muted rounded-lg">
                                                <div>
                                                    <p className="font-medium">{log.name}</p>
                                                    <p className="text-sm text-muted-foreground">
                                                        P: {log.protein}g | F: {log.fat}g | C: {log.carbohydrates}g
                                                    </p>
                                                </div>
                                                <Badge variant="outline">{log.calories} cal</Badge>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <p className="text-muted-foreground">No food logged today</p>
                                )}
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="profile">
                        <Card>
                            <CardHeader>
                                <CardTitle>Body Composition Profile</CardTitle>
                                <CardDescription>
                                    Enter your measurements to calculate body fat percentage using the US Navy method
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={handleProfileSubmit} className="space-y-4">
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="height">Height (cm)</Label>
                                            <Input
                                                id="height"
                                                type="number"
                                                placeholder="175"
                                                value={profileForm.data.height}
                                                onChange={(e) => profileForm.setData('height', e.target.value)}
                                            />
                                            {profileForm.errors.height && (
                                                <p className="text-sm text-red-600">{profileForm.errors.height}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="weight">Weight (kg)</Label>
                                            <Input
                                                id="weight"
                                                type="number"
                                                placeholder="70"
                                                value={profileForm.data.weight}
                                                onChange={(e) => profileForm.setData('weight', e.target.value)}
                                            />
                                            {profileForm.errors.weight && (
                                                <p className="text-sm text-red-600">{profileForm.errors.weight}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="neck">Neck Circumference (cm)</Label>
                                            <Input
                                                id="neck"
                                                type="number"
                                                placeholder="38"
                                                value={profileForm.data.neck_circumference}
                                                onChange={(e) => profileForm.setData('neck_circumference', e.target.value)}
                                            />
                                            {profileForm.errors.neck_circumference && (
                                                <p className="text-sm text-red-600">{profileForm.errors.neck_circumference}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="waist">Waist Circumference (cm)</Label>
                                            <Input
                                                id="waist"
                                                type="number"
                                                placeholder="80"
                                                value={profileForm.data.waist_circumference}
                                                onChange={(e) => profileForm.setData('waist_circumference', e.target.value)}
                                            />
                                            {profileForm.errors.waist_circumference && (
                                                <p className="text-sm text-red-600">{profileForm.errors.waist_circumference}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="gender">Gender</Label>
                                            <Select value={profileForm.data.gender} onValueChange={(value) => profileForm.setData('gender', value)}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select gender" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem value="male">Male</SelectItem>
                                                    <SelectItem value="female">Female</SelectItem>
                                                </SelectContent>
                                            </Select>
                                            {profileForm.errors.gender && (
                                                <p className="text-sm text-red-600">{profileForm.errors.gender}</p>
                                            )}
                                        </div>
                                    </div>

                                    <Button type="submit" disabled={profileForm.processing} className="w-full">
                                        {profileForm.processing ? 'Updating...' : '💾 Update Profile'}
                                    </Button>
                                </form>
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="nutrition">
                        <Card>
                            <CardHeader>
                                <CardTitle>Log Food & Drinks</CardTitle>
                                <CardDescription>
                                    Enter nutritional information for your meals and drinks
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={handleFoodSubmit} className="space-y-4">
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="food-name">Food/Drink Name</Label>
                                            <Input
                                                id="food-name"
                                                placeholder="Grilled chicken breast"
                                                value={foodForm.data.name}
                                                onChange={(e) => foodForm.setData('name', e.target.value)}
                                            />
                                            {foodForm.errors.name && (
                                                <p className="text-sm text-red-600">{foodForm.errors.name}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="calories">Calories</Label>
                                            <Input
                                                id="calories"
                                                type="number"
                                                placeholder="250"
                                                value={foodForm.data.calories}
                                                onChange={(e) => foodForm.setData('calories', e.target.value)}
                                            />
                                            {foodForm.errors.calories && (
                                                <p className="text-sm text-red-600">{foodForm.errors.calories}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="protein">Protein (g)</Label>
                                            <Input
                                                id="protein"
                                                type="number"
                                                placeholder="30"
                                                value={foodForm.data.protein}
                                                onChange={(e) => foodForm.setData('protein', e.target.value)}
                                            />
                                            {foodForm.errors.protein && (
                                                <p className="text-sm text-red-600">{foodForm.errors.protein}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="fat">Fat (g)</Label>
                                            <Input
                                                id="fat"
                                                type="number"
                                                placeholder="5"
                                                value={foodForm.data.fat}
                                                onChange={(e) => foodForm.setData('fat', e.target.value)}
                                            />
                                            {foodForm.errors.fat && (
                                                <p className="text-sm text-red-600">{foodForm.errors.fat}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="carbs">Carbohydrates (g)</Label>
                                            <Input
                                                id="carbs"
                                                type="number"
                                                placeholder="0"
                                                value={foodForm.data.carbohydrates}
                                                onChange={(e) => foodForm.setData('carbohydrates', e.target.value)}
                                            />
                                            {foodForm.errors.carbohydrates && (
                                                <p className="text-sm text-red-600">{foodForm.errors.carbohydrates}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="food-date">Date</Label>
                                            <Input
                                                id="food-date"
                                                type="date"
                                                value={foodForm.data.logged_date}
                                                onChange={(e) => foodForm.setData('logged_date', e.target.value)}
                                            />
                                            {foodForm.errors.logged_date && (
                                                <p className="text-sm text-red-600">{foodForm.errors.logged_date}</p>
                                            )}
                                        </div>
                                    </div>

                                    <Button type="submit" disabled={foodForm.processing} className="w-full">
                                        {foodForm.processing ? 'Adding...' : '🍎 Add Food Log'}
                                    </Button>
                                </form>
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <TabsContent value="exercise">
                        <Card>
                            <CardHeader>
                                <CardTitle>Log Exercise</CardTitle>
                                <CardDescription>
                                    Track your workouts - calories burned are calculated automatically based on your weight
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={handleExerciseSubmit} className="space-y-4">
                                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="exercise-type">Exercise Type</Label>
                                            <Select value={exerciseForm.data.exercise_type} onValueChange={(value) => exerciseForm.setData('exercise_type', value)}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select exercise" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {exerciseTypes.map((exercise) => (
                                                        <SelectItem key={exercise.value} value={exercise.value}>
                                                            {exercise.label}
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                            {exerciseForm.errors.exercise_type && (
                                                <p className="text-sm text-red-600">{exerciseForm.errors.exercise_type}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="duration">Duration (minutes)</Label>
                                            <Input
                                                id="duration"
                                                type="number"
                                                placeholder="30"
                                                value={exerciseForm.data.duration_minutes}
                                                onChange={(e) => exerciseForm.setData('duration_minutes', e.target.value)}
                                            />
                                            {exerciseForm.errors.duration_minutes && (
                                                <p className="text-sm text-red-600">{exerciseForm.errors.duration_minutes}</p>
                                            )}
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="exercise-date">Date</Label>
                                            <Input
                                                id="exercise-date"
                                                type="date"
                                                value={exerciseForm.data.logged_date}
                                                onChange={(e) => exerciseForm.setData('logged_date', e.target.value)}
                                            />
                                            {exerciseForm.errors.logged_date && (
                                                <p className="text-sm text-red-600">{exerciseForm.errors.logged_date}</p>
                                            )}
                                        </div>
                                    </div>

                                    <Button type="submit" disabled={exerciseForm.processing} className="w-full">
                                        {exerciseForm.processing ? 'Adding...' : '🏃 Add Exercise Log'}
                                    </Button>
                                </form>
                                
                                {!profile?.weight && (
                                    <div className="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <p className="text-sm text-yellow-800">
                                            💡 <strong>Tip:</strong> Set your weight in the Profile tab for more accurate calorie burn calculations.
                                        </p>
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
        </AppLayout>
    );
}