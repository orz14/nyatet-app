<script src="https://code.jquery.com/jquery-3.6.0.min.js" data-navigate-once></script>

@include('partials.scripts.alpine-init')

@include('partials.scripts.modal')

@include('partials.scripts.stone')

@include('partials.scripts.ckeditor')

<script data-navigate-track>
    // Go Up and Down
    jQuery(document).ready(function() {
        var o = 1,
            r = 600;
        jQuery(window).scroll(function() {
            jQuery(this).scrollTop() > o ? jQuery(".scrollToTop").fadeIn(r) : jQuery(".scrollToTop")
                .fadeOut(r)
        })
    });
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location
                .hostname == this.hostname) {
                var t = $(this.hash);
                if (t = t.length ? t : $("[name=" + this.hash.slice(1) + "]"), t.length) return $(
                    "html,body").animate({
                    scrollTop: t.offset().top
                }, 50), !1
            }
        })
    });
</script>
