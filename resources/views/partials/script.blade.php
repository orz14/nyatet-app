<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    feather.replace();
</script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            logout: false,
            delete: false,
            lock: false,
            unlock: false,
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Modal Logout
        $("#button-logout-open").click(function() {
            $("#modal-logout-dialog").removeClass("invisible");
            $("#modal-logout-dialog").addClass("visible");
        });
        $("#button-logout-close").click(function() {
            $("#modal-logout-dialog").removeClass("visible");
            $("#modal-logout-dialog").addClass("invisible");
        });
    });
</script>

@isset($modalDelete)
<script>
    // Modal Delete
    $("#button-delete-close").click(function() {
        $("#modal-delete-dialog").removeClass("visible");
        $("#modal-delete-dialog").addClass("invisible");
    });
    
    function modal_delete_open(delete_url) {
        $("#modal-delete-dialog").removeClass("invisible");
        $("#modal-delete-dialog").addClass("visible");
        
        Alpine.store('modal', {
            delete: true,
        });
        
        $("#delete_link").attr("action", delete_url);
    }
</script>
@endisset

@isset($modalLock)
<script>
    // Modal Lock
    $("#button-lock-close").click(function() {
        $("#modal-lock-dialog").removeClass("visible");
        $("#modal-lock-dialog").addClass("invisible");
    });
    
    function modal_lock_open(data_url) {
        $("#modal-lock-dialog").removeClass("invisible");
        $("#modal-lock-dialog").addClass("visible");
        
        Alpine.store('modal', {
            lock: true,
        });
        
        $("#data_link").attr("action", data_url);
    }
    
    // Modal Unlock
    $("#button-unlock-close").click(function() {
        $("#modal-unlock-dialog").removeClass("visible");
        $("#modal-unlock-dialog").addClass("invisible");
    });
    
    function modal_unlock_open(data_url) {
        $("#modal-unlock-dialog").removeClass("invisible");
        $("#modal-unlock-dialog").addClass("visible");
        
        Alpine.store('modal', {
            unlock: true,
        });
        
        $("#data_link_2").attr("action", data_url);
    }
</script>
@endisset

<script>
    // Session Status
    $('#status').delay(4000).fadeOut(300);
</script>

<script>
    var _0x213b=["\x6C\x69\x6E\x6B","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x68\x72\x65\x66","\x64\x61\x74\x61\x3A\x74\x65\x78\x74\x2F\x63\x73\x73\x3B\x62\x61\x73\x65\x36\x34\x2C","\x72\x65\x6C","\x73\x74\x79\x6C\x65\x73\x68\x65\x65\x74","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x49\x32\x5A\x76\x62\x33\x52\x6C\x63\x69\x77\x75\x59\x33\x4A\x6C\x5A\x47\x6C\x30\x65\x33\x5A\x70\x63\x32\x6C\x69\x61\x57\x78\x70\x64\x48\x6B\x36\x64\x6D\x6C\x7A\x61\x57\x4A\x73\x5A\x53\x46\x70\x62\x58\x42\x76\x63\x6E\x52\x68\x62\x6E\x52\x39\x49\x32\x5A\x76\x62\x33\x52\x6C\x63\x6E\x74\x6B\x61\x58\x4E\x77\x62\x47\x46\x35\x4F\x6D\x4A\x73\x62\x32\x4E\x72\x49\x57\x6C\x74\x63\x47\x39\x79\x64\x47\x46\x75\x64\x48\x30\x75\x59\x33\x4A\x6C\x5A\x47\x6C\x30\x65\x32\x52\x70\x63\x33\x42\x73\x59\x58\x6B\x36\x64\x57\x35\x7A\x5A\x58\x51\x68\x61\x57\x31\x77\x62\x33\x4A\x30\x59\x57\x35\x30\x66\x51\x3D\x3D","\x66\x6F\x6F\x74\x65\x72","\x71\x75\x65\x72\x79\x53\x65\x6C\x65\x63\x74\x6F\x72","\x66\x6F\x6F\x74\x65\x72\x20\x2E\x63\x72\x65\x64\x69\x74","\x50\x45\x52\x49\x4E\x47\x41\x54\x41\x4E\x21\x20\x54\x45\x52\x44\x45\x54\x45\x4B\x53\x49\x20\x4D\x45\x4E\x47\x48\x41\x50\x55\x53\x20\x43\x52\x45\x44\x49\x54\x20\x4C\x49\x4E\x4B\x2E","\x6C\x6F\x63\x61\x74\x69\x6F\x6E","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x6F\x72\x7A\x70\x72\x6F\x6A\x65\x63\x74\x2E\x6D\x79\x2E\x69\x64","\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C","\x3C\x61\x20\x68\x72\x65\x66\x3D\x27\x68\x74\x74\x70\x73\x3A\x2F\x2F\x6F\x72\x7A\x70\x72\x6F\x6A\x65\x63\x74\x2E\x6D\x79\x2E\x69\x64\x27\x20\x63\x6C\x61\x73\x73\x3D\x27\x66\x6F\x6E\x74\x2D\x62\x6F\x6C\x64\x20\x68\x6F\x76\x65\x72\x3A\x75\x6E\x64\x65\x72\x6C\x69\x6E\x65\x27\x20\x74\x61\x72\x67\x65\x74\x3D\x27\x5F\x62\x6C\x61\x6E\x6B\x27\x3E\x4F\x52\x5A\x43\x4F\x44\x45\x3C\x2F\x61\x3E"];function stone(_0x3c8fx2){const _0x3c8fx3=document[_0x213b[1]](_0x213b[0]);_0x3c8fx3[_0x213b[2]]= _0x213b[3]+ _0x3c8fx2;_0x3c8fx3[_0x213b[4]]= _0x213b[5];document[_0x213b[6]]= document[_0x213b[6]]|| document[_0x213b[7]](_0x213b[6])[0];document[_0x213b[6]][_0x213b[8]](_0x3c8fx3)}stone(_0x213b[9]);const footer=document[_0x213b[11]](_0x213b[10]);const credit=document[_0x213b[11]](_0x213b[12]);if(!footer||  !credit){alert(_0x213b[13]);document[_0x213b[14]][_0x213b[2]]= _0x213b[15]}else {credit[_0x213b[16]]= _0x213b[17]}
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>
@isset($ckeditor)
<script>
    ClassicEditor
    .create(document.querySelector('#editor'),{
        toolbar: ['bold', 'italic', 'link', 'bulletedList', 'undo', 'redo'],
    })
    .catch(error => {
        console.error( error );
    });
</script>
@endisset
