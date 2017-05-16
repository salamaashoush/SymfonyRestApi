<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Students_Attendance;
use AppBundle\Entity\Students_Abscence;
use AppBundle\Entity\Rule;
use AppBundle\Entity\User;
use AppBundle\Entity\Track;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;

class AttendanceController extends FOSRestController
{
  /**
   * @param Request $request
   * @return array
   */
  public function postStudentAttendanceAction(Request $request)
  {
      $user = $this->get('security.token_storage')->getToken()->getUser();
      $user_id = $user->getId();
      $trackId = $user->getTrackId();
      $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
      $student = $repository->findOneBy(array('userId' =>$user_id, 'trackId' => $trackId));
      if(!$student)
      {
        $studentAttendance = new Students_Attendance();
        $Latedate = new DateTime();
        $Latedate->setTime(15,15);
        $Absencedate = new DateTime();
        $Absencedate->setTime(10,30);
        $currentDate = new DateTime();
        /*dump( $Latedate);
        dump( $currentDate);
        dump($currentDate <= $Latedate);
        dump($currentDate >= $Latedate && $currentDate <= $Absencedate);
        die();*/
        if ($currentDate <= $Latedate)
        {
           $studentAttendance->setStatus(1);
        }elseif ($currentDate >= $Latedate && $currentDate <= $Absencedate)
        {
          $studentAttendance->setStatus(0);
        }
        $studentAttendance->setArrivalTime(new \DateTime());
        $repository = $this->getDoctrine()->getRepository('AppBundle:Track');
        $track = $repository->findOneById($trackId);
        $studentAttendance->setTrack($track);
        $studentAttendance->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($studentAttendance);
        $em->flush();
        return $this->view(['Message' => 'you have signed your Attendance Successfully', 'Success' => true], Response::HTTP_CREATED);
      }
      else {
        return $this->view(['Message' => 'you have already signed your Attendance before', 'Success' => false], Response::HTTP_NOT_ACCEPTABLE);
      }
  }

  public function postStudentPermissionAction(User $student,$permissonStatus,$permissiondate,Request $request){
    $user_id = $student->getId();
    $trackId = $student->getTrackId();
    $studentAbscence = new Students_Abscence();
    $studentAbscence->setUser($user_id);
    $studentAbscence->setTrack($trackId);
    $ruleid = 0;
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Abscence');
    if ($permissonStatus == "Absent")
    {
      $rule = $repository->findOneBy(array('absence_status' =>'Absence With Permission'));
      $ruleid = $rule->getId();
    }elseif ($permissonStatus == "Late"){
      $rule = $repository->findOneBy(array('absence_status' =>'Late With Permission'));
      $ruleid = $rule->getId();
    }else {
      $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
      $student = $repository->findOneBy(array('user_id' =>$user_id, 'track_id' => $trackId, 'status' => 1,'arrival_time'=>$permissiondate));
      if($student)
      {
        $rule = $repository->findOneBy(array('absence_status' =>'Leave With Permission'));
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


  public function getStudentAttendanceAction(Request $request,$trackId)
  {
    $user = $this->getUser();
    $user_id = $user->getId();
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
    $query = $repository->createQueryBuilder('p')->where("p.user_id = ".$user_id)
    ->andWhere("p.track_id = ".$trackId)
    ->andWhere("p.status != 1")
    ->getQuery();
    $AbsentStudents = $query->getResult();

  }

  public function postStudentsAbsenceAction(Request $request)
  {

  }
}
