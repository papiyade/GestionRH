@extends('layout.admin_rh')

@section('title', 'RH')
@section('page-title', 'Detail')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <div class="avatar-xxl mx-auto mb-3">
                                @if ($user->profile_photo_path)
                                    <img class="rounded-circle img-thumbnail"
                                         src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Photo de profil">
                                @else
                                    <div class="avatar-lg">
                                        <span class="avatar-title rounded-circle bg-light text-dark font-size-32">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                            <p class="text-muted">{{ optional($user->teams->first())->name ?? 'Aucune équipe' }}</p>

                            <ul class="list-inline my-4">
                                <li class="list-inline-item mx-2"><a href="mailto:{{ $user->email }}" class="text-muted"><i class="ri-mail-line fs-4"></i></a></li>
                                {{-- Ajoutez d'autres icônes si vous avez plus de données (téléphone, etc.) --}}
                            </ul>
                        </div>
                        
                        <hr class="my-4">

                        <div class="text-start">
                            <h5 class="fw-semibold text-dark mb-3">Détails de l'employé</h5>
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted">Type de Contrat</dt>
                                <dd class="col-sm-8 text-dark">{{ $user->employeeDetail?->type_contrat ?? 'Non défini' }}</dd>

                                <dt class="col-sm-4 text-muted">Adresse E-mail</dt>
                                <dd class="col-sm-8 text-dark">{{ $user->email ?? 'Non défini' }}</dd>

                                <dt class="col-sm-4 text-muted">Adresse</dt>
                                <dd class="col-sm-8 text-dark">{{ $user->employeeDetail?->adresse ?? 'Non défini' }}</dd>

                                <dt class="col-sm-4 text-muted">Salaire</dt>
                                <dd class="col-sm-8 text-dark">
                                    {{ $user->employeeDetail?->salaire ? number_format($user->employeeDetail->salaire, 0, ',', ' ') . ' FCFA' : 'Non défini' }}
                                </dd>

                                <dt class="col-sm-4 text-muted">Description du poste</dt>
                                <dd class="col-sm-8 text-dark">
                                    {{ $user->employeeDetail?->description_poste ?? 'Non défini' }}
                                </dd>
                            </dl>
                        </div>
                        
                        <hr class="my-4">

                        <div class="d-grid mt-4">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-dark btn-lg">
                                Voir le profil complet <i class="ri-arrow-right-line align-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection