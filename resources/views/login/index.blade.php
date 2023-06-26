<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function(){
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    @if(Session::has('gagal-login'))
    Toast.fire({
            icon: 'error',
            title: '{{ Session::get('gagal-login') }}'
        })
    @endif
});
</script>