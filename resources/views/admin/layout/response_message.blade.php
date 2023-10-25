@if (session()->has('success'))
<script type="text/javascript">
  function massge() {
    let message = "{{ session()->get('success') }}";
    Swal.fire({
            icon: 'success',
            title: message,
            showConfirmButton: true,
        })
  }

  window.onload = massge;
</script>
@endif

@if (session()->has('error'))
<script type="text/javascript">
  function massge() {
    let message = "{{ session()->get('error') }}";
    Swal.fire({
            icon: 'error',
            title: message,
            showConfirmButton: true,
        })
  }

  window.onload = massge;
</script>
@endif