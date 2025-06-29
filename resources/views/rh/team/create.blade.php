@extends('layouts.mydashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Créer une nouvelle équipe</h1>
    <form action="{{ route('teams.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium">Nom de l'équipe</label>
            <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Créer</button>
    </form>
</div>
@endsection
