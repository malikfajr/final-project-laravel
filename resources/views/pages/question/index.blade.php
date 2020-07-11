@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="d-flex align-content-center align-items-center">
      <h1 class="mr-auto">Daftar Pertanyaan</h1>
      <a href="/question/create" class="btn btn-primary ml-auto">Buat Pertanyaan</a>
    </div>
    <!-- <h1>Pertanyaan Saya</h1> -->
    @if(count($questions) > 0)
      <table id="table-pertanyaan" class="table table-bordered" width="100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Action</th>
            <th>Solved</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          @foreach($questions as $key => $question)
            <tr data="{{ $question->id }}" class="{{$question->solved ? 'bg-success' : ''}}">
              <td>{{$key + 1}}</td>
              <td>{{ $question->title }}</td>
              <td>
                <a href="/question/{{ $question->id }}">Show</a> &nbsp;
                @auth
                  @if($question->user_id == Auth::user()->id)
                    <a href="/question/{{ $question->id }}/edit">Edit</a> &nbsp;
                    <a href="#" onclick="deleteQuestion(event, '{{ $question->id }}')">Delete</a>
                  @endif
                @endauth
              </td>
              <td>{{ $question->solved ? "True" : "False"}}</td>
              <td>{{ $question->created_at }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <h3>Belum Ada Pertanyaan</h3>
    @endif
  </div>
@endsection

@push('style')
  <!-- Custom styles for this page -->
  <link href="{{ asset('/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('script')
  <!-- Page level plugins -->
  <script src="{{ asset('/sbadmin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <script type="text/javascript">
      function deleteQuestion(e, id) {
        e.preventDefault();
        console.log(id);
        $.ajax({
          url: '/question/' + id,
          method: 'delete',
          dataType: 'json',
          data: {
            "_token": "{{ csrf_token() }}"
          },
          success: function (res) {
            console.log(res);
            if (res.ok) {
              $(`tr[data='${id}']`).remove();
              alert(res.msg)
              if (!$("tbody tr").length) {
                location.reload()
              }
            }
          }
        })
      }
  </script>
@endpush
