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
            // Todo: increase question count
        }
    }

    public function insertQA($question , $answer = NULL){
        DB::insert('insert into qna (question, answer) VALUES ( ?, ?)',[$question, $answer]);
    }
}