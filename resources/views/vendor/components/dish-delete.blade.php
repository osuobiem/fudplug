<div class="modal fade" id="dish-delete-modal" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="bg-light text-center" style="height:inherit;">
                    <h6 class="pt-3">
                        <i class="las la-info pb-0" style="font-size:xx-large;"></i><br>
                        <span>Delete <span id="del-dish-title"></span> ?</span>
                    </h6>
                    <div class="pb-3">
                        <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">No</button>
                        <button type="button" onclick="deleteDish()" class="btn btn-md btn-primary"
                            id="dish-delete-btn">
                            <span id="dish-delete-txt">Yes</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="dish-delete-spinner"
                                style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
