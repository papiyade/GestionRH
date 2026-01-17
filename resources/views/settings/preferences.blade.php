@extends('layout.admin_rh')

@section('content')
<style>
    .settings-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 24px;
    }

    .settings-header {
        margin-bottom: 32px;
    }

    .settings-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .settings-header p {
        color: #7f8c8d;
        font-size: 1rem;
    }

    /* Tabs Navigation */
    .tabs-nav {
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 32px;
        display: flex;
        gap: 8px;
        overflow-x: auto;
    }

    .tab-item {
        padding: 14px 24px;
        color: #666;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        border-bottom: 3px solid transparent;
        transition: all 0.2s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .tab-item:hover {
        color: #AE3D7D;
        background: #f8f9fa;
    }

    .tab-item.active {
        color: #AE3D7D;
        border-bottom-color: #AE3D7D;
        font-weight: 600;
    }

    .tab-item i {
        font-size: 1.1rem;
    }

    /* Tab Content */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Settings Card */
    .settings-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 32px;
        margin-bottom: 24px;
    }

    .settings-card h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .settings-card p {
        color: #7f8c8d;
        margin-bottom: 24px;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-group .description {
        color: #999;
        font-size: 0.85rem;
        margin-top: 6px;
    }

    .form-control {
        width: 100%;
        height: 4%;
        padding: 12px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #AE3D7D;
        outline: none;
        box-shadow: 0 0 0 3px rgba(174, 61, 125, 0.1);
    }

    /* Switch Toggle */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.3s;
        border-radius: 26px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }

    .switch-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .switch-row:last-child {
        border-bottom: none;
    }

    .switch-label {
        flex: 1;
    }

    .switch-label h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .switch-label p {
        font-size: 0.85rem;
        color: #999;
        margin: 0;
    }

    /* Select */
    select.form-control {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
        appearance: none;
    }

    /* Danger Zone */
    .danger-zone {
        background: #fff5f5;
        border: 2px solid #fee;
        border-radius: 12px;
        padding: 32px;
        margin-top: 48px;
    }

    .danger-zone h3 {
        color: #dc3545;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .danger-zone p {
        color: #666;
        margin-bottom: 24px;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        color: white;
        padding: 12px 32px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(174, 61, 125, 0.3);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #666;
        padding: 12px 32px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        max-width: 500px;
        width: 90%;
        padding: 32px;
        animation: slideUp 0.3s;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        margin-bottom: 24px;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .modal-body {
        margin-bottom: 24px;
    }

    .modal-footer {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .alert-warning {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        color: #856404;
    }

    .alert-danger {
        background: #f8d7da;
        border-left: 4px solid #dc3545;
        color: #721c24;
    }

    .input-verification {
        font-family: monospace;
        font-size: 0.9rem;
        background: #f8f9fa;
    }

    /* Theme Selector */
    .theme-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 12px;
    }

    .theme-selector input[type="radio"] {
        display: none;
    }

    .theme-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
    }

    .theme-option:hover {
        border-color: #AE3D7D;
        background: #fafafa;
    }

    .theme-selector input[type="radio"]:checked + .theme-option {
        border-color: #AE3D7D;
        background: linear-gradient(135deg, rgba(174, 61, 125, 0.05) 0%, rgba(134, 18, 84, 0.05) 100%);
        position: relative;
    }

    .theme-selector input[type="radio"]:checked + .theme-option::after {
        content: '\2713';
        position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
        background: linear-gradient(135deg, #AE3D7D 0%, #861254FF 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
    }

    .theme-option i {
        font-size: 2rem;
        color: #AE3D7D;
        margin-bottom: 12px;
    }

    .theme-option span {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    @media (max-width: 576px) {
        .theme-selector {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="settings-container">
    <!-- Header -->
    <div class="settings-header">
        <h1><i class="bi bi-sliders"></i> Paramètres</h1>
        <p>Gérez vos préférences et paramètres du compte</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="tabs-nav">
        <a href="{{ route('settings.edit') }}" class="tab-item">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
        <div class="tab-item active" data-tab="preferences">
            <i class="bi bi-gear"></i>
            <span>Préférences</span>
        </div>
        <div class="tab-item" data-tab="notifications">
            <i class="bi bi-bell"></i>
            <span>Notifications</span>
        </div>
        <div class="tab-item" data-tab="privacy">
            <i class="bi bi-shield-check"></i>
            <span>Confidentialité</span>
        </div>
        <div class="tab-item" data-tab="appearance">
            <i class="bi bi-palette"></i>
            <span>Apparence</span>
        </div>
    </div>

    <!-- Tab: Préférences -->
    <div id="preferences" class="tab-content active">
        <form method="POST" action="{{ route('settings.preferences.update') }}">
            @csrf
            @method('PUT')

            <div class="settings-card">
                <h3>Préférences générales</h3>
                <p>Configurez vos préférences d'utilisation</p>

                <div class="form-group">
                    <label>Langue</label>
                    <select name="language" class="form-control">
                        <option value="fr" selected>Français</option>
                        <option value="en">English</option>
                        <option value="es">Español</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fuseau horaire</label>
                    <select name="timezone" class="form-control">
                        <option value="Africa/Dakar" selected>Afrique/Dakar (GMT+0)</option>
                        <option value="Europe/Paris">Europe/Paris (GMT+1)</option>
                        <option value="America/New_York">America/New York (GMT-5)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Format de date</label>
                    <select name="date_format" class="form-control">
                        <option value="d/m/Y" selected>DD/MM/YYYY</option>
                        <option value="m/d/Y">MM/DD/YYYY</option>
                        <option value="Y-m-d">YYYY-MM-DD</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>

    <!-- Tab: Notifications -->
    <div id="notifications" class="tab-content">
        <form method="POST" action="{{ route('settings.notifications.update') }}">
            @csrf
            @method('PUT')

            <div class="settings-card">
                <h3>Notifications par email</h3>
                <p>Choisissez les notifications que vous souhaitez recevoir</p>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Nouveaux messages</h4>
                        <p>Recevoir un email lors de nouveaux messages</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="notif_messages" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Mises à jour de projets</h4>
                        <p>Notifications sur les modifications de projets</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="notif_projects" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Rappels de tâches</h4>
                        <p>Recevoir des rappels pour vos tâches</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="notif_tasks" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Newsletter</h4>
                        <p>Recevoir notre newsletter mensuelle</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="notif_newsletter">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>

    <!-- Tab: Confidentialité -->
    <div id="privacy" class="tab-content">
        <form method="POST" action="{{ route('settings.privacy.update') }}">
            @csrf
            @method('PUT')

            <div class="settings-card">
                <h3>Paramètres de confidentialité</h3>
                <p>Contrôlez qui peut voir vos informations</p>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Profil public</h4>
                        <p>Rendre mon profil visible aux autres utilisateurs</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="public_profile" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Afficher l'email</h4>
                        <p>Permettre aux autres de voir votre email</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="show_email">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Statut en ligne</h4>
                        <p>Afficher quand vous êtes en ligne</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="online_status" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>

    <!-- Tab: Apparence -->
    <div id="appearance" class="tab-content">
        <form method="POST" action="{{ route('settings.appearance.update') }}">
            @csrf
            @method('PUT')

            <div class="settings-card">
                <h3>Personnalisation de l'interface</h3>
                <p>Adaptez l'apparence à vos préférences</p>

                <div class="form-group">
                    <label>Thème</label>
                    <div class="theme-selector">
                        <input type="radio" name="theme" id="theme-light" value="light" {{ (Auth::user()->preferences['appearance']['theme'] ?? 'light') == 'light' ? 'checked' : '' }}>
                        <label for="theme-light" class="theme-option">
                            <i class="ti ti-sun"></i>
                            <span>Clair</span>
                        </label>

                        <input type="radio" name="theme" id="theme-dark" value="dark" {{ (Auth::user()->preferences['appearance']['theme'] ?? 'light') == 'dark' ? 'checked' : '' }}>
                        <label for="theme-dark" class="theme-option">
                            <i class="ti ti-moon"></i>
                            <span>Sombre</span>
                        </label>

                        <input type="radio" name="theme" id="theme-auto" value="auto" {{ (Auth::user()->preferences['appearance']['theme'] ?? 'light') == 'auto' ? 'checked' : '' }}>
                        <label for="theme-auto" class="theme-option">
                            <i class="ti ti-device-desktop"></i>
                            <span>Automatique</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Densité d'affichage</label>
                    <select name="density" class="form-control">
                        <option value="comfortable" selected>Confortable</option>
                        <option value="compact">Compact</option>
                        <option value="spacious">Spacieux</option>
                    </select>
                </div>

                <div class="switch-row">
                    <div class="switch-label">
                        <h4>Animations</h4>
                        <p>Activer les animations de l'interface</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="animations" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="danger-zone">
        <h3><i class="bi bi-exclamation-triangle me-2"></i>Zone de danger</h3>
        <p>La suppression de votre compte est irréversible. Toutes vos données seront définitivement perdues.</p>
        <button type="button" class="btn-danger" onclick="openDeleteModal()">
            <i class="bi bi-trash me-2"></i>Supprimer mon compte
        </button>
    </div>
</div>

<!-- Modal 1: Confirmation -->
<div id="deleteModal1" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="bi bi-exclamation-triangle text-danger me-2"></i>Supprimer le compte</h2>
        </div>
        <div class="modal-body">
            <div class="alert alert-warning">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Attention :</strong> Cette action est irréversible !
            </div>
            <p>Êtes-vous sûr de vouloir supprimer votre compte ? Toutes vos données seront définitivement perdues :</p>
            <ul style="color: #666; margin-left: 20px;">
                <li>Profil et informations personnelles</li>
                <li>Projets et tâches</li>
                <li>Messages et historique</li>
                <li>Fichiers et documents</li>
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Annuler</button>
            <button type="button" class="btn-danger" onclick="openDeleteModal2()">Continuer</button>
        </div>
    </div>
</div>

<!-- Modal 2: Verification -->
<div id="deleteModal2" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="bi bi-shield-exclamation text-danger me-2"></i>Vérification finale</h2>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                <strong>Dernière étape :</strong> Veuillez confirmer en tapant exactement le texte ci-dessous.
            </div>
            <p>Pour confirmer la suppression, tapez :</p>
            <div style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin: 16px 0; font-family: monospace; font-weight: 600;">
                delete/my-account-{{ strtolower(Auth::user()->name) }}
            </div>
            <form id="deleteAccountForm" method="POST" action="{{ route('settings.account.delete') }}">
                @csrf
                @method('DELETE')
                <input type="text"
                       id="deleteConfirmation"
                       name="confirmation"
                       class="form-control input-verification"
                       placeholder="Tapez le texte ci-dessus"
                       autocomplete="off"
                       required>
                <p id="errorMessage" class="text-danger mt-2" style="display: none; font-size: 0.85rem;">
                    <i class="bi bi-x-circle me-1"></i>Le texte ne correspond pas
                </p>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDeleteModal2()">Annuler</button>
            <button type="button" class="btn-danger" onclick="submitDelete()">
                <i class="bi bi-trash me-2"></i>Supprimer définitivement
            </button>
        </div>
    </div>
</div>

<script>
// Tabs Management
document.querySelectorAll('.tab-item[data-tab]').forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

        // Add active class to clicked tab
        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});

// Modal Management
function openDeleteModal() {
    document.getElementById('deleteModal1').classList.add('active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal1').classList.remove('active');
}

function openDeleteModal2() {
    document.getElementById('deleteModal1').classList.remove('active');
    document.getElementById('deleteModal2').classList.add('active');
}

function closeDeleteModal2() {
    document.getElementById('deleteModal2').classList.remove('active');
    document.getElementById('deleteConfirmation').value = '';
    document.getElementById('errorMessage').style.display = 'none';
}

function submitDelete() {
    const input = document.getElementById('deleteConfirmation').value;
    const expected = 'delete/my-account-{{ strtolower(Auth::user()->name) }}';
    const errorMessage = document.getElementById('errorMessage');

    if (input === expected) {
        if (confirm('Êtes-vous absolument certain ? Cette action est irréversible.')) {
            document.getElementById('deleteAccountForm').submit();
        }
    } else {
        errorMessage.style.display = 'block';
        document.getElementById('deleteConfirmation').style.borderColor = '#dc3545';
    }
}

// Close modals on outside click
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
}

// Theme Management
document.addEventListener('DOMContentLoaded', function() {
    // Load saved theme from localStorage or user preferences
    const savedTheme = localStorage.getItem('userTheme') || '{{ Auth::user()->preferences["appearance"]["theme"] ?? "light" }}';
    applyTheme(savedTheme);

    // Listen for theme changes
    document.querySelectorAll('input[name="theme"]').forEach(radio => {
        radio.addEventListener('change', function() {
            applyTheme(this.value);
            localStorage.setItem('userTheme', this.value);
        });
    });
});

function applyTheme(theme) {
    const body = document.body;

    if (theme === 'dark') {
        body.classList.add('dark-mode');
        body.classList.remove('light-mode');
    } else if (theme === 'light') {
        body.classList.add('light-mode');
        body.classList.remove('dark-mode');
    } else if (theme === 'auto') {
        // Detect system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            body.classList.add('dark-mode');
            body.classList.remove('light-mode');
        } else {
            body.classList.add('light-mode');
            body.classList.remove('dark-mode');
        }
    }
}

// Watch for system theme changes when 'auto' is selected
if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        const currentTheme = localStorage.getItem('userTheme') || '{{ Auth::user()->preferences["appearance"]["theme"] ?? "light" }}';
        if (currentTheme === 'auto') {
            applyTheme('auto');
        }
    });
}
</script>

@endsection
