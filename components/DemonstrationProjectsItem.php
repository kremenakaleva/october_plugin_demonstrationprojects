<?php namespace Pensoft\DemonstrationProjects\Components;

use Cms\Classes\ComponentBase;
use Pensoft\DemonstrationProjects\Models\DemonstrationProjects as DemoModel;

/**
 * DemonstrationProjectsItem Component
 */
class DemonstrationProjectsItem extends ComponentBase
{
    public $record;

    public function componentDetails()
    {
        return [
            'name' => 'Demo Projects Details',
            'description' => 'Displays the details of a record'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Slug',
                'description' => 'The slug of the record',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->record = $this->loadRecord();
        $this->page['records'] = $this->record;
    }

    protected function loadRecord()
    {
        return DemoModel::with(['scientific_partners', 'policy_partners'])->where('slug', $this->property('slug'))->first(); 
    }
}
