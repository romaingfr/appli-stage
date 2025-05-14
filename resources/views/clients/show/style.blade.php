<style>
    :root {
        --primary: #008caa;
        --secondary: #00aead;
        --success: #95c11f;
        --danger: #e83943;
        --warning: #f9ae00;
        --info: #00b4ce;
        --light: #f1f5f9;
        --dark: #0f172a;
        --border: #e2e8f0;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
        --shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
    }


    body {
        font-family: 'Archivo Narrow', sans-serif;
    }

    .container-fluid {
        max-width: 1400px;
        background: #f8fafc;
        min-height: calc(100vh - 60px);
    }

    .card {
        background: white;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .card:hover {
        box-shadow: var(--shadow);
        transform: translateY(-2px);
    }

    .nav-tabs {
        background: white;
        padding: 0.5rem;
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
    }

    .nav-link {
        color: var(--secondary);
        border-radius: 6px;
        padding: 0.75rem 1.25rem;
        font-weight: 500;
    }

    .nav-link.active {
        background: var(--primary);
        color: white;
        font-weight: 600;
    }

    .btn {
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.625rem 1.25rem;
        border-radius: 6px;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary {
        background: var(--primary);
        border: none;
    }

    .btn-primary:hover {
        background: #007a94;
        box-shadow: var(--shadow);
    }

    .table thead th {
        background: var(--light);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: var(--secondary);
        padding: 1rem;
    }
    /* Bouton de suppression */
    .btn-delete,
    .btn-danger,
    form button[type="submit"].btn-danger {
        background: var(--danger) !important;
        border-color: var(--danger) !important;
        color: white !important;
    }

    .btn-delete:hover,
    .btn-danger:hover,
    form button[type="submit"].btn-danger:hover {
        background: #d42f38 !important;
        border-color: #d42f38 !important;
        box-shadow: var(--shadow);
        transform: translateY(-1px);
    }
    /* Style du bouton d'export */
    .btn-export {
        background-color: white !important;
        border: 2px solid var(--primary) !important;
        color: var(--primary) !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        padding: 0.625rem 1.25rem !important;
        border-radius: 6px !important;
        box-shadow: var(--shadow-sm) !important;
        transition: all 0.2s ease !important;
    }

    .btn-export:hover {
        background-color: var(--primary) !important;
        color: white !important;
        box-shadow: var(--shadow) !important;
        transform: translateY(-1px) !important;
    }
    .modal-content {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    #addPhoneLineModal .form-control {
        border-radius: 6px;
        border: 1px solid #e1e1e1;
        padding: 0.75rem 1rem;
        font-family: 'Archivo Narrow', sans-serif;
        transition: all 0.3s ease;
    }

    #addPhoneLineModal .form-control:focus {
        border-color: #009FE3;
        box-shadow: 0 0 0 0.2rem rgba(0, 159, 227, 0.25);
    }

    #addPhoneLineModal .btn-primary {
        background-color: #009FE3;
        border-color: #009FE3;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 159, 227, 0.2);
    }

    #addPhoneLineModal .btn-primary:hover {
        background-color: #0080B3;
        border-color: #0080B3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 159, 227, 0.3);
    }

    #addPhoneLineModal .form-check-input:checked {
        background-color: #009FE3;
        border-color: #009FE3;
    }
</style>
