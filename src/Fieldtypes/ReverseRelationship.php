<?php

namespace Tv2regionerne\StatamicReverseRelationship\Fieldtypes;

use Statamic\Fields\Fieldtype;
use Statamic\Facades\Entry;
use Statamic\Facades\Term;

class ReverseRelationship extends Fieldtype
{
    protected $icon = 'entries';

    protected function configFieldItems(): array
    {
        return [
            [
                'display' => __('Appearance & Behavior'),
                'fields' => [
                    'mode' => [
                        'display' => __('Type'),
                        'instructions' => __('The relationship type'),
                        'type' => 'button_group',
                        'default' => 'entries',
                        'options' => [
                            'entries' => __('Entries'),
                            'terms' => __('Terms'),
                        ],
                    ],
                    'collection' => [
                        'display' => __('Collection'),
                        'instructions' => __('The related collection'),
                        'type' => 'collections',
                        'max_items' => 1,
                        'validate' => 'required_if:mode,entries',
                        'if' => [
                            'mode' => 'entries',
                        ],
                    ],
                    'taxonomy' => [
                        'display' => __('Taxonomy'),
                        'instructions' => __('The related taxonomy'),
                        'type' => 'taxonomies',
                        'max_items' => 1,
                        'validate' => 'required_if:mode,terms',
                        'if' => [
                            'mode' => 'terms',
                        ],
                    ],
                    'field' => [
                        'display' => __('Field'),
                        'instructions' => __('The related field'),
                        'type' => 'text',
                        'validate' => 'required',
                    ],
                    'sort' => [
                        'display' => __('Sort'),
                        'instructions' => __('The related item sort order'),
                        'type' => 'text',
                    ],
                ],
            ],
        ];
    }

    public function augment($value)
    {
        $id = $this->field->parent()->id();

        return $this->getItems($id);
    }

    public function getItems($id)
    {
        $mode = $this->config('mode');

        if ($mode === 'entries') {
            $query = Entry::query()->where('collection', $this->config('collection'));
        } else if ($mode === 'terms') {
            $query = Term::query()->where('taxonomy', $this->config('taxonomy'));
        }

        $query 
            ->whereJsonContains($this->config('field'), $id)
            ->orderBy($this->config('sort') ?? 'title');
        
        return $query->get();
    }
}
