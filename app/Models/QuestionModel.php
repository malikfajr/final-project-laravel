<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class QuestionModel{
    public static function QuestionDetail($question_id){
      $query = "SELECT
                  q.*,
                  u.name as username,
                  (Select count(vote) FROM votes where question_id = '$question_id' and vote = 'like') as 'like',
                  (Select count(vote) FROM votes where question_id = '$question_id' and vote = 'dislike') as 'dislike'
                FROM `questions`q INNER JOIN `users` u
                  ON q.user_id = u.id
                WHERE q.id = '$question_id' GROUP BY q.id";
      $data =  DB::SELECT(DB::raw($query));
      return $data[0];
    }

    public static function AnswersDetail($question_id) {
      $query = "SELECT
      a.* ,
      (SELECT COUNT(vote) FROM votes WHERE vote = 'like' AND answer_id = a.id) as 'like',
      (SELECT COUNT(vote) FROM votes WHERE vote = 'dislike' AND answer_id = a.id) as 'dislike'
      from answers a
      WHERE a.question_id = '$question_id'";
      return $data =  DB::SELECT(DB::raw($query));;
    }
}
