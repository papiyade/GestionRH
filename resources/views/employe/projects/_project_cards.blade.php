{{-- This file: resources/views/employe/projects/_project_cards.blade.php --}}

@forelse ($projets as $projet)
    @php
        // Check if the authenticated user is the lead for this specific project
        $isLead = $projet->users()->where('user_id', Auth::id())->wherePivot('is_lead', true)->exists();

        // Calculate project-level task completion percentage
        $totalProjectTasks = $projet->tasks->count();
        $completedProjectTasks = $projet->tasks->where('status', 'completed')->count();
        $progressPercentage = $totalProjectTasks > 0 ? round(($completedProjectTasks / $totalProjectTasks) * 100) : 0;

        $statusClass = match($projet->status) {
            'not_started' => 'secondary',
            'in_progress' => 'warning',
            'completed' => 'success',
            default => 'light',
        };
    @endphp
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title d-flex justify-content-between align-items-center">
                    {{ $projet->title }}
                    @if ($isLead)
                        <span class="badge bg-primary ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Vous êtes le chef de projet">
                            <i class="bi bi-star-fill"></i> Lead
                        </span>
                    @endif
                </h5>
                <h6 class="card-subtitle mb-2 text-muted small">
                    <i class="bi bi-building me-1"></i> {{ $projet->entreprise->name ?? 'N/A' }}
                </h6>

                <p class="card-text text-truncate-3" style="font-size: 0.9rem;">
                    {{ $projet->description ?? 'Aucune description disponible.' }}
                </p>

                <div class="mb-2">
                    <span class="badge bg-{{ $statusClass }}">
                        {{ ucfirst(str_replace('_', ' ', $projet->status)) }}
                    </span>
                    @if ($projet->team)
                        <span class="badge bg-info text-dark ms-2">
                            <i class="bi bi-people-fill me-1"></i> Équipe: {{ $projet->team->name }}
                        </span>
                    @endif
                </div>

                <div class="mb-3">
                    <p class="text-muted small mb-1">
                        <i class="bi bi-list-task me-1"></i> Tâches du projet: {{ $completedProjectTasks }} / {{ $totalProjectTasks }}
                    </p>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-muted small text-end mt-1">{{ $progressPercentage }}% du projet terminé</p>
                </div>

                <div class="row text-muted small mb-3">
                    <div class="col-6">
                        <p class="mb-0"><i class="bi bi-chat-dots me-1"></i> Commentaires: {{ $projet->comments->count() }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-0"><i class="bi bi-file-earmark me-1"></i> Fichiers: {{ $projet->files->count() }}</p>
                    </div>
                </div>

                <div class="mt-auto">
                    <a href="{{ route('employe.projects.show', $projet) }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Voir les détails
                    </a>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info text-center py-4">
            <i class="bi bi-info-circle-fill me-2"></i> Aucun projet trouvé correspondant à votre recherche ou filtre.
        </div>
    </div>
@endforelse