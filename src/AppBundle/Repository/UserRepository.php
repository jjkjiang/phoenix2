<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
        
        if (null === $user) {
            $message = sprintf(
                'Unable to find an active admin AppBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message);
        }
        
        return $user;
    }
    
    public function getAllAuthors()
    {
        $dql = 'SELECT p , a FROM AppBundle\Entity\Post p JOIN p.author a';
        $query = $this->_em->createQuery($dql);
        $posts = $query->getResult();
        $authors = [];
        foreach($posts as $post) {
            array_push($authors, $post->getAuthor());
        }
        return $authors;
    }
}
