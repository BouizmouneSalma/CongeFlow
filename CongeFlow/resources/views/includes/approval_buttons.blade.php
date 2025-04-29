<div class="d-flex justify-content-start align-items-center mt-3">
    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
        <i class="fas fa-check me-1"></i> Approuver
    </button>
    
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
        <i class="fas fa-times me-1"></i> Rejeter
    </button>
</div>

<!-- Modal d'approbation -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Confirmer l'approbation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update-statut', $demande->id ?? 1) }}" method="POST">
                @csrf
                <input type="hidden" name="statut" value="approuvee">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="approve_comment" class="form-label">Commentaire (optionnel)</label>
                        <textarea class="form-control" id="approve_comment" name="commentaire" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Confirmer l'approbation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Motif du rejet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update-statut', $demande->id ?? 1) }}" method="POST">
                @csrf
                <input type="hidden" name="statut" value="refusee">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reject_reason" class="form-label">Veuillez indiquer le motif du rejet</label>
                        <textarea class="form-control" id="reject_reason" name="commentaire" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>
</div> 