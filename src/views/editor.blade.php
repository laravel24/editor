<link rel="stylesheet" href="/packages/vinelab/laravel-editor/css/bootstrap-markdown.min.css">

<textarea name="vinelab-editor-text" id="vinelab-editor-textarea" rows="10"></textarea>

<script type="text/javascript" src="/packages/vinelab/laravel-editor/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/packages/vinelab/laravel-editor/js/markdown.min.js"></script>
<script type="text/javascript">
$(function(){

    $("#vinelab-editor-textarea").markdown({
        savable:false,
        autofocus:false,
        iconLibrary: 'fa',
        hiddenButtons: ['cmdCode', 'cmdList', 'cmdListO', 'cmdHeading', 'cmdQuote'],
        additionalButtons: [
        [{
            name: "groupCustom",
            data: [{
                toggle: false,
                name: "cmdUploadPhoto",
                title: "Upload Photo",
                icon: "glyphicon glyphicon-camera",
                callback: function(e){
                    // globalize the event to grant access to the editor
                    window.lePhotoUploadEvent = e;
                    // if the editor is in fullscreen we need to close it
                    $('a.exit-fullscreen').first().click();
                    // now we show the modal so that they choose a photo
                    $("#laravel-editor-uploads-modal").modal('show');
                }
            }]
        }]
      ]
    });

    window.leUploader = $('#laravel-editor-upload-more').mrUploader({uploadUrl: '/upload'});
    window.leUploader.on('upload', function(event, data) {
        image = $('<img />')
            .attr('src', data.$image.attr('src'))
            .css({
                margin: '0 auto',
                width: '200px',
                padding: '5px',
                cursor: 'pointer'
            }).click(function (event) {
                var chunk, cursor;
                var selected = window.lePhotoUploadEvent.getSelection(), content = window.lePhotoUploadEvent.getContent();

                var url = data.response.url;
                var chunk = '![enter image description here]('+url+' "enter image title here")';
                var cursor = selected.start;

                window.lePhotoUploadEvent.replaceSelection(chunk);
                window.lePhotoUploadEvent.setSelection(cursor+2, 30);

                $("#laravel-editor-uploads-modal").modal('hide');
            });

        $('#laravel-editor-uploads-container').prepend(image);
    });

});
</script>

<div id="laravel-editor-uploads-modal" class="modal fade laravel-editor-uploads-modal" role="dialog" aria-hidden="true" aria-labelledby="editorUploads">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Choose Photo</h4>
            </div>

            <div class="modal-body">
                <div id="laravel-editor-uploads-container" style="max-height: 300px; overflow: scroll;"></div>
            </div>

            <div class="modal-footer">
                <button class="btn" id="laravel-editor-upload-more">Upload More</button>
            </div>

        </div>
    </div>
</div>
