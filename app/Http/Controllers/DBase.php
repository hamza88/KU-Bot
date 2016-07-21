<?php
/**
 * Created by PhpStorm.
 * User: rsanjib
 * Date: 7/16/16
 * Time: 5:45 PM
 */

namespace App\Http\Controllers;
use DB;

class DBase extends Controller
{

    /**
     * @param $question
     */
    public function insertQuestion($question){
        $exists = DB::select('SELECT question from questions where question = ?',[$question]);
        if(!$exists){
            DB::insert('insert into questions (question) VALUES ( ?)',[$question]);
        } else {
            DB::update('UPDATE questions SET count = count + 1 WHERE question = ?',[$question]);
        }
        return;
    }

    public function insertQA($question , $answer = NULL){
        DB::insert('insert into qna (question, answer) VALUES ( ?, ?)',[$question, $answer]);
    }

    public static function insertTopic($topic){
        $exists = DB::select('SELECT id FROM topics where topic = ?', [$topic]);
        if(!$exists){
            DB::insert('INSERT INTO topics (topic) VALUE (?)',[$topic]);
        }else{
            DB::update('UPDATE topics SET count = count + 1 WHERE topic = ?',[$topic]);
        }
        return;
    }

    public static function getTrending(){
        return DB::select('SELECT * FROM topics ORDER BY count ASC limit 5');
    }
}
