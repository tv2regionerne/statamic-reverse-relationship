<?php

namespace Tv2regionerne\StatamicReverseRelationship\Http\Controllers;

use Facades\Statamic\Fields\FieldtypeRepository as Fieldtype;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Statamic\Fields\Field;

class ReverseRelationshipController
{
    public function index(Request $request)
    {
        $fieldtype = $this->fieldtype($request);

        $items = $fieldtype->getItems($request->input('id'));

        return JsonResource::collection($items);
    }

    private function fieldtype($request)
    {
        $config = $this->getConfig($request);

        return Fieldtype::find($config['type'])->setField(
            new Field('reverse_relationship', $config)
        );
    }

    private function getConfig($request)
    {
        $json = base64_decode($request->config);
        $utf8 = mb_convert_encoding($json, 'UTF-8', mb_list_encodings());
        $json = empty($utf8) ? $json : $utf8;

        return json_decode($json, true);
    }
}
