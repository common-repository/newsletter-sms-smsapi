<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Subusers;

use Smsapi\Client\Version3\Feature\Subusers\Bag\CreateSubuserBag;
use Smsapi\Client\Version3\Feature\Subusers\Bag\DeleteSubuserBag;
use Smsapi\Client\Version3\Feature\Subusers\Bag\UpdateSubuserBag;
use Smsapi\Client\Version3\Feature\Subusers\Data\Subuser;

/**
 * @api
 */
interface SubusersFeature
{
    public function createSubuser(CreateSubuserBag $createSubuser): Subuser;

    /**
     * @return Subuser[]
     */
    public function findSubusers(): array;

    /**
     * @return void
     */
    public function deleteSubuser(DeleteSubuserBag $deleteSubuser);

    public function updateSubuser(UpdateSubuserBag $updateSubuser): Subuser;
}
