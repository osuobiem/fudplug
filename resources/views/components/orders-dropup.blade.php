<div class="dropup-container order-container animate__animated d-none">
    <div class="dropup-inner order-inner animate__animated">

        <ul class="nav nav-justified osahan-line-tab" style="box-shadow: 0 5px 10px 0 #00000061">
            <li class="nav-item text-left">
                <a class="nav-link active dropup-top-a d-flex" style="padding: 0 !important">
                    <span class="ml-0 py-0">
                        <i class="la la-list la-lg dropup-top-ico-left d-none" id="mob-today-order-btn"></i>
                        <i class="la la-history la-lg dropup-top-ico-left" id="mob-order-history-btn"></i>

                        <!-- <a href="javascript:void(0)" title="Order history" class="text-dark"><i
                                class="las la-history la-2x"></i></a>
                        <a href="javascript:void(0)" title="Today's Orders" class="text-dark d-none"><i
                                class="las la-list la-2x"></i></a> -->
                        <span>
                            @if(!Auth::guard('vendor')->guest())
                            Orders<span id="mob-state-display">(Today)</span> <span id="mob-order-count"
                                class="badge badge-dark"></span>
                            @elseif(!Auth::guard('user')->guest())
                            My Orders <span id="mob-state-display">(Today)</span>
                            @endif
                        </span>
                    </span>
                    <div class="text-right">
                        <i class="la la-times la-lg dropup-top-ico" onclick="closeOrders()"></i>
                    </div>
                </a>
            </li>
        </ul>

        <div>
            <div class="py-1 text-center">
                <div class="box-body generic-scrollbar p-2 text-center job-item-2 mob-order-container"
                    style="max-height: 450px; overflow: auto;" id="h-noti-cont">
                    <p>No Orders yet!</p>
                </div>
                @if(!Auth::guard('user')->guest())
                <div class="box-body">
                    <div class="col-md-12 mt-xs-2">
                        <button type="button" id="mob-order-cancel-btn"
                            class="btn btn-sm btn-primary btn-block font-weight-bold" data-attach-loading="true"><i
                                class="las la-times"></i>&nbsp;
                            Cancel All <span id="mob-order-price" class="float-right" data-item-subtotal="">₦0.00</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
