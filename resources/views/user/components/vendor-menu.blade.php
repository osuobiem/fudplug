@if(empty($menu_dishes) && $curr_page == 1)
<div class="bg-light text-center col-md-12" style="height:inherit; padding-top: 7rem;">
    <i class="las la-info" style="font-size:xx-large;"></i><br>
    <small>Empty Content</small>
</div>
@elseif(empty($menu_dishes) && $curr_page > 1)

@else
@foreach($menu_dishes as $menu_dish)
<div class="col-md-6 mb-2">
    <div class="card card-body" style="background-image: url('{{Storage::url('vendor/dish/'.$menu_dish->image)}}'); background-position: center;background-size: cover;
background-repeat: no-repeat;">

        <div class="p-3" style="width:100%; background-color: rgba(0,0,0,0.7)">
            <h6 class="text-truncate text-white font-weight-bold">{{$menu_dish->title}}</h6>
            <div class="d-flex align-items-center border-top border-danger red-top text-center" id="menu-item-data">
                @if($menu_dish->type == "simple")
                <a class="small" onclick="loadRegOrderModal('{{$menu_dish->id}}')"><i
                        class="las la-plus-circle"></i>Regular
                    Order</a>
                @else
                @php
                $bulk_qty = json_decode($menu_dish->quantity, true)['bulk'];
                $regular_qty = json_decode($menu_dish->quantity, true)['regular'];
                @endphp
                @if($bulk_qty == null)
                <a class="small" onclick="loadRegOrderModal('{{$menu_dish->id}}')"><i
                        class="las la-plus-circle"></i>Regular
                    Order</a>
                @elseif($regular_qty == null)
                <div class="pr-3 mr-3 small">
                    <a class="" onclick="loadBulkOrderModal('{{$menu_dish->id}}')"><i
                            class="las la-plus-circle"></i>Bulk
                        Order</a>
                </div>
                @else
                <div class="border-right red-right pr-3 mr-3 small">
                    <a class="" onclick="loadBulkOrderModal('{{$menu_dish->id}}')"><i
                            class="las la-plus-circle"></i>Bulk
                        Order</a>
                </div>
                <a class="small" onclick="loadRegOrderModal('{{$menu_dish->id}}')"><i
                        class="las la-plus-circle"></i>Regular
                    Order</a>
                @endif
                @endif
            </div>
        </div>

    </div>
</div>
@endforeach
@endif
