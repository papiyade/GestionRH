@extends('layout.superadmin')

@section('title', 'Tableau de Bord SuperAdmin')
@section('page-title', 'Liste des Admins Entreprise')

@section('content')
@if(session('success'))
<!-- Success Alert -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Succès</strong> - {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
@endif

				<!-- Breadcrumb -->
				<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
					<div class="my-auto mb-2">
						<h2 class="mb-1">Administrateurs</h2>
						<nav>
							<ol class="breadcrumb mb-0">
								<li class="breadcrumb-item">
									<a href="https://smarthr.co.in/demo/html/template/index.html"><i class="ti ti-smart-home"></i></a>
								</li>
								<li class="breadcrumb-item">
									Superadmin
								</li>
								<li class="breadcrumb-item active" aria-current="page">Liste des admins</li>
							</ol>
						</nav>
					</div>
					<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
						<div class="me-2 mb-2">
							<div class="dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
									<i class="ti ti-file-export me-1"></i>Exporter
								</a>
								<ul class="dropdown-menu  dropdown-menu-end p-3">
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Exporter vers PDF</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Exporter vers Excel </a>
									</li>
								</ul>
							</div>
						</div>
						<div class="mb-2">
							<a href="#" data-bs-toggle="modal" data-bs-target="#add_users" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Nouvel admin</a>
						</div>
						<div class="head-icons ms-2">
							<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
								<i class="ti ti-chevrons-up"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- /Breadcrumb -->

				<!-- Performance Indicator list -->
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
						<h5>Liste des admins</h5>
						<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
							<div class="me-3">
								<div class="input-icon-end position-relative">
									<input type="text" class="form-control date-range bookingrange" placeholder="dd/mm/yyyy - dd/mm/yyyy">
									<span class="input-icon-addon">
										<i class="ti ti-chevron-down"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="custom-datatable-filter table-responsive">
							<table class="table datatable">
								<thead class="thead-light">
									<tr>
										<th class="no-sort">
											<div class="form-check form-check-md">
												<input class="form-check-input" type="checkbox" id="select-all">
											</div>
										</th>
										<th>Nom</th>
										<th>Email</th>
										<th>Ajouté le</th>
										<th>Téléphone</th>
										<th>Adresse</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($admins as $admin )
									<tr>
										<td>
											<div class="form-check form-check-md">
												<input class="form-check-input" type="checkbox">
											</div>
										</td>
										<td>
											<div class="d-flex align-items-center file-name-icon">
												<div class="ms-2">
													<h6 class="fw-medium" style="color: #fff;"><a href="#">{{ $admin->name }}</a></h6>
												</div>
											</div>
										</td>
										<td><a class="fw-medium" >{{ $admin->email }}</a></td>
										<td>
											{{ $admin->created_at }}          
										</td>
										<td>
											<span class="fw-medium">{{$admin->telephone ?? 'Non renseigné'}}</span>
										</td>
										<td class="fw-medium">{{ $admin->adresse ?? 'Non renseignée' }}</td>
										<td>
											<div class="action-icon d-inline-flex">
                                                @if ($admin->entreprise_id)
                                                  <a href="{{ route('entreprise.show', $admin->entreprise_id) }}" class="me-2"><i class="ti ti-shield"></i></a>
                                                @endif

												<a href="#" class="me-2" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="ti ti-edit"></i></a>
												<a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
											</div>
										</td>
									</tr>
				                @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- /Performance Indicator list -->

                		<!-- Add Users -->
		<div class="modal fade" id="add_users">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ajouter un nouvel admin</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<form action="{{route('add_admin')}}" method="POST">
                        @csrf
						<div class="modal-body pb-0">
							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Prénom et Nom</label>
										<input type="text" id="name" name="name" class="form-control">
									</div>	
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input type="email" id="email" name="email" class="form-control">
									</div>	
								</div>
                                <div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Téléphone</label>
										<input type="tel" id="telephone" name="telephone" class="form-control">
									</div>	
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Mot de passe</label>
										<div class="pass-group">
											<input type="password" id="password" name="password" class="pass-input form-control">
											<span class="ti toggle-password ti-eye-off"></span>
										</div>
									</div>	
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Confirmer le mot de passe</label>
										<div class="pass-group">
											<input type="password" id="password_confirmation" name="password_confirmation" class="pass-inputs form-control">
											<span class="ti toggle-passwords ti-eye-off"></span>
										</div>
									</div>	
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">Annuler</button>
							<button type="submit" class="btn btn-primary">Ajouter</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Users -->

		<!-- Edit  Users -->
		<div class="modal fade" id="edit_user">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Editer l'admin</h4>
						<button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="ti ti-x"></i>
						</button>
					</div>
					<form action="{{route('add_admin')}}" method="POST">
                        @csrf
						<div class="modal-body pb-0">
							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Prénom et Nom</label>
										<input type="text" id="name" name="name" class="form-control">
									</div>	
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input type="email" id="email" name="email" class="form-control">
									</div>	
								</div>
                                <div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Téléphone</label>
										<input type="tel" id="telephone" name="telephone" class="form-control">
									</div>	
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Mot de passe</label>
										<div class="pass-group">
											<input type="password" id="password" name="password" class="pass-input form-control">
											<span class="ti toggle-password ti-eye-off"></span>
										</div>
									</div>	
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="form-label">Confirmer le mot de passe</label>
										<div class="pass-group">
											<input type="password" id="password_confirmation" name="password_confirmation" class="pass-inputs form-control">
											<span class="ti toggle-passwords ti-eye-off"></span>
										</div>
									</div>	
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">Annuler</button>
							<button type="submit" class="btn btn-primary">Modifier</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Edit  Users -->

		<!-- Delete Modal -->
		<div class="modal fade" id="delete_modal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
							<i class="ti ti-trash-x fs-36"></i>
						</span>
						<h4 class="mb-1">Confirmer la suppression</h4>
						<p class="mb-3">Vous etes sur le coup de supprimer l'enregistrement de cet utilisateur, cette action est irréversible .</p>
						<div class="d-flex justify-content-center">
							<a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</a>
							<a href="https://smarthr.co.in/demo/html/template/users.html" class="btn btn-danger">Supprimer</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete Modal -->

@endsection
