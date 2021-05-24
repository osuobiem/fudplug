<div class="modal-header bg-light border-bottom">
    <div class="media">
        <div class="u-avatar mr-1">
            <img class="rounded-circle" style="height: 45px; width: 45px;"
                src="/storage/user/profile/{{$order->profile_image}}" alt="Image Description">
        </div>
        <div class="media-body mt-0">
            <div class="text-left font-weight-bold text-dark">
                <span>{{$order->name}}</span>
                <span id="order-status" style="font-size: 108%;">
                    <span class="badge {{$order->order_status['colour']}} ml-1">
                        {{$order->order_status['status']}}
                    </span>
                </span>
            </div>
            <div class="text-left text-dark">
                @<span>{{$order->username}}</span>
            </div>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="box border rounded bg-white">
        <div class="box-body row overflow-auto generic-scrollbar" style="max-height: 400px;">

            @foreach($order['title'] as $title_key=>$title)
            @if($order['order_type'][$title_key] == "simple")
            <div class="col-md-6 mb-2">
                <div class="border shadow-sm border rounded bg-white job-item-2 pl-1 pt-1 pb-1 pr-0">
                    <div class="media">
                        @php
                        $actual_detail = json_decode($order['quantity'][$title_key], true);
                        $order_qty = json_decode($order['order_detail'][$title_key])[0];
                        @endphp
                        <div class="u-avatar">
                            <img class="rounded-circle mr-3" style="height: 45px; width: 45px;"
                                src="/storage/vendor/dish/{{$order['image'][$title_key]}}" alt="Image Description">
                        </div>
                        <div class="media-body">
                            <div class="text-left">
                                <small>{{$title}}</small>
                                <p class="mb-0 mt-0" style="font-size:15px;">
                                    <span class="text-danger pr-2 border-right">
                                        ₦{{$actual_detail['price']}}
                                    </span>
                                    <span class="text-dark pl-2">
                                        <strong>Qty: </strong>{{$order_qty}}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            <!-- <li id="price-type" class="list-group-item pt-0 col">
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
            </li> -->

            <div class="col-md-6 mb-2">
                <div class="border shadow-sm border rounded bg-white job-item-2 pl-1 pt-1 pb-1 pr-0">
                    <div class="media">
                        <div class="u-avatar">
                            <img class="rounded-circle mr-3" style="height: 45px; width: 45px;"
                                src="/storage/vendor/dish/{{$order['image'][$title_key]}}" alt="Image Description">
                        </div>
                        <div class="media-body">
                            <div class="text-left">
                                <small style="">{{$title}}
                                    ({{$qty['title']}})</small>
                                <p class="mb-0 mt-0" style="font-size:15px;">
                                    <span class="text-danger pr-2 border-right">
                                        ₦{{$qty['price']}}
                                    </span>
                                    <span class="text-dark pl-2">
                                        <strong>Qty: </strong>{{$detail[2]}}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            @php
            $qty = json_decode($bulk_qty, true)[$index];
            @endphp
            <!-- <li id="price-type" class="list-group-item pt-0 col">
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
            </li> -->

            <div class="col-md-6 mb-2">
                <div class="border shadow-sm border rounded bg-white job-item-2 pl-1 pt-1 pb-1 pr-0">
                    <div class="media">
                        <div class="u-avatar">
                            <img class="rounded-circle mr-3" style="height: 45px; width: 45px;"
                                src="/storage/vendor/dish/{{$order['image'][$title_key]}}" alt="Image Description">
                        </div>
                        <div class="media-body">
                            <div class="text-left">
                                <small style="">{{$title}}
                                    ({{$qty['title']}} <strong>Litres</strong>)</small>
                                <p class="mb-0 mt-0" style="font-size:15px;">
                                    <span class="text-danger pr-2 border-right">
                                        ₦{{$qty['price']}}
                                    </span>
                                    <span class="text-dark pl-2">
                                        <strong>Qty: </strong>{{$detail[2]}}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @php
            $i++;
            @endphp
            @endforeach

            @endif
            @endforeach

        </div>
    </div>
</div>
<div class="border-top pl-2 pr-2 pb-2 pt-1">
    <div class="row">
        <div class="col-md-6 btn-group btn-group-sm mt-1">
            @if($order->order_status['status'] == "Pending")
            <button type="button" class="btn btn-secondary verdict-btn" style="font-size: 15px;"
                onclick="acceptOrder('{{$order->order_id}}')"><i class="las la-check"></i>&nbsp;Accept</button>
            <button type="button" class="btn btn-danger verdict-btn ml-xs-5" style="font-size: 15px;"
                onclick="rejectOrder('{{$order->order_id}}')"><i class="las la-times"></i>&nbsp;Reject</button>
            @endif
        </div>
        <div class="col-md-6 mt-1">
            <button type="button" style="font-size: 15px;" onclick="showContact(this)"
                class="btn btn-block btn-success"><i class="las la-phone-volume"></i>&nbsp;Show
                Contact</button>
            <a type="button" href="tel:{{$order->phone}}" style="font-size: 15px; margin-top: 0px;" id="contact-btn"
                class="btn btn-success btn-block d-none">{{$order->phone}}</a>
        </div>
    </div>
</div>
