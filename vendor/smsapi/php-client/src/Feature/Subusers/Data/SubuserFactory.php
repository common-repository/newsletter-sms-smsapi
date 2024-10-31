<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Subusers\Data;

use Smsapi\Client\Version3\Feature\Data\PointsFactory;
use stdClass;

/**
 * @internal
 */
class SubuserFactory
{
    private $subUserPointsFactory;

    public function __construct(PointsFactory $subUserPointsFactory)
    {
        $this->subUserPointsFactory = $subUserPointsFactory;
    }

    public function createFromObject(stdClass $object): Subuser
    {
        $subuser = new Subuser();
        $subuser->id = $object->id;
        $subuser->username = $object->username;
        $subuser->active = $object->active;
        $subuser->description = $object->description;
        $subuser->points = $this->subUserPointsFactory->createFromObject($object->points);

        return $subuser;
    }
}
