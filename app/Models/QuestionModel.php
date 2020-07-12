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
                  (SELECT reputations.point from reputations WHERE user_id = u.id) as user_point,
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

    public static function all($user_id){
      $query = "SELECT
                  q.*,
                  u.name as username,
                  (Select count(vote) FROM votes where question_id = q.id and vote = 'like') as 'like',
                  (Select count(vote) FROM votes where question_id = q.id and vote = 'dislike') as 'dislike',
                  (SELECT reputations.point from reputations WHERE user_id = u.id) as user_point,
                  v.vote as 'response'
                FROM `questions`q INNER JOIN `users` u
                  ON q.user_id = u.id
                LEFT JOIN (
                  SELECT * from votes WHERE user_id = '$user_id'
                ) as v
                  ON q.id = v.question_id
                GROUP BY q.id";
      $data =  DB::SELECT(DB::raw($query));
      return $data;
    }

    public static function byTag($user_id, $tag){
      $query = "SELECT
                  q.*,
                  u.name as username,
                  (Select count(vote) FROM votes where question_id = q.id and vote = 'like') as 'like',
                  (Select count(vote) FROM votes where question_id = q.id and vote = 'dislike') as 'dislike',
                  (SELECT reputations.point from reputations WHERE user_id = u.id) as user_point,
                  v.vote as 'response'
                FROM `questions`q INNER JOIN `users` u
                  ON q.user_id = u.id
                LEFT JOIN (
                  SELECT * from votes WHERE user_id = '$user_id'
                ) as v
                  ON q.id = v.question_id
                WHERE q.tag like '%$tag%'
                GROUP BY q.id";
      $data =  DB::SELECT(DB::raw($query));
      return $data;
    }

    public static function AnswersDetail($user_id, $question_id) {
      $query = "SELECT
        a.* ,
       (SELECT COUNT(vote) FROM votes WHERE vote = 'like' AND answer_id = a.id) as 'like',
       (SELECT COUNT(vote) FROM votes WHERE vote = 'dislike' AND answer_id = a.id) as 'dislike',
       (SELECT reputations.point from reputations WHERE user_id = a.user_id) as user_point,
       (SELECT users.name from users WHERE id = a.user_id) as user_name,
        v.vote as 'response'
      from answers a
      	LEFT JOIN
        (SELECT * from votes WHERE user_id = '$user_id') as v
       ON a.id = v.answer_id
      WHERE a.question_id = '$question_id'";
      return $data =  DB::SELECT(DB::raw($query));;
    }
}
