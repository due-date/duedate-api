<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class ResourceCollectionAbstract extends ResourceCollection
{
    private $links;
    private $meta;

    public function __construct($resource)
    {
        if ($resource instanceof LengthAwarePaginator) {
            $this->meta = [
                'total'        => $resource->lastPage(),
                'count'        => $resource->count(),
                'per_page'     => $resource->perPage(),
                'current_page' => $resource->currentPage(),
                'first'        => $resource->firstItem(),
                'last'         => $resource->lastItem(),
            ];

            $this->links = [
                'first_page' => $resource->url(1),
                'last_page'  => $resource->url($resource->lastPage()),
                'previous'   => $resource->previousPageUrl(),
                'next'       => $resource->nextPageUrl(),
            ];

            $resource = $resource->getCollection();
        }

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        if (is_null($this->meta) || is_null($this->links)) {
            return $this->collection;
        }

        return [
            'data'  => $this->collection,
            'meta'  => $this->meta,
            'links' => $this->links
        ];
    }
}
