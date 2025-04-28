// Constantes et variables globales
const BACKUP_OPTIONS = ['none', 'FTTH', 'FTTO', 'FTTE', '4G', '5G', 'DataOnlyFairUse', 'M2M'];
const ACCESS_TYPES = ['FTTH', 'FTTO', 'FTTE', '4G', '5G', 'DataOnlyFairUse', 'M2M'];

// Fonctions de base
function generateServicesHTML(siteId) {
    return `
        <div class="container-fluid">
            <!-- Téléphonie hébergée -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Téléphonie hébergée</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="sviService" onchange="updateSviStatus(this)">
                        <label class="form-check-label" for="sviService">Service SVI</label>
                    </div>
                    <div class="mb-3">
                        <label for="channelCount" class="form-label">Nombre de canaux</label>
                        <input type="number" class="form-control" id="channelCount" min="0" value="0">
                    </div>
                    <div id="sviLabel"></div>
                </div>
            </div>

            <!-- Liens d'accès -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-network-wired me-2"></i>Liens d'accès</h5>
                </div>
                <div class="card-body">
                    ${generateAccessLinksHTML()}
                </div>
            </div>

            <!-- Mobile -->
            <div class="card mb-3">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-mobile-alt me-2"></i>Mobile</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="lignesCount" class="form-label">Nombre de lignes</label>
                        <input type="number" class="form-control" id="lignesCount" min="0" value="0" onchange="updateLignesTable(this.value)">
                    </div>
                    <div id="lignesTableContainer" style="display: none;">
                        <table class="table table-sm" id="lignesTable">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Numéro</th>
                                    <th>Opérateur</th>
                                    <th>Volume data</th>
                                    <th>International</th>
                                    <th>N° SIM</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cloud -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cloud me-2"></i>Cloud</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="cloudService" onchange="updateCloudStatus(this)">
                        <label class="form-check-label" for="cloudService">Activer le service Cloud</label>
                    </div>
                    <div id="cloudLabel" class="mt-2"></div>
                </div>
            </div>
        </div>
    `;
}

function generateAccessLinksHTML() {
    return ACCESS_TYPES.map(type => `
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">${type}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Back-up</label>
                        ${generateBackupRadios(type)}
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="fw${type}" onchange="updateFwStatus(this, '${type}')">
                            <label class="form-check-label" for="fw${type}">Firewall</label>
                        </div>
                        <div id="fwLabel${type}" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function generateBackupRadios(type) {
    return `
        <div class="btn-group" role="group">
            ${BACKUP_OPTIONS.map(option => `
                <input type="radio" class="btn-check" name="backup${type}" id="backup${type}${option}" value="${option}">
                <label class="btn btn-outline-primary btn-sm" for="backup${type}${option}">
                    ${option === 'none' ? 'Aucun' : option}
                </label>
            `).join('')}
        </div>
    `;
}

function loadSiteServices(siteId) {
    axios.get(`/sites/${siteId}/services`)
        .then(response => {
            const services = response.data;
            updateServicesForm(services);
        })
        .catch(error => {
            console.error('Erreur lors du chargement des services:', error);
        });
}

function updateServicesForm(services) {
    // Mise à jour SVI
    document.getElementById('sviService').checked = services.svi;
    document.getElementById('channelCount').value = services.channel_count;
    updateSviStatus(document.getElementById('sviService'));

    // Mise à jour liens d'accès
    if (services.access_links) {
        ACCESS_TYPES.forEach(type => {
            const link = services.access_links[type];
            if (link) {
                document.querySelector(`input[name="backup${type}"][value="${link.backup}"]`).checked = true;
                document.getElementById(`fw${type}`).checked = link.firewall;
                updateFwStatus(document.getElementById(`fw${type}`), type);
            }
        });
    }

    // Mise à jour mobile
    if (services.mobile_lines) {
        document.getElementById('lignesCount').value = services.mobile_lines.length;
        updateLignesTable(services.mobile_lines.length);
        services.mobile_lines.forEach((line, index) => {
            fillMobileLine(index, line);
        });
    }

    // Mise à jour Cloud
    document.getElementById('cloudService').checked = services.cloud;
    updateCloudStatus(document.getElementById('cloudService'));
}

function fillMobileLine(index, line) {
    document.querySelector(`input[name="ligne_nom_${index}"]`).value = line.nom;
    document.querySelector(`input[name="ligne_prenom_${index}"]`).value = line.prenom;
    document.querySelector(`input[name="ligne_numero_${index}"]`).value = line.numero;
    document.querySelector(`select[name="ligne_operateur_${index}"]`).value = line.operateur;
    document.querySelector(`select[name="ligne_data_${index}"]`).value = line.volume_data;
    document.querySelector(`input[name="ligne_international_${index}"]`).checked = line.international;
    document.querySelector(`input[name="ligne_sim_${index}"]`).value = line.numero_sim;
}
