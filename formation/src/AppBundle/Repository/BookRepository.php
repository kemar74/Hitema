<?php

namespace AppBundle\Repository;

/**
 * BookRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookRepository extends \Doctrine\ORM\EntityRepository
{
	public function getByName($name){
		return $this->createQueryBuilder('book')
			->select('book')
			->where('book.title like ?1')
			->orWhere('book.author like ?2')
			->setParameter(1, $name)
			->setParameter(2, $name)
			->getQuery()
			->getResult();
	}
}
