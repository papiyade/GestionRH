@php
    $layout = 'layout.admin'; // par défaut pour admin

    if (Auth::check()) {
        if (Auth::user()->role === 'rh') {
            $layout = 'layout.admin_rh';
        } elseif (Auth::user()->role === 'admin') {
            $layout = 'layout.admin';
        } elseif (Auth::user()->role === 'employe') {
            $layout = 'layout.employe';
        }

    }
@endphp

@extends($layout)
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">
                        <i class="fas fa-edit"></i> Modifier le CRA
                    </h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('cras.update', $cra) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Semaine du {{ \Carbon\Carbon::parse($cra->date_debut)->format('d M Y') }} 
                            au {{ \Carbon\Carbon::parse($cra->date_fin)->format('d M Y') }}
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date Début *</label>
                                <input type="date" name="date_debut" 
                                       class="form-control @error('date_debut') is-invalid @enderror" 
                                       {{-- value="{{ old('date_debut', $cra->date_debut->format('Y-m-d')) }}" --}}
                                        required>
                                @error('date_debut')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date Fin *</label>
                                <input type="date" name="date_fin" 
                                       class="form-control @error('date_fin') is-invalid @enderror" 
                                       {{-- value="{{ old('date_fin', $cra->date_fin->format('Y-m-d')) }}" --}}
                                        required>
                                @error('date_fin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Activités / Projets * <span class="text-danger">●</span></label>
                            <textarea name="activites" 
                                    class="form-control @error('activites') is-invalid @enderror" 
                                    rows="6" required>{{ old('activites', $cra->activites) }}</textarea>
                            @error('activites')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <div class="card bg-light">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-check-circle"></i> Ce qui a bien fonctionné</h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="bien_fonctionne" 
                                                class="form-control"
                                                rows="4">{{ old('bien_fonctionne', $cra->bien_fonctionne ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card bg-light">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0"><i class="fas fa-times-circle"></i> Ce qui n'a pas bien fonctionné</h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="pas_bien_fonctionne" 
                                                class="form-control"
                                                rows="4">{{ old('pas_bien_fonctionne', $cra->pas_bien_fonctionne ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Points Durs / Faits Marquants</label>
                            <textarea name="points_durs" 
                                    class="form-control @error('points_durs') is-invalid @enderror"
                                    rows="4">{{ old('points_durs', $cra->points_durs ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Prochaines Étapes (Next Steps)</label>
                            <textarea name="next_steps" 
                                    class="form-control @error('next_steps') is-invalid @enderror"
                                    rows="4">{{ old('next_steps', $cra->next_steps ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Commentaires / Recommandations</label>
                            <textarea name="commentaires" 
                                    class="form-control @error('commentaires') is-invalid @enderror" 
                                    rows="5">{{ old('commentaires', $cra->commentaires) }}</textarea>
                            @error('commentaires')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('cras.show', $cra) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Mettre à Jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection