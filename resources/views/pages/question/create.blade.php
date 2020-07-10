@extends('layouts.master')

@section('content')
  <div class="container">
    <h1>Buat Pertanyaan</h1>
    <form id="form" method="post">
      <div class="form-group">
        <label for="title">Judul :</label>
        <input type="text" class="form-control" id="title" placeholder="Masukan Judul Pertanyaan" name="title" value="" required>
      </div>
      <div class="form-group">
        <label for="tag">Tag :</label>
        <input type="text" class="form-control" id="tag" placeholder="pisahkan tag dengan koma(,). ex: web,laravel" name="tag" value="" required>
      </div>
      <div class="form-group">
        <label for="content-question">Isi :</label>
        <textarea name="content-question" id="content-question" class="textarea form-control" required="true"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

@endsection

@push('script')
<script src="{{asset('/ckeditor/ckeditor.js')}}" charset="utf-8"></script>
<script type="text/javascript">
    $(function(){
        var editor = CKEDITOR.replace('content-question', {
          language: 'en-gb'
        });
        editor.on( 'required', function( evt ) {
            editor.showNotification( 'This field is required.', 'warning' );
            evt.cancel();
        });

        $("#form").submit(function(e) {
          e.preventDefault();
          var title = $("#title").val()
          var content = CKEDITOR.instances["content-question"].getData()
          var tag = $("#tag").val()

          $.ajax({
            url: "/question" ,
            method: "post",
            dataType: "JSON",
            data: {
              "_token": "{{ csrf_token() }}",
              title,
              content,
              tag
            },
            success: function(res) {
              if (res.ok) {
                location.href = "{{ route('question.index')}}"
              }
            }
          })
        })
    })
</script>
@endpush
