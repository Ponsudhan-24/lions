<div class=" justify-content-center">
    @if(session('success'))
        <div class="alert alert-success text-center position-fixed top-0 start-50 translate-middle-x" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center position-fixed top-0 start-50 translate-middle-x" id="errorMessage">
            {{ session('error') }}
        </div>
    @endif
</div>

<script>
   // Hide messages after 3 seconds
   setTimeout(function() {
       let successMessage = document.getElementById('successMessage');
       if (successMessage) {
           successMessage.style.transition = "opacity 0.5s ease";
           successMessage.style.opacity = 0;
           setTimeout(() => successMessage.remove(), 800);
       }

       let errorMessage = document.getElementById('errorMessage');
       if (errorMessage) {
           errorMessage.style.transition = "opacity 0.5s ease";
           errorMessage.style.opacity = 0;
           setTimeout(() => errorMessage.remove(), 800);
       }
   }, 3000);
</script>
