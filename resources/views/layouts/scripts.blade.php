{{-- PopperJs --}}
<script src="{{url('public/js/popper.min.js')}}"></script>
<script src="{{url('public/js/bootstrap.min.js')}}" async></script>
{{-- Datatable --}}
<script src="{{url('public/js/datatables.min.js')}}" defer></script>
{{-- Font Awesome --}}
<script src="{{url('public/js/all.min.js')}}" async></script>
{{-- Js files --}}
@if(App::environment('local'))
@vite(['resources/scss/style.scss', 'resources/js/app.js'])
@else
<script src="{{url('/build/assets/app.js')}}"></script>
<script src="{{url('/build/assets/custom.js')}}"></script>
@endif

