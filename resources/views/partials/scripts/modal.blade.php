<script data-navigate-track>
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
<script data-navigate-track>
    // Modal Delete
    $("#button-delete-close").click(function() {
        $("#modal-delete-dialog").removeClass("visible");
        $("#modal-delete-dialog").addClass("invisible");
    });
    
    function modal_delete_open(param) {
        $("#modal-delete-dialog").removeClass("invisible");
        $("#modal-delete-dialog").addClass("visible");
        
        Alpine.store('modal', {
            delete: true,
        });
        
        $("#delete_link").attr("wire:submit", param);
    }
</script>
@endisset

@isset($modalDeleteAccount)
<script data-navigate-track>
    // Modal Delete Account
    $("#button-delete-close").click(function() {
        $("#modal-delete-acc-dialog").removeClass("visible");
        $("#modal-delete-acc-dialog").addClass("invisible");
    });
    
    function modal_delete_acc_open() {
        $("#modal-delete-acc-dialog").removeClass("invisible");
        $("#modal-delete-acc-dialog").addClass("visible");
        
        Alpine.store('modal', {
            delaccount: true,
        });
    }
</script>
@endisset

@isset($modalLock)
<script data-navigate-track>
    // Modal Lock
    $("#button-lock-close").click(function() {
        $("#modal-lock-dialog").removeClass("visible");
        $("#modal-lock-dialog").addClass("invisible");
    });
    
    function modal_lock_open(param) {
        $("#modal-lock-dialog").removeClass("invisible");
        $("#modal-lock-dialog").addClass("visible");
        
        Alpine.store('modal', {
            lock: true,
        });
        
        $("#data_link").attr("wire:submit", param);
    }
    
    // Modal Unlock
    $("#button-unlock-close").click(function() {
        $("#modal-unlock-dialog").removeClass("visible");
        $("#modal-unlock-dialog").addClass("invisible");
    });
    
    function modal_unlock_open(param) {        
        $("#modal-unlock-dialog").removeClass("invisible");
        $("#modal-unlock-dialog").addClass("visible");
        
        Alpine.store('modal', {
            unlock: true,
        });
        
        $("#data_link_2").attr("wire:submit", param);
    }
</script>
@endisset
