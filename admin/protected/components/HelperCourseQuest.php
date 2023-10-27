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
            $score = $courseScore->score_number . '/' . $courseScore->score_total;
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
            SumAnsLogCourse::model()->find(["condition" => "course_id"]);
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
}
