<?php

namespace Tv2regionerne\StatamicReverseRelationship\Fieldtypes;

use Statamic\Facades\Asset;
use Statamic\Facades\AssetContainer;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\Taxonomy;
use Statamic\Facades\Term;
use Statamic\Fields\Fieldtype;

class ReverseRelationship extends Fieldtype
{
    protected $icon = 'fieldtype-entries';

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
                            'assets' => __('Assets'),
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
                    'container' => [
                        'display' => __('Container'),
                        'instructions' => __('The related container'),
                        'type' => 'asset_container',
                        'max_items' => 1,
                        'validate' => 'required_if:mode,assets',
                        'if' => [
                            'mode' => 'assets',
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

    public function preload()
    {
        return [
            'id' => $this->field()->parent()->id(),
        ];
    }

    public function augment($value)
    {
        $id = $this->field->parent()->id();

        return $this->getItems($id);
    }

    public function preProcessIndex($data)
    {
        $id = $this->field->parent()->id();

        return $this->getCount($id);
    }

    public function getItems($id)
    {
        return $this->getQuery($id)->get();
    }

    public function getCount($id)
    {
        return $this->getQuery($id)->count();
    }

    protected function getQuery($id)
    {
        $mode = $this->config('mode', 'entries');

        if ($mode === 'entries') {
            $query = Entry::query()->where('collection', $this->config('collection'));
        } elseif ($mode === 'terms') {
            // Remove the taxonomy handle from the ID
            $id = str($id)->after('::')->value();
            $query = Term::query()->where('taxonomy', $this->config('taxonomy'));
        } elseif ($mode === 'assets') {
            $query = Asset::query()->where('container', $this->config('container'));
        }

        $field = $this->getField();
        $key = $field->type() === 'assets' ? 'max_files' : 'max_items';
        $method = $field->get($key) !== 1
            ? 'whereJsonContains'
            : 'where';

        return $query
            ->{$method}($this->config('field'), $id)
            ->orderBy($this->config('sort') ?? 'title');
    }

    protected function getField()
    {
        $mode = $this->config('mode', 'entries');

        if ($mode === 'entries') {
            $blueprint = Collection::findByHandle($this->config('collection'))->entryBlueprint();
        } elseif ($mode === 'terms') {
            $blueprint = Taxonomy::findByHandle($this->config('taxonomy'))->termBlueprint();
        } elseif ($mode === 'assets') {
            $blueprint = AssetContainer::findByHandle($this->config('container'))->blueprint();
        }

        return $blueprint->fields()->get($this->config('field'));
    }
}
