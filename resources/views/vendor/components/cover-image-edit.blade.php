<div class="modal fade" id="cover-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="cover-image" class="img-edit img-responsive"
                        src="{{ Storage::url('vendor/cover/'.Auth::user('vendor')->cover_image) }}">
                </div>
                <div class="progress" style="display: none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                <div class="alert img-edit-alert animate__animated animate__headShake" role="alert"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cover-crop">Crop & Save</button>
                <label type="button" class="btn btn-primary d-none" for="cover-input" id="cover-change">Change</label>
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>
