<?php namespace Pensoft\DemonstrationProjects\Components;

use Cms\Classes\ComponentBase;
use Pensoft\DemonstrationProjects\Models\DemonstrationProjects as DemoModel;

class DemonstrationProjectsList extends ComponentBase
{
    public $records;
    public $categories;
    public $clusters;

    public function onRun()
    {
        $this->prepareVars();
    }

    public function componentDetails()
    {
        return [
            'name' => 'Demo Projects Filter',
            'description' => 'Filter and list demonstration projects'
        ];
    }

    protected function prepareVars()
    {
        $category = input('category', 'all');
        $cluster = input('cluster', 'all');

        $this->categories = $this->getCategoryOptions();
        $this->clusters = $this->getClusterOptions();
        $this->records = $this->filterRecords($category, $cluster);

        $this->page['categories'] = $this->categories;
        $this->page['clusters'] = $this->clusters;
        $this->page['records'] = $this->records;
        $this->page['category'] = $category;
        $this->page['cluster'] = $cluster;
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

    protected function filterRecords($categoryId = 'all', $clusterId = 'all')
    {
        $query = DemoModel::query();

        if ($categoryId !== 'all') {
            $query->where('category', $categoryId);
        }

        if ($clusterId !== 'all') {
            $query->where('cluster', $clusterId);
        }

        return $query->orderBy('sort_order')->get();
    }

    public function defineProperties()
    {
        return [];
    }
}
