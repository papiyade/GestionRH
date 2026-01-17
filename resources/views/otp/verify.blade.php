<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Farlu - Vérification OTP">
	<meta name="author" content="Farlu">
	<meta name="robots" content="noindex, nofollow">
	<title>Farlu | Vérification OTP</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="https://smarthr.co.in/demo/html/template/assets/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/icons/feather/feather.css">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/tabler-icons/tabler-icons.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="https://smarthr.co.in/demo/html/template/assets/plugins/fontawesome/css/all.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

	<style>
		.otp-input input {
			border: 2px solid #e0e0e0;
			transition: all 0.3s ease;
		}
		.otp-input input:focus {
			border-color: #AE3D7D;
			box-shadow: 0 0 0 0.2rem rgba(108, 95, 252, 0.25);
			outline: none;
		}
		.otp-input input.error {
			border-color: #dc3545;
			animation: shake 0.3s;
		}
		@keyframes shake {
			0%, 100% { transform: translateX(0); }
			25% { transform: translateX(-5px); }
			75% { transform: translateX(5px); }
		}
		.alert-container {
			position: fixed;
			top: 20px;
			right: 20px;
			z-index: 9999;
			max-width: 400px;
		}
		.timer-badge {
			font-size: 16px;
			padding: 8px 16px;
		}
		.resend-link {
			color: #AE3D7D;
			cursor: pointer;
			transition: all 0.3s ease;
		}
		.resend-link:hover {
			text-decoration: underline;
		}
		.resend-link.disabled {
			opacity: 0.5;
			pointer-events: none;
		}
	</style>
</head>

<body class="bg-linear-gradiant">

	<div id="global-loader" style="display: none;">
		<div class="page-loader"></div>
	</div>

	<!-- Alert Container -->
	<div class="alert-container" id="alertContainer"></div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<div class="container-fuild">
			<div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
				<div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
					<div class="col-md-4 mx-auto vh-100">
						<form method="POST" action="{{ route('otp.verify') }}" id="otpForm" class="digit-group vh-100">
							@csrf
							<div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
								<div class="mx-auto mb-5 text-center">
									<img src="https://smarthr.co.in/demo/html/template/assets/img/logo.svg" class="img-fluid" alt="Logo">
								</div>
								
								<div>
									<!-- Messages de session Laravel -->
									@if(isset($message))
										<div class="alert alert-info alert-dismissible fade show" role="alert">
											{{ $message }}
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									@endif

									@if(session('success'))
										<div class="alert alert-success alert-dismissible fade show" role="alert">
											{{ session('success') }}
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									@endif

									@if(session('error'))
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											{{ session('error') }}
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									@endif

									@if($errors->any())
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											{{ $errors->first() }}
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									@endif

									<div class="text-center mb-3">
										<h2 class="mb-2">Vérification OTP par Email</h2>
										<p class="mb-0 text-primary">Un code OTP a été envoyé à votre adresse email</p>
									</div>

									<div class="text-center otp-input">
                                        <div class="d-flex align-items-center justify-content-center mb-3 gap-2">
                                            <input type="text" class="rounded py-2 text-center fw-bold otp-digit" 
                                                id="digit-1" data-index="0" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]" style="width: 50px; height: 50px; font-size: 24px;">
                                            <input type="text" class="rounded py-2 text-center fw-bold otp-digit" 
                                                id="digit-2" data-index="1" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]" style="width: 50px; height: 50px; font-size: 24px;">
                                            <input type="text" class="rounded py-2 text-center fw-bold otp-digit" 
                                                id="digit-3" data-index="2" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]" style="width: 50px; height: 50px; font-size: 24px;">
                                            <input type="text" class="rounded py-2 text-center fw-bold otp-digit" 
                                                id="digit-4" data-index="3" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]" style="width: 50px; height: 50px; font-size: 24px;">
                                            <input type="text" class="rounded py-2 text-center fw-bold otp-digit" 
                                                id="digit-5" data-index="4" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]" style="width: 50px; height: 50px; font-size: 24px;">
                                            <input type="text" class="rounded py-2 text-center fw-bold otp-digit" 
                                                id="digit-6" data-index="5" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]" style="width: 50px; height: 50px; font-size: 24px;">
                                        </div>

										<!-- Champ caché pour envoyer le code OTP complet -->
										<input type="hidden" name="otp" id="otpValue">

										<div>
											<div class="badge bg-danger-transparent mb-3 timer-badge">
												<p class="d-flex align-items-center mb-0">
													<i class="ti ti-clock me-1"></i>
													<span id="timer">10:00</span>
												</p>
											</div>
											<div class="mb-3 d-flex justify-content-center">
												<p class="text-gray-9 mb-0">
													Vous n'avez pas reçu le code ? 
													<a href="{{ route('otp.resend') }}" class="text-primary resend-link" id="resendLink">
														Renvoyer le code OTP
													</a>
												</p>
											</div>
										</div>
									</div>

									<div class="mb-3">
										<button type="submit" class="btn btn-primary w-100" id="verifyBtn">
											Vérifier et Continuer
										</button>
									</div>
								</div>

								<div class="mt-5 pb-4 text-center">
									<p class="mb-0 text-gray-9">Copyright &copy; 2025 - Farlu</p>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="https://smarthr.co.in/demo/html/template/assets/js/jquery-3.7.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="https://smarthr.co.in/demo/html/template/assets/js/bootstrap.bundle.min.js"></script>

	<!-- Feather Icon JS -->
	<script src="https://smarthr.co.in/demo/html/template/assets/js/feather.min.js"></script>

	<!-- Custom JS -->
	<script src="https://smarthr.co.in/demo/html/template/assets/js/script.js"></script>

	<script>
		// ===== Gestion des champs OTP =====
		const otpInputs = document.querySelectorAll('.otp-digit');
		const otpValue = document.getElementById('otpValue');
		const form = document.getElementById('otpForm');
		const verifyBtn = document.getElementById('verifyBtn');

		// Focus sur le premier champ au chargement
		window.addEventListener('load', () => {
			otpInputs[0].focus();
		});

		// Gestion de la navigation entre les champs
		otpInputs.forEach((input, index) => {
			// Saisie de chiffre
			input.addEventListener('input', (e) => {
				const value = e.target.value;
				
				// Accepter uniquement les chiffres
				if (!/^\d$/.test(value)) {
					e.target.value = '';
					return;
				}

				// Retirer la classe d'erreur
				input.classList.remove('error');

				// Passer au champ suivant
				if (value && index < otpInputs.length - 1) {
					otpInputs[index + 1].focus();
				}

				// Mettre à jour la valeur complète de l'OTP
				updateOTPValue();
			});

			// Gestion du backspace
			input.addEventListener('keydown', (e) => {
				if (e.key === 'Backspace') {
					if (!input.value && index > 0) {
						otpInputs[index - 1].focus();
						otpInputs[index - 1].value = '';
					}
					updateOTPValue();
				}

				// Navigation avec les flèches
				if (e.key === 'ArrowLeft' && index > 0) {
					otpInputs[index - 1].focus();
				}
				if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
					otpInputs[index + 1].focus();
				}
			});

			// Empêcher la saisie de caractères non numériques
			input.addEventListener('keypress', (e) => {
				if (!/^\d$/.test(e.key)) {
					e.preventDefault();
				}
			});

			// Sélectionner le contenu au focus
			input.addEventListener('focus', (e) => {
				e.target.select();
			});

			// Support du copier-coller
			input.addEventListener('paste', (e) => {
				e.preventDefault();
				const pastedData = e.clipboardData.getData('text').trim();
				
				// Vérifier que c'est un code de 6 chiffres
				if (/^\d{6}$/.test(pastedData)) {
					pastedData.split('').forEach((digit, idx) => {
						if (otpInputs[idx]) {
							otpInputs[idx].value = digit;
						}
					});
					otpInputs[5].focus();
					updateOTPValue();
				}
			});
		});

		// Mettre à jour la valeur cachée du formulaire
		function updateOTPValue() {
			const otp = Array.from(otpInputs).map(input => input.value).join('');
			otpValue.value = otp;
			
			// Activer/désactiver le bouton de vérification
			if (otp.length === 6) {
				verifyBtn.disabled = false;
			} else {
				verifyBtn.disabled = true;
			}
		}

		// Validation du formulaire
		form.addEventListener('submit', (e) => {
			const otp = otpValue.value;
			
			if (otp.length !== 6) {
				e.preventDefault();
				showAlert('Veuillez entrer un code OTP de 6 chiffres', 'danger');
				otpInputs.forEach(input => input.classList.add('error'));
				return;
			}

			verifyBtn.disabled = true;
			verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Vérification...';
		});

		// ===== Timer de 10 minutes =====
		let timeLeft = 600; // 10 minutes en secondes
		const timerElement = document.getElementById('timer');
		const resendLink = document.getElementById('resendLink');

		function updateTimer() {
			const minutes = Math.floor(timeLeft / 60);
			const seconds = timeLeft % 60;
			timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

			if (timeLeft === 0) {
				clearInterval(timerInterval);
				showAlert('Le code OTP a expiré. Veuillez en demander un nouveau.', 'warning');
				verifyBtn.disabled = true;
				resendLink.classList.remove('disabled');
			} else {
				timeLeft--;
			}
		}

		const timerInterval = setInterval(updateTimer, 1000);
		updateTimer();

		// ===== Gestion du renvoi du code =====
		resendLink.addEventListener('click', (e) => {
			if (resendLink.classList.contains('disabled')) {
				e.preventDefault();
				return;
			}

			// Désactiver temporairement le lien pendant 30 secondes
			resendLink.classList.add('disabled');
			let countdown = 30;
			const originalText = resendLink.textContent;
			
			const countdownInterval = setInterval(() => {
				resendLink.textContent = `Renvoyer dans ${countdown}s`;
				countdown--;
				
				if (countdown < 0) {
					clearInterval(countdownInterval);
					resendLink.textContent = originalText;
					resendLink.classList.remove('disabled');
				}
			}, 1000);

			// Réinitialiser le timer
			timeLeft = 600;
		});

		// ===== Fonction pour afficher les alertes =====
		function showAlert(message, type = 'success') {
			const alertContainer = document.getElementById('alertContainer');
			const alertDiv = document.createElement('div');
			alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
			alertDiv.innerHTML = `
				${message}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			`;
			alertContainer.appendChild(alertDiv);

			// Auto-dismiss après 5 secondes
			setTimeout(() => {
				alertDiv.classList.remove('show');
				setTimeout(() => alertDiv.remove(), 150);
			}, 5000);
		}

		// Désactiver le bouton initialement
		verifyBtn.disabled = true;
	</script>

</body>
</html>