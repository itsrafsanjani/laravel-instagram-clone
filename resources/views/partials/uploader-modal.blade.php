<div class="modal fade" id="uploaderModal" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content h-100">
            <div class="modal-header pb-0">
                <div>
                    <ul class="nav nav-tabs border-0">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-medium text-dark" data-toggle="tab"
                               href="#select-file">{{ __('Select File') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-medium text-dark" data-toggle="tab"
                               href="#upload-new">{{ __('Upload New') }}</a>
                        </li>
                    </ul>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content h-100">
                    <div class="tab-pane active h-100" id="select-file">
                        <div class="uploader-filter pt-1 pb-3 border-bottom mb-4">
                            <div class="row align-items-center gutters-5 gutters-md-10 position-relative">
                                <div class="col-xl-2 col-md-3 col-5">
                                    <div class="">
                                        <!-- Input -->
                                        <select class="form-control form-control-xs selectpicker"
                                                name="uploader-sort">
                                            <option value="newest" selected>{{ __('Sort by newest') }}</option>
                                            <option value="oldest">{{ __('Sort by oldest') }}</option>
                                            <option value="smallest">{{ __('Sort by smallest') }}</option>
                                            <option value="largest">{{ __('Sort by largest') }}</option>
                                        </select>
                                        <!-- End Input -->
                                    </div>
                                </div>
                                <div class="col-md-3 col-5">
                                    <div class="custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input" name="show-selected"
                                               id="show-selected">
                                        <label class="custom-control-label" for="show-selected">
                                            {{ __('Selected Only') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xl-3 ml-auto mr-0 col-2 position-static">
                                    <div class="uploader-search text-right">
                                        <input type="text" class="form-control form-control-xs"
                                               name="uploader-search" placeholder="{{ __('Search your files') }}">
                                        <i class="search-icon d-md-none"><span></span></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uploader-all clearfix c-scrollbar-light">
                            <div class="align-items-center d-flex h-100 justify-content-center w-100">
                                <div class="text-center" id="medias"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane h-100" id="upload-new">
                        <div class="dropzone" id="uploadFiles"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="flex-grow-1 overflow-hidden d-flex">
                    <div class="">
                        <div class="uploader-selected">{{ __('0 File selected') }}</div>
                        <button type="button"
                                class="btn-link btn btn-sm p-0 uploader-selected-clear">{{ __('Clear') }}</button>
                    </div>
                    <div class="mb-0 ml-3">
                        <button type="button" class="btn btn-sm btn-primary"
                                id="uploader_prev_btn">{{ __('Prev') }}</button>
                        <button type="button" class="btn btn-sm btn-primary"
                                id="uploader_next_btn">{{ __('Next') }}</button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary"
                        data-toggle="uploaderAddSelected">{{ __('Add Files') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        let dropzone = new Dropzone("#uploadFiles", {
            url: "/uploader",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        dropzone.on("addedfile", file => {
            console.log(`File added: ${file.name}`);
        });

        // get all files when this modal is opened
        $('#uploaderModal').on('shown.bs.modal', function (e) {
            let ids = $(e.relatedTarget).data('ids')
            $.ajax({
                url: '/uploader?ids=' + ids,
                type: 'GET',
                success: function (data) {
                    $('#medias').html(data);
                }
            });
        });
    </script>
@endpush
