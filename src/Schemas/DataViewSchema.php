<?php

namespace Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Schema;
use Amethyst\Managers\DataViewManager;

class DataViewSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('name')
                ->setRequired(true)
                ->setUnique(true),
            Attributes\TextAttribute::make('type')
                ->setRequired(true),
            Attributes\TextAttribute::make('tag'),
            Attributes\LongTextAttribute::make('description'),
            Attributes\YamlAttribute::make('config'),
            Attributes\BooleanAttribute::make('enabled'),
            Attributes\BelongsToAttribute::make('parent_id')
                ->setRelationName('parent')
                ->setRelationManager(DataViewManager::class),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
