@extends('layouts.master')

@section('content')
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-2">
          <div class="card-header">
            <div class="media flex-wrap w-100 align-items-center">
              <div class="media-body ml-3 mr-auto">
                <!-- redirect to user profile -->
                <a href="#" >{{ $question->username }}</a>
                <div class="text-muted small">created at {{ $question->created_at }}, updated at {{ $question->updated_at }}</div>
              </div>
              <div class="media-body d-flex mr-3 ml-auto justify-content-end align-items-center">
                {!! ($question->solved) ? "<a href='#{$question->solved}' class='btn btn-success'>Solved</a>" : "" !!}
                &nbsp;&nbsp;&nbsp; {{ !$question->user_point ? '0' : $question->user_point}} point
              </div>
            </div>
          </div>
          <div class="card-body">
                <p style="text-align:center; font-size: 3em; border-radius: 50px;" class="bg-secondary">
                  {!! $question->title !!}
                </p>
               {!! $question->content !!}
           </div>
           <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">
             <?php
             $like =  $question->response == 'like' ? 'bg-primary disabled' : (!$question->response ? 'bg-secondary' : ' bg-secondary disabled');
             $dislike =  $question->response == 'dislike' ? 'bg-primary disabled' : (!$question->response ? 'bg-secondary' : ' bg-secondary disabled');
              ?>
               <div class="px-4 pt-3">
                  <a href="#" class="btn btn-normal text-light {{$like}}" onclick="thumbs('like', 'question', '{{ $question->id }}')">
                    <i class="far fa-thumbs-up"></i>
                  </a>
                  <span> &nbsp;{{ $question->like - $question->dislike }} &nbsp;</span>
                  <a href="#" class="btn btn-normal text-light {{$dislike}}"  onclick="thumbs('dislike', 'question', '{{ $question->id }}')">
                    <i class="far fa-thumbs-down"></i>
                  </a>
                </div>
               <div class="px-4 pt-3">
                 <button type="button" class="btn btn-primary" data-togle="modal" data-target="#commentModal" onclick="addComment('{{$question->id}}')">
                   <i class="ion ion-md-create"></i>&nbsp; add comment
                 </button>
               </div>
           </div>
           <div class="card-footer">
             <div class="container">
               @foreach($question->comment as $key => $comment)
                <small>{{$comment['content']}} - {{ $comment['name']}}</small> <br>
               @endforeach
            </div>
           </div>
        </div>
      </div>
      @if(count($answers))
        <div class="col-md-12 mt-2">
          <h3>{{ count($answers) }} Jawaban</h3>
        </div>
        @foreach($answers as $key => $answer)
          <div class="col-md-12">
            <div class="card mb-2" id="{{ $answer->id }}">
              <div class="card-body">
                   {!! $answer->content !!}
               </div>
               <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">
                 <?php
                 $like =  $answer->response == 'like' ? 'bg-primary disabled' : (!$answer->response ? 'bg-secondary' : ' bg-secondary disabled');
                 $dislike =  $answer->response == 'dislike' ? 'bg-primary disabled' : (!$answer->response ? 'bg-secondary' : ' bg-secondary disabled');
                  ?>
                   <div class="px-4 pt-3">
                      <a href="#" class="btn btn-normal text-light {{$like}}"  onclick="thumbs('like', 'answer', '{{ $answer->id }}')">
                        <i class="far fa-thumbs-up"></i>
                      </a>
                      <span> &nbsp;{{ $answer->like - $answer->dislike }} &nbsp;</span>
                      <a href="#" class="btn btn-normal text-light {{$dislike}}"  onclick="thumbs('dislike', 'answer', '{{ $answer->id }}')">
                        <i class="far fa-thumbs-down"></i>
                      </a>
                      &nbsp;&nbsp;&nbsp;
                      @if($question->user_id == Auth::id() && $answer->user_id != Auth::id())
                        <a href="#" class="btn btn-normal text-white {{ $question->solved == $answer->id ? 'btn-success disabled' : (!$question->solved ? 'bg-secondary' : 'bg-secondary disabled')}}" onclick="setSolved('{{ $answer->id }}')">Solve</a>
                      @endif
                    </div>
                   <div class="px-4 pt-3">
                     dijawab oleh <strong> {{ $answer->user_name }} </strong> {{!$answer->user_point ? '0' : $answer->user_point }} point
                     &nbsp;&nbsp;&nbsp;
                     <button type="button" class="btn btn-primary" data-togle="modal" data-target="#commentModal" onclick="addComment('{{$answer->id}}')">
                       <i class="ion ion-md-create"></i>&nbsp; add comment
                     </button>
                   </div>
               </div>
               <div class="card-footer">
                 <div class="container">
                   @foreach($answer->comment as $key => $comment)
                    <small>{{$comment['content']}} - {{ $comment['name']}}</small> <br>
                   @endforeach
                </div>
               </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-md-12 mt-2">
          <h3>Belum ada jwaban</h3>
        </div>
      @endif
      <div class="col-md-12 mt-4">
        <div class="card mb-2">
          <form  action="/answers/{{$question->id}}" method="post">
            @csrf
            <div class="form-group">
              <textarea name="content" id="content-answer" class="form-control" rows="8" cols="80"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Input Jawaban</button>
          </form>

        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Comment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="commentForm">
          <div class="modal-body">
              <div class="form-group">
                <input type="text" class="form-control" name="commentValue" value="">
                <input type="hidden" class="form-control" name="requestId" value="">
              </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send Comment</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('style')
  <style media="screen">
    body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    font-size: .88rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: left;
    background-color: #eef1f3
  }

  .mt-100 {
    margin-top: 100px
  }

  .card {
    box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03), 0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03), 0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05), 0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
    border-width: 0;
    transition: all .2s
  }

  .card-header:first-child {
    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0
  }

  .card-header {
    display: flex;
    align-items: center;
    border-bottom-width: 1px;
    padding-top: 0;
    padding-bottom: 0;
    padding-right: .625rem;
    height: 3.5rem;
    text-transform: uppercase;
    background-color: #fff;
    border-bottom: 1px solid rgba(26, 54, 126, 0.125)
  }

  .btn-primary {
    color: #fff;
    background-color: #3f6ad8;
    border-color: #3f6ad8
  }

  .btn {
    font-size: 0.8rem;
    font-weight: 500;
    outline: none !important;
    position: relative;
    transition: color 0.15s, background-color 0.15s, border-color 0.15s, box-shadow 0.15s
  }

  .card-body {
    flex: 1 1 auto;
    padding: 1.25rem
  }

  .card-body p {
    font-size: 13px
  }

  a {
    color: #E91E63;
    text-decoration: none !important;
    background-color: transparent
  }

  .media img {
    width: 40px;
    height: auto
  }
  </style>
@endpush

@push('script')
  <script src="{{asset('/ckeditor/ckeditor.js')}}" charset="utf-8"></script>
  <script type="text/javascript">
    $(function(){
      var editor = CKEDITOR.replace('content-answer', {
        language: 'en-gb'
      });
      editor.on( 'required', function( evt ) {
          editor.showNotification( 'This field is required.', 'warning' );
          evt.cancel();
      });
      $("#commentForm").submit(function(e){
        e.preventDefault();

        var content = $("input[name='commentValue']").val();
        var id = $("input[name='requestId']").val();
        $.ajax({
          url: '/comment',
          method: 'post',
          dataType: 'json',
          data: {
            "_token": '{{ csrf_token() }}',
            id,
            content
          },
          success: function(res) {
            if (res.ok) {
              location.reload()
            }else {
              alert(res.message)
            }
          }
        })
      });

    })
    function addComment(id) {
      $("input[name='requestId']").val(id);
      @guest
      alert('Anda harus login dulu!')
      @else
      $("#commentModal").modal('show');
      @endguest
    }

    function setSolved(answer_id) {
      $.ajax({
        url: '/question/solved',
        method: 'post',
        dataType: 'json',
        data: {
          "_token": "{{ csrf_token() }}",
          "question_id": '{{ $question->id }}',
          answer_id
        },
        success: function(res) {
          if (res.ok) {
            location.reload()
          }
        }
      })
    }

    function thumbs(vote, type, id) {
      $.ajax({
        url: '/vote',
        method:'post',
        dataType: 'json',
        data: {
          "_token": "{{ csrf_token() }}",
          vote,
          type,
          id
        },
        success: function (res) {
          if (res.ok) {
            location.reload();
          }else {
            alert(res.message)
          }
        }
      })
    };
  </script>
@endpush
