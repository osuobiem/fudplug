<div>
    <div>
        @if(!empty($orders))
        @foreach($orders as $order_key=>$order)
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
                                            src="/storage/vendor/cover/{{$order->vendor_image}}"
                                            alt="Image Description">
                                    </div>
                                    <div class="media-body mt-2">
                                        {{$order->vendor_name}}

                                        <span
                                            class="badge {{$order->order_status['colour']}} ml-2">{{$order->order_status['status']}}</span>
                                    </div>
                                </div>
                            </a>
                        </h5>
                    </div>
                    <div id="basicsCollapseOne" class="collapse @if($order_key < 1): show @endif"
                        aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion" style="">
                        <div class="card-body border-top p-2 text-muted" style="font-size: large;">
                            <ul id="basket-price-type" id="item" class="list-group box-body generic-scrollbar"
                                style="max-height: 250px; overflow: auto;">
                                @foreach($order['title'] as $title_key=>$title)
                                @if($order['order_type'][$title_key] == "simple")
                                <li class="list-group-item pt-0 col">
                                    @php
                                    $actual_detail = json_decode($order['quantity'][$title_key], true);
                                    $order_qty = json_decode($order['order_detail'][$title_key])[0];
                                    @endphp
                                    <div class="media mt-2">
                                        <div class="u-avatar">
                                            <img class="img-fluid rounded-circle"
                                                src="/storage/vendor/dish/{{$order['image'][$title_key]}}"
                                                alt="Image Description">
                                        </div>
                                        <div class="media-body pl-4">
                                            <div class="text-left">
                                                @if($order_key < 1) <small>{{$title}}</small>
                                                    @else
                                                    <small>{{$title}}</small>
                                                    @endif
                                                    <p class="mb-0 mt-0" style="font-size:15px;">
                                                        <span class="text-danger pr-3 border-right">
                                                            ₦{{$actual_detail['price']}}
                                                        </span>
                                                        <span class="text-dark pl-3">
                                                            <strong>Qty: </strong>{{$order_qty}}
                                                        </span>
                                                    </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @else

                                @php
                                $i = 1;

                                $regular_qty = json_decode($order['quantity'][$title_key], true)['regular'];
                                $bulk_qty = json_decode($order['quantity'][$title_key], true)['bulk'];
                                $order_detail = json_decode($order['order_detail'][$title_key], true);

                                @endphp
                                @foreach($order_detail as $key=>$detail)
                                @php
                                $index = $detail[1];
                                $type = $detail[0];
                                @endphp
                                @if($type == "regular")
                                @php
                                $qty = json_decode($regular_qty, true)[$index];
                                @endphp
                                <li id="price-type" class="list-group-item pt-0 col">
                                    <div class="media mt-2">
                                        <div class="u-avatar">
                                            <img class="img-fluid rounded-circle"
                                                src="/storage/vendor/dish/{{$order['image'][$title_key]}}"
                                                alt="Image Description">
                                        </div>
                                        <div class="media-body pl-4">
                                            <div class="text-left">
                                                <small style="">{{$title}}
                                                    ({{$qty['title']}})</small>
                                                <p class="mb-0 mt-0" style="font-size:15px;">
                                                    <span class="text-danger pr-3 border-right">
                                                        ₦{{$qty['price']}}
                                                    </span>
                                                    <span class="text-dark pl-3">
                                                        <strong>Qty: </strong>{{$detail[2]}}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @else
                                @php
                                $qty = json_decode($bulk_qty, true)[$index];
                                @endphp
                                <li id="price-type" class="list-group-item pt-0 col">
                                    <div class="media mt-2">
                                        <div class="u-avatar">
                                            <img class="img-fluid rounded-circle"
                                                src="/storage/vendor/dish/{{$order['image'][$title_key]}}"
                                                alt="Image Description">
                                        </div>
                                        <div class="media-body pl-4">
                                            <div class="text-left">
                                                <small style="">{{$title}}
                                                    ({{$qty['title']}} <strong>Litres</strong>)</small>
                                                <p class="mb-0 mt-0" style="font-size:15px;">
                                                    <span class="text-danger pr-3 border-right">
                                                        ₦{{$qty['price']}}
                                                    </span>
                                                    <span class="text-dark pl-3">
                                                        <strong>Qty: </strong>{{$detail[2]}}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @php
                                $i++;
                                @endphp
                                @endforeach

                                @endif
                                @endforeach
                            </ul>
                        </div>
                        @if($order->order_status['status'] == "Pending")
                        <div class="card-footer border-top p-0 text-muted">
                            <a href="javascript:void(0);" onclick="cancelOrder('{{$order->order_id}}')"
                                class="btn btn-sm"><i class="las la-times"></i>&nbsp;Cancel
                                order</a>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
        @endforeach
        @else
        <p>No Orders yet!</p>
        @endif
    </div>
</div>
