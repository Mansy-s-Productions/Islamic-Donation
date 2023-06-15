@push('other-scripts')
    {{-- Datatable --}}
    <script src="{{url('public/js/datatables.min.js')}}"></script>
    {{-- Bootstrap Js --}}
    <script src="{{url('public/js/bootstrap.min.js')}}"></script>
<script>
    let table = new DataTable('#myTable');
</script>
@endpush
@push('head')
{{-- DataTable --}}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- Bootstrap --}}
<link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
@endpush
