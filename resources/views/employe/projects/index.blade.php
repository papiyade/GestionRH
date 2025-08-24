@extends('layout.employe')

@section('title', 'Projets')

@section('page-title', 'Mes projets')

@section('content')
<div class="container mx-auto max-w-6xl px-4">

    <!-- En-tête -->
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-semibold text-gray-900 mb-2">📂 Mes Projets</h1>
        <p class="text-gray-500">Gérez et suivez vos projets en un coup d'œil</p>
    </div>

    <!-- Barre de recherche & filtre -->
    <form action="{{ route('employe.projects') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-8">
        <div class="md:col-span-5">
            <input type="text" name="search" id="search"
                   class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black text-sm"
                   placeholder="🔍 Rechercher par titre ou description"
                   value="{{ request('search') }}">
        </div>
        <div class="md:col-span-4">
            <select name="status_filter" id="status_filter"
                    class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black text-sm">
                <option value="">Tous les statuts</option>
                <option value="not_started" {{ request('status_filter') == 'not_started' ? 'selected' : '' }}>Non débuté</option>
                <option value="in_progress" {{ request('status_filter') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                <option value="completed" {{ request('status_filter') == 'completed' ? 'selected' : '' }}>Terminé</option>
            </select>
        </div>
        <div class="md:col-span-3">
            <button type="submit"
                    class="w-full bg-black text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                ⚡ Appliquer les filtres
            </button>
        </div>
    </form>

    <!-- Message dynamique tâches -->
    @php
        $userTotalTasks = 0;
        $userCompletedTasks = 0;
        foreach ($projets as $projet) {
            foreach ($projet->tasks as $task) {
                if ($task->users->contains(Auth::id())) {
                    $userTotalTasks++;
                    if ($task->status === 'completed') $userCompletedTasks++;
                }
            }
        }
        $userIncompleteTasks = $userTotalTasks - $userCompletedTasks;
    @endphp

    @if ($userIncompleteTasks > 0)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg mb-6">
            ⚠️ Vous avez <strong>{{ $userIncompleteTasks }}</strong> tâche{{ $userIncompleteTasks > 1 ? 's' : '' }} non terminée{{ $userIncompleteTasks > 1 ? 's' : '' }} parmi vos projets.
        </div>
    @else
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            🎉 Félicitations ! Toutes vos tâches sont terminées.
        </div>
    @endif

    <!-- Liste des projets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projets as $projet)
            @php
                $isLead = $projet->users()->where('user_id', Auth::id())->wherePivot('is_lead', true)->exists();
                $totalProjectTasks = $projet->tasks->count();
                $completedProjectTasks = $projet->tasks->where('status', 'completed')->count();
                $progressPercentage = $totalProjectTasks > 0 ? round(($completedProjectTasks / $totalProjectTasks) * 100) : 0;

                $statusColor = match($projet->status) {
                    'not_started' => 'bg-gray-200 text-gray-700',
                    'in_progress' => 'bg-yellow-200 text-yellow-800',
                    'completed' => 'bg-green-200 text-green-800',
                    default => 'bg-gray-100 text-gray-600',
                };
            @endphp

            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition flex flex-col">
                <!-- Header -->
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $projet->title }}</h3>
                    @if ($isLead)
                        <span class="px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-700 font-medium">⭐ Lead</span>
                    @endif
                </div>

                <p class="text-sm text-gray-500 mb-2">
                    🏢 {{ $projet->entreprise->name ?? 'N/A' }}
                </p>

                <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                    {{ $projet->description ?? 'Aucune description disponible.' }}
                </p>

                <!-- Statut & équipe -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-2 py-1 text-xs rounded-md {{ $statusColor }}">
                        {{ ucfirst(str_replace('_', ' ', $projet->status)) }}
                    </span>
                    @if ($projet->team)
                        <span class="px-2 py-1 text-xs rounded-md bg-blue-100 text-blue-700">
                            👥 Équipe: {{ $projet->team->name }}
                        </span>
                    @endif
                </div>

                <!-- Progression -->
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-1">Tâches : {{ $completedProjectTasks }} / {{ $totalProjectTasks }}</p>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 text-right">{{ $progressPercentage }}% terminé</p>
                </div>

                <!-- Footer -->
                <div class="flex justify-between text-xs text-gray-500 mb-4">
                    <span>💬 {{ $projet->comments->count() }} commentaires</span>
                    <span>📁 {{ $projet->files->count() }} fichiers</span>
                </div>

                <a href="{{ route('employe.projects.show', $projet) }}"
                   class="mt-auto inline-block text-center bg-black text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    👀 Voir les détails
                </a>
            </div>
        @empty
            <div class="col-span-3">
                <div class="text-center py-10 text-gray-500 border rounded-lg">
                    📭 Aucun projet trouvé correspondant à vos filtres.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
