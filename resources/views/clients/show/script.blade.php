<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const style = document.createElement('style');
        style.textContent = `
        .btn-xs .fas.fa-pen, .edit-btn .fas.fa-pen {
            font-size: 0.65rem !important;
        }
        .btn-xs {
            padding: 0.15rem 0.3rem !important;
            line-height: 0.8 !important;
        }
    `;
        document.head.appendChild(style);
        const savePhoneLineBtn = document.getElementById('savePhoneLine');
        if (savePhoneLineBtn) {
            savePhoneLineBtn.addEventListener('click', function() {
                addPhoneLine();
            });
        }
        const progressBar = document.querySelector('.progress-bar');


        function updateProgress(progress) {
            progressBar.style.width = `${progress}%`;
        }

        function startProgress() {
            updateProgress(0);
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 30;
                if (progress > 90) {
                    clearInterval(interval);
                    return;
                }
                updateProgress(progress);
            }, 500);
            return interval;
        }

        function completeProgress() {
            updateProgress(100);
            setTimeout(() => updateProgress(0), 300);
        }

        document.addEventListener('turbo:before-visit', () => {
            startProgress();
        });

        document.addEventListener('turbo:load', () => {
            completeProgress();
        });
    });


    let terminalsData = [];



    // Initialiser les fonctions au chargement du document
    // Initialiser les fonctions au chargement du document
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter un événement d'ouverture pour la modale
        const modal = document.getElementById('addPhoneLineModal');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function() {
                // La fonction setupTerminalFeatures s'occupe déjà de charger les données
            });
        }
    });


    function attachRowClickHandlers() {
        document.querySelectorAll('#phoneLinesBody tr').forEach(row => {
            // Ne pas attacher d'événement à la ligne "Aucune ligne"
            if (!row.querySelector('td[colspan="4"]')) {
                row.style.cursor = 'pointer';
                row.classList.add('phone-line-row');

                // Éviter d'attacher plusieurs gestionnaires au même élément
                row.removeEventListener('click', handleRowClick);
                row.addEventListener('click', handleRowClick);
            }
        });
    }

    // Fonction pour gérer le clic sur une ligne
    function handleRowClick(event) {
        // Ne pas déclencher si on clique sur le bouton de suppression
        if (event.target.closest('.delete-phone-line') || event.target.closest('button')) {
            return;
        }

        // Récupérer l'ID de la ligne
        const deleteButton = this.querySelector('.delete-phone-line');
        if (!deleteButton) return;

        const lineId = parseInt(deleteButton.getAttribute('data-id'));
        const line = phoneLines.find(line => line.id === lineId);
        if (!line) return;

        // Afficher les détails dans une modal
        showPhoneLineDetails(line);
    }
    function showPhoneLineDetails(line) {
        // Créer la modal si elle n'existe pas
        let modal = document.getElementById('phoneLineDetailsModal');
        if (!modal) {
            const modalHTML = `
        <div class="modal fade" id="phoneLineDetailsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Détails de la ligne</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="phoneLineDetailsContent">
                        <!-- Le contenu sera inséré dynamiquement -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" id="editPhoneLineBtn">Modifier</button>
                    </div>
                </div>
            </div>
        </div>`;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
            modal = document.getElementById('phoneLineDetailsModal');

            // Ajouter gestionnaire pour le bouton de modification
            document.getElementById('editPhoneLineBtn').addEventListener('click', function() {
                // Fermer la modal de détails
                bootstrap.Modal.getInstance(modal).hide();

                // Ouvrir la modal d'édition avec les données pré-remplies
                openEditPhoneLineModal(line);
            });
        }

        // Remplir la modal avec les détails
        const content = document.getElementById('phoneLineDetailsContent');
        content.innerHTML = `
    <table class="table table-striped">
        <tr><th>Nom</th><td>${line.lastName || '-'}</td></tr>
        <tr><th>Prénom</th><td>${line.firstName || '-'}</td></tr>
        <tr><th>Numéro</th><td>${line.phoneNumber || '-'}</td></tr>
        <tr><th>Mobile</th><td>${line.mobileNumber || '-'}</td></tr>
        <tr><th>Marque</th><td>${line.brand || '-'}</td></tr>
        <tr><th>Type de terminal</th><td>${line.terminalType || '-'}</td></tr>
        <tr><th>N° série</th><td>${line.serialNumber || '-'}</td></tr>
        <tr><th>Opérateur</th><td>${line.operator || '-'}</td></tr>
        <tr><th>Data</th><td>${line.dataAmount ? line.dataAmount + ' Go' : '-'}</td></tr>
        <tr><th>Option internationale</th><td>${line.internationalOption ? 'Oui' : 'Non'}</td></tr>
        <tr><th>Option facultative</th><td>${line.optionalFeature ? 'Oui' : 'Non'}</td></tr>
        <tr><th>N° Carte SIM</th><td>${line.simCardNumber || '-'}</td></tr>
    </table>`;

        // Afficher la modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    // Fonction pour pré-remplir et ouvrir la modal d'édition
    function openEditPhoneLineModal(line) {
        const modal = document.getElementById('addPhoneLineModal');
        if (!modal) return;

        // Remplir le formulaire avec les données
        document.getElementById('lastName').value = line.lastName || '';
        document.getElementById('firstName').value = line.firstName || '';
        document.getElementById('phoneNumber').value = line.phoneNumber || '';

        // Autres champs si disponibles
        if (document.getElementById('mobileNumber'))
            document.getElementById('mobileNumber').value = line.mobileNumber || '';
        if (document.getElementById('brand'))
            document.getElementById('brand').value = line.brand || '';
        if (document.getElementById('terminalType'))
            document.getElementById('terminalType').value = line.terminalType || '';
        if (document.getElementById('serialNumber'))
            document.getElementById('serialNumber').value = line.serialNumber || '';
        if (document.getElementById('operator'))
            document.getElementById('operator').value = line.operator || '';
        if (document.getElementById('dataAmount'))
            document.getElementById('dataAmount').value = line.dataAmount || '';
        if (document.getElementById('internationalOption'))
            document.getElementById('internationalOption').checked = line.internationalOption || false;
        if (document.getElementById('optionalFeature'))
            document.getElementById('optionalFeature').checked = line.optionalFeature || false;
        if (document.getElementById('simCardNumber'))
            document.getElementById('simCardNumber').value = line.simCardNumber || '';

        // Modifier le bouton de sauvegarde pour faire une mise à jour
        const saveButton = document.getElementById('savePhoneLine');
        saveButton.textContent = 'Mettre à jour';
        saveButton.setAttribute('data-id', line.id);
        saveButton.onclick = function() {
            updatePhoneLine(line.id);
        };

        // Afficher la modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
    function updatePhoneLine(lineId) {
        // Récupérer les données du formulaire
        const lastName = document.getElementById('lastName').value;
        const firstName = document.getElementById('firstName').value;
        const phoneNumber = document.getElementById('phoneNumber').value;

        // Vérifier les données minimales
        if (!lastName && !firstName && !phoneNumber) {
            alert('Veuillez saisir au moins un nom, prénom ou numéro');
            return;
        }

        // Créer l'objet mis à jour
        const updatedLine = {
            id: lineId,
            lastName: lastName,
            firstName: firstName,
            phoneNumber: phoneNumber,
            mobileNumber: document.getElementById('mobileNumber')?.value || '',
            brand: document.getElementById('brand')?.value || '',
            terminalType: document.getElementById('terminalType')?.value || '',
            serialNumber: document.getElementById('serialNumber')?.value || '',
            operator: document.getElementById('operator')?.value || '',
            dataAmount: document.getElementById('dataAmount')?.value || '',
            internationalOption: document.getElementById('internationalOption')?.checked || false,
            optionalFeature: document.getElementById('optionalFeature')?.checked || false,
            simCardNumber: document.getElementById('simCardNumber')?.value || ''
        };

        // Mettre à jour le tableau
        const index = phoneLines.findIndex(line => line.id === lineId);
        if (index !== -1) {
            phoneLines[index] = updatedLine;
        }

        // Mettre à jour l'affichage
        updatePhoneLinesTable();

        // Fermer la modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addPhoneLineModal'));
        if (modal) {
            modal.hide();
        }

        // Réinitialiser le formulaire et le bouton
        document.getElementById('phoneLineForm').reset();
        const saveButton = document.getElementById('savePhoneLine');
        saveButton.textContent = 'Enregistrer';
        saveButton.removeAttribute('data-id');
        saveButton.onclick = addPhoneLine;

        // Sauvegarder les changements
        saveServices();
    }

    // Modifier la fonction updatePhoneLinesTable pour ajouter les gestionnaires de clic
    const originalUpdatePhoneLinesTable = updatePhoneLinesTable;
    updatePhoneLinesTable = function() {
        originalUpdatePhoneLinesTable();
        attachRowClickHandlers();
    };

    // Ajouter un style pour indiquer que les lignes sont cliquables
    const style = document.createElement('style');
    style.textContent = `
    .phone-line-row:hover {
        background-color: #f5f5f5;
    }
`;
    document.head.appendChild(style);

    // Initialiser les gestionnaires lors du chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        // S'assurer que les gestionnaires sont attachés après le chargement initial
        setTimeout(attachRowClickHandlers, 500);
    });


    // Définir cette fonction en dehors de DOMContentLoaded, à placer après la définition de phoneLines
    function updatePhoneLinesTable() {
        const tbody = document.getElementById('phoneLinesBody');
        if (!tbody) return;

        tbody.innerHTML = '';

        if (phoneLines.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">Aucune ligne téléphonique ajoutée</td></tr>`;
            return;
        }

        phoneLines.forEach(line => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${line.lastName || ''}</td>
            <td>${line.firstName || ''}</td>
            <td>${line.phoneNumber || ''}</td>
            <td class="text-center">
                <button class="btn btn-xs text-danger delete-phone-line" data-id="${line.id}">
                    <i class="fas fa-trash fa-2xs"></i>
                </button>
            </td>
        `;
            tbody.appendChild(tr);
        });

        // Attacher les gestionnaires d'événements pour les boutons de suppression
        // Dans la fonction updatePhoneLinesTable()
        document.querySelectorAll('.delete-phone-line').forEach(btn => {
            // Supprimer tous les gestionnaires d'événements existants pour éviter les doublons
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);

            newBtn.addEventListener('click', function(e) {
                // Empêcher la propagation de l'événement
                e.stopPropagation();

                // Récupérer l'ID et le convertir en nombre
                const lineId = parseInt(this.getAttribute('data-id'));

                console.log('Suppression de la ligne ID:', lineId);
                console.log('phoneLines avant suppression:', JSON.stringify(phoneLines));

                // Vérifier si des lignes ont cet ID
                const matchingLines = phoneLines.filter(line => parseInt(line.id) === lineId);
                console.log(`Nombre de lignes avec l'ID ${lineId}:`, matchingLines.length);

                // Filtrer en comparant de façon stricte
                const newPhoneLines = phoneLines.filter(line => parseInt(line.id) !== lineId);

                console.log('Nombre de lignes supprimées:', phoneLines.length - newPhoneLines.length);
                console.log('phoneLines après filtrage:', JSON.stringify(newPhoneLines));

                // Mettre à jour la variable globale
                phoneLines = newPhoneLines;

                // Mettre à jour l'affichage
                updatePhoneLinesTable();

                // Sauvegarder APRÈS avoir mis à jour l'affichage
                setTimeout(() => saveServices(), 100);
            });
        });
    }

    let phoneLines = [];
    function addPhoneLine() {
        // Récupérer les données du formulaire
        const lastName = document.getElementById('lastName').value;
        const firstName = document.getElementById('firstName').value;
        const phoneNumber = document.getElementById('phoneNumber').value;

        // Vérifier que les informations minimales sont présentes
        if (!lastName && !firstName && !phoneNumber) {
            alert('Veuillez saisir au moins un nom, prénom ou numéro de téléphone');
            return;
        }

        // Créer un identifiant unique (ajout d'un nombre aléatoire pour garantir l'unicité)
        const uniqueId = Date.now() + Math.floor(Math.random() * 1000);

        // Créer un nouvel objet ligne avec ID unique
        const newLine = {
            id: uniqueId,
            lastName: lastName,
            firstName: firstName,
            phoneNumber: phoneNumber,
            mobileNumber: document.getElementById('mobileNumber')?.value || '',
            brand: document.getElementById('brand')?.value || '',
            terminalType: document.getElementById('terminalType')?.value || '',
            serialNumber: document.getElementById('serialNumber')?.value || '',
            operator: document.getElementById('operator')?.value || '',
            dataAmount: document.getElementById('dataAmount')?.value || '',
            internationalOption: document.getElementById('internationalOption')?.checked || false,
            optionalFeature: document.getElementById('optionalFeature')?.checked || false,
            simCardNumber: document.getElementById('simCardNumber')?.value || ''
        };

        // Ajouter la ligne au tableau
        phoneLines.push(newLine);

        // Mettre à jour l'affichage et sauvegarder
        updatePhoneLinesTable();

        // Fermer la modal correctement
        const modalElement = document.getElementById('addPhoneLineModal');
        const modal = bootstrap.Modal.getInstance(modalElement);

        if (modal) {
            modal.hide();
            // Nettoyage du backdrop après fermeture
            setTimeout(() => {
                // Supprimer manuellement la classe modal-backdrop si elle existe encore
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                // Enlever la classe modal-open du body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }, 300);
        }

        // Réinitialiser le formulaire
        const form = document.getElementById('phoneLineForm');
        if (form) {
            form.reset();
        }

        // Sauvegarder les changements
        saveServices();
    }
    function cleanupBootstrapModals() {
        // Supprimer tous les backdrops
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

        // Nettoyer le body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        // Fermer toutes les modals qui pourraient être ouvertes
        document.querySelectorAll('.modal.show').forEach(modalEl => {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        });
    }

    const errorMessages = {
        400: 'Données invalides',
        401: 'Non autorisé - Veuillez vous reconnecter',
        403: 'Accès refusé',
        404: 'Ressource non trouvée',
        408: 'Délai d\'attente dépassé',
        409: 'Conflit de données',
        429: 'Trop de requêtes',
        500: 'Erreur serveur',
        503: 'Service indisponible'
    };

    function showError(error, retryCallback = null) {
        const message = errorMessages[error.status] || 'Une erreur est survenue';

        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: message,
            showCancelButton: !!retryCallback,
            confirmButtonText: retryCallback ? 'Réessayer' : 'OK',
            cancelButtonText: 'Annuler'
        }).then(result => {
            if (result.isConfirmed && retryCallback) {
                retryCallback();
            }
        });
    }
    const validationRules = {
        phone: {
            regex: /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/,
            message: 'Format de numéro de téléphone invalide'
        },
        siret: {
            regex: /^[0-9]{14}$/,
            message: 'Le SIRET doit contenir 14 chiffres'
        },
        email: {
            regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            message: 'Adresse email invalide'
        }
    };

    function validateField(value, type) {
        if (!validationRules[type]) return true;
        return validationRules[type].regex.test(value);
    }
    // Variables globales
    const clientId = {{ $client->id }};
    let activeSiteId = 'principal';

    function showLoading(show = true) {
        const loadingOverlay = document.getElementById('loadingOverlay') || createLoadingOverlay();
        loadingOverlay.style.display = show ? 'flex' : 'none';
    }

    function createLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.innerHTML = `
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    `;
        document.body.appendChild(overlay);
        return overlay;
    }

    function validatePhoneLine(line) {
        const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/;
        return {
            isValid: phoneRegex.test(line.numero),
            errors: []
        };
    }

    function validateBeforeSave() {
        const errors = [];
        // Validation des champs obligatoires
        const requiredFields = document.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value) errors.push(`Le champ ${field.name} est requis`);
        });
        return errors;
    }
    // Gestionnaire des lignes téléphoniques
    function generatePhoneLines(count) {
        const tableContainer = document.getElementById('phoneLinesTable');
        const tbody = document.getElementById('phoneLinesBody');

        if (count > 0) {
            tableContainer.style.display = 'block';
            tbody.innerHTML = '';

            for (let i = 0; i < count; i++) {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td><input type="text" class="form-control form-control-sm phone-line-nom" placeholder="Nom"></td>
                <td><input type="text" class="form-control form-control-sm phone-line-prenom" placeholder="Prénom"></td>
                <td><input type="tel" class="form-control form-control-sm phone-line-numero" placeholder="Numéro"></td>
                <td>
                    <select class="form-select form-select-sm phone-line-operateur">
                        <option value="">Sélectionner</option>
                        <option value="orange">Orange</option>
                        <option value="sfr">SFR</option>
                        <option value="bouygues">Bouygues</option>
                    </select>
                </td>
                <td><input type="number" class="form-control form-control-sm phone-line-data" min="0" placeholder="Go"></td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input phone-line-international">
                    </div>
                </td>
                <td><input type="text" class="form-control form-control-sm phone-line-sim" placeholder="N° SIM"></td>
            `;
                tbody.appendChild(row);
            }
        } else {
            tableContainer.style.display = 'none';
        }
    }

    // Gestion de l'affichage
    function showFullClientInfo() {
        document.getElementById('selectedSiteDetails').style.display = 'none';
        document.getElementById('clientInfos').style.display = 'block';

        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.classList.toggle('active', tab.getAttribute('data-site-id') === 'principal');
        });
    }
    function showSiteContactInfo(contact) {
        return `
        <table class="table table-hover">
            <tr><th>Contact</th><td>${contact.prenom} ${contact.nom}</td></tr>
            <tr><th>Téléphone</th><td>${contact.telephone || 'Non renseigné'}</td></tr>
            <tr><th>Mobile</th><td>${contact.mobile || 'Non renseigné'}</td></tr>
            <tr><th>Email</th><td>${contact.email || 'Non renseigné'}</td></tr>
        </table>
    `;
    }
    let selectedSiteId = 'principal';

    function showSiteDetails(siteId) {
        selectedSiteId = siteId;
        activeSiteId = siteId.toString();
        const detailsContainer = document.getElementById('selectedSiteDetails');
        const clientInfos = document.getElementById('clientInfos');
        const siteTitle = document.getElementById('selectedSiteTitle');
        const siteInfo = document.getElementById('siteInfo');
        const mainTitle = document.querySelector('h1.h3');

        // Masquer les infos client et afficher les détails du site
        clientInfos.style.display = 'none';
        detailsContainer.style.display = 'block';

        // Mise à jour des onglets
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.classList.toggle('active', tab.getAttribute('data-site-id') === siteId.toString());
        });

        // Affichage des informations du site
        if (siteId === 'principal') {
            // Utiliser la valeur actuelle du display-name_boite au lieu de la valeur statique Blade
            const currentNameBoite = $('#display-name_boite').text() || '{{ $client->name_boite }}';
            mainTitle.textContent = currentNameBoite;
            siteTitle.textContent = currentNameBoite;

            showPrincipalSiteInfo(siteTitle, siteInfo);
        } else {
            // Récupération du site secondaire (code existant)
            fetch(`/clients/${clientId}/sites/${siteId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Réponse reçue:', text.substring(0, 200));
                            throw new Error(`Erreur HTTP ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.data) {
                        mainTitle.textContent = data.data.name_boite;
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération du titre:', error);
                });

            showSecondarySiteInfo(siteId, siteTitle, siteInfo);
        }

        loadSiteServices(activeSiteId);
    }

    function createClientHeader() {
        // Vérifier si l'en-tête existe déjà
        let header = document.querySelector('.client-header');
        if (!header) {
            // Créer l'en-tête s'il n'existe pas
            header = document.createElement('div');
            header.className = 'client-header alert alert-info mb-4';
            document.querySelector('.container').insertBefore(header, document.querySelector('.container').firstChild);
        }
        return header;
    }
    function updateClientHeader(siteName) {
        // On supprime tout le contenu pour ne rien afficher
        const header = createClientHeader();
        header.style.display = 'none';
    }

    function showPrincipalSiteInfo(siteTitle, siteInfo) {
        siteTitle.textContent = `{{ $client->name_boite }}`;
        siteInfo.innerHTML = `
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 mb-0">Informations du site</h3>
                <button type="button" class="btn btn-primary btn-sm" onclick="exportSitePDF('principal')">
                    <i class="fas fa-file-pdf me-2"></i>Exporter en PDF
                </button>
            </div>
            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="fas fa-user me-2"></i>
                <span><strong>{{ $client->prenom_client }} {{ $client->nom_client }}</strong> |
                Tél : {{ $client->numero_telephone ?: 'Non renseigné' }} |
                Mobile : {{ $client->numero_mobile ?: 'Non renseigné' }} |
                Email : {{ $client->email }}</span>
            </div>
            <table class="table table-hover">
                <colgroup>
                    <col style="width: 30%">
                    <col style="width: 70%">
                </colgroup>
                <tbody>
                    <tr><th>SIRET</th><td>{{ $client->siret }}</td></tr>
                    <tr><th>Adresse</th><td>{{ $client->adresse_siege }}</td></tr>
                    <tr><th>Code postal</th><td>{{ $client->code_postal }}</td></tr>
                    <tr><th>Localité</th><td>{{ $client->localite }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>`;
    }

    function showSecondarySiteInfo(siteId, siteTitle, siteInfo) {
        // Récupérer les informations du site
        fetch(`/clients/${clientId}/sites/${siteId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                if (data && data.data) {
                    const site = data.data;

                    // Mettre à jour le titre
                    siteTitle.textContent = site.name_boite;

                    // Afficher les informations du site avec des boutons plus petits
                    siteInfo.innerHTML = `
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0">Informations du site</h3>
                        <button type="button" class="btn btn-primary btn-sm" onclick="exportSitePDF(${siteId})">
                            <i class="fas fa-file-pdf me-2"></i>Exporter en PDF
                        </button>
                    </div>
                    <div class="alert alert-info d-flex align-items-center mb-4">
                        <i class="fas fa-user me-2"></i>
                        <span><strong>${site.contact_nom || ''} ${site.contact_prenom || ''}</strong> |
                        Tél : ${site.telephone || 'Non renseigné'} |
                        Mobile : ${site.mobile || 'Non renseigné'} |
                        Email : ${site.email || 'Non renseigné'}</span>
                    </div>
                    <table class="table table-hover table-sm">
                        <colgroup>
                            <col style="width: 30%">
                            <col style="width: 70%">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>Nom du site</th>
                                <td class="d-flex align-items-center justify-content-between">
                                    <span id="site-display-name_boite-${siteId}">${site.name_boite}</span>
                                    <button class="btn btn-xs text-secondary edit-site-btn" data-field="name_boite" data-site-id="${siteId}" data-original="${site.name_boite}">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th>Adresse</th>
                                <td class="d-flex align-items-center justify-content-between">
                                    <span id="site-display-adresse-${siteId}">${site.adresse || 'Non renseigné'}</span>
                                    <button class="btn btn-xs text-secondary edit-site-btn" data-field="adresse" data-site-id="${siteId}" data-original="${site.adresse || ''}">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th>Code postal</th>
                                <td class="d-flex align-items-center justify-content-between">
                                    <span id="site-display-code_postal-${siteId}">${site.code_postal || 'Non renseigné'}</span>
                                    <button class="btn btn-xs text-secondary edit-site-btn" data-field="code_postal" data-site-id="${siteId}" data-original="${site.code_postal || ''}">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th>Ville</th>
                                <td class="d-flex align-items-center justify-content-between">
                                    <span id="site-display-ville-${siteId}">${site.ville || 'Non renseigné'}</span>
                                    <button class="btn btn-xs text-secondary edit-site-btn" data-field="ville" data-site-id="${siteId}" data-original="${site.ville || ''}">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>`;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                siteInfo.innerHTML = `<div class="alert alert-danger">Erreur lors du chargement des informations du site.</div>`;
            });
    }


    // Variable globale pour stocker l'ID du site actuellement sélectionné
    let currentSiteId = 'principal';


    // Fonction d'exportation PDF
    function exportSitePDF(siteId) {
        showLoader();
        // URL correcte basée sur la structure de route Laravel
        const url = `/clients/${clientId}/sites/${siteId}/export-pdf`;
        window.open(url, '_blank');
        setTimeout(() => {
            hideLoader();
        }, 1000);
    }

    // Gestion des services
    function loadSiteServices(siteId) {
        showLoader();
        const url = `/clients/${clientId}/sites/${siteId}/services`;

        // Réinitialiser les tableaux avant le chargement
        phoneLines = [];

        const phoneLinesBody = document.getElementById('phoneLinesBody');
        if (phoneLinesBody) {
            phoneLinesBody.innerHTML = '';
        }

        const phoneLinesTable = document.getElementById('phoneLinesTable');
        if (phoneLinesTable) {
            phoneLinesTable.style.display = 'none';
        }

        return fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
            credentials: 'same-origin'
        })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(data => {
                console.log('Services chargés:', data);
                updateFormFields(data.data || data);
                hideLoader();
            })
            .catch(error => {
                console.error('Erreur lors du chargement des services:', error);
                hideLoader();

                const serviceContainer = document.querySelector('#telephonyHostedSection .accordion-body');
                if (serviceContainer) {
                    serviceContainer.innerHTML = `<div class="alert alert-danger">Erreur lors du chargement des services.</div>`;
                }
            });
    }

    function updateFormFields(service) {
        // Vérification si le service existe
        if (!service) {
            console.warn('Aucun service à afficher');
            return;
        }

        console.log('Mise à jour des champs avec:', service);

        // Réinitialiser les tableaux globaux
        phoneLines = [];

        // --- Section Téléphonie hébergée ---
        const sviCheckbox = document.getElementById('svi');
        if (sviCheckbox && service.configuration && service.configuration.svi !== undefined) {
            sviCheckbox.checked = Boolean(service.configuration.svi);
        }

        // Nombre de canaux/lignes
        const channelCount = document.getElementById('channelCount');
        if (channelCount && service.configuration && service.configuration.channel_count !== undefined) {
            channelCount.value = service.configuration.channel_count;
        }

        // --- Section Lignes téléphoniques ---
        // Dans la fonction updateFormFields()
        if (service.lignes && Array.isArray(service.lignes)) {
            console.log(`Chargement de ${service.lignes.length} lignes téléphoniques`);

            phoneLines = service.lignes.map(line => ({
                id: line.id || Date.now(),
                lastName: line.nom || '',
                firstName: line.prenom || '',
                phoneNumber: line.numero || '',
                mobileNumber: line.mobile || '',  // Correction ici
                brand: line.marque || '',         // Correction ici
                terminalType: line.type_terminal || '', // Correction ici
                serialNumber: line.numero_serie || '', // Correction ici
                operator: line.operateur || '',
                dataAmount: line.data || '',
                internationalOption: line.international || false,
                optionalFeature: line.option_facultative || false,
                simCardNumber: line.sim || ''
            }));

            updatePhoneLinesTable();
        }

        // --- Section Cloud ---
        const cloudCheckbox = document.getElementById('cloud');
        if (cloudCheckbox && service.configuration && service.configuration.cloud !== undefined) {
            cloudCheckbox.checked = Boolean(service.configuration.cloud);
        }

        // --- Section Lien d'accès ---
        const accessTypeSelect = document.getElementById('accessType');
        if (accessTypeSelect && service.configuration && service.configuration.access_type !== undefined) {
            accessTypeSelect.value = service.configuration.access_type;
        }

        const accessDebit = document.getElementById('accessDebit');
        if (accessDebit && service.configuration && service.configuration.debit !== undefined) {
            accessDebit.value = service.configuration.debit;
        }

    }

    function updatePhoneLines(phoneLines) {
        if (!Array.isArray(phoneLines) || phoneLines.length === 0) {
            return;
        }

        const rows = document.querySelectorAll('#phoneLinesBody tr');

        phoneLines.forEach((line, index) => {
            if (index < rows.length) {
                const row = rows[index];

                // Sélectionnez tous les éléments de formulaire dans la ligne
                const nomInput = row.querySelector('.phone-line-nom');
                const prenomInput = row.querySelector('.phone-line-prenom');
                const numeroInput = row.querySelector('.phone-line-numero');
                const operateurSelect = row.querySelector('.phone-line-operateur');
                const dataInput = row.querySelector('.phone-line-data');
                const internationalCheckbox = row.querySelector('.phone-line-international');
                const simInput = row.querySelector('.phone-line-sim');

                // Affectez les valeurs s'ils existent
                if (nomInput) nomInput.value = line.nom || '';
                if (prenomInput) prenomInput.value = line.prenom || '';
                if (numeroInput) numeroInput.value = line.numero || '';
                if (operateurSelect) operateurSelect.value = line.operateur || '';
                if (dataInput) dataInput.value = line.data || '';
                if (internationalCheckbox) internationalCheckbox.checked = Boolean(line.international);
                if (simInput) simInput.value = line.sim || '';
            }
        });
    }
    function updateAccessLinkOptions(selectedType) {
        const backOptions = document.getElementById('backOptions');
        const fwOptions = document.getElementById('fwOptions');

        // Réinitialiser les options
        backOptions.style.display = 'none';
        fwOptions.style.display = 'none';

        // Afficher les options appropriées
        if (['ftth', 'ftto', 'ftte', 'data'].includes(selectedType)) {
            backOptions.style.display = 'block';
            fwOptions.style.display = 'block';
        }
    }

    function updateAccessLinks(accessLinksData) {
        // Vérifier si les éléments existent avant de les manipuler
        const accessLinkTypeSelect = document.querySelector('#accessLinkType');
        const accessLinkDebitInput = document.querySelector('#accessLinkSection input[type="number"]');

        if (!accessLinkTypeSelect || !accessLinkDebitInput) {
            console.warn('Elements de lien d\'accès non trouvés');
            return;
        }

        let accessLinks = accessLinksData;

        if (typeof accessLinksData === 'string' && accessLinksData) {
            try {
                accessLinks = JSON.parse(accessLinksData);
            } catch (e) {
                console.error('Erreur de parsing access_links:', e);
                accessLinks = {};
            }
        }

        accessLinks = accessLinks || {};

        // Mise à jour des valeurs si les éléments existent
        accessLinkTypeSelect.value = accessLinks.type || '';
        accessLinkDebitInput.value = accessLinks.debit || '';

        if (accessLinks.type) {
            updateAccessLinkOptions(accessLinks.type);

            const backTypeInput = document.querySelector(`input[name="backType"][value="${accessLinks.back_type}"]`);
            const fwEnabledInput = document.getElementById('fwEnabled');

            if (backTypeInput && accessLinks.back_type) {
                backTypeInput.checked = true;
            }

            if (fwEnabledInput && accessLinks.fw_enabled !== undefined) {
                fwEnabledInput.checked = accessLinks.fw_enabled;
            }
        }
    }


    function updatePhoneLines(phoneLinesData) {
        let phoneLines = phoneLinesData;

        if (typeof phoneLinesData === 'string' && phoneLinesData) {
            try {
                phoneLines = JSON.parse(phoneLinesData);
            } catch (e) {
                console.error('Erreur de parsing phone_lines:', e);
                phoneLines = [];
            }
        }

        phoneLines = phoneLines || [];

        const rows = document.querySelectorAll('#phoneLinesBody tr');
        phoneLines.forEach((line, index) => {
            if (rows[index]) {
                const row = rows[index];
                row.querySelector('.phone-line-nom').value = line.nom || '';
                row.querySelector('.phone-line-prenom').value = line.prenom || '';
                row.querySelector('.phone-line-numero').value = line.numero || '';
                row.querySelector('.phone-line-operateur').value = line.operateur || '';
                row.querySelector('.phone-line-data').value = line.data || '';
                row.querySelector('.phone-line-international').checked = line.international || false;
                row.querySelector('.phone-line-sim').value = line.sim || '';
            }
        });
    }

    function resetFormFields() {
        document.getElementById('svi').checked = false;
        document.querySelector('#telephonyHostedSection input[type="number"]').value = '';
        document.getElementById('cloud').checked = false;
        document.querySelector('#accessLinkSection select').value = '';
        document.querySelector('#accessLinkSection input[type="number"]').value = '';
        document.getElementById('phoneLinesTable').style.display = 'none';
    }

    function saveServices() {
        console.log('Début de saveServices()');
        showLoader();

        const serviceData = {
            client_id: clientId,
            site_id: activeSiteId,
            configuration: {
                svi: Boolean(document.getElementById('svi')?.checked),
                channel_count: phoneLines.length || parseInt(document.getElementById('channelCount')?.value || '0'),
                cloud: Boolean(document.getElementById('cloud')?.checked),
                access_type: document.getElementById('accessType')?.value || 'Aucun',
                debit: document.getElementById('accessDebit')?.value || 'Aucun'
            },
            lignes: phoneLines.map(line => ({
                nom: line.lastName || '',
                prenom: line.firstName || '',
                numero: line.phoneNumber || '',
                mobile: line.mobileNumber || '',
                marque: line.brand || '',
                type_terminal: line.terminalType || '',
                numero_serie: line.serialNumber || '',
                operateur: line.operator || '',
                data: line.dataAmount || '',
                international: line.internationalOption || false,
                option_facultative: line.optionalFeature || false,
                sim: line.simCardNumber || ''
            })),
            lignes_mobiles: [] // Ajouter ce champ pour satisfaire la validation
        };

        console.log('Données à envoyer:', serviceData);

        return fetch(`/clients/${clientId}/sites/${activeSiteId}/services`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(serviceData)
        })
            .then(response => {
                console.log('Réponse reçue, status:', response.status);
                hideLoader();

                if (!response.ok) {
                    return response.json().then(err => {
                        console.error('Erreur serveur:', err);
                        throw new Error('Erreur serveur');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Services sauvegardés avec succès:', data);
                const toast = document.getElementById('successToast');
                if (toast) {
                    const bsToast = new bootstrap.Toast(toast);
                    document.getElementById('successToastMessage').textContent = 'Services mis à jour avec succès';
                    bsToast.show();
                } else {
                    showToast('Services mis à jour avec succès');
                }
                return data;
            })
            .catch(error => {
                console.error('Erreur:', error);
                hideLoader();
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Erreur lors de la sauvegarde des services: ' + error.message,
                    confirmButtonText: 'OK'
                });
                throw error;
            });
    }

    // Attacher l'événement uniquement si le bouton existe
    const saveButton = document.querySelector('#saveButton');
    if (saveButton) {
        saveButton.addEventListener('click', saveServices);
    }

    function autoSave() {
        const formData = new FormData(document.querySelector('form'));
        const isDirty = JSON.stringify(formData) !== JSON.stringify(lastSavedData);

        if (isDirty) {
            saveServices()
                .then(() => {
                    lastSavedData = formData;
                    showToast('Modifications sauvegardées');
                })
                .catch(handleError);
        }
    }
    function showSuccessMessage() {
        Swal.fire({
            icon: 'success',
            title: 'Services enregistrés',
            text: 'Les services ont été mis à jour avec succès'
        });
    }

    function handleError(error) {
        console.error('Erreur:', error);

        const errorMessages = {
            404: 'Ressource non trouvée',
            403: 'Accès non autorisé',
            500: 'Erreur serveur'
        };

        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: errorMessages[error.status] || 'Une erreur est survenue',
            showCancelButton: true,
            confirmButtonText: 'Réessayer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Retenter l'opération
                saveServices();
            }
        });
    }

    // Initialisation
    document.addEventListener('input', (e) => {
        if (e.target.matches('.form-control, .form-select')) {
            // Sauvegarder automatiquement après un délai
            debounce(() => autoSave(), 1000);
        }
    });
    // Debounce pour les sauvegardes automatiques
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Cache des données
    const dataCache = {
        services: new Map(),
        sites: new Map(),

        set(key, data, ttl = 300000) {
            this.services.set(key, {
                data,
                timestamp: Date.now() + ttl
            });
        },

        get(key) {
            const item = this.services.get(key);
            if (!item) return null;
            if (Date.now() > item.timestamp) {
                this.services.delete(key);
                return null;
            }
            return item.data;
        }
    };
    // Protection XSS pour les données dynamiques
    function sanitizeHTML(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Validation des données avant envoi
    function validatePayload(data) {
        const sensitivePatterns = /(<script|javascript:|data:text\/html)/i;
        return !Object.values(data).some(value =>
            typeof value === 'string' && sensitivePatterns.test(value)
        );
    }
    function showToast(message, type = 'success') {
        const toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        toast.fire({
            icon: type,
            title: message
        });
    }
    // Animation des changements de contenu
    function animateContent(element, content) {
        element.style.opacity = 0;
        setTimeout(() => {
            element.innerHTML = content;
            element.style.opacity = 1;
        }, 200);
    }

    // Auto-collapse des accordéons inactifs
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.accordion-collapse.show').forEach(collapse => {
                if (collapse !== button.nextElementSibling) {
                    collapse.classList.remove('show');
                }
            });
        });
    });

    // Ajoutez cette fonction au début de votre script
    function hideLoader() {
        const loader = document.getElementById('loadingOverlay');
        if (loader) {
            loader.style.display = 'none';
        }

        // Rétablir le défilement
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }

    function showLoader() {
        const loader = document.getElementById('loader');
        if (loader) {
            loader.classList.add('visible');
        }
    }

    function setupLoadingIndicators() {
        const loader = document.getElementById('loader');
    }
    // Gestion des onglets du menu latéral
    let currentTab = 'overview';

    function switchTab(tabId) {
        // Empêcher le comportement par défaut du lien
        event.preventDefault();

        // Ne rien faire si on clique sur l'onglet actif
        if (currentTab === tabId) return;

        // Désactiver tous les onglets
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.classList.remove('active');
        });

        // Activer l'onglet cliqué
        document.getElementById('tab-' + tabId).classList.add('active');

        // Mettre à jour le fil d'Ariane
        const tabTitle = document.getElementById('tab-' + tabId).textContent.trim();
        document.getElementById('currentSection').textContent = tabTitle;

        // Cacher tous les contenus des onglets
        document.getElementById('billing-content').style.display = 'none';
        document.getElementById('documents-content').style.display = 'none';
        document.getElementById('history-content').style.display = 'none';

        // Actions spécifiques selon l'onglet
        switch(tabId) {
            case 'overview':
            case 'services':
                // Réafficher le contenu approprié selon l'état actuel
                if (activeSiteId) {
                    document.getElementById('selectedSiteDetails').style.display = 'block';
                    document.getElementById('clientInfos').style.display = 'none';
                } else {
                    document.getElementById('selectedSiteDetails').style.display = 'none';
                    document.getElementById('clientInfos').style.display = 'block';
                }
                break;
            case 'billing':
                document.getElementById('billing-content').style.display = 'block';
                document.getElementById('clientInfos').style.display = 'none';
                document.getElementById('selectedSiteDetails').style.display = 'none';
                break;
            case 'documents':
                document.getElementById('documents-content').style.display = 'block';
                document.getElementById('clientInfos').style.display = 'none';
                document.getElementById('selectedSiteDetails').style.display = 'none';
                break;
            case 'history':
                document.getElementById('history-content').style.display = 'block';
                document.getElementById('clientInfos').style.display = 'none';
                document.getElementById('selectedSiteDetails').style.display = 'none';
                break;
        }

        currentTab = tabId;
    }

    // Charger l'onglet correct au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.substring(1) || 'overview';
        if (document.getElementById('tab-' + hash)) {
            switchTab(hash);
        }
    });

    $(document).ready(function() {
        // Clic sur le bouton d'édition
        // Modification du bouton d'édition dans les informations du client
        $(document).on('click', '.edit-btn', function() {
            const field = $(this).data('field');
            const original = $(this).data('original');
            const displayElement = $(`#display-${field}`);

            // Créer le formulaire d'édition avec des styles pour réduire la taille
            const form = `
    <div class="edit-form d-flex align-items-center">
        <div class="flex-grow-1 me-1">
            <input type="text" class="form-control form-control-sm py-1" id="input-${field}" value="${original || ''}">
        </div>
        <div class="d-flex">
            <button class="btn btn-xs btn-success save-btn px-2 py-1 me-1" data-field="${field}" style="font-size: 0.65rem; line-height: 0.8;">
                <i class="fas fa-check fa-2xs"></i>
            </button>
            <button class="btn btn-xs btn-secondary cancel-btn px-2 py-1" data-field="${field}" data-original="${original || ''}" style="font-size: 0.65rem; line-height: 0.8;">
                <i class="fas fa-times fa-2xs"></i>
            </button>
        </div>
    </div>
    `;

            // Remplacer l'affichage par le formulaire
            displayElement.hide().after(form);
            $(this).hide();
        });

        // Clic sur le bouton d'annulation
        $(document).on('click', '.cancel-btn', function() {
            const field = $(this).data('field');

            // Supprimer le formulaire et montrer l'affichage original
            $(this).closest('.edit-form').remove();
            $(`#display-${field}`).show();
            $(`.edit-btn[data-field="${field}"]`).show();
        });

        // Clic sur le bouton de sauvegarde
        // Clic sur le bouton de sauvegarde
        $(document).on('click', '.save-btn', function() {
            const field = $(this).data('field');
            const value = $(`#input-${field}`).val();
            const clientId = {{ $client->id }};

            // Envoi AJAX
            $.ajax({
                url: `/clients/${clientId}/update-field`,
                method: 'POST',
                data: {
                    field: field,
                    value: value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Mettre à jour l'affichage
                    $(`#display-${field}`).text(value).show();
                    $(`.edit-form`).remove();
                    $(`.edit-btn[data-field="${field}"]`).data('original', value).show();

                    // Mettre à jour le titre si le champ est name_boite
                    if (field === 'name_boite') {
                        // Mettre à jour le titre principal
                        $('h1.h3').text(value);

                        // Mettre également à jour le titre dans les détails du site si on est sur le site principal
                        if (activeSiteId === 'principal') {
                            $('#selectedSiteTitle').text(value);
                        }
                    }

                    // Afficher un message de succès
                    showNotification('Modification enregistrée', 'success');
                },
                error: function() {
                    showNotification('Erreur lors de la modification', 'error');
                }
            });
        });
    });

    function showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
             style="top: 20px; right: 20px; z-index: 9999;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
        $('body').append(notification);
        setTimeout(() => $('.alert').alert('close'), 3000);
    }
    // Clic sur le bouton d'édition de site
    $(document).on('click', '.edit-site-btn', function() {
        const field = $(this).data('field');
        const original = $(this).data('original');
        const siteId = $(this).data('site-id');
        const displayElement = $(`#site-display-${field}-${siteId}`);

        // Créer le formulaire d'édition
        const form = `
        <div class="edit-form d-flex align-items-center">
            <div class="flex-grow-1 me-1">
                <input type="text" class="form-control form-control-sm py-1" id="site-input-${field}-${siteId}" value="${original || ''}">
            </div>
            <div class="d-flex">
                <button class="btn btn-xs btn-success save-site-btn px-2 py-1 me-1" data-field="${field}" data-site-id="${siteId}" style="font-size: 0.7rem; line-height: 1;">
                    <i class="fas fa-check"></i>
                </button>
                <button class="btn btn-xs btn-secondary cancel-site-btn px-2 py-1" data-field="${field}" data-site-id="${siteId}" data-original="${original || ''}" style="font-size: 0.7rem; line-height: 1;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;

        // Remplacer l'affichage par le formulaire
        displayElement.hide().after(form);
        $(this).hide();
    });

    // Clic sur le bouton d'annulation de site
    $(document).on('click', '.cancel-site-btn', function() {
        const field = $(this).data('field');
        const siteId = $(this).data('site-id');

        // Supprimer le formulaire et montrer l'affichage original
        $(this).closest('.edit-form').remove();
        $(`#site-display-${field}-${siteId}`).show();
        $(`.edit-site-btn[data-field="${field}"][data-site-id="${siteId}"]`).show();
    });

    // Clic sur le bouton de sauvegarde de site
    $(document).on('click', '.save-site-btn', function() {
        const field = $(this).data('field');
        const siteId = $(this).data('site-id');
        const value = $(`#site-input-${field}-${siteId}`).val();
        const clientId = {{ $client->id }};

        // Envoi AJAX
        $.ajax({
            url: `/clients/${clientId}/sites/${siteId}/update-field`,
            method: 'POST',
            data: {
                field: field,
                value: value,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Mettre à jour l'affichage
                $(`#site-display-${field}-${siteId}`).text(value).show();
                $(`.edit-form`).remove();
                $(`.edit-site-btn[data-field="${field}"][data-site-id="${siteId}"]`).data('original', value).show();

                // Mettre à jour le titre si le champ est name_boite
                if (field === 'name_boite') {
                    // Si on est sur le site actuellement affiché
                    if (activeSiteId === siteId.toString()) {
                        // Mettre à jour le titre affiché
                        $('#selectedSiteTitle').text(value);
                        $('h1.h3').text(value);
                    }
                }

                // Afficher un message de succès
                showNotification('Modification enregistrée', 'success');
            },
            error: function() {
                showNotification('Erreur lors de la modification', 'error');
            }
        });
    });

    function updateTelephonyHostedSection() {
        const section = document.getElementById('telephonyHostedSection');
        if (!section) return;

        // Remplacer complètement le contenu par un tableau à 4 colonnes
        section.querySelector('.accordion-body').innerHTML = `
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="svi">
            <label class="form-check-label" for="svi">SVI</label>
        </div>

        <div class="mb-3">
            <label for="channelCount" class="form-label">Nombre de canaux</label>
            <input type="number" class="form-control form-control-sm" id="channelCount" min="0">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="bg-light">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="phoneLinesBody">
                <!-- Les lignes seront ajoutées ici dynamiquement -->
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <button type="button" class="btn btn-primary btn-sm" id="addPhoneLineBtn">
                <i class="fas fa-plus me-1"></i> Ajouter une ligne
            </button>
        </div>
    `;

        // Assurer l'existence d'une seule modal
        setupPhoneLineModal();

        // Ajouter l'événement au bouton d'ajout
        document.getElementById('addPhoneLineBtn').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('addPhoneLineModal'));
            modal.show();
        });
    }

    // Appeler cette fonction à l'initialisation ou lors du chargement des services
    document.addEventListener('DOMContentLoaded', function() {
        updateTelephonyHostedSection();
    });
    // Fonction pour nettoyer les modals en double et assurer qu'une seule instance existe
    function setupPhoneLineModal() {
        // Supprimer les modals existantes
        document.querySelectorAll('#addPhoneLineModal').forEach(modal => {
            modal.remove();
        });

        // Créer une nouvelle instance de la modal
        const modalHTML = `
    <div class="modal fade" id="addPhoneLineModal" tabindex="-1" aria-labelledby="addPhoneLineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPhoneLineModalLabel">Ajouter une ligne</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="phoneLineForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Nom</label>
                                <input type="text" class="form-control form-control-sm" id="lastName">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Prénom</label>
                                <input type="text" class="form-control form-control-sm" id="firstName">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Numéro de ligne</label>
                            <input type="text" class="form-control form-control-sm" id="phoneNumber">
                        </div>
                        <div class="mb-3">
                            <label for="mobileNumber" class="form-label">Numéro de mobile</label>
                            <input type="text" class="form-control form-control-sm" id="mobileNumber">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="brand" class="form-label">Marque</label>
                                <input type="text" class="form-control form-control-sm" id="brand">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="terminalType" class="form-label">Type de terminal</label>
                                <select class="form-select form-select-sm" id="terminalType">
                                    <option value="">Sélectionner</option>
                                    <option value="Smartphone">Smartphone</option>
                                    <option value="Téléphone fixe">Téléphone fixe</option>
                                    <option value="DECT">DECT</option>
                                    <option value="Softphone">Softphone</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="serialNumber" class="form-label">Numéro de série</label>
                            <input type="text" class="form-control form-control-sm" id="serialNumber">
                        </div>
                        <div class="mb-3">
                            <label for="operator" class="form-label">Opérateur</label>
                            <select class="form-select form-select-sm" id="operator">
                                <option value="">Sélectionner</option>
                                <option value="Orange">Orange</option>
                                <option value="SFR">SFR</option>
                                <option value="Bouygues">Bouygues</option>
                                <option value="Free">Free</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dataAmount" class="form-label">Data (Go)</label>
                            <input type="number" class="form-control form-control-sm" id="dataAmount" min="0">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3 form-check ps-4">
                                <input type="checkbox" class="form-check-input" id="internationalOption">
                                <label class="form-check-label" for="internationalOption">Option internationale</label>
                            </div>
                            <div class="col-6 mb-3 form-check ps-4">
                                <input type="checkbox" class="form-check-input" id="optionalFeature">
                                <label class="form-check-label" for="optionalFeature">Option facultative</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="simCardNumber" class="form-label">N° Carte SIM</label>
                            <input type="text" class="form-control form-control-sm" id="simCardNumber">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary btn-sm" id="savePhoneLine">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>`;

        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Attacher l'événement au bouton de sauvegarde
        document.getElementById('savePhoneLine').addEventListener('click', addPhoneLine);
    }

    function updateTelephonyHostedSection() {
        const section = document.getElementById('telephonyHostedSection');
        if (!section) return;

        section.querySelector('.accordion-body').innerHTML = `
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="svi">
            <label class="form-check-label" for="svi">SVI</label>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="bg-light">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro de ligne</th>
                    <th>Opérateur</th>
                    <th>Data (Go)</th>
                    <th>International</th>
                    <th>N° Carte SIM</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="phoneLinesBody">
                <!-- Les lignes seront ajoutées ici dynamiquement -->
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <button type="button" class="btn btn-primary btn-sm" id="addPhoneLineBtn">
                <i class="fas fa-plus me-1"></i> Ajouter une ligne
            </button>
        </div>
    `;

        // Assurer l'existence d'une seule modal
        setupPhoneLineModal();

        // Ajouter l'événement au bouton d'ajout
        document.getElementById('addPhoneLineBtn').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('addPhoneLineModal'));
            modal.show();
        });
    }


    // Fonction pour s'assurer que la modal de ligne téléphonique existe sans la dupliquer
    function ensurePhoneLineModal() {
        // Vérifier si la modal existe déjà
        if (!document.getElementById('addPhoneLineModal')) {
            // Créer uniquement si elle n'existe pas
            const modalHTML = `
        <div class="modal fade" id="addPhoneLineModal" tabindex="-1" aria-labelledby="addPhoneLineModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPhoneLineModalLabel">Ajouter une ligne téléphonique</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="phoneLineForm">
                            <!-- Vos champs de formulaire existants -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary btn-sm" id="savePhoneLine">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>`;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        // S'assurer que l'événement est attaché une seule fois
        document.getElementById('savePhoneLine').removeEventListener('click', addPhoneLine);
        document.getElementById('savePhoneLine').addEventListener('click', addPhoneLine);
    }


    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser la section téléphonie hébergée
        updateTelephonyHostedSection();

    });

    // Ajouter cette fonction
    function fixTableColumns() {
        // Vérifier et corriger l'en-tête du tableau
        const tableHead = document.querySelector('#telephonyHostedSection .table thead tr');
        if (tableHead && tableHead.children.length > 4) {
            tableHead.innerHTML = `
            <th>Nom</th>
            <th>Prénom</th>
            <th>Numéro</th>
            <th>Actions</th>
        `;
        }

        // S'assurer que updatePhoneLinesTable génère correctement les lignes
        if (typeof updatePhoneLinesTable === 'function') {
            const originalUpdateFunction = updatePhoneLinesTable;
            updatePhoneLinesTable = function() {
                originalUpdateFunction();
                // Vérifier et corriger les lignes après mise à jour
                document.querySelectorAll('#phoneLinesBody tr').forEach(row => {
                    if (row.children.length > 4) {
                        const name = row.children[0].textContent;
                        const firstName = row.children[1].textContent;
                        const number = row.children[2].textContent;
                        const id = row.querySelector('.delete-phone-line')?.dataset.id;

                        row.innerHTML = `
                        <td>${name}</td>
                        <td>${firstName}</td>
                        <td>${number}</td>
                        <td class="text-center">
                            <button class="btn btn-xs text-danger delete-phone-line" data-id="${id}">
                                <i class="fas fa-trash fa-2xs"></i>
                            </button>
                        </td>
                    `;
                    }
                });
            };
        }
    }

    // Exécuter cette fonction après le chargement complet de la page
    document.addEventListener('DOMContentLoaded', fixTableColumns);
    // L'exécuter aussi quand l'onglet téléphonie est ouvert
    document.querySelector('button[data-bs-target="#telephonyHostedSection"]')?.addEventListener('click', function() {
        setTimeout(fixTableColumns, 100);
    });
    // Fonction améliorée pour charger les terminaux

    function loadTerminalData() {
        // Utiliser la bonne URL - ajuster selon la structure de votre API
        fetch('/admin/terminals/list')  // ou '/admin/terminals' selon votre API
            .then(response => {
                if (!response.ok) {
                    if (response.status === 401) {
                        throw new Error('Non autorisé - Veuillez vous reconnecter');
                    }
                    throw new Error(`Erreur ${response.status}`);
                }

                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    console.warn('Réponse non-JSON reçue');
                    return [];
                }
            })
            .then(data => {
                terminalsData = Array.isArray(data) ? data : [];

                // Créer ou vider la datalist
                let datalist = document.getElementById('serialNumberList');
                if (!datalist) {
                    datalist = document.createElement('datalist');
                    datalist.id = 'serialNumberList';
                    document.body.appendChild(datalist);
                } else {
                    datalist.innerHTML = '';
                }

                // Remplir la datalist avec les numéros de série
                terminalsData.forEach(terminal => {
                    if (terminal.serial_number) {
                        const option = document.createElement('option');
                        option.value = terminal.serial_number;
                        datalist.appendChild(option);
                    }
                });

                // Associer la datalist au champ
                const serialNumberField = document.getElementById('serialNumber');
                if (serialNumberField) {
                    serialNumberField.setAttribute('list', 'serialNumberList');

                    // Configuration de l'auto-remplissage
                    serialNumberField.addEventListener('input', function() {
                        const serialNumber = this.value;
                        const terminal = terminalsData.find(t => t.serial_number === serialNumber);

                        if (terminal) {
                            if (document.getElementById('brand'))
                                document.getElementById('brand').value = terminal.brand || '';
                            if (document.getElementById('terminalType'))
                                document.getElementById('terminalType').value = terminal.model || '';
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des terminaux:', error);
            });
    }

    // Initialisation sécurisée pour la modal
    document.addEventListener('DOMContentLoaded', function() {
        // Attacher l'événement d'ouverture de la modal quand le bouton d'ajout est cliqué
        const addPhoneLineBtn = document.getElementById('addPhoneLineBtn');
        if (addPhoneLineBtn) {
            addPhoneLineBtn.addEventListener('click', function() {
                // S'assurer que la modal existe
                ensurePhoneLineModal();
                // Charger les données des terminaux
                loadTerminalData();
                // Ouvrir la modal
                const modal = new bootstrap.Modal(document.getElementById('addPhoneLineModal'));
                modal.show();
            });
        }
    });

//     function setupTerminalFeatures() {
//         console.log("Initialisation des fonctionnalités de terminal...");
//
//         // Variables globales
//         let terminalsData = [];
//
//         // 1. Vérifier et créer la datalist si elle n'existe pas
//         function ensureDatalistExists() {
//             // Vérifier si la datalist existe déjà
//             let serialList = document.getElementById('serialNumberList');
//             if (!serialList) {
//                 console.log("Création de la datalist manquante...");
//
//                 // Trouver le champ de saisie du numéro de série
//                 const serialField = document.getElementById('serialNumber');
//                 if (serialField) {
//                     // Créer la datalist
//                     serialList = document.createElement('datalist');
//                     serialList.id = 'serialNumberList';
//
//                     // Insérer après le champ de saisie
//                     serialField.insertAdjacentElement('afterend', serialList);
//
//                     // S'assurer que le champ est lié à la datalist
//                     serialField.setAttribute('list', 'serialNumberList');
//                     serialField.setAttribute('autocomplete', 'off');
//
//                     return serialList;
//                 } else {
//                     console.error("Champ serialNumber introuvable");
//                     return null;
//                 }
//             }
//             return serialList;
//         }
//
//         // 2. Récupération des terminaux depuis l'API
//         function loadTerminalsData() {
//             console.log("Chargement des terminaux...");
//             fetch('/api/terminals', {
//                 headers: {
//                     'Accept': 'application/json',
//                     'X-Requested-With': 'XMLHttpRequest'
//                 }
//             })
//                 .then(response => {
//                     if (!response.ok) {
//                         throw new Error(`Erreur HTTP: ${response.status}`);
//                     }
//                     const contentType = response.headers.get('content-type');
//                     if (!contentType || !contentType.includes('application/json')) {
//                         console.error("L'API a renvoyé un format incorrect:", contentType);
//                         // Utiliser des données de test en attendant
//                         return getDummyTerminals();
//                     }
//                     return response.json();
//                 })
//                 .then(data => {
//                     console.log(`${data.length} terminaux chargés`);
//                     terminalsData = data;
//                     populateSerialNumberList();
//                 })
//                 .catch(error => {
//                     console.error('Erreur de chargement des terminaux:', error);
//                     // Utiliser des données de test en cas d'erreur
//                     terminalsData = getDummyTerminals();
//                     populateSerialNumberList();
//                 });
//         }
//
// // Fonction pour générer des données de test
//         function getDummyTerminals() {
//             return [
//                 { serial_number: "SN001", brand: "Samsung", model: "Galaxy S21" },
//                 { serial_number: "SN002", brand: "Apple", model: "iPhone 13" },
//                 { serial_number: "SN003", brand: "Xiaomi", model: "Mi 11" },
//                 { serial_number: "SN004", brand: "Google", model: "Pixel 6" }
//             ];
//         }
//
//         // 3. Remplissage de la datalist
//         function populateSerialNumberList() {
//             const serialList = ensureDatalistExists();
//             if (!serialList) return;
//
//             serialList.innerHTML = '';  // Vider la liste existante
//
//             if (terminalsData.length === 0) {
//                 console.warn("Aucun terminal disponible");
//                 return;
//             }
//
//             // Ajouter tous les numéros de série à la datalist
//             terminalsData.forEach(terminal => {
//                 if (terminal.serial_number) {
//                     const option = document.createElement('option');
//                     option.value = terminal.serial_number;
//                     serialList.appendChild(option);
//                 }
//             });
//
//             console.log(`${serialList.children.length} numéros de série ajoutés à la datalist`);
//         }
//
//         // 4. Configuration de l'auto-remplissage
//         function setupAutoFill() {
//             const serialNumberField = document.getElementById('serialNumber');
//             if (!serialNumberField) {
//                 console.warn("Champ serialNumber introuvable");
//                 return;
//             }
//
//             // Afficher toutes les options au focus
//             serialNumberField.addEventListener('focus', function() {
//                 this.value = '';
//             });
//
//             // Auto-remplir les autres champs
//             serialNumberField.addEventListener('input', function() {
//                 const serialNumber = this.value;
//                 const terminal = terminalsData.find(t => t.serial_number === serialNumber);
//
//                 if (terminal) {
//                     console.log("Terminal trouvé:", terminal);
//                     // Remplir les champs de marque et modèle
//                     if (document.getElementById('brand'))
//                         document.getElementById('brand').value = terminal.brand || '';
//                     if (document.getElementById('terminalType'))
//                         document.getElementById('terminalType').value = terminal.model || '';
//                 }
//             });
//         }
//
//         // 5. Initialiser à l'ouverture de la modal
//         const modal = document.getElementById('addPhoneLineModal');
//         if (modal) {
//             // Écouter l'événement d'ouverture de la modal
//             modal.addEventListener('shown.bs.modal', function() {
//                 console.log("Modal ouverte - initialisation des terminaux");
//                 // Recréer la datalist à chaque ouverture
//                 ensureDatalistExists();
//                 loadTerminalsData();
//                 setupAutoFill();
//             });
//         } else {
//             console.error("Modal addPhoneLineModal introuvable");
//         }
//
//         // Chargement initial
//         if (document.getElementById('serialNumber')) {
//             loadTerminalsData();
//             setupAutoFill();
//         }
//     }


</script>
