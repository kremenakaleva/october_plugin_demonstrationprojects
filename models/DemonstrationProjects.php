<?php namespace Pensoft\DemonstrationProjects\Models;

use Model;
use October\Rain\Database\Traits\Sortable;

/**
 * DemonstrationProjects Model
 */
class DemonstrationProjects extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use Sortable;

    /**
     * @var string table associated with the model
     */
    public $table = 'pensoft_demonstrationprojects_demonstration_projects';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        
    ];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
    ];    
    public $belongsToMany = [
        'scientific_partners' => [
            'Pensoft\Partners\Models\Partners',
            'table' => 'pensoft_scientific_partners_demonstrations',
            'key' => 'demonstration_id',
            'otherKey' => 'partner_id'
        ],
        'policy_partners' => [
            'Pensoft\Partners\Models\Partners',
            'table' => 'pensoft_policy_partners_demonstrations',
            'key' => 'demonstration_id',
            'otherKey' => 'partner_id'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'cover_photo' => 'System\Models\File'
    ];
    public $attachMany = [];

    public function getCategoryOptions()
    {
        return [
            'Public' => 'Public',
            'Private' => 'Private',
        ];
    }

    public function getScientificPartnersOptions()
    {
        return \Pensoft\Partners\Models\Partners::pluck('instituion', 'id')->toArray();
    }

    public function getPolicyPartnersOptions()
    {
        return \Pensoft\Partners\Models\Partners::pluck('instituion', 'id')->toArray();
    }

    public function getCountryOptions()
    {
        return \RainLab\Location\Models\Country::orderBy('name', 'asc')->pluck('name', 'name')->toArray();
    }

    public function getClusterOptions()
    {
        return [
            'Agriculture and water' => 'Agriculture and water',
            'Forestry and Finance' => 'Forestry and Finance',
            'Coastal and marine' => 'Coastal and marine',
            'Spatial planning' => 'Spatial planning',
        ];
    }

}
