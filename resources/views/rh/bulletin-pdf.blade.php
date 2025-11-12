<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Smarthr - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
	<meta name="author" content="Dreams technologies - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Smarthr Admin Template</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="https://smarthr.co.in/demo/html/template/assets/img/favicon.png">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="https://smarthr.co.in/demo/html/template/assets/img/apple-touch-icon.png">

	<!-- Theme Script js -->
	<script src="https://smarthr.co.in/demo/html/template/assets/js/theme-script.js"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/css/bootstrap.min.css">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/icons/feather/feather.css">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/tabler-icons/tabler-icons.min.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/select2/css/select2.min.css">

	<!-- Player CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/css/plyr.css">

    <!-- Datatable CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/css/dataTables.bootstrap5.min.css">

	<!-- Owl Carousel -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/owlcarousel/owl.carousel.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/fontawesome/css/all.min.css">

	 <!-- Color Picker Css -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/flatpickr/flatpickr.min.css">
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/@simonwep/pickr/themes/nano.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/css/style.css">

</head>
<body>
    <div class="card">
        <div class="card-body">
            {{-- <div class="row justify-content-between align-items-center border-bottom mb-3">
                <div class="col-md-6">
                    <div class="mb-2">
                        <img src="https://smarthr.co.in/demo/html/template/assets/img/logo.svg" class="img-fluid" alt="logo">
                    </div>
                    <p>3099 Kennedy Court Framingham, MA 01702</p>
                </div>
                <div class="col-md-6">
                    <div class=" text-end mb-3">
                        <h5 class="text-gray mb-1">Bulletin N° <span class="text-primary">#BULLETIN001</span></h5>
                        <p class="mb-1 fw-medium">Date d'émission : <span class="text-dark">{{ date('d/m/Y') }}</span> </p>
                        <p class="fw-medium">Période : <span class="text-dark">{{ $periode ?? 'Mois/Année' }}</span> </p>
                    </div>
                </div>
            </div>
            <div class="row border-bottom mb-3">
                <div class="col-md-5">
                    <p class="text-dark mb-2 fw-semibold">Employeur</p>
                    <div>
                        <h4 class="mb-1">{{ $employeur['nom'] ?? 'Nom Employeur' }}</h4>
                        <p class="mb-1">{{ $employeur['adresse'] ?? 'Adresse Employeur' }}</p>
                        <p class="mb-1">Email : <span class="text-dark">{{ $employeur['email'] ?? 'email@exemple.com' }}</span></p>
                        <p>Téléphone : <span class="text-dark">{{ $employeur['telephone'] ?? '0000000000' }}</span></p>
                    </div>
                </div>
                <div class="col-md-5">
                    <p class="text-dark mb-2 fw-semibold">Salarié</p>
                    <div>
                        <h4 class="mb-1">{{ $salarie['nom'] ?? 'Nom Salarié' }}</h4>
                        <p class="mb-1">{{ $salarie['adresse'] ?? 'Adresse Salarié' }}</p>
                        <p class="mb-1">Email : <span class="text-dark">{{ $salarie['email'] ?? 'email@exemple.com' }}</span></p>
                        <p>Téléphone : <span class="text-dark">{{ $salarie['telephone'] ?? '0000000000' }}</span></p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <p class="text-title mb-2 fw-medium">Statut Paiement</p>
                        <span class="badge badge-success align-items-center mb-3"><i class="ti ti-point-filled"></i>Payé</span>
                        <div>
                            <img src="https://smarthr.co.in/demo/html/template/assets/img/qr.svg" class="img-fluid" alt="QR">
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <p class="fw-medium">Poste : <span class="text-dark fw-medium">{{ $salarie['poste'] ?? 'Poste' }}</span></p>
                <div class="table-responsive mb-3">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Libellé</th>
                                <th class="text-end">Base</th>
                                <th class="text-end">Taux</th>
                                <th class="text-end">Retenue</th>
                                <th class="text-end">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lignes ?? [] as $ligne)
                                <tr>
                                    <td><h6>{{ $ligne['libelle'] }}</h6></td>
                                    <td class="text-gray-9 fw-medium text-end">{{ $ligne['base'] }}</td>
                                    <td class="text-gray-9 fw-medium text-end">{{ $ligne['taux'] }}</td>
                                    <td class="text-gray-9 fw-medium text-end">{{ $ligne['retenue'] }}</td>
                                    <td class="text-gray-9 fw-medium text-end">{{ $ligne['montant'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row border-bottom mb-3">
                <div class="col-md-7">
                    <div class="py-4">
                        <div class="mb-3">
                            <h6 class="mb-1">Informations</h6>
                            <p>Merci de vérifier les informations de ce bulletin. Pour toute question, contactez le service RH.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-1">Notes</h6>
                            <p>Ce bulletin est généré automatiquement.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                        <p class="mb-0">Salaire Brut</p>
                        <p class="text-dark fw-medium mb-2">{{ $brut ?? '0' }} €</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                        <p class="mb-0">Total Retenues</p>
                        <p class="text-dark fw-medium mb-2">{{ $retenues ?? '0' }} €</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                        <p class="mb-0">Net à Payer</p>
                        <p class="text-dark fw-medium mb-2">{{ $net ?? '0' }} €</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                        <h5>Net Payé</h5>
                        <h5>{{ $net ?? '0' }} €</h5>
                    </div>
                    <p class="fs-12">
                        Montant en lettres : {{ $net_lettres ?? 'Zéro euro' }}
                    </p>
                </div>
            </div>
            <div class="row justify-content-end align-items-end text-end border-bottom mb-3">
                <div class="col-md-3">
                    <div class="text-end">
                        <img src="https://smarthr.co.in/demo/html/template/assets/img/sign.svg" class="img-fluid" alt="sign">
                    </div>
                    <div class="text-end mb-3">
                        <h6 class="fs-14 fw-medium pe-3">{{ $employeur['signataire'] ?? 'Nom Signataire' }}</h6>
                        <p>{{ $employeur['fonction'] ?? 'Fonction' }}</p>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <div class="mb-3">
                    <img src="https://smarthr.co.in/demo/html/template/assets/img/logo.svg" class="img-fluid" alt="logo">
                </div>
                <p class="text-dark mb-1">Paiement effectué par virement bancaire / chèque au nom de {{ $salarie['nom'] ?? 'Nom Salarié' }}</p>
                <div class="d-flex justify-content-center align-items-center">
                    <p class="fs-12 mb-0 me-3">Banque : <span class="text-dark">{{ $banque['nom'] ?? 'Nom Banque' }}</span></p>
                    <p class="fs-12 mb-0 me-3">N° Compte : <span class="text-dark">{{ $banque['compte'] ?? 'Numéro Compte' }}</span></p>
                    <p class="fs-12">Code Banque : <span class="text-dark">{{ $banque['code'] ?? 'Code Banque' }}</span></p>
                </div>
            </div> --}}
            A compléter
        </div>
    </div>
</body>
</html>
