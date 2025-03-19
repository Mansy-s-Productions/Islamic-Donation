{{-- PopperJs --}}
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}" async></script>
{{-- Datatable --}}
<script src="{{asset('js/datatables.min.js')}}" defer></script>
{{-- Font Awesome --}}
<script src="{{asset('js/all.min.js')}}" async></script>
{{-- Js files --}}
@if(App::environment('local'))
@vite(['resources/scss/style.scss', 'resources/js/app.js'])
@else
<script src="{{asset('build/app.js')}}"></script>
<script src="{{asset('build/custom.js')}}"></script>
@endif

