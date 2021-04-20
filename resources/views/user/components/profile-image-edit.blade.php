<div class="modal fade" id="user-image-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="image" class="img-edit"
                        src="{{ Storage::url('user/profile/'.Auth::guard('user')->user()->profile_image) }}">
                </div>
                <!-- <div class="progress" style="display: none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div> -->
                <div class="alert img-edit-alert animate__animated animate__headShake" role="alert"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="user-crop">
                    <span id="user-crop-txt">Crop & Save</span>
                    <div class="spinner-border spinner-border-sm btn-pr mx-4" id="user-crop-spinner"
                        style="display:none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </button>
                <label type="button" class="btn btn-primary d-none" for="input" id="change">Change</label>
            </div>
        </div>
    </div>
</div>
