<div>

    <form id="basket-form">
        @csrf

        @foreach($basket_items as $dish_key=>$dish)
        @if($dish->order_type == "simple")
        <div>
            <!-- <div class="mb-5 pt-3 text-lg-left text-center">
                <div class="float-left">
                    <h4 class="font-weight-semi-bold">
                    </h4>
                </div>
            </div> -->

            <div id="basicsAccordion">
                <div class="box shadow border rounded bg-white mb-2">
                    <div id="basicsHeadingOne">
                        <h5 class="mb-0">
                            <a href="javascript:void(0)" onclick="toggleAccordion(event, this)" type="button"
                                class="shadow-none d-flex p-3 collapsed font-weight-bold" data-toggle=""
                                data-target="#basicsCollapseOne" aria-expanded="false"
                                aria-controls="basicsCollapseOne">
                                <div class="media">
                                    <div class="u-avatar mr-3">
                                        <img class="img-fluid rounded-circle"
                                            src="/storage/vendor/dish/{{$dish->image}}" alt="Image Description">
                                    </div>
                                    <div class="media-body mt-2">
                                        {{ucfirst($dish->title)}}
                                    </div>
                                </div>
                            </a>
                        </h5>
                    </div>
                    <div id="basicsCollapseOne" class="collapse @if($dish_key < 1): show @endif"
                        aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion" style="">
                        <div class="card-body border-top p-2 text-muted" style="font-size: large;">
                            <ul id="basket-price-type" id="item" class="list-group box-body generic-scrollbar"
                                style="max-height: 250px; overflow: auto;">
                                <li class="list-group-item pt-0">
                                    <div class="float-left col-4">
                                        <small class="basket-price-small">Price</small>
                                        <p class="mt-0">
                                            <span class="float-left text-danger" style="font-size: large;">
                                                @php
                                                $actual_detail = json_decode($dish->quantity, true);
                                                $order_qty = json_decode($dish->order_detail)[0];
                                                @endphp
                                                ₦{{$actual_detail['price']}}
                                            </span>
                                        </p>
                                        <input name="basket_price[]" type="hidden" value="{{$actual_detail['price']}}">
                                        <input name="order_detail[]" type="hidden" value="" disabled>
                                    </div>
                                    <div class="float-right col-2">
                                        <a href="javascript:void(0)" title="delete"
                                            onclick="deleteCartItem('{{$dish->id}}', '{{$dish->order_type}}')">
                                            <i class="las la-trash-alt mt-4 bskt-del-btn"></i>
                                        </a>
                                    </div>
                                    <div class="float-right col-5 mt-4">
                                        <div class="input-group qty-field">
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button bordered"
                                                    class="btn btn-sm btn-secondary btn-number rounded-right-0 qty-btn"
                                                    data-type="minus">
                                                    <span class="la la-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="order_quantity[]" onkeydown="keydown(event)"
                                                onchange="change(event, this, '{{$dish->id}}', '{{$dish->order_type}}')"
                                                onfocus="focusin(event, this)"
                                                class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input"
                                                value="{{$order_qty}}" min="0" max="{{$actual_detail['quantity']}}"
                                                disabled>
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button"
                                                    class="btn btn-sm btn-secondary btn-number rounded-left-0 qty-btn"
                                                    data-type="plus">
                                                    <span class="la la-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        @else
        <div">

            <!-- <div class="mb-5 pt-3 text-lg-left text-center">
                <div class="float-left">
                    <h4 class="font-weight-semi-bold">{{ucfirst($dish->title)}}
                    </h4>
                </div>
            </div> -->
            <div id="basicsAccordion">

                <div class="box shadow border rounded bg-white mb-2">
                    <div id="basicsHeadingOne">
                        <h5 class="mb-0">
                            <a href="javascript:void(0)" onclick="toggleAccordion(event, this)"
                                class="shadow-none d-flex p-3 collapsed font-weight-bold" data-toggle=""
                                data-target="#basicsCollapseOne" aria-expanded="false"
                                aria-controls="basicsCollapseOne">
                                <div class="media">
                                    <div class="u-avatar mr-3">
                                        <img class="img-fluid rounded-circle"
                                            src="/storage/vendor/dish/{{$dish->image}}" alt="Image Description">
                                    </div>
                                    <div class="media-body mt-2">
                                        {{ucfirst($dish->title)}}
                                    </div>
                                </div>
                            </a>
                        </h5>
                    </div>
                    <div id="basicsCollapseOne" class="collapse @if($dish_key < 1): show @endif"
                        aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion" style="">
                        <div class="card-body border-top p-2 text-muted" style="font-size: large;">

                            <ul id="basket-price-type" class="list-group box-body generic-scrollbar"
                                style="max-height: 250px; overflow: auto;">
                                @php
                                $i = 1;

                                $regular_qty = json_decode($dish->quantity, true)['regular'];
                                $order_detail = json_decode($dish->order_detail, true);
                                @endphp
                                @foreach($order_detail as $key=>$detail)
                                @php
                                $index = $detail[1];
                                $qty = json_decode($regular_qty, true)[$index];
                                @endphp
                                <li id="price-type" class="list-group-item pt-0 col">
                                    <div class="float-left col-4">
                                        <small class="basket-small">{{$qty['title']}}</small>
                                        <p class="mt-0">
                                            <span class="float-left text-danger" style="font-size: large;">
                                                ₦{{$qty['price']}}</span>
                                        </p>
                                        <input class="basket-price" name="basket_price[]" type="hidden"
                                            value="{{$qty['price']}}">
                                        <input name="order_detail[]" type="hidden" value="['regular','{{$key}}']"
                                            disabled>
                                    </div>
                                    <div class="float-right col-2">
                                        <a href="javascript:void(0)"
                                            onclick="deleteCartItem('{{$dish->id}}', '{{$dish->order_type}}', '{{$key}}')">
                                            <i class="las la-trash-alt mt-4 bskt-del-btn"></i>
                                        </a>
                                    </div>
                                    <div class="float-right col-5 mt-4">
                                        <div class="input-group qty-field">
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button bordered"
                                                    class="btn btn-sm btn-secondary btn-number rounded-right-0 qty-btn"
                                                    data-type="minus">
                                                    <span class="la la-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" onkeydown="keydown(event)"
                                                onchange="change(event, this, '{{$dish->id}}', '{{$dish->order_type}}', '{{$key}}')"
                                                onfocus="focusin(event, this)" name="order_quantity[]"
                                                class="form-control rounded-left-0 rounded-right-0 form-control-sm qty-input"
                                                value="{{$detail[2]}}" min="0" max="{{$qty['quantity']}}">
                                            <span class="input-group-btn">
                                                <button onclick="clicked(event, this);" type="button"
                                                    class="btn btn-sm btn-secondary btn-number rounded-left-0 qty-btn"
                                                    data-type="plus">
                                                    <span class="la la-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>

            </div>

</div>
@endif
@endforeach
<div class="row">
    <div class="col-md-12 mt-xs-2">
        <button type="submit" id="basket-order-btn" class="btn btn-sm btn-primary btn-block font-weight-bold"
            data-attach-loading="true" disabled>
            Place order <span id="basket-final-price" class="float-right" data-item-subtotal="">₦0.00</span>
        </button>
    </div>
</div>
</form>
</div>
@push('scripts')
<script>
    console.log("hello my");

</script>
@endpush
