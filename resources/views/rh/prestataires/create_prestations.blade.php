@extends('layout.admin_rh')

@section('content')
<div class="container">
    @php
            use Carbon\Carbon;
        Carbon::setLocale('fr');
$moisInt = (int) $mois; // convertit "09" ou "9" en 9
@endphp

<h3>
    Saisir les prestations -
    {{ \Carbon\Carbon::createFromDate($annee, (int) $mois, 1)->translatedFormat('F') }}
    {{ $annee }}
</h3>


    <form action="{{ route('rh.prestataires.prestations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="mois" value="{{ $mois }}">
        <input type="hidden" name="annee" value="{{ $annee }}">

        <table class="table datatable table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Montant (XOF)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestataires as $p)
                <tr>
                    <td>{{ $p->nom }}</td>
                    <td>{{ $p->prenom }}</td>
                    <td>{{ $p->email }}</td>
                    <td>
                        <input type="hidden" name="prestataires[{{ $p->id }}][id]" value="{{ $p->id }}">
                        <input type="number" name="prestataires[{{ $p->id }}][montant]" class="form-control" value="{{ $p->montantTotal($mois, $annee) }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Enregistrer les prestations</button>
    </form>
</div>
@endsection
