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
    public $rules = [
        // 'icon_settings' => 'json'
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        
    ];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = ['icon_settings'];

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
        'business_partners' => [
            'Pensoft\Partners\Models\Partners',
            'table' => 'pensoft_business_partners_demonstrations',
            'key' => 'demonstration_id',
            'otherKey' => 'partner_id'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'cover_photo' => 'System\Models\File',
        'center_photo' => 'System\Models\File',
        'right_photo' => 'System\Models\File',
        'pdf_preview' => 'System\Models\File',
        'pdf_document' => 'System\Models\File',
    ];
    public $attachMany = [];

    public function getCategoryOptions()
    {
        return [
            'Public' => 'Public',
            'Private' => 'Private',
            'Hybrid' => 'Hybrid'
        ];
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
    
    public function setIconSettingsAttribute($value)
    {
        $this->attributes['icon_settings'] = empty($value) ? json_encode([]) : json_encode($value);
    }


    public function getScientificPartnersOptions()
    {
        return \Pensoft\Partners\Models\Partners::pluck('instituion', 'id')->toArray();
    }

    public function getPolicyPartnersOptions()
    {
        return \Pensoft\Partners\Models\Partners::pluck('instituion', 'id')->toArray();
    }

    public function getBusinessPartnersOptions()
    {
        return \Pensoft\Partners\Models\Partners::pluck('instituion', 'id')->toArray();
    }

    public function getCountryOptions()
    {
        $countries = \RainLab\Location\Models\Country::orderBy('name', 'asc')->pluck('name', 'name')->toArray();
        
        $eu = ['Europe' => 'Europe'];

        return $countries + $eu;
    }
    
    private function convertEmbed($url) {
        // check if the URL is a YouTube link
        if (preg_match('/^(https?:\/\/)?((www\.)?youtube\.com|youtu\.be)\//', $url)) {
            // check if the URL is already an embed link
            if (!preg_match('/^(https?:\/\/)?((www\.)?youtube\.com|youtu\.be)\/embed\/(.+)$/', $url)) {
                // modify the URL to include the embed code
                $id = '';
                if (strpos($url, 'youtu.be/') !== false) {
                    // extract video id from youtu.be short link
                    $id = substr(strstr($url, 'youtu.be/'), 9);
                } else {
                    // extract video id from youtube.com link
                    $query_string = parse_url($url, PHP_URL_QUERY);
                    parse_str($query_string, $query_params);
                    $id = $query_params['v'] ?? '';
                }
                $embed_url = 'https://www.youtube.com/embed/' . $id;
                return $embed_url;
            }
        }
        return $url;
    }

    public function beforeSave()
    {
        $url = $this->embedded_url;

        // check if the URL is a YouTube link
        if (preg_match('/^(https?:\/\/)?((www\.)?youtube\.com|youtu\.be)\//', $url)) {
            // check if the URL is already an embed link
            if (!preg_match('/^(https?:\/\/)?((www\.)?youtube\.com|youtu\.be)\/embed\/(.+)$/', $url)) {
                // modify the URL to include the embed code
                $embed_url = $this->convertEmbed($url);
                $this->embedded_url = $embed_url;
            }
        }
    }

}
