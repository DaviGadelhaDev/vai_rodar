@if (session('success'))
    <div class="alert alert-success" data-alert role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" data-alert role="alert">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" data-alert role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

<script>
    function myFunction() {
        var containers = document.querySelectorAll('[data-alert]');
        
        containers.forEach(function(container) {
            setTimeout(function() {
                container.remove();
            }, 3000); 
        });
    }
    
    myFunction();
</script>
