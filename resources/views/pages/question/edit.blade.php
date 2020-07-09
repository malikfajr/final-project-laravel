@extends('layouts.master')

@section('content')
  <div class="container">
    <h1>Buat Pertanyaan</h1>
    <form id="form" method="post">
      <input type="hidden" name="user_id" value="{{ $question->user_id }}">
      <div class="form-group">
        <label for="title">Judul :</label>
        <input type="text" class="form-control" id="title" placeholder="Masukan Judul Pertanyaan" name="title" value="{{ $question->title }}" required>
      </div>
      <div class="form-group">
        <label for="content">Isi :</label>
        <textarea name="content" id="content-question" class="textarea form-control" required>{{ $question->content }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

@endsection

@push('script')
<script type="text/javascript">
    $(function(){
        $("#form").submit(function(e) {
          e.preventDefault();
          var title = $("#title").val()
          var content = $("#content-question").val()
          var user_id = $("input[name='user_id']").val()

          $.ajax({
            url: "/question/{{ $question->id }}" ,
            method: "put",
            dataType: "JSON",
            data: {
              "_token": "{{ csrf_token() }}",
              title,
              content,
              user_id
            },
            success: function(res) {
              if (res.ok) {
                location.href = "{{ route('question.index')}}"
              }else {
                alert(res.error)
              }
            }
          })
        })
    })
</script>
@endpush
