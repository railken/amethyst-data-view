<?php

namespace Amethyst\Services;

use Railken\Lem\Attributes;

trait HasAttributeSerializer
{
    public function serializeAttribute(Attributes\BaseAttribute $attribute): array
    {
        $method = sprintf('serialize%sAttribute', $attribute->getType());

        if (!method_exists($this, $method)) {
            $method = 'serializeBaseAttribute';
        }

        return $this->$method($attribute);
    }

    public function serializeBaseAttribute(Attributes\BaseAttribute $attribute): iterable
    {
        $nameComponent = $this->enclose($attribute->getManager()->getName(), $attribute->getName());

        $params = [
            'name'    => $nameComponent,
            'extends' => 'attribute-input',
            'type'    => 'attribute',
            'options' => [
                'name' => $nameComponent,
                'type' => $attribute->getType(),
                'hide' => false, // 'hide' => in_array($attribute->getType(), ['LongText', 'Json', 'Array', 'Object'], true),
                // 'fillable'   => (bool) $attribute->getFillable(),
                'required' => (bool) $attribute->getRequired(),
                'unique'   => (bool) $attribute->getUnique(),
                'mutable'  => (bool) $attribute->isMutable(),
                'default'  => $attribute->getDefault($attribute->getManager()->newEntity()),
                // 'descriptor' => $attribute->getDescriptor(),
                'extract' => [
                    'attributes' => [
                        $nameComponent => [
                            'path' => $nameComponent,
                        ],
                    ],
                ],
                'inject' => [
                    'attributes' => [
                        $nameComponent => [
                            'path' => 'value',
                        ],
                    ],
                ],
                'readable' => [
                    'type'  => 'default',
                    'label' => '{{ value }}',
                ],
                // 'inject' => $attribute->getName(),
                'persist' => [
                    'attributes' => [
                        $nameComponent,
                    ],
                ],
                'select' => [
                    'attributes' => [
                        $nameComponent => '{{ resource.'.$nameComponent.' }}',
                    ],
                ],
            ],
        ];

        return $params;
    }

    public function serializeEnumAttribute(Attributes\EnumAttribute $attribute): iterable
    {
        $attr = $this->serializeBaseAttribute($attribute);
        $attr['options']['items'] = $attribute->getOptions();

        return $attr;
    }

    public function serializeDateTimeAttribute(Attributes\DateTimeAttribute $attribute): iterable
    {
        $attr = $this->serializeBaseAttribute($attribute);
        $attr['options']['readable']['label'] = '{{ date(value).format("D MMM YYYY, HH:mm:ss") }}';

        return $attr;
    }

    public function serializeCreatedAtAttribute(Attributes\DateTimeAttribute $attribute): iterable
    {
        return $this->serializeDateTimeAttribute($attribute);
    }

    public function serializeUpdatedAtAttribute(Attributes\DateTimeAttribute $attribute): iterable
    {
        return $this->serializeDateTimeAttribute($attribute);
    }

    public function serializeBooleanAttribute(Attributes\BooleanAttribute $attribute): iterable
    {
        $attr = $this->serializeBaseAttribute($attribute);
        $attr['options']['readable']['label'] = '{{ value ? 1 : 0 }}';

        return $attr;
    }
}
