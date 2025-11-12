@extends('layout.admin_rh')

@section('content')
<div class="container">
    <h3>Prestations - {{ \Carbon\Carbon::create()->month($mois)->format('F') }} {{ $annee }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Type contrat</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestataires as $p)
            <tr>
                <td>{{ $p->nom }}</td>
                <td>{{ $p->prenom }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->type_contrat }}</td>
                <td>{{ number_format($p->montantTotal($mois, $annee), 0, ',', ' ') }} XOF</td>
            </tr>
            @endforeach
            <tr class="fw-bold">
                <td colspan="4" class="text-end">TOTAL</td>
                <td>{{ number_format($totalMois, 0, ',', ' ') }} XOF</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
