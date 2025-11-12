@extends('layout.admin_rh')

@section('content')
<div class="container mt-4">

    @php
        use Carbon\Carbon;
        Carbon::setLocale('fr');

        // On prépare les dates du mois précédent et suivant
        $current = Carbon::createFromDate((int)$annee, (int)$mois, 1);
        $prev = $current->copy()->subMonth();
        $next = $current->copy()->addMonth();

        // Traduire les mois
        $moisActuel = ucfirst($current->translatedFormat('F'));
        $moisPrecedent = ucfirst($prev->translatedFormat('F'));
        $moisSuivant = ucfirst($next->translatedFormat('F'));
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- Bouton mois précédent --}}
        <a href="{{ route('rh.prestataires.prestations', ['mois' => $prev->month, 'annee' => $prev->year]) }}"
           class="btn btn-outline-secondary">
            &laquo; {{ $moisPrecedent }} {{ $prev->year }}
        </a>

        <h3 class="text-center mb-0">
            Prestations du mois de {{ $moisActuel }} {{ $annee }}
        </h3>

        {{-- Bouton mois suivant --}}
        @if($next <= Carbon::now()) {{-- On empêche d’aller dans le futur --}}
            <a href="{{ route('rh.prestataires.prestations', ['mois' => $next->month, 'annee' => $next->year]) }}"
               class="btn btn-outline-secondary">
                {{ $moisSuivant }} {{ $next->year }} &raquo;
            </a>
        @else
            <button class="btn btn-outline-secondary" disabled>
                {{ $moisSuivant }} {{ $next->year }} &raquo;
            </button>
        @endif
    </div>

    @if($prestations->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune prestation trouvée pour {{ mb_strtolower($moisActuel) }} {{ $annee }}.
        </div>
    @else

    <div class="text-start d-flex justify-content-center mb-3">
    <a href="{{ route('rh.prestations.export', ['mois' => $mois, 'annee' => $annee]) }}"
       class="btn btn-secondary d-flex align-items-center">
        <i class="bi bi-file-earmark-excel"></i> Exporter en Excel
    </a>
</div>

    <table class="table table-bordered mt-3">
        <thead class="table-light text-center">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Montant brut (XOF)</th>
                <th>BRS (5%)</th>
                <th>Net à payer (XOF)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBrut = 0;
                $totalBRS = 0;
                $totalNet = 0;
            @endphp

            @foreach($prestations as $prestation)
                @php
                    $brut = (float) $prestation->montant;
                    $brs = round($brut * 0.05, 0); // arrondir en XOF si tu veux entier
                    $net = $brut - $brs;

                    $totalBrut += $brut;
                    $totalBRS += $brs;
                    $totalNet += $net;
                @endphp
                <tr class="text-center">
                    <td>{{ $prestation->prestataire->nom ?? '-' }}</td>
                    <td>{{ $prestation->prestataire->prenom ?? '-' }}</td>
                    <td>{{ $prestation->prestataire->email ?? '-' }}</td>
                    <td>{{ number_format($brut, 0, ',', ' ') }}</td>
                    <td>{{ number_format($brs, 0, ',', ' ') }}</td>
                    <td>{{ number_format($net, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr class="fw-bold text-center bg-light">
                <th colspan="3" class="text-end">TOTAL</th>
                <th>{{ number_format($totalBrut, 0, ',', ' ') }} XOF</th>
                <th>{{ number_format($totalBRS, 0, ',', ' ') }} XOF</th>
                <th>{{ number_format($totalNet, 0, ',', ' ') }} XOF</th>
            </tr>
        </tfoot>
    </table>

    @endif

    <div class="text-center mt-4">
        <a href="{{ route('rh.prestataires.prestations.create', ['mois' => $mois, 'annee' => $annee]) }}" class="btn btn-primary">
            Modifier / Ajouter des prestations
        </a>
    </div>

</div>
@endsection
