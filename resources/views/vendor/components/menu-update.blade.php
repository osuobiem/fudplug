<div class="modal fade" id="menu-update-modal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-1 modal-md" style="height: 500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-menu-update">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Info alert box -->
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading mb-0"><i class="las la-info"></i> Notice!</h4>
                    <p class="mt-0">Please select a dish by checking the boxes next to the dish. You can add as many
                        dishes as
                        possible to your menu list. Note that any dish you select here will reflect on your menu for
                        the day.</p>
                    <hr style="margin-top: -13px;
                    margin-bottom: -13px;">
                    <p class="mb-0">Once you have selected your dishes, click on the 'Update' button to
                        update your menu.
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="box shadow-lg border rounded bg-white mb-3">
                    @if(!empty($dishes))
                    <div class="box-title border-bottom bg-white p-3 mb-0">
                        <div class="row">
                            <div class="col-12 p-2">
                                <div class="float-left">
                                    <h6 class="m-0">Dishes</h6>
                                </div>
                                <div class="form-check float-right">
                                    <input class="form-check-input" type="checkbox" onchange="checkAll(this)"
                                        id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Select all
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body p-1">
                        <form id="update-menu">
                            @csrf

                            <ul class="list-group generic-scrollbar" style="height: 300px; overflow-y: scroll;">
                                @foreach($dishes as $dish)
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center osahan-post-header people-list">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle"
                                                src="{{Storage::url('vendor/dish/'.$dish->image)}}" alt="">

                                        </div>
                                        <div class="font-weight-bold mr-2">
                                            <div class="text-truncate"><a href="http://">
                                                    {{$dish->title}}
                                                </a></div>
                                        </div>
                                        <div class="ml-auto">
                                            @if(!empty($menu_items))
                                            @if(in_array((string) $dish->id, $menu_items))
                                            <input class="" name="item[]" type="checkbox" onchange="state(this)"
                                                value="{{$dish->id}}" id="defaultCheck{{$dish->id}}" checked>
                                            <label class="form-check-label" for="defaultCheck{{$dish->id}}">
                                                Remove
                                            </label>
                                            @else
                                            <input class="" name="item[]" type="checkbox" onchange="state(this)"
                                                value="{{$dish->id}}" id="defaultCheck{{$dish->id}}">
                                            <label class="form-check-label" for="defaultCheck{{$dish->id}}">
                                                Select
                                            </label>
                                            @endif
                                            @else
                                            <input class="" name="item[]" type="checkbox" onchange="state(this)"
                                                value="{{$dish->id}}" id="defaultCheck{{$dish->id}}">
                                            <label class="form-check-label" for="defaultCheck{{$dish->id}}">
                                                Select
                                            </label>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                    <div class="form-group text-center col-sm-12 m-0">
                        <button id="menu-update-btn" class="btn btn-primary px-5">
                            <span id="vendor-txt">Update</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner"
                                style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                    @else
                    <div class="bg-light text-center py-3">
                        <i class="las la-info" style="font-size:xx-large;"></i><br>
                        <small>You have not added dishes yet.</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Check form validity and fire submit event
        let menuForm = document.getElementById('update-menu');
        document.getElementById('menu-update-btn').onclick = function () {
            if (menuForm.reportValidity()) {
                $('#update-menu').trigger('submit')
            }
        }

        // Attach menu-update form event listener
        $('#update-menu').submit(el => {
            el.preventDefault()
            updateMenu(el)
        });
    });

    // Update Menu
    function updateMenu(el) {
        el.preventDefault()

        spin('vendor')
        //offError('v-dish-error')

        let url = `{{ url('vendor/update-menu') }}`;
        let data = new FormData(el.target)

        goPost(url, data)
            .then(res => {
                spin('vendor')

                if (handleFormRes(res, false, false, 'modal-body')) {
                    showAlert(true, res.message);

                    // Reload the Right Bar on Completion
                    loadRight('1');
                }
            })
            .catch(err => {
                spin('vendor')
                handleFormRes(err, 'v-dish-error');
            })
    }

    // Set State of Checkboxes (select or remove)
    function state(el) {
        let isChecked = $(el).prop("checked");
        if (isChecked) {
            $(el).next().html("Remove");
        } else {
            $(el).next().html("Select");
        }
    }

    // Check all Checkboxes
    function checkAll(el) {
        let isChecked = $(el).prop("checked");
        if (isChecked) {
            $('#update-menu').trigger('reset');
            $(el).parent().parent().parent().parent().next().find('input').attr('checked', '');
            $(el).parent().parent().parent().parent().next().find('label').html("Remove");
        } else {
            $('#update-menu').trigger('reset');
            $(el).parent().parent().parent().parent().next().find('input').removeAttr('checked');
            $(el).parent().parent().parent().parent().next().find('label').html("Select");
        }
    }

</script>
