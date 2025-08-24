@extends('layout.employe')

@section('title', 'Tableau de Bord')

@section('page-title', 'Répertoire statistique')

@section('content')
<div class="container mx-auto max-w-6xl px-6">
    
    <!-- En-tête -->
    <div class="mb-12 text-center">
        <h1 class="text-3xl font-semibold text-gray-900 mb-2">📊 Tableau de Bord</h1>
        <p class="text-gray-500">Un aperçu clair et rapide de vos tâches</p>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="bg-green-50 text-green-800 px-4 py-3 rounded-lg mb-6 text-center text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 text-red-800 px-4 py-3 rounded-lg mb-6 text-center text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-14">
        <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-sm hover:bg-gray-50 transition">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-500">Tâches totales</span>
                <span class="text-gray-400">📌</span>
            </div>
            <p class="text-4xl font-semibold text-gray-900">{{ $totalTasks }}</p>
            <a href="#recent-tasks" class="mt-3 inline-block text-sm text-gray-600 hover:text-black">
                → Voir les tâches récentes
            </a>
        </div>

        <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-sm hover:bg-gray-50 transition">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-500">Tâches en cours</span>
                <span class="text-gray-400">⏳</span>
            </div>
            <p class="text-4xl font-semibold text-gray-900">{{ $inProgressTasks }}</p>
            <a href="#recent-tasks" class="mt-3 inline-block text-sm text-gray-600 hover:text-black">
                → Voir les tâches en cours
            </a>
        </div>

        <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-sm hover:bg-gray-50 transition">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-500">Tâches terminées</span>
                <span class="text-gray-400">✅</span>
            </div>
            <p class="text-4xl font-semibold text-gray-900">{{ $completedTasks }}</p>
            <a href="#recent-tasks" class="mt-3 inline-block text-sm text-gray-600 hover:text-black">
                → Voir les tâches terminées
            </a>
        </div>
    </div>

    <!-- Tâches récentes -->
    <div id="recent-tasks" class="mb-16">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">🕒 Tâches récentes</h2>

        @if($recentTasks->isEmpty())
            <div class="text-center py-10 text-gray-500 border border-dashed border-gray-300 rounded-xl">
                Aucune tâche récente pour le moment.
            </div>
        @else
        <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-semibold text-gray-800">Tâches récentes</h2>
    <a href="{{ route('employe.projects') }}" 
       class="text-sm px-3 py-1 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
       Voir plus
    </a>
</div>

            <div class="divide-y divide-gray-200 border border-gray-200 rounded-xl">
                @foreach($recentTasks as $task)
                    <div class="p-5 hover:bg-gray-50 transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <!-- Infos principales -->
                            <div class="mb-3 sm:mb-0">
                                <h3 class="text-lg font-medium text-gray-900">{{ $task->title }}</h3>
                                <p class="text-gray-500 text-sm mt-1">
                                    Projet : <span class="font-medium">{{ $task->project->title ?? 'N/A' }}</span>
                                </p>
                            </div>
                            
                            <!-- Métadonnées -->
                            <div class="flex flex-wrap items-center gap-3 text-sm">
                                <span class="px-3 py-1 rounded-full text-white text-xs
                                    @if($task->priority === 'High') bg-red-500
                                    @elseif($task->priority === 'Medium') bg-yellow-500
                                    @else bg-green-500
                                    @endif
                                ">
                                    {{ $task->priority }}
                                </span>
                                <span class="text-gray-600">Statut :
                                    <span class="font-medium">{{ ucwords($task->status) }}</span>
                                </span>
                                <span class="text-gray-600">Échéance :
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
