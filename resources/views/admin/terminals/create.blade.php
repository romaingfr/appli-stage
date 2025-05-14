@extends('layouts.app')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Archivo Narrow', sans-serif;
            background-color: #f8f9fa;
        }

        /* En-tête et titres */
        .iotiz-header {
            background-color: #009FE3;
            color: white;
            font-weight: 600;
            padding: 1.25rem;
            border-radius: 8px 8px 0 0;
        }

        /* Card */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeIn 0.6s ease-in-out;
        }

        .card-body {
            padding: 2rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Formulaire */
        .form-control {
            border-radius: 6px;
            border: 1px solid #e1e1e1;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Archivo Narrow', sans-serif;
        }

        .form-control:focus {
            border-color: #009FE3;
            box-shadow: 0 0 0 0.2rem rgba(0, 159, 227, 0.25);
        }

        .form-control.is-invalid {
            border-color: #E8393F;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(232, 57, 63, 0.25);
        }

        .col-form-label {
            font-weight: 600;
            color: #4a5568;
        }

        label {
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
        }

        /* Boutons */
        .iotiz-btn-primary {
            background-color: #009FE3;
            border-color: #009FE3;
            font-weight: 500;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 159, 227, 0.2);
            letter-spacing: 0.5px;
        }

        .iotiz-btn-primary:hover {
            background-color: #0080B3;
            border-color: #0080B3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 159, 227, 0.3);
        }

        .iotiz-btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-weight: 500;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(108, 117, 125, 0.2);
            letter-spacing: 0.5px;
        }

        .iotiz-btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        }

        /* Select */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
        }

        /* Statut couleurs */
        option[value="disponible"] {
            background-color: rgba(123, 192, 67, 0.1);
        }

        option[value="en_service"] {
            background-color: rgba(0, 159, 227, 0.1);
        }

        option[value="maintenance"] {
            background-color: rgba(247, 147, 30, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .col-form-label.text-md-right {
                text-align: left!important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header iotiz-header">
                        <i class="fas fa-plus-circle me-2"></i> Ajouter un terminal
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('terminals.store') }}">
                            @csrf

                            <div class="form-group row mb-4">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nom</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="model" class="col-md-4 col-form-label text-md-right">Modèle</label>
                                <div class="col-md-6">
                                    <input id="model" type="text" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ old('model') }}" required>
                                    @error('model')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="serial_number" class="col-md-4 col-form-label text-md-right">Numéro de série</label>
                                <div class="col-md-6">
                                    <input id="serial_number" type="text" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number" value="{{ old('serial_number') }}">
                                    @error('serial_number')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="phone_number" class="col-md-4 col-form-label text-md-right">Numéro de téléphone</label>
                                <div class="col-md-6">
                                    <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="status" class="col-md-4 col-form-label text-md-right">Statut</label>
                                <div class="col-md-6">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="disponible" {{ old('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                        <option value="en_service" {{ old('status') == 'en_service' ? 'selected' : '' }}>En service</option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 d-flex gap-2">
                                    <button type="submit" class="btn iotiz-btn-primary">
                                        <i class="fas fa-save me-1"></i> Enregistrer
                                    </button>
                                    <a href="{{ route('terminals.index') }}" class="btn iotiz-btn-secondary">
                                        <i class="fas fa-times me-1"></i> Annuler
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
