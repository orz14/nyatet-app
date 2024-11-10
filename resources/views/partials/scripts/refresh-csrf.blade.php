<script data-navigate-track>
    function refreshCsrfToken() {
        fetch("{{ route('refresh-csrf') }}")
            .then(response => response.json())
            .then(data => {
                $("meta[name='csrf-token']").attr("content", data.csrf_token);
                $("input[name='_token']").val(data.csrf_token);
            });
    }

    setInterval(refreshCsrfToken, 6000000);
</script>
