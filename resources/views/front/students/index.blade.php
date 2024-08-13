@extends('front.layouts.main')
@section('main-container')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between">
      <p class="card-title">Student's List</p>
      <p class="card-title"><a href="{{route('studentadd')}}" class="btn btn-success">Add Student</a></p>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="row">
              <div class="col-sm-12 col-md-6"></div>
              <div class="col-sm-12 col-md-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table class="display expandable-table data-table no-footer" style="width: 100%;" role="grid">
                  <thead>
                    <tr role="row">
                      <th class="select-checkbox sorting_disabled" style="width: 40px;">Sr.No.</th>
                      <th class="sorting_asc" style="width: 51px;">Student Name</th>
                      <th class="sorting_asc" style="width: 51px;">Student Class</th>
                      <th class="sorting_asc" style="width: 51px;">Status</th>
                      <th class="details-control sorting_disabled" style="width: 0px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-5"></div>
              <div class="col-sm-12 col-md-7"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript">
  $(function() {
    var table = $('.data-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('student') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'class',
          name: 'class'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ],
      columnDefs: [{
          "width": "5%",
          "targets": 0
        }, // First column width set to 20%
        {
          "width": "15%",
          "targets": -1
        }, // First column width set to 20%
        {
          "className": "dt-center",
          "targets": "_all"
        }
      ]
    });
  });
</script>
@endsection