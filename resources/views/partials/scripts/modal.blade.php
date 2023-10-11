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
        event.preventDefault();

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
        event.preventDefault();
        
        $("#modal-unlock-dialog").removeClass("invisible");
        $("#modal-unlock-dialog").addClass("visible");
        
        Alpine.store('modal', {
            unlock: true,
        });
        
        $("#data_link_2").attr("action", data_url);
    }
</script>
@endisset
