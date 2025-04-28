@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-link text-muted ps-0">
            <i class="fas fa-arrow-left me-2"></i>Retour au client
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h3 class="h6 mb-0">{{ $site->nom }}</h3>
        </div>
        <div class="card-body">
            <p class="mb-1"><strong>Adresse :</strong> {{ $site->adresse }}</p>
            <p class="mb-1"><strong>Code postal :</strong> {{ $site->code_postal }}</p>
            <p class="mb-0"><strong>Ville :</strong> {{ $site->ville }}</p>
        </div>
    </div>

    @include('clients.partials.service-accordion')
</div>
@endsection
