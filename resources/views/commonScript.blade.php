@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('admin/vendor/jquery/jquery.min.js')}}" defer></script>
    <script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}" defer></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}" defer></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('admin/js/sb-admin-2.min.js')}}" defer></script>

    <!-- Page level plugins -->
    <script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}" defer></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('admin/js/demo/chart-area-demo.js')}}" defer></script>
    <script src="{{asset('admin/js/demo/chart-pie-demo.js')}}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
    alert("hello");
    $('#countryid').on('change', function(event){
        event.preventDefault();
        var country_id = $(this).val();
       
        console.log(country_id);
        if(country_id){
            $.ajax({
                    url: '{{ route('stateGetConutryWise') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "country_id": country_id,
                       
                    },

                    dataType: 'json',
                    success: function (html) {
                        
                        if(html){
                            $("#stateid").empty();
                            $("#stateid").append('<option value="">Select State</option>');
                             $.each(html,function(key,value){
                               
                                $("#stateid").append('<option value="'+key+'">'+value+'</option>');
                            });
                        }else{
                            
                            $("#stateid").append('<option value="">Select State</option>');
                        }
                        
                            
                    }
                });
        }else{
            $("#stateid").empty();
            $("#stateid").append('<option value="">Select State</option>');
        }
    });
});
</script>

@endpush