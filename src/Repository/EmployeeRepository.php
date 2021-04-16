<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function getDepartmentWiseclassEmployee()
    {
        // return $this->getEntityManager()->createQuery(
        //     'SELECT e.dept,  d.dept_name, COUNT(e.id)
        //     FROM App\Entity\Employee e
        //     JOIN App\Entity\Department d ON d.id = e.dept_id
        //     GROUP BY e.dept'
        // )->getResult();

        // return $this->createQueryBuilder('e')
        //     ->select('e.count(e.id) as count')
        //     ->addSelect('d.dept')
        //     ->addSelect('d.dept_name')
        //     ->innerJoin('e.dept', 'd')
        //     ->groupBy('d.dept')
        //     ->getQuery()
        //     // ->getArrayResult();
        //     ->getResult();

        // return $this->createQueryBuilder('e')
        //     ->select('e.count(e.id) AS Count')
        //     ->innerJoin('App\Entity\Department', 'd', 'WITH', 'e.dept_id = d.id')
        //     ->groupBy('d.dept_name')
        //     ->getQuery()
        //     ->getResult();

        return $this->createQueryBuilder('e')
            ->select('d.id AS dept_id, d.dept_name, COUNT(e.id) AS empcount')
            ->innerJoin('e.dept', 'd')
            ->groupBy('dept_id')
            ->getQuery()
            ->getResult();


        // return $this->createQueryBuilder('e')
        //     ->innerJoin('e.dept', 'd')
        //     ->select(['COUNT(e)', 'd.dept_name', 'e.dept'])
        //     ->addSelect('d.dept_name, d.id AS dept_id')
        //     ->groupBy('e.dept')
        //     ->groupBy('d.dept_name')
        //     ->getQuery()
        //     ->getResult();

        // return $this->createQueryBuilder('e')
        //     ->select(['d.dept_name', 'e.dept', 'COUNT(e.id)'])
        //     // ->from('App\Entity\Employee', 'e')
        //     ->join('App\Entity\Department', 'd', 'd.id = e.dept')
        //     // ->innerJoin('e.dept', 'd')
        //     ->groupBy('e.dept')
        //     ->getQuery()
        //     ->getResult();
    }

    // /**
    //  * @return Employee[] Returns an array of Employee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
