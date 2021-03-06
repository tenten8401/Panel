<?php

namespace Pterodactyl\Transformers\Api\Application;

use Pterodactyl\Models\Location;
use Pterodactyl\Services\Acl\Api\AdminAcl;

class LocationTransformer extends BaseTransformer
{
    /**
     * List of resources that can be included.
     *
     * @var array
     */
    protected $availableIncludes = ['nodes', 'servers'];

    /**
     * Return the resource name for the JSONAPI output.
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return Location::RESOURCE_NAME;
    }

    /**
     * Return a generic transformed pack array.
     *
     * @param \Pterodactyl\Models\Location $location
     * @return array
     */
    public function transform(Location $location): array
    {
        return $location->toArray();
    }

    /**
     * Return the nodes associated with this location.
     *
     * @param \Pterodactyl\Models\Location $location
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\NullResource
     */
    public function includeServers(Location $location)
    {
        if (! $this->authorize(AdminAcl::RESOURCE_SERVERS)) {
            return $this->null();
        }

        $location->loadMissing('servers');

        return $this->collection($location->getRelation('servers'), $this->makeTransformer(ServerTransformer::class), 'server');
    }

    /**
     * Return the nodes associated with this location.
     *
     * @param \Pterodactyl\Models\Location $location
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\NullResource
     */
    public function includeNodes(Location $location)
    {
        if (! $this->authorize(AdminAcl::RESOURCE_NODES)) {
            return $this->null();
        }

        $location->loadMissing('nodes');

        return $this->collection($location->getRelation('nodes'), $this->makeTransformer(NodeTransformer::class), 'node');
    }
}
