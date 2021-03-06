<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 27/09/2013
 * Time: 13:53
 */

namespace Pix\SortableBehaviorBundle\Services;

use Doctrine\ORM\EntityManager;

class PositionHandler
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }


    public function getPosition($object, $position, $last_position)
    {
        switch ($position) {
            case 'up' :
                if ($object->getPosition() > 0) {
                    $new_position = $object->getPosition() - 1;
                }
                break;

            case 'down':
                if ($object->getPosition() < $last_position) {
                    $new_position = $object->getPosition() + 1;
                }
                break;

            case 'top':
                if ($object->getPosition() > 0) {
                    $new_position = 0;
                }
                break;

            case 'bottom':
                if ($object->getPosition() < $last_position) {
                    $new_position = $last_position;
                }
                break;

            default: $new_position = 0;
        }

        return $new_position;

    }

    public function getLastPosition($entity)
    {

        $query = $this->em->createQuery('SELECT MAX(m.position) FROM '.$entity.' m');
        $result = $query->getResult();

        if (array_key_exists(0, $result)) {
            return intval($result[0][1]);
        }

        return 0;
    }


}
