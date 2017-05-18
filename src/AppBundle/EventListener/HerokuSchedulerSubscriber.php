<?php
/**
 * Created by PhpStorm.
 * User: salamaashoush
 * Date: 5/17/17
 * Time: 11:50 PM
 */
namespace AppBundle\EventListener;
use AppBundle\Entity\Branch;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Students_Attendance;
use AppBundle\Entity\Students_Absence;
use AppBundle\Entity\Rule;
use AppBundle\Entity\User;
use AppBundle\Entity\Track;
use mCzolko\HerokuSchedulerBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use \Datetime;
Use \DateTime\createFromFormat;
date_default_timezone_set('Africa/Cairo');

class HerokuSchedulerSubscriber implements EventSubscriberInterface
{

    protected $em;
    /**
    * @InjectParams({
    *    "em" = @Inject("doctrine.orm.entity_manager")
    * })
    */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::TEN_MINUTES  => 'tenminutes'
            //Events::DAILY       => 'daily'
        ];
    }

    public function tenminutes()
    {
//      $repository = $this->em->getRepository('AppBundle:Students_Attendance');
//      $query = $repository->createQueryBuilder('p')->Where("p.status != 1")->getQuery();
//      $LateStudents = $query->getResult();
//      // check if there's results
//      if($LateStudents)
//      {
//      foreach($LateStudents as $student) {
//        $getDateformat = $student->getArrivalTime()->setTime(00,00,00);
//        $repository = $this->em->getRepository('AppBundle:Students_Absence');
//        $absence = $repository->findOneBy(array('userId' =>$student->getUser()->getId(), 'trackId' => $student->getTrack()->getId(),'date' => $getDateformat));
//        $accAbsencePoints = $this->em->getRepository('AppBundle:User')->findOneById($student->getUser()->getId())->getAccAbsencePoints();
//        if($absence)
//        {
//            $ruleRate = $absence->getRule()->getRate();
//            $accAbsencePoints += $ruleRate;
//        }else {
//          $status = $student->getStatus();
//          $repository = $this->em->getRepository('AppBundle:Rule');
//          $rule=null;
//          $ruleRate = 0;
//          switch ($status) {
//            case 0:
//            $rule = $repository->findOneBy(array('absenceStatus' =>'Late Without Permission'));
//            $ruleRate = $rule->getRate();
//              break;
//            case -1:
//            $rule = $repository->findOneBy(array('absenceStatus' =>'Absence Without Permission'));
//            $ruleRate = $rule->getRate();
//              break;
//          }
//          $accAbsencePoints += $ruleRate;
//          $studentAbsence = new Students_Absence();
//          $repository = $this->em->getRepository('AppBundle:User');
//          $user = $repository->findOneById($student->getUser()->getId());
//          $studentAbsence->setUser($user);
//          $repository = $this->em->getRepository('AppBundle:Track');
//          $track = $repository->findOneById($student->getTrack()->getId());
//          $studentAbsence->setTrack($track);
//          $studentAbsence->setRule($rule);
//          $studentAbsence->setDate($getDateformat);
//          //$em = $this->getDoctrine()->getManager();
//          $this->em->persist($studentAbsence);
//          $this->em->flush();
//        }
//        $student->getUser()->setAccAbsencePoints($accAbsencePoints);
//        $this->em->flush();
//      }
//      //$em = $this->getDoctrine()->getManager();
//      $qb = $this->em->createQueryBuilder();
//      $qb->select('a', 'u')->from('AppBundle\Entity\User', 'a')
//          ->leftJoin(
//              'AppBundle\Entity\Students_Attendance',
//              'u',
//              \Doctrine\ORM\Query\Expr\Join::WITH,
//              'a.id = u.userId'
//          )
//          ->where('u.userId is null');
//      $AbsentStudents = $qb->getQuery()->getResult();
//      foreach($AbsentStudents as $student) {
//        if($student != null)
//        {
//        $TodayDate = new \Datetime();
//        $TodayDate = $TodayDate->setTime(00,00,00);
//        $repository = $this->em->getRepository('AppBundle:Students_Absence');
//        $absence = $repository->findOneBy(array('userId' => $student->getId(), 'trackId' => $student->getTrack()->getId(),'date' => $TodayDate));
//        $accAbsencePoints = $this->em->getRepository('AppBundle:User')->findOneById($student->getId())->getAccAbsencePoints();
//        $ruleRate = 0;
//        if($absence)
//        {
//            $ruleRate = $absence->getRule()->getRate();
//        }else {
//          $rule = $this->em->getRepository('AppBundle:Rule')->findOneBy(array('absenceStatus' =>'Absence Without Permission'));
//          $ruleRate = $rule->getRate();
//          $studentAbsence = new Students_Absence();
//          $repository = $this->em->getRepository('AppBundle:User');
//          $user = $repository->findOneById($student->getId());
//          $studentAbsence->setUser($user);
//          $repository = $this->em->getRepository('AppBundle:Track');
//          $track = $repository->findOneById($student->getTrack()->getId());
//          $studentAbsence->setTrack($track);
//          $studentAbsence->setRule($rule);
//          $studentAbsence->setDate($TodayDate);
//          //$em = $this->getDoctrine()->getManager();
//          $this->em->persist($studentAbsence);
//          $this->em->flush();
//        }
//        $accAbsencePoints += $ruleRate;
//        $student->setAccAbsencePoints($accAbsencePoints);
//        $this->em->flush();
//      }
//     }
//     $query = $this->em->createQuery('DELETE AppBundle:Students_Attendance');
//     $query->execute();
//        echo "worked";
//     }
//     else {
//         echo "no students";
//     }
        $branch = new Branch();
        $branch->setDescription("sdasd");
        $branch->setAddress("adasdasd");
        $branch->setName("asdasdas");
        $branch->setLocation("asdasdsa");
        $this->em->persist($branch);
        $this->em->flush();
    }
}
