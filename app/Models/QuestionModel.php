<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class QuestionModel{
    public static function QuestionDetail($user_id, $question_id){
      $query = "SELECT
                  q.*,
                  u.name as username,
                  (Select count(vote) FROM votes where question_id = '$question_id' and vote = 'like') as 'like',
                  (Select count(vote) FROM votes where question_id = '$question_id' and vote = 'dislike') as 'dislike',
                  v.vote as 'response'
                FROM `questions`q INNER JOIN `users` u
                  ON q.user_id = u.id
                LEFT JOIN (
                  SELECT * from votes WHERE user_id = '$user_id'
                ) as v
                  ON q.id = v.question_id
                WHERE q.id = '$question_id' GROUP BY q.id";
      $data =  DB::SELECT(DB::raw($query));
      if (!$data) {
        return false;
      }
      return $data[0];
    }

    public static function AnswersDetail($user_id, $question_id) {
      $query = "SELECT
        a.* ,
       (SELECT COUNT(vote) FROM votes WHERE vote = 'like' AND answer_id = a.id) as 'like',
       (SELECT COUNT(vote) FROM votes WHERE vote = 'dislike' AND answer_id = a.id) as 'dislike',
        v.vote as 'response'
      from answers a
      	LEFT JOIN
        (SELECT * from votes WHERE user_id = '$user_id') as v
       ON a.id = v.answer_id
      WHERE a.question_id = '$question_id'";
      return $data =  DB::SELECT(DB::raw($query));;
    }
}
