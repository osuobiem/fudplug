<div class="dropup-container bas-container animate__animated d-none">
    <div class="dropup-inner bas-inner animate__animated">

        <ul class="nav nav-justified osahan-line-tab" style="box-shadow: 0 5px 10px 0 #00000061">
            <li class="nav-item text-left">
                <a class="nav-link active dropup-top-a d-flex" style="padding: 0 !important">
                    <span class="ml-2 py-2"> <i class="la la-shopping-basket la-lg"></i> My Basket <span
                            id="mob-head-count"></span></span>
                    <div class="text-right">
                        <i class="la la-times la-lg dropup-top-ico" onclick="closeBasket()"></i>
                    </div>
                </a>
            </li>
        </ul>

        <div class="pb-2 pt-3">

            <div class="text-center">
                <div class="box-body p-0 text-center job-item-2">
                    <div class="col-12 generic-scrollbar" id="basket-container-mob"
                        style="max-height: 323px; overflow: auto;">


                        <div id="basket-container-spinner-mob" class="text-white" style="line-height: 27px;">
                            jdjjd
                        </div>
                    </div>
                    <div class="col-12 pt-2">
                        <button type="button" onclick="placeOrder()"
                            class="btn btn-sm btn-primary btn-block font-weight-bold basket-order-btn"
                            data-attach-loading="true" disabled>

                            <span id="basket-txt">Place order</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="basket-spinner"
                                style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span class="float-right basket-final-price" data-item-subtotal="">₦0.00</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
