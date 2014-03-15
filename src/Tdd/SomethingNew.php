<?php
/**
 * Description of SomethingNew
 *
 * @author dholmes
 */

// make sure score is a valid TeamScore

function assignGrade(TeamScore $score)
{
    $grade = "C";
    if($score->getPoints() >= 13) {
        $grade = "A";
    } elseif ($score->getPoints() >= 10) {
        $grade = "B";
    }
    return $grade;
}

?>
