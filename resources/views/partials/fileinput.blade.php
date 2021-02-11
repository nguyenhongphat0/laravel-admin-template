<div class="form-group @if($errors->has($model)) is-invalid @endif">
    <div class="kv-avatar">
        <div class="file-loading">
            <input id="{{ $model }}_file" name="fileUpload" type="file" {{ isset($multiple) && $multiple ? 'multiple' : '' }} data-error-id="2" data-valid="true" data-value="{{ $value ?? '' }}">
        </div>
    </div>
    <input type="hidden" id="{{ $model }}" name="{{ $model }}" value="{{ $value ?? null }}">
    <div id="kv-avatar-errors-2" class="center-block" style="display:none"></div>
    {!! $errors->first($model, '<div class="help-block error text-left">:message</div>') !!}
</div>


@php global $fileupload_assets_pushed @endphp
@if(!$fileupload_assets_pushed)
@php $fileupload_assets_pushed = true @endphp
@section('js')
@parent
<script>
    UPLOAD_URL = '{{ route('admin::file.upload') }}';
    DELETE_URL = '{{ route('admin::file.delete') }}';
    BLOB_URL = '{{ route('admin::file.blob') }}';
    CSRF_TOKEN = '{{ csrf_token() }}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        }
    });
    initFileUpload = function(selector, payload) {
        $(`${selector}_file`).fileinput({
            theme: "fas",
            overwriteInitial: !payload.multiple,
            browseOnZoneClick: true,
            autoReplace: true,
            maxFileSize: 2048,
            maxFileCount: 100,
            uploadUrl: UPLOAD_URL,
            deleteUrl: DELETE_URL,
            browseLabel: 'Browse',
            uploadClass: 'btn btn-success',
            browseClass: 'btn btn-default',
            uploadExtraData: payload,
            fileActionSettings: {
                showRemove: false,
            },
            showClose: false,
            showRemove: true,
            initialPreview: generatePreview(selector),
            initialPreviewConfig: generatePreviewConfig(selector),
        }).on('fileuploaded', function(event, data, index, fileId) {
            if (data.response.status == 200) {
                if (payload.multiple) {
                    $(selector).val([$(selector).val(), data.response.fileName].filter(e => e.length).join('/'));
                } else {
                    $(selector).val(data.response.fileName);
                }
            }
        }).on('filedeleted', function(event, key, jqXHR, data) {
            let value = $(selector).val().split('/');
            value = value.filter(file => file != key);
            $(selector).val(value.join('/'));
        });
    }

    function generatePreview(selector) {
        if ($(selector).val()) {
            const filename = $(selector).val();
            const files = filename.split('/');
            const previews = files.map(file => {
                const url = BLOB_URL + '/' + file;
                const type = getType(file);
                if (type == 'pdf') {
                    return `<div class="ng-scope pdfobject-container mt-4">
                    <iframe id="pdf_preview" src="${url}" type="application/pdf" width="100%" height="100%" style="overflow: auto;">
                    </iframe>
                </div>`;
                } else if (type == 'image') {
                    return `<img key="${file}" data-key="${file}" class="file-preview-image kv-preview-data file-image-preview mt-4" id="image_preview" src="${url}">`;
                } else {
                    return `<a href="${url}" class="file-preview-other">
                    <div class="file-footer-caption pt-4">
                        <span class="file-other-icon"><i class="fas fa-file text-dark"></i></span>
                        <span class="file-caption-info text-dark" id="file_preview">${file.replace(/_\d+\./, '.')}</span>
                        <span class="btn btn-light"><i class="fas fa-download"></i></span>
                    </div>
                </a>`;
                }
            });
            return previews;
        }
    }

    function generatePreviewConfig(selector) {
        if ($(selector).val()) {
            const filename = $(selector).val();
            const files = filename.split('/');
            return files.map(file => ({
                key: file,
                showRemove: true,
            }));
        }
    }

    function getType(filename) {
        var ext = filename.substr(filename.lastIndexOf('.') + 1).toLowerCase();;
        var type;
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'png':
                type = 'image'
                break;
            case 'pdf':
                type = 'pdf';
                break;
            default:
                type = 'file';
                break;
        }
        return type;
    }
</script>
@stop
@endif

@section('js')
@parent
<script>
    $( document ).ready(function() {
        initFileUpload('#{{ $model }}', { multiple: {{ isset($multiple) && $multiple ? 'true' : 'false' }} });
    });
</script>
@stop