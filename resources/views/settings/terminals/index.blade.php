@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Gestion des terminaux</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <a href="{{ route('terminals.create') }}" class="btn btn-primary">Ajouter un terminal</a>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($terminals ?? [] as $terminal)
                                <tr>
                                    <td>{{ $terminal->id }}</td>
                                    <td>{{ $terminal->name }}</td>
                                    <td>
                                        <a href="{{ route('terminals.edit', $terminal) }}" class="btn btn-sm btn-info">Modifier</a>
                                        <form action="{{ route('terminals.destroy', $terminal) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Aucun terminal trouvé</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
