<?php

return [
    'table'      => 'amethyst_data_views',
    'comment'    => 'DataView',
    'model'      => Amethyst\Models\DataView::class,
    'schema'     => Amethyst\Schemas\DataViewSchema::class,
    'repository' => Amethyst\Repositories\DataViewRepository::class,
    'serializer' => Amethyst\Serializers\DataViewSerializer::class,
    'validator'  => Amethyst\Validators\DataViewValidator::class,
    'authorizer' => Amethyst\Authorizers\DataViewAuthorizer::class,
    'faker'      => Amethyst\Fakers\DataViewFaker::class,
    'manager'    => Amethyst\Managers\DataViewManager::class,
];
