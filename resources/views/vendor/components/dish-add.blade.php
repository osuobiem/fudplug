<div class="modal fade" id="dish-add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog mt-1 modal-lg" style="height: 500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Dish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-sign">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="js-validate" method="POST" id="" novalidate="false">
                    <!-- Form Success -->
                    <div class="alert alert-success d-none text-center animate__animated animate__headShake"
                        id="v-update-error" role="alert">
                    </div>

                    <!-- Form Error -->
                    <div class="alert alert-danger d-none text-center animate__animated animate__headShake"
                        id="v-update-error" role="alert">
                    </div>

                    <div id="myRepeatingFields">
                        <div class="input-group row border rounded pt-2 mt-2">
                            <div class="col-sm-6 mb-2">
                                <input class="form-control" name="item[]" type="text" placeholder="Name of dish" />
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>

                            <div class="col-sm-6 border text-center">
                                <label class="text-center"> Regular Quantity </label>
                                <div id="repeatingQuantityFields-1" class="">
                                    <div class="qty-entry-1 mb-2 form-inline">
                                        <input class="form-control rounded-right-0 col-sm-4" name="fields[]" type="text"
                                            placeholder="Title" />
                                        <input class="form-control col-sm-3 rounded-0" name="fields[]" type="number"
                                            placeholder="Price" />
                                        <input class="form-control rounded-left-0 col-sm-3" name="fields[]"
                                            type="number" placeholder="Quantity Available" />
                                        <div class="col-sm-2">
                                            <button type="button" onclick="toggleRegularFields('1', this)"
                                                class="btn btn-success btn-sm qty-btn-add-1">
                                                <span class="las la-plus" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 border text-center">
                                <label class="text-center"> Bulk Quantity </label>
                                <div id="repeatingBulkFields-1">
                                    <div class="bulk-entry-1 mb-2 form-inline">
                                        <input class="form-control col-sm-5 rounded-right-0" name="fields[]" type="text"
                                            placeholder="Title" />
                                        <input class="form-control col-sm-5 rounded-left-0" name="fields[]" type="text"
                                            placeholder="Price" />
                                        <div class="col-sm-2">
                                            <button type="button" onclick="toggleBulkFields('1', this)"
                                                class="btn btn-success btn-sm bulk-btn-add-1">
                                                <span class="las la-plus" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                        <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                        placeholder="Quantity Available" /> -->
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-btn col-sm-12 my-2">
                                <button type="button" onclick="toggleMain(this)"
                                    class="btn btn-success btn-lg btn-add first">
                                    <span class="las la-plus" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center col-sm-12 mt-3">
                        <button class="btn btn-primary px-5" type="submit">
                            <span id="vendor-txt">Add</span>
                            <div class="spinner-border spinner-border-sm btn-pr" id="vendor-spinner"
                                style="display: none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Original entry to be fetched from -->
                <div class="d-none">
                    <div id="original-entry">
                        <div class="input-group og-{j} row border rounded pt-2 mt-2">
                            <div class="col-sm-6 mb-2">
                                <input class="form-control" name="item[]" type="text" placeholder="Name of dish" />
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>

                            <div class="col-sm-6 border text-center">
                                <label class="text-center"> Regular Quantity </label>
                                <div id="repeatingQuantityFields-{j}" class="">
                                    <div class="qty-entry-{j} mb-2 form-inline">
                                        <input class="form-control rounded-right-0 col-sm-4" name="fields[]" type="text"
                                            placeholder="Title" />
                                        <input class="form-control col-sm-3 rounded-0" name="fields[]" type="number"
                                            placeholder="Price" />
                                        <input class="form-control rounded-left-0 col-sm-3" name="fields[]"
                                            type="number" placeholder="Quantity Available" />
                                        <div class="col-sm-2">
                                            <button type="button" onclick="toggleRegularFields('{j}', this)"
                                                class="btn btn-success btn-sm qty-btn-add-{j}">
                                                <span class="las la-plus" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 border text-center">
                                <label class="text-center"> Bulk Quantity </label>
                                <div id="repeatingBulkFields-{j}">
                                    <div class="bulk-entry-{j} mb-2 form-inline">
                                        <input class="form-control col-sm-5 rounded-right-0" name="fields[]" type="text"
                                            placeholder="Title" />
                                        <input class="form-control col-sm-5 rounded-left-0" name="fields[]" type="text"
                                            placeholder="Price" />
                                        <div class="col-sm-2">
                                            <button type="button" onclick="toggleBulkFields('{j}', this)"
                                                class="btn btn-success btn-sm bulk-btn-add-{j}">
                                                <span class="las la-plus" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                        <!-- <input class="form-control col-sm-4" name="fields[]" type="text"
                                        placeholder="Quantity Available" /> -->
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-btn col-sm-12 my-2">
                                <button type="button" onclick="toggleMain(this)" class="btn btn-success btn-lg btn-add">
                                    <span class="las la-plus" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Original entry to be fetched from -->
            </div>
        </div>
    </div>
</div>

<span class="d-none" data-toggle="modal" href="#loginModal" id="login-pop"></span>

<script>
    // Block to handle main form repeaters
    let index = 1;

    function toggleMain(element) {
        if ($(element).hasClass('btn-add')) {
            //e.preventDefault();
            index++;

            var controlForm = $('#myRepeatingFields:first'),
                currentEntry = $("#original-entry"),
                newEntry = currentEntry.clone().html().replace(/{j}/g, index);
            newEntry = controlForm.append(newEntry);
            console.log(newEntry);

            $(".og-" + index).find('input').val('');
            $(".og-" + index).addClass('entry');
            $(element).removeClass('btn-add').addClass('btn-remove').removeClass(
                'btn-success').addClass('btn-danger').html(`<i class="las la-minus"></i>`);
            //$('.btn-remove').html(`<i class="las la-minus"></i>`);

        } else {
            //e.preventDefault();
            if ($(element).hasClass('first')) {
                $(element).parents('.input-group:first').next('div').remove();
                $(element).removeClass('btn-remove').addClass('btn-add').removeClass(
                    'btn-danger').addClass('btn-success').html(`<i class="las la-plus"></i>`);
            } else {
                $(element).parents('.entry').remove();
                return false;
            }
        }
    }
    // Block to handle main form repeaters


    // Functions to handle Regular Quantity form repeaters
    function toggleRegularFields(id, element) {
        if ($(element).hasClass('qty-btn-add-' + id)) {
            var controlForm = $(`#repeatingQuantityFields-${id}:first`),
                currentEntry = $(`.qty-btn-add-${id}`).parents(`.qty-entry-${id}:first`),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input').val('');
            controlForm.find(`.qty-entry-${id}:not(:last) .qty-btn-add-${id}`)
                .removeClass(`qty-btn-add-${id}`).addClass(`qty-btn-remove-${id}`)
                .removeClass('btn-success').addClass('btn-danger')
                .html('');
            $(`.qty-btn-remove-${id}`).html(`<i class="las la-minus"></i>`);
        } else {
            $(element).parents(`.qty-entry-${id}:first`).remove();
            return false;
        }
    }
    // Functions to handle Regular Quantity form repeaters


    // Function to handle Bulk Quantity form repeaters
    function toggleBulkFields(id, element) {
        if ($(element).hasClass('bulk-btn-add-' + id)) {
            //e.preventDefault();
            var controlForm = $(`#repeatingBulkFields-${id}:first`),
                currentEntry = $(element).parents(`.bulk-entry-${id}:first`),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input').val('');
            controlForm.find(`.bulk-entry-${id}:not(:last) .bulk-btn-add-${id}`)
                .removeClass(`bulk-btn-add-${id}`).addClass(`bulk-btn-remove-${id}`)
                .removeClass('btn-success').addClass('btn-danger')
                .html('');
            $(`.bulk-btn-remove-${id}`).html(`<i class="las la-minus"></i>`);
        } else {
            //e.preventDefault();
            $(element).parents(`.bulk-entry-${id}:first`).remove();
            return false;
        }
    }
    // Function to handle Bulk Quantity form repeaters

</script>
