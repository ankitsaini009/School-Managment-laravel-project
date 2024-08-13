
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"><a href="https://www.bootstrapdash.com/" target="_blank"></span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i class="ti-heart text-danger ml-1"></i></span>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- plugins:js -->
<script src="{{ asset('/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('/jquery/dist/jquery.min.js') }}"></script>
<script src="{{asset('/')}}vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('/summernote/dist/summernote.js') }}"></script>
<script src="{{asset('/')}}vendors/chart.js/Chart.min.js"></script>
<script src="{{asset('/')}}js/off-canvas.js"></script>
<script src="{{asset('/')}}js/hoverable-collapse.js"></script>
<script src="{{asset('/')}}js/template.js"></script>
<script src="{{asset('/')}}js/settings.js"></script>
<script src="{{asset('/')}}js/todolist.js"></script>
<script src="{{asset('/')}}js/select2.js"></script>
<script src="{{asset('/')}}vendors/select2/select2.min.js"></script>
<script src="{{asset('/')}}js/dashboard.js"></script>
<script src="{{asset('/')}}js/bootstrap-datepicker.js"></script>
<script src="{{asset('/')}}js/Chart.roundedBarCharts.js"></script>
<script>
    $(document).ready(function() {
        $("#error-message").delay(3000).fadeOut();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
@yield('scripts')
<script>
    function deleteitem(msg, item_id, route, item_name) {
        bootbox.confirm({
            message: msg,
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result) {
                    $.ajax({
                        url: route,
                        method: 'get',
                        data: {
                            id: item_id,
                            name: item_name,
                        },
                        success: function(data) {
                            if (data == 'done') {
                                location.reload();
                            }
                        }
                    });
                }
            }
        });
    }

    $(document).on('click', '.removeold', function() {
        id = $(this).attr('document_id');
        documentrow = $(this).parent().parent();
        bootbox.confirm({
            message: "Are You Want To Remove The Document?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result) {
                    $.ajax({
                        url: '{{ route("delete.document") }}',
                        method: 'get',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            documentrow.remove();
                        }
                    });
                }
            }
        });
    });
</script>
</body>

</html>