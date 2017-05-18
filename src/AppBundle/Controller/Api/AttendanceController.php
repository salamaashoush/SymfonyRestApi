<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Students_Attendance;
use AppBundle\Entity\Students_Absence;
use AppBundle\Entity\Rule;
use AppBundle\Entity\User;
use AppBundle\Entity\Track;
use AppBundle\Entity\QrCode;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;
Use \DateTime\createFromFormat;
date_default_timezone_set('Africa/Cairo');

class AttendanceController extends FOSRestController
{
  /**
   * @param Request $request
   * @param string $code
   * @return array
   */
  public function postStudentAttendanceAction(Request $request,$code)
  {
      $repository = $this->getDoctrine()->getRepository('AppBundle:QrCode');
      $code = $repository->findOneBy(['code'=>$code]);
      $currentDate = new DateTime();
      $codestartdate = new DateTime($code->getStartDate()->format('Y-m-d H:i:s'));
      $codeDuration =  $code->getDuration();
      $codeExpirydate = $code->getStartDate()->modify('+'.$codeDuration.' seconds');
      if ($currentDate >= $codestartdate && $currentDate <= $codeExpirydate)
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
          $Latedate->setTime(9,15);
          $Absencedate = new DateTime();
          $Absencedate->setTime(10,30);
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
          return $this->view(['message' => 'you have signed your Attendance Successfully', 'Success' => true], Response::HTTP_CREATED);
        }
        else {
          return $this->view(['message' => 'you have already signed your Attendance before', 'Success' => false], Response::HTTP_NOT_ACCEPTABLE);
        }
      }else {
        return $this->view(['message' => 'Invalid QR Code','Success' => false], Response::HTTP_NOT_ACCEPTABLE);
      }
  }

  public function postPermissionAction(Request $request)
  {
    $data = json_decode($request->getContent(), true);
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $user_id = $user->getId();
    $trackId = $user->getTrackId();
    $permissonDate = new \Datetime($data['permissionDate']);
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
    $absence = $repository->findOneBy(array('userId' =>$user_id, 'trackId' => $trackId,'date'=>$permissonDate));
    if(!$absence)
    {
      $studentAbsence = new Students_Absence();
      $studentAbsence->setUser($user);
      $repository = $this->getDoctrine()->getRepository('AppBundle:Track');
      $track = $repository->findOneById($trackId);
      $studentAbsence->setTrack($track);
      $rule;
      $repository = $this->getDoctrine()->getRepository('AppBundle:Rule');
      if ($data['permissonStatus'] == "Absent")
      {
        $rule = $repository->findOneBy(array('absenceStatus' =>'Absence With Permission'));
      }elseif ($data['permissonStatus'] == "Late"){
        $rule = $repository->findOneBy(array('absenceStatus' =>'Late With Permission'));
      }else {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
        $student = $repository->findOneBy(array('userId' =>$user_id, 'trackId' => $trackId));
        if($student)
        {
          $repository = $this->getDoctrine()->getRepository('AppBundle:Rule');
          $rule = $repository->findOneBy(array('absenceStatus' =>'Leave With Permission'));
        }else {
            return $this->view(['message' => 'you can not have a leave permission','Success' => false], Response::HTTP_NOT_ACCEPTABLE);
        }
      }
      $studentAbsence->setRule($rule);
      $studentAbsence->setDate($permissonDate);
      $em = $this->getDoctrine()->getManager();
      $em->persist($studentAbsence);
      $em->flush();
      return $this->view(['message' => 'your permission Submitted Successfully', 'Success' => true], Response::HTTP_CREATED);
    }else {
      return $this->view(['message' => 'you can not sign two permissions for the same day','Success' => false], Response::HTTP_NOT_ACCEPTABLE);
    }
  }

  // stuent get his/her absenece report
  public function getStudentAbsenceAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $user_id = $user->getId();
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
    $results = $repository->findBy(array('userId' => $user_id));
    $accAbsencePoints = $this->getDoctrine()->getRepository('AppBundle:User')->findOneById($user_id)->getAccAbsencePoints();
    return $this->view(array('results' => $results,'$accAbsencePoints' => $accAbsencePoints));
  }

  // get max Absence points
  public function getMaxAbsencePointsAction(Request $request){
    $ruleRate = $this->getDoctrine()->getRepository('AppBundle:Rule')->findOneBy(array('absenceStatus' =>'Max Points'))->getRate();
    return $ruleRate;
  }

  // admin get student absenece report
  public function getStudentAbsenceReportAction(User $student,Request $request)
  {
    $user_id = $student->getId();
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
    $results = $repository->findBy(array('userId' => $user_id));
    return $results;
  }

  // admin get track students absenece reports
  public function getTrackAbsenceAction(Request $request,$trackId)
  {
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
    $results = $repository->findBy(array('trackId' => $trackId));
    return $results;
  }

  // background job
  public function getCalcStudentsAttendanceAction()
  {
    $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Attendance');
    $query = $repository->createQueryBuilder('p')->Where("p.status != 1")->getQuery();
    $LateStudents = $query->getResult();
    // check if there's results
    if($LateStudents)
    {
    foreach($LateStudents as $student) {
      $getDateformat = $student->getArrivalTime()->setTime(00,00,00);
      $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
      $absence = $repository->findOneBy(array('userId' =>$student->getUser()->getId(), 'trackId' => $student->getTrack()->getId(),'date' => $getDateformat));
      $em = $this->getDoctrine()->getManager();
      $accAbsencePoints = $em->getRepository('AppBundle:User')->findOneById($student->getUser()->getId())->getAccAbsencePoints();
      if($absence)
      {
          $ruleRate = $absence->getRule()->getRate();
          $accAbsencePoints += $ruleRate;
      }else {
        $status = $student->getStatus();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Rule');
        $rule;
        $ruleRate = 0;
        switch ($status) {
          case 0:
          $rule = $repository->findOneBy(array('absenceStatus' =>'Late Without Permission'));
          $ruleRate = $rule->getRate();
            break;
          case -1:
          $rule = $repository->findOneBy(array('absenceStatus' =>'Absence Without Permission'));
          $ruleRate = $rule->getRate();
            break;
        }
        $accAbsencePoints += $ruleRate;
        $studentAbsence = new Students_Absence();
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->findOneById($student->getUser()->getId());
        $studentAbsence->setUser($user);
        $repository = $this->getDoctrine()->getRepository('AppBundle:Track');
        $track = $repository->findOneById($student->getTrack()->getId());
        $studentAbsence->setTrack($track);
        $studentAbsence->setRule($rule);
        $studentAbsence->setDate($getDateformat);
        $em = $this->getDoctrine()->getManager();
        $em->persist($studentAbsence);
        $em->flush();
      }
      $student->getUser()->setAccAbsencePoints($accAbsencePoints);
      $em->flush();
    }
    $em = $this->getDoctrine()->getManager();
    $qb = $em->createQueryBuilder();
    $qb->select('a', 'u')->from('AppBundle\Entity\User', 'a')
        ->leftJoin(
            'AppBundle\Entity\Students_Attendance',
            'u',
            \Doctrine\ORM\Query\Expr\Join::WITH,
            'a.id = u.userId'
        )
        ->where('u.userId is null');
    $AbsentStudents = $qb->getQuery()->getResult();
    foreach($AbsentStudents as $student) {
      if($student != null)
      {
      $TodayDate = new \Datetime();
      $TodayDate = $TodayDate->setTime(00,00,00);
      $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
      $absence = $repository->findOneBy(array('userId' => $student->getId(), 'trackId' => $student->getTrack()->getId(),'date' => $TodayDate));
      $accAbsencePoints = $em->getRepository('AppBundle:User')->findOneById($student->getId())->getAccAbsencePoints();
      $ruleRate = 0;
      if($absence)
      {
          $ruleRate = $absence->getRule()->getRate();
      }else {
        $rule = $this->getDoctrine()->getRepository('AppBundle:Rule')->findOneBy(array('absenceStatus' =>'Absence Without Permission'));
        $ruleRate = $rule->getRate();
        $studentAbsence = new Students_Absence();
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->findOneById($student->getId());
        $studentAbsence->setUser($user);
        $repository = $this->getDoctrine()->getRepository('AppBundle:Track');
        $track = $repository->findOneById($student->getTrack()->getId());
        $studentAbsence->setTrack($track);
        $studentAbsence->setRule($rule);
        $studentAbsence->setDate($TodayDate);
        $em = $this->getDoctrine()->getManager();
        $em->persist($studentAbsence);
        $em->flush();
      }
      $accAbsencePoints += $ruleRate;
      $student->setAccAbsencePoints($accAbsencePoints);
      $em->flush();
    }
   }
   $query = $em->createQuery('DELETE AppBundle:Students_Attendance');
   $query->execute();
   dump('your Attendance Submitted Successfully');
   die();
   }
   else {
     dump('No Students Found');
     die();
   }
 }

 public function getpermissionsAction(Request $request){
   $user = $this->get('security.token_storage')->getToken()->getUser();
   $user_id = $user->getId();
   $currentDate = new \Datetime();
   $currentDate = $currentDate->setTime(00,00,00);
   $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
   $query = $repository->createQueryBuilder('p')->Where("p.userId = ".$user_id)
    ->andWhere("p.date >= :curretDate")
    ->andWhere("p.ruleId IN (:withPermissionsIds)")
    ->setParameter('curretDate',$currentDate)
    ->setParameter('withPermissionsIds', array_values([1,3,5]))
    ->getQuery();
   $Permissions = $query->getResult();
   if ($Permissions){
     return $Permissions;
   }
   else {
     return $this->view(['Message' => 'No Permissions Submitted Recently','Success' => false],Response::HTTP_OK);
   }
 }

 public function putPermissionAction(Request $request,$permissionId,$permissionStatus){
   $permission = $this->getDoctrine()->getRepository('AppBundle:Students_Absence')->findOneById($permissionId);
   if($permission)
   {
     $permissionRule = $permission->getRule()->getRate();
     dump($permissionRule);
     die();
   }else {
     return $this->view(['Message' => 'permission Not Exist','Success' => false], Response::HTTP_NOT_ACCEPTABLE);
   }
 }

 public function deletePermissionAction(Request $request,$permissionId){
   $user = $this->get('security.token_storage')->getToken()->getUser();
   $user_id = $user->getId();
   $permission = $this->getDoctrine()->getRepository('AppBundle:Students_Absence')->findOneBy(['id'=>$permissionId,'userId'=>$user_id]);
   if($permission)
   {
     $em = $this->getDoctrine()->getManager();
     /*$permissionRule = $permission->getRule()->getRate();
     $userAccAbsencePoints = $user->getAccAbsencePoints();
     $userAccAbsencePoints -= $permissionRule;
     $user->setAccAbsencePoints($userAccAbsencePoints);*/
     $em->remove($permission);
     $em->flush();
     return $this->view(['Message' => 'permission Deleted Successfully','Success' => true], Response::HTTP_OK);
   }else {
     return $this->view(['Message' => 'permission Not Exist','Success' => false], Response::HTTP_NOT_ACCEPTABLE);
   }
 }
}
