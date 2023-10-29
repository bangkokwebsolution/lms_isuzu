<?php
class HelperCourseQuest
{
    public static function lib()
    {
        return new HelperCourseQuest;
    }

    public function getScoreLog($log, $type = "post")
    {
        $courseScore = Coursescore::model()->find([
            'condition' => 'course_id = :course_id AND user_id = :user_id AND type = :type AND active = :active',
            'params' => [
                ':course_id' => $log->course_id,
                ':user_id' => $log->user_id,
                ':type' => $type,
                ':active' => 'y',
            ],
            'order' => 'score_id DESC',
        ]);

        return $courseScore;
    }

    public function getScores($log, $type = "post")
    {
        $score = 'N/A';
        $percent = 0;
        $courseScore = $this->getScoreLog($log, $type);

        if (!empty($courseScore)) {
            $score = $courseScore->score_number . '/' . $courseScore->score_total."&nbsp;";
            $percent = $courseScore->score_number * 100 / $courseScore->score_total;
        }
        return ['score' => $score, 'percent' => $percent . "%"];
    }

    public function getTypeRefer($courseScore)
    {
        $status = "N/A";
        if (!empty($courseScore)) {
            $list_status = ['Close' => "None", 'AnswerAfter' => "General", 'AnswerByOne' => "Special"];
            $status =  !empty($list_status[$courseScore->refer_status]) ? $list_status[$courseScore->refer_status] : "None";
        }
        return $status;
    }



    public function getAnswers($courseScore, $ques_id)
    {
        $status = "-";

        if (!empty($courseScore)) {
            $SumAnsLogCourse = SumAnsLogCourse::model()->find([
                'condition' => 'score_id = :score_id AND quest_id = :quest_id',
                'params' => [
                    ':score_id' => $courseScore->score_id,
                    ':quest_id' => $ques_id
                ],
                'order' => 'id DESC',
            ]);
            if (!empty($SumAnsLogCourse)) {
                $status = $SumAnsLogCourse->status;
            }
        }

        return $status;
    }
    // ---------------------------------------------------------------- Lessons ----------------------------------------------------------------

    public function getScoreLogLesson($log, $lesson, $type = "post")
    {
        $lessonScore = Score::model()->find([
            'condition' => 'course_id = :course_id AND lesson_id = :lesson_id AND user_id = :user_id AND type = :type AND active = :active',
            'params' => [
                ':course_id' => $log->course_id,
                ':lesson_id' => $lesson->id,
                ':user_id' => $log->user_id,
                ':type' => $type,
                ':active' => 'y',
            ],
            'order' => 'score_id DESC',
        ]);

        return $lessonScore;
    }

    public function getTypeReferLesson($lessonScore)
    {
        $status = "N/A";
        if (!empty($lessonScore)) {
            $list_status = ['Close' => "None", 'AnswerAfter' => "General", 'AnswerByOne' => "Special"];
            $status =  !empty($list_status[$lessonScore->status]) ? $list_status[$lessonScore->status] : "None";
        }
        return $status;
    }

    public function getScoresLesson($log, $lesson, $type = "post")
    {
        $score = 'N/A';
        $percent = 0;
        $lessonScore = $this->getScoreLogLesson($log, $lesson, $type);

        if (!empty($lessonScore)) {
            $score = $lessonScore->score_number . '/' . $lessonScore->score_total."&nbsp;";
            $percent = $lessonScore->score_number * 100 / $lessonScore->score_total;
        }
        return ['score' => $score, 'percent' => $percent . "%"];
    }

    public function getAnswersLesson($lessonScore, $ques_id)
    {
        $status = "-";

        if (!empty($lessonScore)) {
            $SumAnsLogLesson = SumAnsLogLesson::model()->find([
                'condition' => 'score_id = :score_id AND quest_id = :quest_id',
                'params' => [
                    ':score_id' => $lessonScore->score_id,
                    ':quest_id' => $ques_id
                ],
                'order' => 'id DESC',
            ]);
            if (!empty($SumAnsLogLesson)) {
                $status = $SumAnsLogLesson->status;
            }
        }

        return $status;
    }
}
