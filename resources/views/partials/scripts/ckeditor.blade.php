<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>
@isset($ckeditor)
<script>
    ClassicEditor
    .create(document.querySelector('#editor'),{
        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
    })
    .catch(error => {
        console.error( error );
    });
</script>
@endisset
