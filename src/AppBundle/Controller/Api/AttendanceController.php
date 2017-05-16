<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Students_Attendance;
use AppBundle\Entity\Students_Abscence;
use AppBundle\Entity\Rule;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AttendanceController extends FOSRestController
{
  /**
   * @param Request $request
   * @return array
   */
  public function postStudentAttendanceAction(Request $request)
  {
      $user = $this->getUser();
      $user_id = $user->getId();
      $trackId = $user->getTrackId();
      $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
      $student = $repository->findOneBy(array('user_id' =>$user_id, 'track_id' => $trackId));
      if($student)
      {
        $studentAttendance = new Students_Attendance();
        $Latedate = new DateTime();
        $Latedate->setTime(9,15);
        $Abscencedate = new DateTime();
        $Abscencedate->setTime(10,30);
        $currentDate = new DateTime();
        if ($Latedate <= $currentDate)
        {
           $studentAttendance->setStatus(1);
        }elseif ($Latedate >= $currentDate && $Abscencedate <= $currentDate)
        {
          $studentAttendance->setStatus(0);
        }
        $studentAttendance->setArrivalTime(new \DateTime());
        $studentAttendance->setTrack($trackId);
        $studentAttendance->setUser($user_id);
        $em = $this->getDoctrine()->getManager();
        $em->persist($studentAttendance);
        $em->flush();
        return $this->view(['Message' => 'you have signed your Attendance Successfully', 'Success' => true], Response::HTTP_CREATED);
      }
      else {
        return $this->view(['Message' => 'you have already signed your Attendance before', 'Success' => false], Response::HTTP_NOT_ACCEPTABLE);
      }
  }

  public function postStudentPermission(User $student,$permissonStatus,$permissiondate,Request $request){
    $user_id = $student->getId();
    $trackId = $student->getTrackId();
    $studentAbscence = new Students_Abscence();
    $studentAbscence->setUser($user_id);
    $studentAbscence->setTrack($trackId);
    $ruleid = 0;
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Abscence');
    if ($permissonStatus == "Absent")
    {
      $rule = $repository->findOneBy('Abscence_Status' =>'Abscence With Permission');
      $ruleid = $rule->getId();
    }elseif ($permissonStatus == "Late"){
      $rule = $repository->findOneBy('Abscence_Status' =>'Late With Permission');
      $ruleid = $rule->getId();
    }else {
      $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
      $student = $repository->findOneBy(array('user_id' =>$user_id, 'track_id' => $trackId, 'status' => 1,'arrival_time'=>$permissiondate));
      if($student)
      {
        $rule = $repository->findOneBy('Abscence_Status' =>'Leave With Permission');
        $ruleid = $rule->getId();
      }else {
          return $this->view(['Message' => 'you can not have a leave permission','Success' => false], Response::HTTP_NOT_ACCEPTABLE);
      }
    }
    $studentAbscence->setRule($ruleid);
    $studentAbscence->setAbscenceDate($permissiondate);
    $em = $this->getDoctrine()->getManager();
    $em->persist($studentAbscence);
    $em->flush();
    return $this->view(['Message' => 'your permission Submitted Successfully', 'Success' => true], Response::HTTP_CREATED);
  }



  public function getStudentAttendanceAction(Request $request,$trackID)
  {
    // return only late or absent students
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
    $students = $repository->findBy(array('track_id' => $trackId));
    return $students;
  }

  public function postStudentsAbscencePermissions(Request $request)
  {

  }
}
