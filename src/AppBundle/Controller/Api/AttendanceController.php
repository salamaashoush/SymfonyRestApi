<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Rule;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AttendanceController extends FOSRestController
{
    /**
     * @param User $student
     * @param Request $request
     * @return array
     */
    public function postStudentAttendanceAction(User $student,Request $request)
    {
        //implement the logic
    }
}
