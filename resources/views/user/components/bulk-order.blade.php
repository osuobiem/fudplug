<div class="modal fade" id="bulk-order-modal" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 pb-3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="img-container pl-md-0 col-md-7">
                        <img id="image" class="img-edit rounded order-img"
                            src="{{Storage::url('vendor/dish/'.$dish->image)}}">
                    </div>
                    <div class="col-md-5">
                        <form id="bulk-order-form">
                            @csrf

                            <div id="basics">

                                <div class="mb-5 pt-3 text-lg-left text-center">
                                    <div class="float-left">
                                        <h4 class="font-weight-semi-bold">{{ucfirst($dish->title)}} </h4>
                                    </div>
                                </div>
                                <div id="basicsAccordion">
                                    <div class="box shadow-sm border rounded bg-white mb-2">
                                        <div id="basicsHeadingTwo">
                                            <h5 class="mb-0">
                                                <button type="button"
                                                    class="shadow-none btn btn-block d-flex justify-content-between card-btn p-3 collapsed font-weight-bold"
                                                    data-toggle="collapse" data-target="#basicsCollapseTwo"
                                                    aria-expanded="false" aria-controls="basicsCollapseTwo">
                                                    Bulk Quantity
                                                    <span class="card-btn-arrow">
                                                        <span class="la la-chevron-down"></span>
                                                    </span>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="basicsCollapseTwo" class="collapse show"
                                            aria-labelledby="basicsHeadingTwo" data-parent="#basicsAccordion">
                                            <div class="card-body border-top p-2 text-muted" style="font-size:large;">
                                                @if(!empty($bulk_qty))
                                                <ul class="list-group">
                                                    @foreach($bulk_qty as $key=>$qty)
                                                    <li class="list-group-item pt-0">
                                                        <div class="float-left">
                                                            <small>{{$qty->title}}</small>
                                                            <p class="mt-0">
                                                                <span class="float-left text-danger"
                                                                    style="font-size: larger;">
                                                                    ₦{{$qty->price}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="float-right mt-4">
                                                            <input class="" type="checkbox"
                                                                onchange="bulkCheck(event, this)"
                                                                value="['bulk','{{$key}}']" name="order_detail[]"
                                                                id="item-{{$dish->id}}-{{$key}}">
                                                            <label class="form-check-label small"
                                                                for="item-{{$dish->id}}-{{$key}}">
                                                                Select
                                                            </label>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @else
                                                <div class="bg-light text-center py-5">
                                                    <i class="las la-info" style="font-size:xx-large;"></i><br>
                                                    <small>Empty Content</small>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-xs-2">
                                    <button type="submit" id="bulk-order-btn"
                                        class="btn btn-sm btn-primary btn-block font-weight-bold"
                                        data-attach-loading="true" disabled>
                                        Add to basket <span id="bulk-final-price" class="float-right"
                                            data-item-subtotal="">₦0.00</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

<script>
    $(document).ready(function () {
        $("#bulk-order-form").submit(function (el) {
            addToBasket(el, '{{$dish->vendor_id}}');
        });
    });

    // Place order
    function addToBasket(el, vendorId) {
        el.preventDefault()

        // spin('profile')
        offError('pr-update-error')

        let url = `{{url('user/add-to-basket')}}`;
        let data = new FormData(el.target);
        data.append('vendor_id', '{{$dish->vendor_id}}');
        data.append('item_id', '{{$dish->id}}');
        data.append('order_type', '{{$dish->type}}');

        goPost(url, data)
            .then(res => {
                // spin('profile')

                if (handleFormRes(res)) {
                    if (res.type == "error") {
                        handleValidateErr(res);
                    } else {
                        showAlert(true, res.message);
                        // Load user basket details
                        getBasket();
                        // Close modal
                        $("#bulk-order-modal").modal('hide');
                    }
                }
            })
            .catch(err => {
                // spin('profile');
                handleFormRes(err, 'pr-update-error');
            })
    }

</script>
