@extends('layout.employe')

@section('title', 'Projets')
@section('page-title', 'Détail projet')

@section('content')
@php
    $priorites = [
        'high' => ['label' => 'Haute', 'color' => 'red-500'],
        'medium' => ['label' => 'Moyenne', 'color' => 'yellow-500'],
        'low' => ['label' => 'Basse', 'color' => 'green-500'],
    ];

    $tasksByStatus = $tasks->groupBy('status');

    $statuts = [
        'not_started' => ['label' => 'Non débuté', 'icon' => '⏳', 'tasks' => $tasksByStatus->get('not_started', collect())],
        'in_progress' => ['label' => 'En cours', 'icon' => '⚡', 'tasks' => $tasksByStatus->get('in_progress', collect())],
        'completed' => ['label' => 'Terminée', 'icon' => '✅', 'tasks' => $tasksByStatus->get('completed', collect())],
    ];
@endphp

<div class="container mx-auto max-w-7xl px-4">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 flex items-center gap-2">
                📌 {{ $project->title }}
            </h1>
            <p class="text-gray-500">Mes tâches pour ce projet</p>
        </div>
        <a href="{{ route('employe.projects') }}" class="px-4 py-2 text-sm border rounded-lg text-gray-600 hover:bg-gray-100 transition">
            ← Retour aux projets
        </a>
    </div>

    <!-- Search -->
    <div class="mb-8">
        <input type="text" id="taskSearch"
            class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black"
            placeholder="🔍 Rechercher une tâche par titre...">
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="p-4 border rounded-xl bg-white shadow-sm text-center">
            <p class="text-gray-500 text-sm">Total tâches</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $tasks->count() }}</p>
        </div>
        <div class="p-4 border rounded-xl bg-white shadow-sm text-center">
            <p class="text-gray-500 text-sm">Non débuté</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $statuts['not_started']['tasks']->count() }}</p>
        </div>
        <div class="p-4 border rounded-xl bg-white shadow-sm text-center">
            <p class="text-gray-500 text-sm">En cours</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $statuts['in_progress']['tasks']->count() }}</p>
        </div>
        <div class="p-4 border rounded-xl bg-white shadow-sm text-center">
            <p class="text-gray-500 text-sm">Terminées</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $statuts['completed']['tasks']->count() }}</p>
        </div>
    </div>

    <!-- Kanban -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($statuts as $keyStatut => $statut)
            <div class="bg-gray-50 border rounded-xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-800 flex items-center gap-2">
                        {{ $statut['icon'] }} {{ $statut['label'] }}
                    </h2>
                    <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-700">
                        {{ $statut['tasks']->count() }}
                    </span>
                </div>

                <div class="space-y-4 max-h-[70vh] overflow-y-auto" data-column="{{ $keyStatut }}">
                    @forelse($statut['tasks']->sortByDesc('priority') as $task)
                        @php
                            $prio = $priorites[$task->priority] ?? ['label'=>'Inconnue','color'=>'gray-400'];
                        @endphp
                        <div class="bg-white p-4 rounded-lg border shadow-sm hover:shadow-md transition task-card"
                             data-titre="{{ strtolower($task->title) }}">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-medium text-gray-900">{{ $task->title }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full text-white bg-{{ $prio['color'] }}">
                                    {{ $prio['label'] }}
                                </span>
                            </div>

                            @if($task->description)
                                <p class="text-sm text-gray-500 mb-2">{{ Str::limit($task->description, 80) }}</p>
                            @endif

                            @if($task->deadline)
                                <p class="text-xs text-gray-500 mb-2">
                                    📅 {{ $task->deadline->format('d/m/Y') }}
                                    @if($task->deadline->isPast() && $task->status !== 'completed')
                                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-600">En retard</span>
                                    @endif
                                </p>
                            @endif

                            <!-- Assignés -->
                            <div class="mb-3 flex flex-wrap gap-2">
                                @forelse($task->users as $user)
                                    <span class="px-2 py-1 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium">
                                        {{ $user->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-sm">Non assigné</span>
                                @endforelse
                            </div>

                            <!-- Changer statut -->
                            <form action="{{ route('employe.tasks.changerStatut', $task) }}" method="POST" class="mb-3">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="w-full rounded-md border-gray-300 text-sm"
                                    onchange="if(confirm('Changer le statut de cette tâche ?')) this.form.submit()">
                                    @foreach(App\Models\Task::statuses() as $sKey => $sLabel)
                                        <option value="{{ $sKey }}" {{ $task->status === $sKey ? 'selected' : '' }}>
                                            {{ $sLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>

                            <!-- Commentaires -->
                            <details class="text-sm">
                                <summary class="cursor-pointer text-gray-600 hover:text-black">
                                    💬 Commentaires ({{ $task->comments->count() }})
                                </summary>
                                <div class="mt-2 space-y-2 max-h-28 overflow-y-auto">
                                    @forelse($task->comments as $comment)
                                        <div class="p-2 bg-gray-50 rounded-md text-gray-700 text-sm">
                                            <strong class="text-gray-900">{{ $comment->user->name ?? 'Anonyme' }}:</strong>
                                            {{ $comment->content }}
                                        </div>
                                    @empty
                                        <p class="text-gray-400">Aucun commentaire</p>
                                    @endforelse
                                </div>
                            </details>

                            <form action="{{ route('employe.tasks.commenter', $task) }}" method="POST" class="mt-2 flex">
                                @csrf
                                <input type="text" name="content"
                                    class="flex-1 rounded-l-md border-gray-300 text-sm"
                                    placeholder="Ajouter un commentaire..." required>
                                <button class="px-3 bg-black text-white text-sm rounded-r-md">Envoyer</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center py-6">Aucune tâche ici</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('taskSearch');
    const taskCards = document.querySelectorAll('.task-card');

    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        taskCards.forEach(card => {
            const title = card.getAttribute('data-titre');
            card.style.display = title.includes(query) ? '' : 'none';
        });
    });
});
</script>
@endsection
