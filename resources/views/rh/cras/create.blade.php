@extends('layout.admin_rh')

@section('title', 'Créer un nouveau CRA')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-white">
                            <i class="fas fa-file-alt"></i> Nouveau Compte Rendu d'Activité
                        </h3>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h5><i class="fas fa-exclamation-circle"></i> Erreurs dans le formulaire</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('cras.store') }}" method="POST">
                        @csrf

                        <div class="alert alert-info border-0">
                            <i class="fas fa-lightbulb"></i>
                            <strong>CRA = Compte Rendu d'Activité</strong> - Documentez vos activités hebdomadaires, vos projets, les points difficiles et vos recommandations.
                        </div>

                        <!-- Section Dates -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-calendar"></i> Période du CRA
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Date Début *</label>
                                <input type="date" name="date_debut" 
                                       class="form-control @error('date_debut') is-invalid @enderror" 
                                       value="{{ old('date_debut', now()->startOfWeek()->format('Y-m-d')) }}" required>
                                <small class="text-muted">Premier jour de la semaine</small>
                                @error('date_debut')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Date Fin *</label>
                                <input type="date" name="date_fin" 
                                       class="form-control @error('date_fin') is-invalid @enderror" 
                                       value="{{ old('date_fin', now()->endOfWeek()->format('Y-m-d')) }}" required>
                                <small class="text-muted">Dernier jour de la semaine</small>
                                @error('date_fin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($teams->count() > 0)
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Équipe (Optionnel)</label>
                                <select name="team_id" class="form-select @error('team_id') is-invalid @enderror">
                                    <option value="">-- Sélectionner une équipe --</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('team_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                        </div>

                        <!-- Section Activités -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-tasks"></i> Activités / Projets
                        </h5>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Activités Principales * <span class="text-danger">●</span></label>
                            <textarea name="activites" 
                                    class="form-control @error('activites') is-invalid @enderror" 
                                    rows="5" required
                                    placeholder="Décrivez vos activités et projets de la semaine:&#10;- Projet/Action 1&#10;- Projet/Action 2&#10;- Réunions importantes&#10;- Etc.">{{ old('activites') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Énumérez tous vos projets, actions et activités principales
                            </small>
                            @error('activites')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Positive/Négative -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-chart-pie"></i> Analyse de la Semaine
                        </h5>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <div class="card bg-light border-success">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-check-circle"></i> Ce qui a bien fonctionné
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="bien_fonctionne" 
                                                class="form-control @error('bien_fonctionne') is-invalid @enderror"
                                                rows="4"
                                                placeholder="Décrivez les points positifs et succès...">{{ old('bien_fonctionne') }}</textarea>
                                        @error('bien_fonctionne')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card bg-light border-danger">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-times-circle"></i> Ce qui n'a pas bien fonctionné
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="pas_bien_fonctionne" 
                                                class="form-control @error('pas_bien_fonctionne') is-invalid @enderror"
                                                rows="4"
                                                placeholder="Décrivez les difficultés, obstacles...">{{ old('pas_bien_fonctionne') }}</textarea>
                                        @error('pas_bien_fonctionne')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Points Durs -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-exclamation-triangle"></i> Points Durs & Faits Marquants
                        </h5>
                        <div class="mb-4">
                            <textarea name="points_durs" 
                                    class="form-control @error('points_durs') is-invalid @enderror"
                                    rows="4"
                                    placeholder="Décrivez les situations difficiles, les obstacles rencontrés ou les événements importants...">{{ old('points_durs') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Quels sont les défis à relever, les blocages ou les faits marquants?
                            </small>
                            @error('points_durs')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Next Steps -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-arrow-right"></i> Prochaines Étapes (Next Steps)
                        </h5>
                        <div class="mb-4">
                            <textarea name="next_steps" 
                                    class="form-control @error('next_steps') is-invalid @enderror"
                                    rows="4"
                                    placeholder="- Tâche 1 (échéance: date)&#10;- Tâche 2 (échéance: date)&#10;- Suivi de...&#10;- Etc.">{{ old('next_steps') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Planifiez vos prochaines actions et définissez les échéances
                            </small>
                            @error('next_steps')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Commentaires -->
                        <h5 class="mt-4 mb-3 text-primary">
                            <i class="fas fa-comment"></i> Commentaires & Recommandations
                        </h5>
                        <div class="mb-4">
                            <textarea name="commentaires" 
                                    class="form-control @error('commentaires') is-invalid @enderror" 
                                    rows="4"
                                    placeholder="Ajoutez vos recommandations, observations ou commentaires supplémentaires...">{{ old('commentaires') }}</textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Recommandations pour l'équipe, observations, autocritique...
                            </small>
                            @error('commentaires')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('cras.index') }}" class="btn btn-lg btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="fas fa-save"></i> Soumettre le CRA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-remplir les dates
    document.addEventListener('DOMContentLoaded', function() {
        const dateDebut = document.querySelector('input[name="date_debut"]');
        const dateFin = document.querySelector('input[name="date_fin"]');
        
        if (dateDebut && dateDebut.value) {
            const debut = new Date(dateDebut.value);
            const fin = new Date(debut);
            fin.setDate(fin.getDate() + 6);
            
            if (!dateFin.value) {
                dateFin.value = fin.toISOString().split('T')[0];
            }
        }

        dateDebut?.addEventListener('change', function() {
            const debut = new Date(this.value);
            const fin = new Date(debut);
            fin.setDate(fin.getDate() + 6);
            dateFin.value = fin.toISOString().split('T')[0];
        });
    });
</script>
@endsection