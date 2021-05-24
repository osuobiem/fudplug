@foreach($menu_dishes as $menu_dish)
<div class="d-flex align-items-center osahan-post-header mb-3 people-list">
    <div class="dropdown-list-image mr-2">
        <img class="rounded-circle" src="{{Storage::url('vendor/dish/'.$menu_dish->image)}}" alt="">

    </div>
    <div class="font-weight-bold text-truncate mr-1 text-left" style="width: 64%;">
        {{$menu_dish->title}}
    </div>
    <span title="add to today's menu" class="ml-auto">
        <button type="button" class="btn btn-outline-danger border-0 btn-sm text-nowrap"
            onclick="viewDish('{{$menu_dish->id}}')"><i class="feather-eye"></i>
            <i class="las la-eye la-2x"></i></button>
        <!-- <div class="custom-control custom-switch pull-left">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1"></label>
                        </div> -->
    </span>
</div>
@endforeach
