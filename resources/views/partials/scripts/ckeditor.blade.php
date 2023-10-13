<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js" data-navigate-once></script>
@isset($ckeditor)
<script data-navigate-track>
    ClassicEditor
    .create(document.querySelector('#editor'),{
        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
    })
    .catch(error => {
        console.error( error );
    });
</script>
@endisset
