<?php namespace Pensoft\DemonstrationProjects\Components;

use Cms\Classes\ComponentBase;
use Pensoft\DemonstrationProjects\Models\DemonstrationProjects as DemoModel;

/**
 * DemonstrationProjectsList Component
 */
class DemonstrationProjectsList extends ComponentBase
{
    public $records;

    public function onRun()
    {
        $this->records = $this->filterRecords();
        $this->page['records'] = $this->records;
        $this->page['categories'] = $this->getCategoryOptions();
        $this->page['clusters'] = $this->getClusterOptions();
    }

    public function componentDetails()
    {
        return [
            'name' => 'Demo Projects Filter',
            'description' => 'Filter and list demonstration projects'
        ];
    }

    protected function getCategoryOptions()
    {
        $demoModelInstance = new DemoModel();
        return $demoModelInstance->getCategoryOptions();
    }
    
    protected function getClusterOptions()
    {
        $demoModelInstance = new DemoModel();
        return $demoModelInstance->getClusterOptions();
    }
    
    public function onFilterRecords()
    {
        $this->page['records'] = $this->filterRecords();
        return [
            '#recordsContainer' => $this->renderPartial('@records', ['records' => $this->page['records']])
        ];
    }
    
    protected function filterRecords()
    {
        $category = \Input::get('category');
        $cluster = \Input::get('cluster');

        $this->page['category'] = $category;
        $this->page['cluster'] = $cluster;

        $query = DemoModel::query();

        if($category){
            $query->where('category', $category);
        }

        if($cluster){
            $query->where('cluster', $cluster);
        }

        return $query->orderBy('title', 'asc')->get();
    }

    public function defineProperties()
    {
        return [];
    }
}
