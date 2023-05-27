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
