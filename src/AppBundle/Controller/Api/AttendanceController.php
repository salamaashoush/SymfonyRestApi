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
  public function getUsersAbsenceAction(User $student,Request $request)
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

 public function getPermissionsAction(Request $request){
   $user = $this->get('security.token_storage')->getToken()->getUser();
   $user_id = $user->getId();
   $currentDate = new \Datetime();
   $currentDate = $currentDate->setTime(00,00,00);
   $repository = $this->getDoctrine()->getRepository('AppBundle:Rule');
   $rules = $repository->createQueryBuilder('r')->select('r.id')->Where("r.absenceStatus IN (:status)")
   ->setParameter('status', array_values(['Absence With Permission','Late With Permission','Leave With Permission']))
   ->getQuery()->getResult();
   $repository = $this->getDoctrine()->getRepository('AppBundle:Students_Absence');
   $query = $repository->createQueryBuilder('p')->Where("p.userId = ".$user_id)
    ->andWhere("p.date >= :curretDate")
    ->andWhere("p.ruleId IN (:withPermissionsIds)")
    ->setParameter('curretDate',$currentDate)
    ->setParameter('withPermissionsIds', array_values($rules))
    ->getQuery();
   $Permissions = $query->getResult();
   if ($Permissions){
     return $Permissions;
   }
   else {
     return $this->view(['Message' => 'No Permissions Submitted Recently','Success' => false],Response::HTTP_OK);
   }
 }

 public function putPermissionAction(Request $request,$permissionId){
   $permission = $this->getDoctrine()->getRepository('AppBundle:Students_Absence')->findOneById($permissionId);
   if($permission)
   {
     $data = json_decode($request->getContent(), true);
     $rule = null;
     $repository = $this->getDoctrine()->getRepository('AppBundle:Rule');
     if ($data['permissonStatus'] == "Absent")
     {
       $rule = $repository->findOneBy(array('absenceStatus' =>'Absence With Permission'));
     }elseif ($data['permissonStatus'] == "Late"){
       $rule = $repository->findOneBy(array('absenceStatus' =>'Late With Permission'));
     }else {
       $rule = $repository->findOneBy(array('absenceStatus' =>'Leave With Permission'));
     }
     $permission->setRule($rule);
     $permissonDate = new \Datetime($data['permissionDate']);
     $permissonDate->setTime(00,00,00);
     $permission->setDate($permissonDate);
     $em = $this->getDoctrine()->getManager();
     $em->persist($permission);
     $em->flush();
     return $this->view(['message' => 'your permission Updated Successfully', 'Success' => true], Response::HTTP_CREATED);
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
