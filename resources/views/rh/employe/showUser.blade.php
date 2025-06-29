@extends('layouts.admin_rh-dashboard')

@section('content')
<div class="container">
    <div class="row"></div>
        <div class="col-lg-12">
            <div class="card"></div>
                <div class="card-header">
                        <div class="card" id="company-overview">
                            <div class="card-body">
                                <div class="avatar-lg mx-auto mb-3">
                                    <div class="avatar-title bg-light rounded">
                                        @if ($user->profile_photo_path)
                                        <img class="rounded-circle header-profile-user" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Header Avatar">
                                    @else
                                    <div class="avatar-lg">
                                        <span class="avatar-title rounded-circle bg-primary text-white font-size-32">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                                        </span>
                                    </div>
                                    @endif
                                    </div>
                                </div>

                                <div class="text-center">
                                    <a href="#!">
                                        <h5 class="overview-companyname">{{$user->name}}</h5>
                                    </a>
                                    <p class="text-muted overview-industryType">{{ $user->teams->first()->name }}</p>

                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-success-subtle text-success fs-15 rounded">
                                                <i class="ri-account-circle-line"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                                                <i class="ri-question-answer-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Information</h6>
                                <p class="text-muted mb-4 overview-companydesc">{{ $user->teams->first()->description }}</p>

                                <div class="table-responsive table-card">
                                    <table class="table table-borderless mb-4">
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium" scope="row">Type de Contrat</td>
                                                <td class="overview-industryType">{{ $user->employeeDetail->type_contrat }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium" scope="row">Email</td>
                                                <td class="overview-email">{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium" scope="row">Adresse</td>
                                                <td class="overview-company_location">{{ $user->employeeDetail->adresse }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium" scope="row">Salaire</td>
                                                <td><span class="overview-rating">{{ $user->employeeDetail->salaire}}</span> <i class="ri-star-fill text-warning align-bottom"></i></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium" scope="row">Description</td>
                                                <td>
                                                    <span  class="overview-website">{{ $user->employeeDetail->description_poste }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="hstack gap-3">
                                    <button type="button" class="btn btn-soft-success custom-toggle w-100 material-shadow-none" data-bs-toggle="button">
                                        <a class="icon-on"><i class="ri-pencil-line align-bottom me-1"></i> Completer le profil</a>
                                    </button>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary w-100">Voir le profil <i class="ri-arrow-right-line align-bottom"></i></a>
                                    <a href="#!" class="btn btn-danger w-100">Bloquer le compte <i class="ri-trash align-bottom"></i></a>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>

@endsection